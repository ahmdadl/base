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
        'views' => dirname(__DIR__) . '/resources/views/',
        'config' => dirname(__DIR__) . '/config//',
        'cache' => dirname(__DIR__) . '/storage/cache/',
        'errlog' => dirname(__DIR__) . '/storage/log/',
    ],

    /**
     * set current enviroment
     * dev || prod
     * setting to dev will display all errors on screen
     * and setting to prod will log errors only to error log directory
     */
    'env' => 'dev', // or 'prod'

    /**
     * is debug enabled for this enviroment
     * setting this to true will turn on whoops error handler
     * and setting to false will turn on custom errro handler
     * * Please be aware that setting this to false will stop 
     * * affecting the router with changes 
     * * and website will work on cached routes
     */
    'isDebug' => true,

    // hashids options
    'hashids' => [
        'minLength' => 5,
        'salt' => '4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d'
    ],

    // sessions options
    'session' => [
        'name' => null, // use default webSiteNameSESSION
        'samesite' => 'Strict', // or `lax' for example.website.com
        // maxlife should be changed at App\Util\Session class
    ],

    /**
     * create an unique csrf token for important forms
     * and store two versions of csrf tokenes in session
     * @example loginForm, changePassword and so on
     */
    'formToken' => true,
];