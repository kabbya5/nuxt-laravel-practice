<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
phpinfo();

});
Route::get('/test-proxy', [ProxyTestController::class, 'test']);

Route::get('/php-check', function () {
    return [
        'php_version' => phpversion(),
        'php_ini' => php_ini_loaded_file(),
    ];
});

Route::get('/chat', function(){
    return view('chat');
});

Route::get('/file-upload',function(){
    return view('welcome');
});