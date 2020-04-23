<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\Translation;
use App\Language;

use App\Helpers\TranslationHelper as TranslationHelper;

class TranslationsController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'all',
            'edit',
            'edit_action',
        ]);
    }
    
    public function all(Request $request) {
        $_url_param__id = $request->input('id');
        $_url_param__attribute = $request->input('attribute');
        $whereStatements = [];
        $_url_search_parameters = [];
        if (!empty($_url_param__id)) {
            $_url_search_parameters['id'] = $_url_param__id;
            $whereStatements[] = [
                'id', '=', $_url_param__id
            ];
        }
        if (!empty($_url_param__attribute)) {
            $_url_search_parameters['attribute'] = $_url_param__attribute;
            $whereStatements[] = [
                'attribute', 'like', '%'.$_url_param__attribute.'%'
            ];
        }

        $return_data = Translation::where($whereStatements)
                                ->sessionBusinessId()
                                ->paginate(10)
                                ->appends($_url_search_parameters);
        return view('business.translations.all', [
            'table' => $return_data
        ]);
    }

    public function edit(Request $request) {
        $_url_param__id = $request->input('id');
        $whereStatements = [
            ['id', '=', $_url_param__id]
        ];
        $item = Translation::where($whereStatements)
                                ->sessionBusinessId()
                                ->first();
        if (!$item) {
            return redirect()->route('business.translations.all');
        }
        $languages = Language::sessionBusinessId()
                                ->get()
                                ->toArray();
        return view('business.translations.edit', [
            'languages' => $languages,
            'data' => [
                'item' => $item
            ]
        ]);
    }

    public function edit_action(Request $request) {
        $_form__id = $request->input('id');
        $_form__translations = $request->input('translations');
        $whereStatements = [
            ['id', '=', $_form__id]
        ];
        $item = Translation::where($whereStatements)
                                ->sessionBusinessId()
                                ->first();
        if (!$item) {
            return redirect()->route('business.translations.all');
        }

        //Get model translatable attributes
        $translationAttributes = Translation::$translationAttributes;
        $request = TranslationHelper::singleTableJsonTranslateJobModifyRequest($request, $translationAttributes);

        $rules = [
            'translations' => 'array',
            'translations.default' => 'required|string|min:1|max:100',
            'translations.*' => 'max:100',
        ];
        $messages = [
            'translations' => 'There was an error. Try again!',
            'translations.default.required' => "Name (Default)" . __('business/request_types.validation__is_required'),
            'translations.default.string' => "Name (Default)" . __('business/request_types.validation__must_be_string'),
            'translations.default.min' => "Name (Default)" . __('business/request_types.validation__string_min_size', ['min' => "1"]),
            'translations.default.max' => "Name (Default)" . __('business/request_types.validation__string_max_size', ['max' => "100"]),

            'translations.*.string' => "Name" . __('business/request_types.validation__must_be_string'),
            'translations.*.max' => "Name" . __('business/request_types.validation__string_max_size', ['max' => "100"]),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            \Session::flash('form_error', $validator->errors()->toArray());
            \Session::flash('toasts',
                [
                    'error' => $validator->errors()->all()
                ]
            );
            return redirect()->route('business.translations.edit', ['id' => $_form__id]);
        } else {

            $whereStatements = [
                ['id', '=', $_form__id]
            ];
            Translation::where($whereStatements)
                                    ->sessionBusinessId()
                                    ->update([
                                        'translations' => $request->translations
                                    ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/translations.data_updated_successfully'),
                    ]
                ]
            );
            return redirect()->route('business.translations.edit', ['id' => $_form__id]);
        }
    }

}
