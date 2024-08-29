<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


//Route::get('/login', [UserController::class, 'index'])->name('login');

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
     
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
         'email' => ['The provided credentials are incorrect.'],
        ]);
    } 
   

    $Token = $user->createToken($request->email)->plainTextToken;
    $response =['user' => $user,'token' =>$Token];

    return response($response,201);
    
});

//---------Authentification---------//

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);



// Protected routes
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::apiResource("users", UserController::class);
});

//Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');












Route::post('/adduser',[UserController::class,'create']);

//----TerrainApis-----//

Route::post('/addTerrain',[TerrainController::class,'create']);
Route::get('/getTerrain',[TerrainController::class,'index']);
Route::get('/getTerrain/{id}', [TerrainController::class, 'getTerainById']);
Route::post('/update/{id}',[TerrainController::class,'update']);
Route::delete('/deleteTerrain', [TerrainController::class, 'destroy']);


//----ReservationApis-----//
Route::get('/getReservations',[ReservationController::class,'index']);
Route::post('/addReservation',[ReservationController::class,'create']);
Route::post('/updateReservation/{id}',[ReservationController::class,'update']);
Route::post('/deleteReservation/{id}',[ReservationController::class,'destroy']);
//----ClientApis-----//
Route::post('/nombreClient/{sport}',[ReservationController::class,'nombreClient']);
// Exemple de middleware pour vérifier les autorisations
//Route::post('clients', [ClientsController::class, 'store'])->middleware('auth');


Route::get('clients', [ClientsController::class, 'index']);
Route::post('clients', [ClientsController::class, 'store']);
Route::put('clients/edit/{id}', [ClientsController::class, 'update']);
Route::delete('clients/delete/{id}', [ClientsController::class, 'destroy']);



