<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        'queue_admin' => [
            'driver' => 'session',
            'provider' => 'queue_admins',
        ],

       'queue_admin-api' => [
            'driver' => 'token',
            'provider' => 'queue_admins',
            'hash' => false,
        ],

        'station_admin' => [
            'driver' => 'session',
            'provider' => 'station_admins',
        ],

        'station_admin-api' => [
            'driver' => 'token',
            'provider' => 'station_admins',
            'hash' => false,
        ],

        'window_admin' => [
            'driver' => 'session',
            'provider' => 'window_admins',
        ],

        'window_admin-api' => [
            'driver' => 'token',
            'provider' => 'window_admins',
            'hash' => false,
        ],

        'flashboard' => [
            'driver' => 'session',
            'provider' => 'flashboards',
        ],

        'flashboard-api' => [
            'driver' => 'token',
            'provider' => 'flashboards',
            'hash' => false,
          ],

          'kiosk' => [
              'driver' => 'session',
              'provider' => 'kiosks',
          ],

          'kiosk-api' => [
              'driver' => 'token',
              'provider' => 'kiosks',
              'hash' => false,
            ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'queue_admins' => [
            'driver' => 'eloquent',
            'model' => App\QueueAdmins::class,
        ],

        'station_admins' => [
            'driver' => 'eloquent',
            'model' => App\StationAdmins::class,
        ],

        'window_admins' => [
            'driver' => 'eloquent',
            'model' => App\WindowAdmins::class,
        ],

        'flashboards' => [
            'driver' => 'eloquent',
            'model' => App\Flashboards::class,
        ],

        'kiosks' => [
            'driver' => 'eloquent',
            'model' => App\Kiosks::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
