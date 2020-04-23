<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;
use App\Label;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class ConnectLabelsEmployeesController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'init',
            'init_action',
            'select_employee',
            'select_label',
            'remove_employee_action',
        ]);
    }

    public function init(Request $request) {
        $_url_param__employee_id = $request->input('employee_id');
        $_url_param__label_id = $request->input('label_id');
        $employee_object = [];
        $label_object = [];
        $employee = Employee::where('id', $_url_param__employee_id)
                        ->sessionBusinessId()
                        ->first();
        if ($employee) {
            $employee_object['id'] = $employee->id;
            $employee_object['firstname'] = $employee->firstname;
            $employee_object['lastname'] = $employee->lastname;
        }
        $label = Label::where('id', $_url_param__label_id)
                        ->sessionBusinessId()
                        ->first();
        if ($label) {
            $label_object['id'] = $label->id;
            $label_object['name'] = $label->name;
        }
        return view('business.connect_labels_employees.init', [
            'data' => [
                'employee' => $employee_object,
                'label' => $label_object,
            ]
        ]);
    }

    public function init_action(Request $request) {
        $_form__employee_id = $request->input('employee_id');
        $_form__label_id = $request->input('label_id');
        $found = true;
        $employee = Employee::where('id', $_form__employee_id)
                        ->sessionBusinessId()
                        ->first();
        if (!$employee) {
            \Session::flash('toasts',
                [
                    'error' => [
                        __('business/connect_labels_employees.you_should_select_an_employee')
                    ]
                ]
            );
            return redirect()->route('business.connect_labels_employees.init', ['label_id' => $_form__label_id]);
        }
        $label = Label::where('id', $_form__label_id)
                        ->sessionBusinessId()
                        ->first();
        if (!$label) {
            \Session::flash('toasts',
                [
                    'error' => [
                        __('business/connect_labels_employees.you_should_select_a_label')
                    ]
                ]
            );
            return redirect()->route('business.connect_labels_employees.init', ['employee_id' => $_form__employee_id]);
        }
        if ($employee->labels->contains($_form__label_id)) {
            \Session::flash('toasts',
                [
                    'error' => [
                        __('business/connect_labels_employees.label_and_employee_already_connected')
                    ]
                ]
            );
            return redirect()->route('business.connect_labels_employees.init', ['employee_id' => $_form__employee_id, 'label_id' => $_form__label_id]);
        } else {
            $employee->labels()->attach($_form__label_id, ['business_id' => BusinessSessionHelper::id()]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/connect_labels_employees.label_and_employee_success_connected',
                            [
                                'employee_name' => $employee->firstname . ' ' . $employee->lastname,
                                'label_name' => $label->name
                            ]
                        )
                    ]
                ]
            );
            return redirect()->route('business.connect_labels_employees.init');
        }
    }

    public function select_employee(Request $request) {
        $_url_param__label_id = $request->input('label_id');
        $_url_param__id = $request->input('id');
        $_url_param__firstname = $request->input('firstname');
        $_url_param__lastname = $request->input('lastname');
        $whereStatements = [];
        $_url_search_parameters = [];
        $_url_search_parameters['label_id'] = $_url_param__label_id;
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
        return view('business.connect_labels_employees.employees', [
            'table' => $employees_data
        ]);
    }

    public function select_label(Request $request) {
        $_url_param__employee_id = $request->input('employee_id');
        $_url_param__id = $request->input('id');
        $_url_param__name = $request->input('name');
        $whereStatements = [];
        $_url_search_parameters = [];
        $_url_search_parameters['employee_id'] = $_url_param__employee_id;
        if (!empty($_url_param__id)) {
            $_url_search_parameters['id'] = $_url_param__id;
            $whereStatements[] = [
                'id', '=', $_url_param__id
            ];
        }
        if (!empty($_url_param__name)) {
            $_url_search_parameters['name'] = $_url_param__name;
            $whereStatements[] = [
                'name', 'like', '%'.$_url_param__name.'%'
            ];
        }
        $labels_data = Label::where($whereStatements)
                                ->sessionBusinessId()
                                ->paginate(10)
                                ->appends($_url_search_parameters);
        return view('business.connect_labels_employees.labels', [
            'table' => $labels_data
        ]);
    }

    public function remove_employee_action(Request $request) {
        $_form__label_id = $request->input('label_id');
        $_form__employee_id = $request->input('employee_id');
        $whereStatements = [
            ['id', '=', $_form__label_id]
        ];
        $label = Label::where($whereStatements)
                                ->sessionBusinessId()
                                ->first();
        $label->employees()->detach($_form__employee_id);
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/labels.data_label_removed_employee_successfully'),
                ]
            ]
        );
        return redirect()->back();
    }

}
