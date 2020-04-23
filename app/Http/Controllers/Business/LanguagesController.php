<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Language;

use App\Helpers\LanguageHelper as LanguageHelper;
use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class LanguagesController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'all',
            'create',
            'create_action',
            'delete',
        ]);
    }
    
    public function all(Request $request) {
        $_url_param__name = $request->input('name');
        $_url_param__slug = $request->input('slug');
        $_url_search_parameters = [];
        $whereStatements = [];
        if (!empty($_url_param__name)) {
            $_url_search_parameters['name'] = $_url_param__name;
            $whereStatements[] = [
                'name', 'like', '%'.$_url_param__name.'%'
            ];
        }
        if (!empty($_url_param__slug)) {
            $_url_search_parameters['slug'] = $_url_param__slug;
            $whereStatements[] = [
                'slug', 'like', '%'.$_url_param__slug.'%'
            ];
        }

        $return_data = Language::where($whereStatements)
                                ->sessionBusinessId()
                                ->paginate(10)
                                ->appends($_url_search_parameters);
        return view('business.languages.all', [
            'table' => $return_data
        ]);
    }

    public function create(Request $request) {
        $business_languages = Language::sessionBusinessId()->get(['slug'])->toArray();
        $all_languages = LanguageHelper::get();
        //Return all available languages, if business has addded languages add extra flag "exists = 1".
        foreach ($business_languages as $key => $value) {
            if (!empty($all_languages[$value['slug']])) {
                $all_languages[$value['slug']]['exists'] = 1;
            }
        }
        return view('business.languages.add', [
            'data' => [
                'languages' => $all_languages
            ]
        ]);
    }

    public function create_action(Request $request) {
        $_form__language = $request->input('language');
        $validated_language = LanguageHelper::get($_form__language);
        if ($validated_language) {
            //Check if already exists
            $checkExistsLanguage = Language::sessionBusinessId()
                        ->where([
                            ['slug', '=', $validated_language['slug']]
                        ])
                        ->first();
            if ($checkExistsLanguage) {
                return redirect()->route('business.languages.create');
            } else {
                Language::create([
                    'business_id' => BusinessSessionHelper::id(),
                    'name' => $validated_language['name'],
                    'native_name' => $validated_language['nativeName'],
                    'slug' => $validated_language['slug']
                ]);
                \Session::flash('toasts',
                    [
                        'success' => [
                            __('business/languages.data_added_successfully')
                        ]
                    ]
                );
                return redirect()->route('business.languages.create');
            }
        } else {
            return redirect()->route('business.languages.create');
        }
    }

    public function delete(Request $request) {
        $ids = $request->input('id', null);
        $ids = explode(',', $ids);
        $ids = array_values(array_filter($ids, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        //Count current languages
        $currentLanguages = Language::sessionBusinessId()->get()->count();
        if (($currentLanguages - count($ids)) > 0) {
            Language::sessionBusinessId()
                        ->whereIn('id', $ids)
                        ->delete();
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/languages.data_deleted_successfully')
                    ]
                ]
            );
        } else {
            \Session::flash('toasts',
                [
                    'error' => [
                        __('business/languages.errors.at_least_one_language')
                    ]
                ]
            );
        }
        return redirect()->back();
    }

}
