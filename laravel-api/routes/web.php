<?php

use App\Http\Controllers\FileTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
phpinfo();

});

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

Route::post('/file/uploads', [FileTestController::class, 'uploads'])->name('file.uploads');

Route::get('/wingo', [FileTestController::class, 'wingo'])->name('wingo');