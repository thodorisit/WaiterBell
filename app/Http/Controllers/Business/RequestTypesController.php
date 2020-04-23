<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\RequestTypes;
use App\Language;

use App\Helpers\LanguageHelper as LanguageHelper;
use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;
use App\Helpers\TranslationHelper as TranslationHelper;

class RequestTypesController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'all',
            'create',
            'create_action',
            'edit',
            'edit_action',
            'delete',
        ]);
    }
    
    public function all(Request $request) {
        $_url_param__id = $request->input('id');
        $whereStatements = [];
        $_url_search_parameters = [];

        if (!empty($_url_param__id)) {
            $_url_search_parameters['id'] = $_url_param__id;
            $whereStatements[] = [
                'id', '=', $_url_param__id
            ];
        }

        //Get model translatable attributes
        $translationAttributes = RequestTypes::$translationAttributes;
        //Loop through each translatable attribute
        foreach($translationAttributes as $key => $attribute) {
            //Check if translatable attribute exists in Request object
            if ($request->{$attribute}) {
                $attribute_data = $request->{$attribute};
                $_url_search_parameters[$attribute] = $attribute_data;
                $whereStatements[] = [
                    'name->default', 'LIKE', '%'.$attribute_data.'%'
                ];
            }
        }

        $request_type = RequestTypes::sessionBusinessId()
                                    ->where($whereStatements)
                                    ->paginate(10)
                                    ->appends($_url_search_parameters);

        return view('business.request_types.all', [
            'table' => $request_type
        ]);
    }

    public function create(Request $request) {
        $languages = Language::sessionBusinessId()
                                ->get()
                                ->toArray();
        return view('business.request_types.add', [
            'languages' => $languages,
        ]);
    }

    public function create_action(Request $request) {

        //Get model translatable attributes
        $translationAttributes = RequestTypes::$translationAttributes;
        $request = TranslationHelper::singleTableJsonTranslateJobModifyRequest($request, $translationAttributes);

        $rules = [
            'name' => 'array',
            'name.default' => 'required|string|min:1|max:100',
            'name.*' => 'string|min:1|max:100',
        ];
        $messages = [
            'name' => 'There was an error. Try again!',
            'name.default.required' => "Name (Default)" . __('business/request_types.validation__is_required'),
            'name.default.string' => "Name (Default)" . __('business/request_types.validation__must_be_string'),
            'name.default.min' => "Name (Default)" . __('business/request_types.validation__string_min_size', ['min' => "1"]),
            'name.default.max' => "Name (Default)" . __('business/request_types.validation__string_max_size', ['max' => "100"]),

            'name.*.string' => "Name" . __('business/request_types.validation__must_be_string'),
            'name.*.min' => "Name" . __('business/request_types.validation__string_min_size', ['min' => "1"]),
            'name.*.max' => "Name" . __('business/request_types.validation__string_max_size', ['max' => "100"]),
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
            //Create
            $request_type = RequestTypes::create([
                'business_id' => BusinessSessionHelper::id(),
                'name' => $request->name
            ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/request_types.data_added_successfully')
                    ]
                ]
            );
            return redirect()->route('business.request_types.all', ['id' => $request_type->id]);
        }
    }

    public function edit(Request $request) {
        $_url_param__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $item = RequestTypes::where($whereStatements)
                            ->sessionBusinessId()
                            ->first();
        if (!$item) {
            return redirect()->route('business.request_types.all');
        }
        $languages = Language::sessionBusinessId()
                                ->get()
                                ->toArray();
        return view('business.request_types.edit', [
            'languages' => $languages,
            'data' => [
                'item' => $item
            ]
        ]);
    }

    public function edit_action(Request $request) {
        $_form__id = $request->input('id');

        $whereStatements = [
            ['id', '=', $_form__id]
        ];
        $item = RequestTypes::where($whereStatements)
                            ->sessionBusinessId()
                            ->first();
        if (!$item) {
            return redirect()->route('business.request_types.all');
        }

        //Get model translatable attributes
        $translationAttributes = RequestTypes::$translationAttributes;
        $request = TranslationHelper::singleTableJsonTranslateJobModifyRequest($request, $translationAttributes);

        $rules = [
            'name' => 'array',
            'name.default' => 'required|string|min:1|max:100',
            'name.*' => 'string|min:1|max:100',
        ];
        $messages = [
            'name' => 'There was an error. Try again!',
            'name.default.required' => "Name (Default)" . __('business/request_types.validation__is_required'),
            'name.default.string' => "Name (Default)" . __('business/request_types.validation__must_be_string'),
            'name.default.min' => "Name (Default)" . __('business/request_types.validation__string_min_size', ['min' => "1"]),
            'name.default.max' => "Name (Default)" . __('business/request_types.validation__string_max_size', ['max' => "100"]),

            'name.*.string' => "Name" . __('business/request_types.validation__must_be_string'),
            'name.*.min' => "Name" . __('business/request_types.validation__string_min_size', ['min' => "1"]),
            'name.*.max' => "Name" . __('business/request_types.validation__string_max_size', ['max' => "100"]),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->route('business.request_types.edit', ['id' => $_form__id]);
        } else {
            RequestTypes::where($whereStatements)
                                    ->sessionBusinessId()
                                    ->update([
                                        'name' => $request->name
                                    ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/request_types.data_updated_successfully')
                    ]
                ]
            );
            return redirect()->route('business.request_types.edit', ['id' => $_form__id]);
        }

    }

    public function delete(Request $request) {
        $ids = $request->input('id', null);
        $ids = explode(',', $ids);
        $ids = array_values(array_filter($ids, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        $request_types = RequestTypes::sessionBusinessId()
                    ->whereIn('id', $ids)
                    ->delete();
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/request_types.data_deleted_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

}
