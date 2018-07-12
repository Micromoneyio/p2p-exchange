<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'client_id' => '531964876786-ust9t6lkgdmejf0npaoq3qf10422vs5p.apps.googleusercontent.com',
        'secret' => 'OmbPlfeg-_UN0AS6LfherLCy',
        'api_key' => 'AIzaSyAaGRiitEZm1vdwsMtaaSdGFbCd981Znmo',
        'app_name' => 'Exchange',
    ],
    'facebook' => [
        'client_id' => '832591046950309',
        'client_secret' => 'fa5c4c0646c2410846e21214a081c14a',
        'redirect' => '/redirect',
    ],


];
