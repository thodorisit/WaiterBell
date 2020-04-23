<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Notification;
use App\Label;

class NotificationsController extends Controller {

    public function __construct() {
        $this->middleware('BusinessRequiresLogin')->only([
            'all',
            'create',
            'create_action',
            'delete',
        ]);
    }
    
    public function all(Request $request) {
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

        $_url_search_parameters = [];
        $whereStatements = [];
        if (!empty($_url_param__id_string)) {
            $_url_search_parameters['id'] = $_url_param__id_string;
        }
        if (!empty($_url_param__label_id_string)) {
            $_url_search_parameters['label_id'] = $_url_param__label_id_string;
        }
        if (!empty($_url_param__title)) {
            $_url_search_parameters['title'] = $_url_param__title;
        }
        if (!empty($_url_param__body)) {
            $_url_search_parameters['body'] = $_url_param__body;
        }
        if (!empty($_url_param__date_from)) {
            $_url_search_parameters['date_from'] = $_url_param__date_from;
        }
        if (!empty($_url_param__date_to)) {
            $_url_search_parameters['date_to'] = $_url_param__date_to;
        }
        if (!empty($_url_param__state)) {
            $_url_search_parameters['state'] = $_url_param__state;
        }
        if (!empty($_url_param__order_by)) {
            $_url_search_parameters['order_by'] = $_url_param__order_by;
        }
        
        $return_data = Notification::with('label')
                                ->where($whereStatements)
                                ->filterIds($_url_param__id)
                                ->hasLabelIds($_url_param__label_id)
                                ->filterTitle($_url_param__title)
                                ->filterBody($_url_param__body)
                                ->filterDateFrom($_url_param__date_from)
                                ->filterDateTo($_url_param__date_to)
                                ->filterState($_url_param__state)
                                ->orderByDate($_url_param__order_by)
                                ->sessionBusinessId()
                                ->paginate(10)
                                ->appends($_url_search_parameters);
        return view('business.notifications.all', [
            'table' => $return_data
        ]);
    }

    public function delete(Request $request) {
        $ids = $request->input('id', null);
        $ids = explode(',', $ids);
        $ids = array_values(array_filter($ids, function($id) { return is_numeric($id) && ( ctype_digit($id) || is_int($id) ); }));
        Notification::sessionBusinessId()
                    ->whereIn('id', $ids)
                    ->delete();
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/notifications.data_deleted_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

    public function complete_state_action(Request $request) {
        $_form__notification_id = $request->input('id');
        Notification::sessionBusinessId()
                    ->where([
                        'id' => $_form__notification_id,
                    ])->update([
                        'state' => '1'
                    ]);
        \Session::flash('toasts',
            [
                'success' => [
                    __('business/notifications.data_updated_successfully')
                ]
            ]
        );
        return redirect()->back();
    }

}
