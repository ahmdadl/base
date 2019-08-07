<?php declare (strict_types = 1);

return [
    /**
     * appplicate name 
     * i do not know why its important but use it any way
     */
    'name' => 'APP_NAME',

    // default directories
    'dir' => [
        'root' => dirname(__DIR__) . DIRECTORY_SEPARATOR,
        // all below is based on root dir
        'views' => 'resources/views/',
        'config' => 'config/',
        'cache' => 'storage/cache/',
        'errlog' => 'storage/log/',
    ],

    // enviroment
    'env' => 'dev', // or 'prod'

    // is debug enabled for this enviroment
    'isDebug' => true,

    // hashids options
    'hashids' => [
        'minLength' => 5,
        'salt' => '4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d'
    ],

    // sessions options
    'name' => null, // use default webhost_SESSION
    'samesite' => 'Strict', // or `lax' for example.website.com
    // maxlife should be changed at App\Util\Session; class

    /**
     * create an unique csrf token for important forms
     * and store two versions of csrf tokenes in session
     * @example loginForm, changePassword and so on
     */
    'formToken' => true,
];