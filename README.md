<h1 align="center">LaraTie</h1>
<p align="center">
    Laravel Package Development Boilerplate.
</p>

### Features
* Make package structure within a second
* Adding package resource using command line 
* Easy way to define your package custom structure 
* Adding custom stubs facilities 

### Installation
Go to terminal and run this command

```shell
composer require shipu/laratie
```

Wait for few minutes. Composer will automatically install this package for your project.
### For Laravel

Below **Laravel 5.5** open `config/app` and add this line in `providers` section

```php
Shipu\Tie\LaravelTieServiceProvider::class,
```
## Quick Configuration
Some configuration need for use this package. Open `config/tie.php` and update 
```
'vendor'        => '', // Your github username. For Example 'vendor' => 'shipu'
'rootNamespace' => '', // Root Namespace For Example: 'rootNamespace' => 'Shipu'
```
## Quick Usages
Go to terminal and run this command
```shell
php artisan package:create vendor package_name
or 
php artisan p:c vendor/package_name
or 
php artisan p:c
```
Then run `composer dump-autoload `; 
### Package Resources
if you want to create your package resource then run below command:
```shell
php artisan package:file vendor/package --stubkey=fileName
or 
php artisan p:f vendor/package --stubkey=fileName
```
Suppose you want make a controller for your package then:
```shell
php artisan package:file vendor/package --controller=TestController
```
Available `stubKey` :
```
--controller 
--command 
--events
--facades
--config
--migration
--job
--provider
--routes
--middleware
--class 
--exceptions
--key
```
If you have your own custom `stubKey` then you can choose `--key` for create package resource and value will be your stubKey.  
### Package Structure 
Open `config/tie.php` for setup your own package structure. Available configuration: 
```
<?php
return [
    ...
    'stubs' => [
        ...
        'structure' => [
            'stubKey' => [
                'namespace' => 'Namespace',
                'case'  => 'choose one from [lower, upper, snake, title, camel, kebab, studly']' // default studly
                'path' => 'your_path/folderName',
                'suffix' => 'FileNameSuffix',
                'prefix' => 'PrefixFileName',
                'extension' => 'file extension. dot php as default file extension'
                'files' => [
                    //  default file here
                    'default.extension',
                    'default.php',
                    'default.ini',
                    'default.jpg',
                    'PACKAGE_NAME.php'
                ]
            ],
            // or
            'stubKey' => 'your_path/folderName'
        ]
        ...
    ]
    ...
];
```
### Package Stub configuration
Open `config/tie.php` : 
```
<?php
return [
    ...
    'stubs' => [
        'path'      => [
            // adding more stub path for customize stub or new stub
            base_path('vendor/shipu/laravel-tie/src/Consoles/stubs'),
        ],
        'default'   => [
            // default stub key here, For Example your stubkey look like
            'composer',
            'src',
            'config',
            'provider',
            'tests',
        ],
        'root'      => 'stubKey', // folder path which is concating with vendor/package on composer.json
        ...
    ]
    ...
];
```
### String Replacement
For replace string to another string on stub template. Open `config/tie.php` :
```
return [
    ...
    'stubs' => [
        ...
        'replace'   => [
            // ADD YOUR REPLACEMENT STRING. For Example:
            'REPLACEMENT_KEY'    => 'Replacement String',
            'VENDOR_NAME_LOWER'  => 'shipu',
            'VENDOR_NAME'        => 'Shipu',
        ],
        ...
    ]
    ...
];
```
## Credits
- [Shipu Ahamed](https://github.com/shipu)
- [All Contributors](../../contributors)
### Security Vulnerabilities
If you discover a security vulnerability within LaraTie, please send an e-mail to Shipu Ahamed via [shipuahamed01@gmail.com](mailto:shipuahamed01@gmail.com).
### License
The LaraTie package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).