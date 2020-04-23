<?php

namespace App\Http\Middleware\Business;

use Closure;

use App\Helpers\Business\BreadcrumbHelper as BreadcrumbHelper;
use App\Helpers\Business\SidebarHelper as SidebarHelper;
use App\Helpers\Business\LocalizationHelper as LocalizationHelper;

class ViewSharing {

    public function handle($request, Closure $next) {
        view()->share('__breadcrumb', BreadcrumbHelper::create());
        view()->share('__sidebar_menu_item_current', SidebarHelper::getMenuItem());
        view()->share('__languages', [
            'all' => LocalizationHelper::languages_full(),
            'current' => LocalizationHelper::current()
        ]);
        return $next($request);
    }

}
