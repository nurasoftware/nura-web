<?php

/*
 * Add your custom configuration details
 */


return [

    /*
    |--------------------------------------------------------------------------
    | Custom modules
    |--------------------------------------------------------------------------
    |
    */
    'modules' => [
        'custom_module_1' => [
            'label' => 'Mudule label'
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Custom items for admin sidebar
    |--------------------------------------------------------------------------
    |
    */
    'sidebar_admin_items' => [

        /*
        'custom_module_1' => [
            'label' => 'Custom item 1 label',
            'route' => 'admin',
            'icon' => '<i class="bi bi-file-text"></i>'
        ],

        'custom_module_2' => [
            'label' => 'Custom items 2',
            'icon' => '<i class="bi bi-file-text"></i>',
            'items' => [
                'dropdown1' => [
                    'label' => 'Custom dropdown 1',
                    'route' => 'admin',
                ],
                'dropdown2' => [
                    'label' => 'Custom dropdown 2',
                    'route' => 'admin.accounts.index',
                ],
            ],
        ],
        
        */

    ],

];
