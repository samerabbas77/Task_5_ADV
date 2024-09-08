<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group([
     'middleware' => 'api',
   ], function ($router) {
          //Authentecation
          Route::post('/register', [AuthController::class, 'register'])->name('register');
          Route::post('/login', [AuthController::class, 'login'])->name('login');
          Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
          Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
          Route::post('/me', [AuthController::class, 'info'])->middleware('auth:api')->name('me');
//.....................................................................................
//User
        Route::middleware('isAdmin')->group(function () {

          Route::apiResource('/user', UserController::class)->only(['index','store','update']);
          //restore
          Route::post('/user/restore/{id}',[UserController::class,'restore']);

      }); 
      //Admin and user
      Route::apiResource('/user', UserController::class)->only(['show','destroy']);

      //user update
      Route::put('/user/update/{user}',[UserController::class,'updateForUser']);


     
//...........................................................................
//Task
    Route::middleware('isAdmin')->group(function () {

      Route::apiResource('/task', TaskController::class)->only(['index','store','destroy']);
      //restore
      Route::post('/task/restore/{id}',[TaskController::class,'restore']);

    }); 
      // //show all current user tasks
      Route::get('/task/user/',[TaskController::class,'show']);

      //update the ststus only
      Route::put('/task/{task} ', [TaskController::class,'update'])->middleware('isOwner');

      //assigned to
      Route::put('/task/{id}/assign', [TaskController::class,'assignedTo'])->middleware('assignedToMiddleWare');
     
      



   });
   
