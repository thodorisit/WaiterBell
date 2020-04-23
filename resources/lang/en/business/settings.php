<?php

return [
    'meta_title__index' => 'Settings',
    'page_title__index' => 'Settings',
    'meta_title__add' => 'Requests for Customers | Add',
    'page_title__add' => 'Requests for Customers | Add',
    'meta_title__edit' => 'Requests for Customers | Edit',
    'page_title__edit' => 'Requests for Customers | Edit',

    'form__allowed_ips' => [
        'title' => 'Allowed IPs',
        'label' => 'Allowed IPs',
        'label_small' => 'IPs must be separated with commas. Only users from these IP addresses will be able to send notifications (requests for customers).',
        'errors' => [
        ],
        'success' => [
            'update' => 'Allowed IP addresses were updated!'
        ]
    ],
    'form__name' => [
        'title' => 'Update business name',
        'label' => 'Name',
        'label_small' => '',
        'errors' => [
            'empty' => 'Business name can\'t be empty!',
            'min' => 'Business name\'s minimum length is 1 character!',
            'max' => 'Business name\'s maximum length is 100 character!',
        ],
        'success' => [
            'update' => 'Busines name was updated!'
        ]
    ],
    'form__logo' => [
        'title' => 'Change business logo',
        'label' => 'Logo',
        'label_small' => '',
        'errors' => [
            'required' => 'Logo is required!',
            'image' => 'Wrong file type!',
            'mimes' => 'Wrong file type!',
            'max' => 'The maximum file size is 2Mb!',
        ],
        'success' => [
            'update' => 'Logo was updated!'
        ]
    ],
    'form__password' => [
        'title' => 'Update password',
        'label' => 'Password',
        'label_small' => 'Leave password field empty if don\'t want to update password!',
        'errors' => [
            'empty' => 'Password can\'t be empty!',
        ],
        'success' => [
            'update' => 'Password was updated!'
        ]
    ],
    'form__language' => [
        'title' => 'Update default language',
        'label' => 'Default language',
        'label_small' => '',
        'success' => [
            'update' => 'Default language was updated!'
        ]
    ],
    'form__webpush' => [
        'title' => 'Receive Web Push Notifications',
        'label' => '',
        'label_small' => '',
        'unsubscribe_label' => 'This device is subscribed to receive web push notifications for new notifications.',
        'unsubscribe_button' => 'Unsubscribe device',
        'subscribe_label' => 'This device is not subscribed and can\'t receive web push notifications for new notifications.',
        'subscribe_button' => 'Subscribe device',
        'success' => [
            'subscribed' => 'This device subscribed to receive web push notifications!',
            'unsubscribed' => 'This device unsubscribed from receive web push notifications!',
        ],
        'errors' => [
            'no_available_token' => "This feature requires enabled Push notifications from browser!"
        ]
    ],

    'update' => 'Update',

    'error' => 'Error',
    'warning' => 'Warning',
    'success' => 'Success',
];