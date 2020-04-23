<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator,Redirect,Response;

use App\Business;
use App\Employee;
use App\Label;
use App\Language;
use App\Notification;

use App\Helpers\JwtHelper as JWT;
use App\Helpers\CarbonHelper as CarbonHelper;

class BusinessController extends Controller {

    public function __construct() {
        $this->middleware('BusinessNotRequiresLogin')->only([
            'login',
            'login_action',
        ]);
        $this->middleware('BusinessRequiresLogin')->only([
            'home',
            'logout',
        ]);
    }

    public function home(Request $request) {
        $business_info = Business::sessionBusinessId()->first(['id','push_notification_token']);
        $count_employees = Employee::sessionBusinessId()->get()->count();
        $count_labels = Label::sessionBusinessId()->get()->count();
        $count_languages = Language::sessionBusinessId()->get()->count();
        $count_notifications = Notification::selectRaw(
            'sum(case when state = 0 then 1 else 0 end) AS pending, sum(case when state = 1 then 1 else 0 end) AS completed'
        )->sessionBusinessId()->get()->toArray();
        return view('business.home', 
            [
                'info' => [
                    'count_employees' => $count_employees,
                    'count_labels' => $count_labels,
                    'count_languages' => $count_languages,
                    'count_notifications' => $count_notifications,
                    'business_id' => $business_info->id,
                    'web_push_token' => $business_info->push_notification_token,
                    'ip_address' => $request->ip()
                ]
            ]
        );
    }

    public function login(Request $request) {
        return view('business.login');
    }

    public function login_action(Request $request) {
        $_form__username = $request->input('username');
        $_form__password = $request->input('password');
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $messages = [
            'username.required' => __('business/login.username_cant_be_empty'),
            'password.required' => __('business/login.password_cant_be_empty')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('business/login')->with(['errors' => $validator->errors()]);
        } else {
            //Check if credentials are valid
            $whereStatements = [
                ['username', '=', $_form__username]
            ];
            $results = Business::where($whereStatements)
                                    ->take(1)
                                    ->first(['id','password']);
            if ($results != null) {
                if (Hash::check($_form__password, $results->password)) {
                    $userID = $results->id;
                    //Create token
                    $token = JWT::encode([
                        'id' => $userID,
                        'created' => CarbonHelper::datetime()
                    ]);
                    //Update user with the created token and timestamp
                    Business::where('id', $userID)
                                ->update([
                                            'login_token' => $token,
                                            'login_token_created' => CarbonHelper::datetime(),
                                            'push_notification_token' => ''
                                        ]);
                    //Put token in session
                    $request->session()->put('business_login_token', $token);
                    return redirect('business/');
                } else {
                    return redirect('business/login')->with(['other_errors' => [__('business/login.wrong_credentials')]]);
                }
            } else {
                return redirect('business/login')->with(['other_errors' => [__('business/login.wrong_credentials')]]);
            }
        }
    }

    public function logout(Request $request) {
        if ($request->session()->has('business_login_token')) {
            Business::SessionBusinessId()
                        ->update([
                            'login_token' => "",
                            'push_notification_token' => ""
                        ]);
            $request->session()->forget('business_login_token');
        }
        return redirect('business/login');
    }

}
