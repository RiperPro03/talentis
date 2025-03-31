<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => true,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:pwa-update-manifest
    */

    'manifest' => [
        'name' => 'Talentis',
        'short_name' => 'Talentis',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'display' => 'standalone',
        'description' => 'Talentis est une plateforme de gestion des offres, des candidatures et des talents.',
        'theme_color' => '#0e7490',
        'orientation' => 'portrait',

        'icons' => [
            [
                'src' => '/img/logo/logo.png',
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => '/img/logo/logo.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
        ],

        // Splash screens non nécessaires si tu n'as pas encore d'images adaptées
        'splash' => [],

        'custom' => []
    ],


    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

];
