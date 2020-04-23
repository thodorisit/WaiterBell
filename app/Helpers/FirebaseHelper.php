<?php

namespace App\Helpers;

//use GuzzleHttp\Client;

class FirebaseHelper {
    public static function send($users = [], $title = "", $body = "", $click_action = "", $icon = "") {
        $env_firebase_key = env('FIREBASE_KEY', '');
        if ($env_firebase_key !== "") {
            $response = [
                'number_of_chunks' => 0,
                'completed_successfully' => 0
            ];
            try {
                $users = array_chunk($users,1000,false);
                $response['number_of_chunks'] = count($users);
                foreach($users as $user_chunk) {
                    $data = [
                        'notification' => [
                            'title' => $title,
                            'body' => $body,
                            'icon' => $icon,
                            'click_action' => $click_action
                        ],
                        'registration_ids' => $user_chunk,
                        'priority' => 10
                    ];
                    $data = json_encode($data);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization: key='.$env_firebase_key;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $curl_response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        
                    } else {
                        $response['completed_successfully']++;
                    }
                    curl_close($ch);
                    ob_flush();
                }
                return $response;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }
}
