<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;
use App\Helpers\Employee\EmployeeSessionHelper as EmployeeSessionHelper;

class SettingsController extends Controller {

    public function __construct() {
        $this->middleware('EmployeeRequiresLogin')->only([
            'update_push_token_action'
        ]);
    }

    public function update_push_token_action(Request $request) {
        $_form__push_token = $request->input('push_token');
        $_form__reason = $request->input('reason');
        if ($_form__reason == 'subscribe') {
            if (!empty($_form__push_token)) {
                Employee::where([
                                ['id', '=', EmployeeSessionHelper::id()]
                            ])
                            ->update([
                                'push_notification_token' => $_form__push_token
                            ]);
                \Session::flash('toasts',
                    [
                        'success' => [
                            __('business/settings.form__webpush.success.subscribed')
                        ]
                    ]
                );
                return redirect()->back();
            } else {
                \Session::flash('toasts',
                    [
                        'error' => [
                            __('business/settings.form__webpush.errors.no_available_token')
                        ]
                    ]
                );
                return redirect()->back();
            }
        } elseif ($_form__reason == 'unsubscribe') {
            Employee::where([
                            ['id', '=', EmployeeSessionHelper::id()]
                        ])
                        ->update([
                            'push_notification_token' => ""
                        ]);
            \Session::flash('toasts',
                [
                    'success' => [
                        __('business/settings.form__webpush.success.unsubscribed')
                    ]
                ]
            );
            return redirect()->back();
        } elseif ($_form__reason == 'refresh_token') {
            if (!empty($_form__push_token)) {
                //Check if business has enabled push notifications
                $employeeObject = Employee::where([
                                                ['id', '=', EmployeeSessionHelper::id()]
                                            ])->first();
                if ($employeeObject) {
                    if ($employeeObject->push_notification_token != "" && $businessObject->push_notification_token != null) {
                        Employee::where([
                                        ['id', '=', EmployeeSessionHelper::id()]
                                    ])
                                    ->update([
                                        'push_notification_token' => $_form__push_token
                                    ]);
                        return response()->json([
                            'success' => '1'
                        ]);
                    } else {
                        return response()->json([
                            'success' => '0'
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => '0'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => '0'
                ]);
            }
        } else {
            return redirect()->back();
        }
    }

}
