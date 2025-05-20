<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    'enabled' => env('APP_ENV') === 'local',
    /*
     * Override the OpenAPI version to ensure compatibility with Stoplight Elements.
     * Scramble uses the key 'openapi_version' (not 'openapi') for this purpose.
     */
    'openapi_version' => '3.0.3',

    /*
     * Your API path. By default, all routes starting with this path will be added to the docs.
     */
    'api_path' => 'api',

    /*
     * Your API domain. By default, app domain is used.
     */
    'api_domain' => null,

    /*
     * The path where your OpenAPI specification will be exported.
     */
    'export_path' => 'api.json',

    'info' => [
        'version'     => env('API_VERSION', '0.0.1'),
        'description' => '',
    ],

    'ui' => [
        'title'                     => null,
        'theme'                     => 'light',
        'hide_try_it'               => false,
        'hide_schemas'              => false,
        'logo'                      => '',
        'try_it_credentials_policy' => 'include',
        'layout'                    => 'sidebar',
    ],

    'servers' => null,

    'enum_cases_description_strategy' => 'description',

    'middleware' => [
        'web',
        //RestrictedDocsAccess::class,
    ],

    'extensions' => [],
];
