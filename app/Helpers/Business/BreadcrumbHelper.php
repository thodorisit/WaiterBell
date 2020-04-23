<?php

namespace App\Helpers\Business;

use Illuminate\Support\Facades\URL;

class BreadcrumbHelper {
    public static function availablePages() {
        $pages = [
            'business' => [
                '__data__' => [
                    'label' => __('business/breadcrumb.business._label'),
                    'state' => true,
                    'sub_url' => "business"
                ],
                'languages' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.languages._label'),
                        'state' => true,
                        'sub_url' => "languages"
                    ],
                    'all' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.languages.all._label'),
                            'state' => true,
                            'sub_url' => "all"
                        ]
                    ],
                    'create' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.languages.create._label'),
                            'state' => true,
                            'sub_url' => "create"
                        ]
                    ]
                ],
                'translations' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.translations._label'),
                        'state' => true,
                        'sub_url' => "translations"
                    ],
                    'all' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.translations.all._label'),
                            'state' => true,
                            'sub_url' => "all"
                        ]
                    ],
                    'edit' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.translations.edit._label'),
                            'state' => true,
                            'sub_url' => "edit"
                        ]
                    ]
                ],
                'labels' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.labels._label'),
                        'state' => true,
                        'sub_url' => "labels"
                    ],
                    'all' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.labels.all._label'),
                            'state' => true,
                            'sub_url' => "all"
                        ]
                    ],
                    'create' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.labels.create._label'),
                            'state' => true,
                            'sub_url' => "create"
                        ]
                    ],
                    'show' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.labels.show._label'),
                            'state' => true,
                            'sub_url' => "show"
                        ]
                    ],
                    'edit' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.labels.edit._label'),
                            'state' => true,
                            'sub_url' => "edit"
                        ]
                    ]
                ],
                'employees' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.employees._label'),
                        'state' => true,
                        'sub_url' => "employees"
                    ],
                    'all' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.employees.all._label'),
                            'state' => true,
                            'sub_url' => "all"
                        ]
                    ],
                    'create' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.employees.create._label'),
                            'state' => true,
                            'sub_url' => "create"
                        ]
                    ],
                    'show' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.employees.show._label'),
                            'state' => true,
                            'sub_url' => "show"
                        ]
                    ],
                    'edit' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.employees.edit._label'),
                            'state' => true,
                            'sub_url' => "edit"
                        ]
                    ]
                ],
                'connect_labels_employees' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.connect_labels_employees._label'),
                        'state' => true,
                        'sub_url' => "connect_labels_employees"
                    ]
                ],
                'notifications' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.notifications._label'),
                        'state' => true,
                        'sub_url' => "notifications"
                    ],
                    'all' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.notifications.all._label'),
                            'state' => true,
                            'sub_url' => "all"
                        ]
                    ],
                ],
                'request_types' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.request_types._label'),
                        'state' => true,
                        'sub_url' => "request_types"
                    ],
                    'all' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.request_types.all._label'),
                            'state' => true,
                            'sub_url' => "all"
                        ]
                    ],
                    'create' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.request_types.create._label'),
                            'state' => true,
                            'sub_url' => "create"
                        ]
                    ],
                    'edit' => [
                        '__data__' => [
                            'label' => __('business/breadcrumb.business.request_types.edit._label'),
                            'state' => true,
                            'sub_url' => "edit"
                        ]
                    ]
                ],
                'home' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.home._label'),
                        'state' => true,
                        'sub_url' => ""
                    ],
                ],
                'settings' => [
                    '__data__' => [
                        'label' => __('business/breadcrumb.business.settings._label'),
                        'state' => true,
                        'sub_url' => "settings"
                    ]
                ],
            ]
        ];
        return $pages;
    }

    public static function create($term = null, $breadcrumb_divider = "/", $term_divider = ".") {
        //Example term: "admin.employees.index"
        if (!$term) {
            $term = \Route::currentRouteName();
        }
        $pages = self::availablePages();
        $list = explode($term_divider, $term);
        $result = "";
        $url = "";
        for ($i=0; $i<count($list); $i++) {
            if ( isset($pages[$list[$i]]) ) {
                if ( 
                    (
                        isset($pages[$list[$i]]['__data__']['state']) 
                        && $pages[$list[$i]]['__data__']['state'] == true
                    ) || ( 
                        !isset($pages[$list[$i]]['__data__']['state'])
                    )
                ) {
                    $url .= $pages[$list[$i]]['__data__']['sub_url'] . '/';
                    $result .= ' <a href=" '.URL::to($url).' ">' . $pages[$list[$i]]['__data__']['label'] . '</a> ' . $breadcrumb_divider;
                }
                $pages = $pages[$list[$i]];
            } else {
                break;
            }
        }
        $result = rtrim($result, $breadcrumb_divider);
        return $result;
    }

}
