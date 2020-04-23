<?php

namespace App\Helpers\Business;

use App\Helpers\Business\BreadcrumbHelper as BreadcrumbHelper;

class SidebarHelper {

    public static function getMenuItem($term = null, $term_divider = ".") {
        //Example term: "admin.employees.index"
        if (!$term) {
            $term = \Route::currentRouteName();
        }
        $pages = BreadcrumbHelper::availablePages();
        $list = explode($term_divider, $term);
        if (isset($list[1])) {
            return $list[1];
        }
    }
    
}
