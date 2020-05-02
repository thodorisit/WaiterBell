<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Business;
use App\Employee;
use App\Label;
use App\Language;
use App\Notification;
use App\RequestTypes;
use App\Translation;
use App\Pivot\LabelEmployee as PivotLabelEmployee;

class MasterController extends Controller {
    public function __construct() {
        if (env('MASTER_ACCESS', '') != 1) {
            abort(404);
        }
    }
    public function md5(Request $request) {
        return md5($request->input('value'));
    }
    public function create_business(Request $request) {
        $_url_param__security_key = $request->input('securiy_key');
        $_url_param__business_username = $request->input('business_username');
        $_url_param__business_password = $request->input('business_password');

        if (empty($_url_param__security_key) || empty($_url_param__business_username) || empty($_url_param__business_password)){
            abort(404);
        }
        
        $env_master_security_key = env('MASTER_SECURITY_KEY', '');
        if (md5($_url_param__security_key) == $env_master_security_key) {
            $whereStatements = [
                ['username', '=', $_url_param__business_username]
            ];
            $results = Business::where($whereStatements)
                                    ->take(1)
                                    ->first(['id']);
            if ($results == null) {
                $newBusiness = Business::create([
                    'username' => $_url_param__business_username,
                    'password' => Hash::make($_url_param__business_password),
                ]);
                Language::create([
                    'business_id' => $newBusiness->id,
                    'name' => 'english',
                    'native_name' => 'English',
                    'slug' => 'en',
                    'is_default' => 1,
                ]);
                Translation::insert([
                    [
                        'business_id' => $newBusiness->id,
                        'attribute' => 'customer.home.seat',
                        'translations' => '{"default":"Seat","en":"Seat"}'
                    ],
                    [
                        'business_id' => $newBusiness->id,
                        'attribute' => 'customer.home.choose_reason',
                        'translations' => '{"default":"Choose option","en":"Choose option"}'
                    ],
                    [
                        'business_id' => $newBusiness->id,
                        'attribute' => 'customer.home.choose_language',
                        'translations' => '{"default":"Choose language","en":"Choose language"}'
                    ],
                    [
                        'business_id' => $newBusiness->id,
                        'attribute' => 'customer.home.success_message',
                        'translations' => '{"default":"We have received your call!","en":"We have received your call!"}'
                    ],
                    [
                        'business_id' => $newBusiness->id,
                        'attribute' => 'customer.home.error_message',
                        'translations' => '{"default":"Something went wrong. Please try again!","en":"Something went wrong. Please try again!"}'
                    ],
                    [
                        'business_id' => $newBusiness->id,
                        'attribute' => 'customer.home.already_received_limit',
                        'translations' => '{"default":"We have already received your call!","en":"We have already received your call!"}'
                    ]
                ]);
                return 'Business was added!';
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function delete_business(Request $request) {
        $_url_param__security_key = $request->input('securiy_key');
        $_url_param__business_id = $request->input('business_id');
        if (empty($_url_param__security_key) || empty($_url_param__business_id)){
            abort(404);
        }
        $env_master_security_key = env('MASTER_SECURITY_KEY', '');
        if (md5($_url_param__security_key) == $env_master_security_key) {
            Business::where('id', $_url_param__business_id)->delete();
            Employee::where('business_id', $_url_param__business_id)->delete();
            Label::where('business_id', $_url_param__business_id)->delete();
            Language::where('business_id', $_url_param__business_id)->delete();
            Notification::where('business_id', $_url_param__business_id)->delete();
            RequestTypes::where('business_id', $_url_param__business_id)->delete();
            Translation::where('business_id', $_url_param__business_id)->delete();
            PivotLabelEmployee::where('business_id', $_url_param__business_id)->delete();
            return 'Business was deleted!';
        } else {
            abort(404);
        }
    }
}
