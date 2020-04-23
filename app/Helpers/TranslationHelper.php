<?php

namespace App\Helpers;

use App\Translation;
use App\Language;
use Illuminate\Http\Request;

class TranslationHelper {

    //Translation DB table
    public static function translateDbQuery($attributes = array(), $currentLanguage = "", $business_id = null) {
        //Query to get translations
        $translationsObject = Translation::where([
                                                'business_id' => $business_id
                                            ])
                                            ->whereIn('attribute', $attributes)
                                            ->get();
        //Initialize the return array with the translations of the attributes
        $translations = [];
        //Loop through each database results
        foreach($translationsObject as $key => $value) {
            //If there is an available translation the push it
            if (isset($value['translations'][$currentLanguage]) && !empty($value['translations'][$currentLanguage])) {
                $translations[$value['attribute']] = $value['translations'][$currentLanguage];
            } else {
                //If there is a default available string
                if (isset($value['translations']['default'])) {
                    $translations[$value['attribute']] = $value['translations']['default'];
                } else {
                    $translations[$value['attribute']] = "";
                }
            }
        }
        return $translations;
    }

    //Returns translations for each translatable attribute if they are saved as stringified json.
    public static function singleTableJsonTranslateJobShow($dataModel = array(), $translationAttributes = array(), $currentLanguage = '', $defaultLanguage = 'default') {
        //$dataModel requires "->toArray()"
        //Loop for each model data
        foreach($dataModel as $dataModelKey => $dataModelValue) {
            //Loop through each translation attribute
            foreach($translationAttributes as $attributeKey => $attributeValue) {
                //If model data has content with current language
                if (isset($dataModelValue[$attributeValue][$currentLanguage]) && !empty($dataModelValue[$attributeValue][$currentLanguage])) {
                    $dataModel[$dataModelKey][$attributeValue] = $dataModelValue[$attributeValue][$currentLanguage];
                } else {
                    //Check if default contect is available
                    if (isset($dataModelValue[$attributeValue][$defaultLanguage]) && !empty($dataModelValue[$attributeValue][$defaultLanguage])) {
                        $dataModel[$dataModelKey][$attributeValue] = $dataModelValue[$attributeValue][$defaultLanguage];
                    } else {
                        $dataModel[$dataModelKey][$attributeValue] = '-';
                    }
                }
            }
        }
        return $dataModel;
    }

    //Function that filters the request, for example if html form is modified by the end user, it will proccess only correct data.
    public static function singleTableJsonTranslateJobModifyRequest(Request $request, $translationAttributes = array()) {
        //START: Filter Request parameters
        //Get all languages
        $languages = Language::sessionBusinessId()
                    ->get()
                    ->toArray();
        //Loop through each translatable attribute
        foreach($translationAttributes as $key => $attribute) {
            //Initialize the array that will have the translations
            $translations = [];
            //Check if translatable attribute exists in Request object
            if ($request->{$attribute}) {
                $attribute_data = $request->{$attribute};
                //Put default language
                $translations['default'] = $attribute_data['default'];
                //Loop through all languages
                foreach($languages as $language) {
                    /** If the attribute is filled by the user (front-end)
                     * then fill the translations, else language with have
                     * an empty string.
                     * If "else" removed, only languages
                     * that have data will be added to the array.
                     */
                    if (!empty($attribute_data[$language['slug']])) {
                        $translations[$language['slug']] = $attribute_data[$language['slug']];
                    } else {
                        $translations[$language['slug']] = "";
                    }
                }
            }
            //Override request attribute data.
            $request->merge([$attribute => $translations]);
        }
        //END: Filter Request parameters
        return $request;
    }

}
