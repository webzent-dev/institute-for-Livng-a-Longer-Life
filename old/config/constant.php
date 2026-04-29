<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Constant File
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    'roles' => [
        'admin'         => 1,
        'collaborator'  => 2,  
        'member'        => 3
    ],
    'userRolesByName' => [
        1   => 'Admin' ,  
        2   => 'Collaborator',
        3   => 'Member'
    ],
    'path' => [
        'upload_signature_path' => 'public/images/signature/',
        'user_document_path' => 'public/images/users/', //User document path
        'vehicle_document_path' => 'public/images/vehicle/', //Vehicle document path
        'profile_image_path' => '/public/images/profile/', //Profile document path
        'category_image_path' => '/public/images/category/', //category images path
        'product_image_path' => '/public/images/products/', //product images path
        'product_details_path' => '/products/details/', //product details path
        'product_image_folder' => '/images/products/',
        'government_ids_folder' => 'public/images/government_ids/',
        'category_file_path' => '/images/category/', //category images path : added By Sajid Ali
        'product_file_path' => '/images/products/', //product images path : added By Sajid Ali
        'log_path' => '\logs', //log folder path
        'laravel_log_path' => '/storage/logs/', //laravel log file path
    ],
    'success' => [
        'status' => true,
        'errortrue' => false,
        'statusCode' => 200,
        'general_setting_add_message' => 'General setting added successfully.',
        'general_setting_not_add_message' => '',
        'email_setting_add_message' => 'Email setting added successfully.',
        'email_setting_not_add_message' => '',
        'security_setting_add_message' => 'Security setting added successfully.',
        'security_setting_not_add_message' => '',
        'status_change_message' => 'Status has been changed successfully.',
        'status_enable_message' => '{text} enabled successfully.',
        'status_disable_message' => '{text} disabled successfully.',
    ],
    'error' => [
        'status' => 'false',
        'errortrue' => true,
        'statusCode' => 404,
        'general_setting_add_message' => '',
        'general_setting_not_add_message' => 'Unable to add general setting. Please try again...!!!',
        'email_setting_add_message' => '',
        'email_setting_not_add_message' => 'Unable to add email setting. Please try again...!!!',
        'security_setting_add_message' => '',
        'security_setting_not_add_message' => 'Unable to add security setting. Please try again...!!!',
        'status_change_message' => 'Unable to change status. Please try again...!!!',
    ],
];