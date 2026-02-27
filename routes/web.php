<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

