<?php
return [
    'root'          => base_path('packages'), // Base directory
    'vendor'        => '', // Your github username. For Example 'vendor' => 'shipu'
    'rootNamespace' => '', // Root Namespace For Example: 'rootNamespace' => 'Shipu'
    /*
    |--------------------------------------------------------------------------
    | Package Stubs
    |--------------------------------------------------------------------------
    |
    | Default package stubs.
    |
    */
    'stubs'         => [
        'path'      => [
            // adding more stub path for customize stub or new stub
            base_path('vendor/shipu/laratie/src/Consoles/stubs'),
        ],
        'default'   => [
            // default stub key here
            'composer',
            'src',
            'config',
            //'provider', // laravel service provider
            //'filament-plugin-provider', // please uncomment if you need filament plugin service provider
            'spatie-provider', // spatie service provider
            'tests',
        ],
        'root'      => 'src/', // your root folder path which is concat with vendor/package on composer.json
        'structure' => [
//             Example config start
//            'stubKey' => [
//                'namespace' => 'Namespace',
//                'case'  => 'lower or upper or snake or title or camel or kebab or studly', // default studly
//                'path' => 'your_path/folderName',
//                'suffix' => 'FileNameSuffix',
//                'prefix' => 'PrefixFileName',
//                'extension' => 'file extension. dot php as default file extension'
//                'files' => [
//                    //  default file here
//                    'default.extension',
//                    'default.php',
//                    'default.ini',
//                    'default.jpg',
//                    'PACKAGE_NAME.php'
//                ]
//            ],
//             Example config end
            'src'        => 'src/',
            'migration'  => [
                'path' => 'database/migrations',
                'case' => 'snake',
                'extension' => 'php',
            ],
//            'migration-legacy'  => 'database/migrations',
            'config'     => [
                'path'  => 'config',
                'case'  => 'kebab',
                'files' => [
                    'PACKAGE_NAME.php',
                ],
            ],
            'views'      => 'src/Resources/views',
            'events'     => [
                'namespace' => 'Events',
                'path'      => 'src/Events',
            ],
            'jobs'       => [
                'namespace' => 'Jobs',
                'path'      => 'src/Jobs',
            ],
            'exceptions' => [
                'namespace' => 'Exceptions',
                'suffix'    => 'Exception',
                'path'      => 'src/Exceptions',
            ],
            'middleware' => [
                'namespace' => 'Http\Middleware',
                'path'      => 'src/Http/Middleware',
            ],
            'provider'   => [
                'suffix'    => 'ServiceProvider',
                'path'      => 'src/',
                'files'     => [
                    'PACKAGE_NAME.php',
                ],
            ],
            'filament-plugin-provider' => [
                'suffix'    => 'ServiceProvider',
                'path'      => 'src/',
                'files'     => [
                    'PACKAGE_NAME.php',
                ],
            ],
            'spatie-provider' => [
                'suffix'    => 'ServiceProvider',
                'path'      => 'src/',
                'files'     => [
                    'PACKAGE_NAME.php',
                ],
            ],
            'facades'    => [
                'namespace' => 'Facades',
                'suffix'    => 'Facades',
                'path'      => 'src/Facades',
            ],
            'controller' => [
                'namespace' => 'Http\Controllers',
                'suffix'    => 'Controller',
                'path'      => 'src/Http/Controllers',
                'files'     => [
                    'PACKAGE_NAME',
                ],
            ],
            'filament-page' => [
                'namespace' => 'Filament\Pages',
                'path'      => 'src/Filament/Pages'
            ],
            'filament-resource' => [
                'namespace' => 'Filament\Resources',
                'suffix'    => 'Resource',
                'path'      => 'src/Filament/Resources'
            ],
            'routes'     => [
                'path'  => 'src/Routes/',
                'files' => [
                    'routes.php',
                ],
            ],
            'trait'      => [
                'namespace' => 'Traits',
                'path'      => 'src/Traits/',
                'suffix'    => 'Trait',
                'files'     => [
                    'PACKAGE_NAME.php',
                ],
            ],
            'command'    => [
                'namespace' => 'Consoles',
                'suffix'    => 'Command',
                'path'      => 'src/Consoles/',
            ],
            'tests'      => 'tests/',
            'composer'   => [
                'case'      => 'lower',
                'extension' => 'json',
                'files'     => [
                    'composer'
                    // or 'composer.json'
                ],
            ],
        ],
        'replace'   => [
//            'VENDOR_NAME_LOWER'  => 'shipu',
//            'VENDOR_NAME'        => 'Shipu',
        ],
    ],
];
