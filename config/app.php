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
        'minLength' => 8,
        'salt' => 'b6dff7e3c43229cdb1db2dcb24b1b54a20943584c8b2233f398ab6b6c6c840ef939325\04eada4131354751765c3ddez1ed2a6cd6614580002a05e137d300a40e44ad96ae40b44'
    ],

    // sessions options
    'session' => [
        'name' => null, // use default webSiteNameSESSION
        'samesite' => 'Strict', // or `lax' for multi domain websites

        /**
         * destroy the after a period 
         * if user has not make any request in that time
         * @var int number of seconds
         */
        'maxlife' => 1800 // 30 min
    ],

    /**
     * create an unique csrf token for important forms
     * and store two versions of csrf tokenes in session
     * @example loginForm, changePassword and so on
     */
    'formToken' => true,
];