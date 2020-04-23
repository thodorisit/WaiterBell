<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Validator;

use App\Business;
use App\Language;

use App\Helpers\LanguageHelper as LanguageHelper;
use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class SettingsController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'settings',
            'name_action',
            'logo_action',
            'password_action',
            'default_language_action',
            'update_push_token_action',
        ]);
    }
    
    public function settings(Request $request) {
        $languages = Language::sessionBusinessId()
                                ->get();
        $business = Business::sessionBusinessId()
                                ->first();
        return view('business.settings', 
            [
                'data' => [
                    'business_info' => [
                        'name' => $business->name,
                        'logo_url' => $business->logo_url,
                        'allowed_ips' => $business->allowed_ips
                    ],
                    'languages' => $languages,
                ]
            ]
        );
    }

    public function allowed_ips_action(Request $request) {
        $_form__allowed_ips = $request->input('allowed_ips');
        
        Business::SessionBusinessId()->update([
                                                'allowed_ips' => $_form__allowed_ips
                                            ]);
        \Session::flash('toasts',
        [
            'success' => [
                __('business/settings.form__allowed_ips.success.update')
            ]
        ]
        );
        return redirect()->back();
    }

    public function name_action(Request $request) {
        $_form__name = $request->input('name');
        $rules = [
            'name' => 'required|min:1|max:100'
        ];
        $messages = [
            'name.required' => __('business/settings.form__name.errors.empty'),
            'name.min' => __('business/settings.form__name.errors.min'),
            'name.max' => __('business/settings.form__name.errors.max')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->back();
        } else {
            Business::SessionBusinessId()
                        ->update([
                            'name' => $_form__name
                        ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/settings.form__name.success.update')
                    ]
                ]
            );
            return redirect()->back();
        }
    }

    public function logo_action(Request $request) {
        $_form__logo = $request->input('logo');
        $rules = [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
        $messages = [
            'logo.required' => __('business/settings.form__logo.errors.required'),
            'logo.image' => __('business/settings.form__logo.errors.image'),
            'logo.mimes' => __('business/settings.form__logo.errors.mimes'),
            'logo.max' => __('business/settings.form__logo.errors.max'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->back();
        } else {
            $businessObject = Business::sessionBusinessId()->first();
            if ($businessObject->logo_url) {
                //Remove logo
                $path = public_path('business-logo').'/'.$businessObject->logo_url;
                if(\File::exists($path)){
                    unlink($path);
                }
            }
            $imageName = time().'-'.BusinessSessionHelper::id().'.'.$request->logo->extension();
            Business::SessionBusinessId()
                        ->update([
                            'logo_url' => $imageName
                        ]);
            $request->logo->move(public_path('business-logo'), $imageName);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/settings.form__logo.success.update')
                    ]
                ]
            );
            return redirect()->back();
        }
    }

    public function password_action(Request $request) {
        $_form__password = $request->input('password');
        $rules = [
            'password' => 'required'
        ];
        $messages = [
            'password.required' => __('business/settings.form__password.errors.empty')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->back();
        } else {
            $hashed_password = HASH::make($_form__password);
            Business::SessionBusinessId()
                        ->update([
                            'password' => $hashed_password
                        ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/settings.form__password.success.update')
                    ]
                ]
            );
            return redirect()->back();
        }
    }
    
    public function default_language_action(Request $request) {
        $_form__default_language = $request->input('default_language');
        $validate_language = LanguageHelper::get($_form__default_language);
        if ($validate_language) {
            Language::sessionBusinessId()
                    ->update([
                        'is_default' => null
                    ]);
            Language::where([
                        'slug' => $validate_language['slug']
                    ])
                    ->sessionBusinessId()
                    ->update([
                        'is_default' => 1
                    ]);
        }
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/settings.form__language.success.update')
                ]
            ]
        );
        return redirect()->back();
    }

    public function update_push_token_action(Request $request) {
        $_form__push_token = $request->input('push_token');
        $_form__reason = $request->input('reason');
        if ($_form__reason == 'subscribe') {
            if (!empty($_form__push_token)) {
                Business::SessionBusinessId()
                            ->update([
                                'push_notification_token' => $_form__push_token
                            ]);
                \Session::flash('toasts',
                    [
                        'success' => [
                            __('business/settings.form__webpush.success.subscribed')
                        ]
                    ]
                );
                return redirect()->back();
            } else {
                \Session::flash('toasts',
                    [
                        'error' => [
                            __('business/settings.form__webpush.errors.no_available_token')
                        ]
                    ]
                );
                return redirect()->back();
            }
        } elseif ($_form__reason == 'unsubscribe') {
            Business::SessionBusinessId()
                        ->update([
                            'push_notification_token' => ""
                        ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/settings.form__webpush.success.unsubscribed')
                    ]
                ]
            );
            return redirect()->back();
        } elseif ($_form__reason == 'refresh_token') {
            if (!empty($_form__push_token)) {
                //Check if business has enabled push notifications
                $businessObject = Business::SessionBusinessId()->first();
                if ($businessObject->push_notification_token != "" && $businessObject->push_notification_token != null) {
                    Business::SessionBusinessId()
                                ->update([
                                    'push_notification_token' => $_form__push_token
                                ]);
                    return response()->json([
                        'success' => '1'
                    ]);
                } else {
                    return response()->json([
                        'success' => '0'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => '0'
                ]);
            }
        } else {
            return redirect()->back();
        }
    }

}
