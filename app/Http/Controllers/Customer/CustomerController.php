<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;

use App\Business;
use App\Employee;
use App\Label;
use App\Notification;
use App\Translation;
use App\RequestTypes;

use App\Helpers\TranslationHelper as TranslationHelper;
use App\Helpers\FirebaseHelper as FirebaseHelper;

class CustomerController extends Controller {

    public function home(Request $request) {
        $_url_param__label_id = $request->input('label_id');

        //Get Label information
        $labelObject = Label::with('business')
                                ->where([['id', '=', $_url_param__label_id]])
                                ->first();
        if (!$labelObject) {
            return redirect()->route('customer.not_found');
        }

        //Check if user IP is allowed
        $user_ip = $request->ip();
        //Allowed IPS of this label
        $allowed_ips = array_filter(explode(',', $labelObject->allowed_ips ?? ""));
        if (count($allowed_ips) > 0) {
            if (!in_array($user_ip, $allowed_ips)) {
                return redirect()->route('customer.not_found');
            }
        }
        //Global Allowed IPS of the business
        $allowed_ips = array_filter(explode(',', $labelObject->business->allowed_ips ?? ""));
        if (count($allowed_ips) > 0) {
            if (!in_array($user_ip, $allowed_ips)) {
                return redirect()->route('customer.not_found');
            }
        }

        //Get Business information (Languages, Types of requests)
        $businessObject = Business::with(['languages', 'requestTypes'])
                                    ->where('id', '=', $labelObject->business_id)
                                    ->first();
        if (!$businessObject) {
            return redirect()->route('customer.not_found');
        }

        //Search and save session default language & currentSessionLanguage
        if (!\Session::get('customer_language')) {
            $is_default_language = "";
            foreach($businessObject->languages as $lang_key => $lang_value) {
                if ($lang_value['is_default'] == 1) {
                    $is_default_language = $lang_value['slug'];
                }
            }
            \Session::put('customer_language', $is_default_language);
            \Session::save();
            //Get the current language saved on the customer session
            $currentSessionLanguage = $is_default_language;
        } else {
            //Get the current language saved on the customer session
            $currentSessionLanguage = \Session::get('customer_language');
        }

        /**
         * Translations for strings
         */
        //Attributes available on database
        $attributes = [
            'customer.home.seat',
            'customer.home.choose_reason',
            'customer.home.choose_language',
            'customer.home.already_received_limit',
            'customer.home.success_message',
            'customer.home.error_message'
        ];
        $translations = TranslationHelper::translateDbQuery($attributes, $currentSessionLanguage, $businessObject->id);

        /**
         * Translate request_types
         */
        $requestTypesTranslationAttributes = RequestTypes::$translationAttributes;
        $request_types = $businessObject->requestTypes->toArray();
        $request_types = TranslationHelper::singleTableJsonTranslateJobShow($request_types, $requestTypesTranslationAttributes, $currentSessionLanguage);

        //Save session data for later use (success.blade.php, error.blade.php etc)
        \Session::put('customer_additional_session_data', [
            'translations' => $translations,
            'label' => [
                'id' => $_url_param__label_id,
                'name' => $labelObject->name,
            ],
            'business' => [
                'id' => $businessObject->id,
                'name' => $businessObject->name,
                'logo_url' => $businessObject->logo_url
            ]
        ]);
        return view('customer.main', [
            'translations' => $translations,
            'business' => [
                'name' => $businessObject->name,
                'logo_url' => $businessObject->logo_url,
            ],
            'label' => $labelObject->toArray(),
            'languages' => $businessObject->languages->toArray(),
            'request_types' => $request_types,
        ]);
    }

