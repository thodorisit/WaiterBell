<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;
use App\Notification;

use App\Helpers\Employee\EmployeeSessionHelper as EmployeeSessionHelper;

class NotificationsController extends Controller {

    public function __construct() {
        $this->middleware('EmployeeRequiresLogin')->only([
            'all',
            'complete_state_action',
        ]);
    }
    
    public function all(Request $request) {
        $employeeObject = Employee::where([
                                        'id' => EmployeeSessionHelper::id()
                                    ])
                                    ->first();
        $labels_connected_employee = $employeeObject->labels->pluck('id')->toArray();

        //Input: ID
        $_url_param__id_string = $request->input('id', null);
        $_url_param__id = explode(',', $_url_param__id_string);
        $_url_param__id = array_values(array_filter($_url_param__id, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        //Input: Label IDS
        $_url_param__label_id_string = $request->input('label_id', null);
        $_url_param__label_id = explode(',', $_url_param__label_id_string);
        $_url_param__label_id = array_values(array_filter($_url_param__label_id, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        //Input: Title
        $_url_param__title = $request->input('title', null);
        //Input: Body
        $_url_param__body = $request->input('body', null);
        //Input: Date from
        $_url_param__date_from = $request->input('date_from', null);
        //Input: Date to
        $_url_param__date_to = $request->input('date_to', null);
        //Input: State
        $_url_param__state = $request->input('state', null);
        //Input: Order by
        $_url_param__order_by = $request->input('order_by', null);

        $_filters_badges = [];
        $_url_search_parameters = [];
        $whereStatements = [];
        if (!empty($_url_param__id_string)) {
            $_url_search_parameters['id'] = $_url_param__id_string;
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__id'),
                'value' => $_url_param__id_string
            ];
        }
        if (!empty($_url_param__label_id_string)) {
            $_url_search_parameters['label_id'] = $_url_param__label_id_string;
            $common_label_ids = array_intersect($labels_connected_employee, $_url_param__label_id);
            $labels_connected_employee = $common_label_ids;
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__label_id'),
                'value' => $_url_param__label_id_string
            ];
        }
        if (!empty($_url_param__title)) {
            $_url_search_parameters['title'] = $_url_param__title;
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__title'),
                'value' => $_url_param__title
            ];
        }
        if (!empty($_url_param__body)) {
            $_url_search_parameters['body'] = $_url_param__body;
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__body'),
                'value' => $_url_param__body
            ];
        }
        if (!empty($_url_param__date_from)) {
            $_url_search_parameters['date_from'] = $_url_param__date_from;
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__date_from'),
                'value' => $_url_param__date_from
            ];
        }
        if (!empty($_url_param__date_to)) {
            $_url_search_parameters['date_to'] = $_url_param__date_to;
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__date_to'),
                'value' => $_url_param__date_to
            ];
        }
        if (!empty($_url_param__state)) {
            $_url_search_parameters['state'] = $_url_param__state;
            if ($_url_param__state == 0) {
                $_filters_badges[] = [
                    'label' => __('business/notifications.column_table__state'),
                    'value' => __('business/notifications.search_form__state__pending'),
                ];
            } elseif ($_url_param__state == 1) {
                $_filters_badges[] = [
                    'label' => __('business/notifications.column_table__state'),
                    'value' => __('business/notifications.search_form__state__done'),
                ];
            } elseif ($_url_param__state == 9) {
                $_filters_badges[] = [
                    'label' => __('business/notifications.column_table__state'),
                    'value' => __('business/notifications.search_form__state__all'),
                ];
            }
        } else {
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__state'),
                'value' => __('business/notifications.search_form__state__pending'),
            ];
        }
        if (!empty($_url_param__order_by)) {
            $_url_search_parameters['order_by'] = $_url_param__order_by;
            if ($_url_param__order_by == 'desc') {
                $_filters_badges[] = [
                    'label' => __('business/notifications.column_table__order_by'),
                    'value' => __('business/notifications.search_form__order_by_date__descending')
                ];
            } elseif($_url_param__order_by == 'asc') {
                $_filters_badges[] = [
                    'label' => __('business/notifications.column_table__order_by'),
                    'value' => __('business/notifications.search_form__order_by_date__ascending')
                ];
            }
        } else {
            $_filters_badges[] = [
                'label' => __('business/notifications.column_table__order_by'),
                'value' => __('business/notifications.search_form__order_by_date__descending')
            ];
        }
        $notifications = Notification::hasLabelIds($labels_connected_employee, false)
                                        ->filterIds($_url_param__id)
                                        ->filterTitle($_url_param__title)
                                        ->filterBody($_url_param__body)
                                        ->filterDateFrom($_url_param__date_from)
                                        ->filterDateTo($_url_param__date_to)
                                        ->filterState($_url_param__state)
                                        ->orderByDate($_url_param__order_by)
                                        ->paginate(10)
                                        ->appends($_url_search_parameters);
        return view('employee.notifications.all', 
            [
                'notifications' => $notifications,
                'notifications_filters' => $_filters_badges
            ]
        );
    }

    public function complete_state_action(Request $request) {
        $_form__notification_id = $request->input('notification_id');
        Notification::where([
            'id' => $_form__notification_id,
            'business_id' => EmployeeSessionHelper::business_id()
        ])->update([
            'state' => '1'
        ]);
        return redirect()->back();
    }

}
