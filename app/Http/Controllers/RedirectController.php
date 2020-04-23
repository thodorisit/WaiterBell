<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller {

    public function notificationOpenUrl(Request $request) {
        if (!empty($request->route('id') != null)) {
            //If user is logged in as business
            if (\Session::get('employee_login_token')) {
                return redirect()->route('employee.notifications.all', ['id' => $request->route('id')]);
            } else {
                return redirect()->route('business.notifications.all', ['id' => $request->route('id')]);
            }
        } else {
            //If user is logged in as business
            if (\Session::get('employee_login_token')) {
                return redirect()->route('employee.home');
            } else {
                return redirect()->route('business.home');
            }
        }
    }

    public function tinyUrlRedirect(Request $request) {
        if (!empty($request->route('id') != null)) {
            return redirect()->route('customer.home', ['label_id' => $request->route('id')]);
        } else {
            return redirect()->route('customer.not_found');
        }
    }

}