    public function request_action(Request $request) {
        $_form__label_id= $request->input('label_id');
        $_form__request_id= $request->input('request_id');
        
        $rules = [
            'label_id' => 'required|integer',
            'request_id' => 'required|integer'
        ];
        $messages = [
            'label_id.required' => 'label-is-required',
            'label_id.integer' => 'label-is-not-integer',
            'request_id.required' => 'request-is-required',
            'request_id.integer' => 'request-is-not-integer',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('customer.error');
        } else {
            //Get all unique employees that belongs to this label
            $label_employees_business = Label::with(
                    [
                        'employees' => function($query) {
                            $query->distinct('employee.id')
                                    ->IsLogedIn()
                                    ->hasPushToken();
                        },
                        'business'
                    ])
                    ->where('id','=',$_form__label_id)
                    ->get();
            if ($label_employees_business->isEmpty()) {
                return redirect()->route('customer.error');
            }

            //Check if user IP is allowed
            $user_ip = $request->ip();
            //Allowed IPS of this label
            $allowed_ips = array_filter(explode(',', $label_employees_business['allowed_ips'] ?? ""));
            if (count($allowed_ips) > 0) {
                if (!in_array($user_ip, $allowed_ips)) {
                    return redirect()->route('customer.not_found');
                }
            }
            //Global Allowed IPS of the business
            $allowed_ips = array_filter(explode(',', $label_employees_business[0]->business->allowed_ips ?? ""));
            if (count($allowed_ips) > 0) {
                if (!in_array($user_ip, $allowed_ips)) {
                    return redirect()->route('customer.not_found');
                }
            }

            //Collect all employees push tokens
            $push_tokens = [];
            foreach($label_employees_business[0]->employees as $employee) {
                if (!empty($employee->push_notification_token)) {
                    $push_tokens[] = $employee->push_notification_token;
                }
            }
            //Collect business push token
            if (!empty($label_employees_business[0]->business->push_notification_token)) {
                $push_tokens[] = $label_employees_business[0]->business->push_notification_token;
            }
            //Get RequestType information
            $requestObject = RequestTypes::where([
                                                    ['id','=',$_form__request_id],
                                                    ['business_id', '=', $label_employees_business[0]->business->id]
                                                ])
                                                ->first();
            if (!$requestObject) {
                return redirect()->route('customer.error');
            } else {
                $requestObject = $requestObject->toArray();
            }
            //Initialize notification object
            $notification = [
                'title' => __('customer/home.seat') . ': ' . $label_employees_business[0]->name,
                'body' => $requestObject['name']['default'],
                'open_url' => '',
                'icon' => ''
            ];
            //Store notification
            $notificationCreated = Notification::create([
                                                        'business_id' => $label_employees_business[0]->business->id,
                                                        'label_id' => $label_employees_business[0]->id,
                                                        'title' => $notification['title'],
                                                        'body' => $notification['body'],
                                                        'open_url' => $notification['open_url'],
                                                        'icon' => $notification['icon'],
                                                        'state' => 0
                                                    ]);
            if ($notificationCreated) {
                //Create open_url link
                $notification['open_url'] = route('helper.redirect.notification') . '/' . $notificationCreated->id;
                $result = FirebaseHelper::send(
                    $push_tokens,
                    $notification['title'],
                    $notification['body'],
                    $notification['open_url'],
                    $notification['icon']
                );
                return redirect()->route('customer.success');
            } else {
                return redirect()->route('customer.error');
            }
        }
    }

    public function success(Request $request) {
        if (\Session::has('customer_additional_session_data')) {
            //Transfer session data to flash session
            \Session::flash('flash__customer_additional_session_data', \Session::get('customer_additional_session_data'));
            \Session::forget('customer_additional_session_data');
            return view('customer.success');
        } else {
            return redirect()->route('customer.not_found');
        }
    }

    public function error(Request $request) {
        if (\Session::has('customer_additional_session_data')) {
            //Transfer session data to flash session
            \Session::flash('flash__customer_additional_session_data', \Session::get('customer_additional_session_data'));
            \Session::forget('customer_additional_session_data');
            return view('customer.error');
        } else {
            return redirect()->route('customer.not_found');
        }
    }

    public function not_found(Request $request) {
        return view('customer.not_found');
    }
    
}
