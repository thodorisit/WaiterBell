<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\Label;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class LabelsController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'all',
            'show',
            'create',
            'create_action',
            'edit',
            'edit_action',
            'delete',
        ]);
    }
    
    public function all(Request $request) {
        $_url_param__id = $request->input('id');
        $_url_param__name = $request->input('name');
        $whereStatements = [];
        $_url_search_parameters = [];
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

        $return_data = Label::where($whereStatements)
                                ->sessionBusinessId()
                                ->paginate(10)
                                ->appends($_url_search_parameters);
        return view('business.labels.all', [
            'table' => $return_data
        ]);
    }

    public function show(Request $request) {
        $_url_param__id = $request->input('id');
        $_url_param__employee_id = $request->input('employee_id');
        $_url_param__employee_firstname = $request->input('employee_firstname');
        $_url_param__employee_lastname = $request->input('employee_lastname');
        //Get label data
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $label_data = Label::where($whereStatements)
                        ->sessionBusinessId()
                        ->first();
        if (!$label_data) {
            return redirect()->route('business.labels.all');
        }
        //Get employees for the label
        $whereStatements = [];
        $_url_search_parameters = [];
        $_url_search_parameters['id'] = $_url_param__id;
        if (!empty($_url_param__employee_id)) {
            $_url_search_parameters['employee_id'] = $_url_param__employee_id;
            $whereStatements[] = [
                'employee.id', '=', $_url_param__employee_id
            ];
        }
        if (!empty($_url_param__employee_firstname)) {
            $_url_search_parameters['employee_firstname'] = $_url_param__employee_firstname;
            $whereStatements[] = [
                'employee.firstname', '=', $_url_param__employee_firstname
            ];
        }
        if (!empty($_url_param__employee_lastname)) {
            $_url_search_parameters['employee_lastname'] = $_url_param__employee_lastname;
            $whereStatements[] = [
                'employee.lastname', '=', $_url_param__employee_lastname
            ];
        }
        $employees_data = $label_data->employees()
                                    ->where($whereStatements)
                                    ->paginate(10)
                                    ->appends($_url_search_parameters);
        return view('business.labels.show', [
            'label' => [
                'id' => $label_data->id,
                'name' => $label_data->name,
                'allowed_ips' => $label_data->allowed_ips,
            ],
            'table' => $employees_data
        ]);
    }

    public function create(Request $request) {
        return view('business.labels.add');
    }

    public function create_action(Request $request) {
        $_form__name = $request->input('name');
        $_form__allowed_ips = $request->input('allowed_ips');
        $rules = [
            'name' => 'required|string|min:1|max:100',
        ];
        $messages = [
            'name.required' => "Name" . __('business/labels.validation__is_required'),
            'name.string' => "Name" . __('business/labels.validation__must_be_string'),
            'name.min' => "Name" . __('business/labels.validation__string_min_size', ['min' => "1"]),
            'name.max' => "Name" . __('business/labels.validation__string_max_size', ['max' => "100"])
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->route('business.labels.create');
        } else {
            Label::create([
                'business_id' => BusinessSessionHelper::id(),
                'name' => $_form__name,
                'allowed_ips' => $_form__allowed_ips
            ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/labels.data_added_successfully')
                    ]
                ]
            );
            return redirect()->route('business.labels.create');
        }
    }

    public function edit(Request $request) {
        $_url_param__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $item = Label::where($whereStatements)
                                ->sessionBusinessId()
                                ->first();
        if (!$item) {
            return redirect()->route('business.labels.all');
        }
        return view('business.labels.edit', [
            'data' => [
                'item' => $item
            ]
        ]);
    }

    public function edit_action(Request $request) {
        $_form__id = $request->input('id');
        $_form__name = $request->input('name');
        $_form__allowed_ips = $request->input('allowed_ips');
        $whereStatements = [
            ['id', '=', $_form__id]
        ];
        $item = Label::where($whereStatements)
                                ->sessionBusinessId()
                                ->first();
        if (!$item) {
            return redirect()->route('business.labels.all');
        }

        $rules = [
            'name' => 'required|string|min:1|max:100'
        ];
        $messages = [
            'name.required' => "Name" . __('business/labels.validation__is_required'),
            'name.string' => "Name" . __('business/labels.validation__must_be_string'),
            'name.min' => "Name" . __('business/labels.validation__string_min_size', ['min' => "1"]),
            'name.max' => "Name" . __('business/labels.validation__string_max_size', ['max' => "100"])
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->route('business.labels.edit', ['id' => $_form__id]);
        } else {
            $whereStatements = [
                ['id', '=', $_form__id]
            ];
            Label::where($whereStatements)
                                    ->sessionBusinessId()
                                    ->update([
                                        'name' => $_form__name,
                                        'allowed_ips' => $_form__allowed_ips
                                    ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/labels.data_updated_successfully'),
                    ]
                ]
            );
            return redirect()->route('business.labels.edit', ['id' => $_form__id]);
        }
    }

    public function delete(Request $request) {
        $ids = $request->input('id', null);
        $ids = explode(',', $ids);
        $ids = array_values(array_filter($ids, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        $labels = Label::sessionBusinessId()
                    ->whereIn('id', $ids)
                    ->get();
        foreach($labels as $label) {
            $label->employees()->detach();
            $label->delete();
        }
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/labels.data_deleted_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

    public function printa5(Request $request) {
        $_url_param__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $labelBusinessObject = Label::with('business')
                                ->where($whereStatements)
                                ->sessionBusinessId()
                                ->first();
        if (!$labelBusinessObject) {
            return redirect()->route('business.labels.all');
        }
        //dd($labelBusinessObject->toArray());
        return view('business.labels.print-a5', [
            'data' => $labelBusinessObject->toArray()
        ]);
    }

}
