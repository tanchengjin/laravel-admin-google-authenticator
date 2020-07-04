<?php
Route::get('auth/login', 'tanchengjin\LaravelAdmin\Google\GoogleAuthenticator\Http\Controllers\GoogleAuthenticatorController@login');
Route::post('auth/login', 'tanchengjin\LaravelAdmin\Google\GoogleAuthenticator\Http\Controllers\GoogleAuthenticatorController@postLogin');