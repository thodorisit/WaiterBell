<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller {
    public function create(Request $request) {
        $_url_param__data = $request->input('data');
        $_url_param__height = intval($request->input('height'));
        $_url_param__width = intval($request->input('width'));
        if (empty($_url_param__data) || empty($_url_param__height) || empty($_url_param__width)) {
            abort(404);
        } else {
            $googleChartAPI = 'http://chart.apis.google.com/chart';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $googleChartAPI);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$_url_param__width}x{$_url_param__height}&cht=qr&chl=" . urlencode($_url_param__data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $img = curl_exec($ch);
        curl_close($ch);
        return response($img)->header('Content-Type','image/png')
                                ->header('Pragma','public')
                                ->header('Content-Disposition','inline; filename="waiterbell-'.$_url_param__data.'-'.$_url_param__width.'x'.$_url_param__height.'.png"')
                                ->header('Cache-Control','max-age=60, must-revalidate');
    }
}
