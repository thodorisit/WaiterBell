<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\Employee;
use App\Helpers\JwtHelper as JWT;
use App\Helpers\CarbonHelper as CarbonHelper;
use App\Helpers\Employee\EmployeeSessionHelper as EmployeeSessionHelper;

class EmployeeController extends Controller {

    public function __construct() {
        $this->middleware('EmployeeNotRequiresLogin')->only([
            'login',
            'login_action',
        ]);
        $this->middleware('EmployeeRequiresLogin')->only([
            'home',
            'logout',
        ]);
    }
    
    public function home(Request $request) {
        $employeeObject = Employee::where([
                                        'id' => EmployeeSessionHelper::id()
                                    ])
                                    ->first();
        return view('employee.home', 
            [
                'employee' => $employeeObject
            ]
        );
    }

    public function login(Request $request) {
        return view('employee.login');
    }

    public function login_action(Request $request) {
        $_form__business_id = $request->input('business_id');
        $_form__employee_id = $request->input('employee_id');
        $_form__password = $request->input('password');
        $rules = [
            'business_id' => 'required',
            'employee_id' => 'required',
            'password' => 'required'
        ];
        $messages = [
            'business_id.required' => __('employee/login.business_id_cant_be_empty'),
            'employee_id.required' => __('employee/login.employee_id_cant_be_empty'),
            'password.required' => __('employee/login.password_cant_be_empty')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('employee/login')->with(['errors' => $validator->errors()]);
        } else {
            //Check if credentials are valid
            $whereStatements = [
                ['business_id', '=', $_form__business_id],
                ['id', '=', $_form__employee_id],
                ['password', '=', $_form__password]
            ];
            $results = Employee::where($whereStatements)
                                    ->first();
            if ($results != null) {
                $userID = $results->id;
                //Create token
                $token = JWT::encode([
                    'id' => $userID,
                    'business_id' => $results->business_id,
                    'created' => CarbonHelper::datetime()
                ]);
                //Update user with the created token and timestamp
                Employee::where('id', $userID)
                            ->update([
                                        'login_token' => $token,
                                        'login_token_created' => CarbonHelper::datetime(),
                                        'push_notification_token' => ''
                                    ]);
                $request->session()->put('employee_login_token', $token);
                return redirect('employee/');
            } else {
                return redirect('employee/login')->with(['other_errors' => [__('employee/login.wrong_credentials')]]);
            }
        }
    }

    public function logout(Request $request) {
        if ($request->session()->has('employee_login_token')) {
            Employee::where([
                            'id' => EmployeeSessionHelper::id()
                        ])
                        ->update([
                            'login_token' => "",
                            'push_notification_token' => ""
                        ]);
            $request->session()->forget('employee_login_token');
        }
        return redirect('employee/login');
    }
    
}
