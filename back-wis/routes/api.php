<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require __DIR__.'/auth.php';
require __DIR__.'/compagny.php';
//require __DIR__.'/compagnyVerification.php';
//require __DIR__.'/compagnyInvitation.php';
require __DIR__.'/profile.php';
require __DIR__.'/job.php';
require __DIR__.'/application.php';
require __DIR__.'/codelist.php';
require __DIR__.'/subscription.php';
