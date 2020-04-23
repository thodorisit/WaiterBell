<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\Employee;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class EmployeesController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'all',
            'show',
            'create',
            'create_action',
            'edit',
            'edit_action',
            'revoke_login_token',
            'revoke_push_token',
            'delete',
        ]);
    }
    
    public function all(Request $request) {
        $_url_param__id = $request->input('id');
        $_url_param__firstname = $request->input('firstname');
        $_url_param__lastname = $request->input('lastname');
        $whereStatements = [];
        $_url_search_parameters = [];
        if (!empty($_url_param__id)) {
            $_url_search_parameters['id'] = $_url_param__id;
            $whereStatements[] = [
                'id', '=', $_url_param__id
            ];
        }
        if (!empty($_url_param__firstname)) {
            $_url_search_parameters['firstname'] = $_url_param__firstname;
            $whereStatements[] = [
                'firstname', 'LIKE', '%'.$_url_param__firstname.'%'
            ];
        }
        if (!empty($_url_param__lastname)) {
            $_url_search_parameters['lastname'] = $_url_param__lastname;
            $whereStatements[] = [
                'lastname', 'LIKE', '%'.$_url_param__lastname.'%'
            ];
        }
        $employees_data = Employee::sessionBusinessId()
                                    ->where($whereStatements)
                                    ->paginate(10)
                                    ->appends($_url_search_parameters);
        $employees_data->setCollection($employees_data->getCollection()->makeVisible('login_token'));
        return view('business.employees.all', [
            'table' => $employees_data
        ]);
    }

    public function show(Request $request) {
        $_url_param__id = $request->input('id');
        $_url_param__label_name = $request->input('label_name');
        //Get Employee data
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $employee_data = Employee::where($whereStatements)
                        ->sessionBusinessId()
                        ->first();
        if (!$employee_data) {
            return redirect()->route('business.employees.all');
        }
        $employee_data->makeVisible('login_token');
        //Get labels for the employee
        $whereStatements = [];
        $_url_search_parameters = [];
        $_url_search_parameters['id'] = $_url_param__id;
        if (!empty($_url_param__label_name)) {
            $_url_search_parameters['label_name'] = $_url_param__label_name;
            $whereStatements[] = [
                'label.name', 'LIKE', '%'.$_url_param__label_name.'%'
            ];
        }
        $labels_data = $employee_data->labels()
                                        ->where($whereStatements)
                                        ->paginate(10)
                                        ->appends($_url_search_parameters);
        return view('business.employees.show', [
            'employee' => [
                'id' => $employee_data->id,
                'firstname' => $employee_data->firstname,
                'lastname' => $employee_data->lastname,
                'password' => $employee_data->password,
                'login_token' => $employee_data->login_token,
                'push_notification_token' => $employee_data->push_notification_token
            ],
            'table' => $labels_data
        ]);
    }

    public function create(Request $request) {
        return view('business.employees.add');
    }

    public function create_action(Request $request) {
        $_form__firstname = $request->input('firstname');
        $_form__lastname = $request->input('lastname');
        $_form__password = $request->input('password');
        $rules = [
            'firstname' => 'required|string|min:1|max:100',
            'lastname' => 'required|string|min:1|max:100',
            'password' => 'required|string|min:1|max:100',
        ];
        $messages = [
            'firstname.required' => "Firstname" . __('business/employees.validation__is_required'),
            'firstname.string' => "Firstname" . __('business/employees.validation__must_be_string'),
            'firstname.min' => "Firstname" . __('business/employees.validation__string_min_size', ['min' => "1"]),
            'firstname.max' => "Firstname" . __('business/employees.validation__string_max_size', ['max' => "100"]),
            'lastname.required' => "Lastname" . __('business/employees.validation__is_required'),
            'lastname.string' => "Lastname" . __('business/employees.validation__must_be_string'),
            'lastname.min' => "Lastname" . __('business/employees.validation__string_min_size', ['min' => "1"]),
            'lastname.max' => "Lastname" . __('business/employees.validation__string_max_size', ['max' => "100"]),
            'password.required' => "Password" . __('business/employees.validation__is_required'),
            'password.string' => "Password" . __('business/employees.validation__must_be_string')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->back()->withInput();
        } else {
            $employee = Employee::create([
                'business_id' => BusinessSessionHelper::id(),
                'firstname' => $_form__firstname,
                'lastname' => $_form__lastname,
                'password' => $_form__password,
            ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/employees.data_added_successfully')
                    ]
                ]
            );
            return redirect()->route('business.employees.all', ['id' => $employee->id]);
        }
    }

    public function edit(Request $request) {
        $_url_param__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $item = Employee::where($whereStatements)
                            ->sessionBusinessId()
                            ->first();
        if (!$item) {
            return redirect()->route('business.employees.all');
        }
        return view('business.employees.edit', [
            'data' => [
                'item' => $item
            ]
        ]);
    }

    public function edit_action(Request $request) {
        $_form__id = $request->input('id');
        $_form__firstname = $request->input('firstname');
        $_form__lastname = $request->input('lastname');
        $_form__password = $request->input('password');

        $whereStatements = [
            ['id', '=', $_form__id]
        ];
        $item = Employee::where($whereStatements)
                            ->sessionBusinessId()
                            ->first();
        if (!$item) {
            return redirect()->route('business.employees.all');
        }

        $rules = [
            'firstname' => 'required|string|min:1|max:100',
            'lastname' => 'required|string|min:1|max:100',
            'password' => 'required|string|min:1|max:100',
        ];
        $messages = [
            'firstname.required' => "Firstname" . __('business/employees.validation__is_required'),
            'firstname.string' => "Firstname" . __('business/employees.validation__must_be_string'),
            'firstname.min' => "Firstname" . __('business/employees.validation__string_min_size', ['min' => "1"]),
            'firstname.max' => "Firstname" . __('business/employees.validation__string_max_size', ['max' => "100"]),
            'lastname.required' => "Lastname" . __('business/employees.validation__is_required'),
            'lastname.string' => "Lastname" . __('business/employees.validation__must_be_string'),
            'lastname.min' => "Lastname" . __('business/employees.validation__string_min_size', ['min' => "1"]),
            'lastname.max' => "Lastname" . __('business/employees.validation__string_max_size', ['max' => "100"]),
            'password.required' => "Password" . __('business/employees.validation__is_required'),
            'password.string' => "Password" . __('business/employees.validation__must_be_string')
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
            Employee::where($whereStatements)
                                    ->sessionBusinessId()
                                    ->update([
                                        'firstname' => $_form__firstname,
                                        'lastname' => $_form__lastname,
                                        'password' => $_form__password,
                                    ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/employees.data_updated_successfully')
                    ]
                ]
            );
            return redirect()->route('business.employees.edit', ['id' => $_form__id]);
        }
    }

    public function revoke_login_token(Request $request) {
        $_form__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_form__id]
        ];
        Employee::where($whereStatements)
                    ->sessionBusinessId()
                    ->update([
                        'login_token' => "",
                        'login_token_created' => null,
                        'push_notification_token' => "",
                    ]);
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/employees.data_revoke_login_token_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

    public function revoke_push_token(Request $request) {
        $_form__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_form__id]
        ];
        Employee::where($whereStatements)
                    ->sessionBusinessId()
                    ->update([
                        'push_notification_token' => "",
                    ]);
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/employees.data_revoke_push_token_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

    public function delete(Request $request) {
        $ids = $request->input('id', null);
        $ids = explode(',', $ids);
        $ids = array_values(array_filter($ids, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        $employees = Employee::sessionBusinessId()
                    ->whereIn('id', $ids)
                    ->get();
        foreach($employees as $employee) {
            $employee->labels()->detach();
            $employee->delete();
        }
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/employees.data_deleted_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

}
