<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/',[AuthController::class,'loginPage'])->name('loginPage');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/registeration',[AuthController::class,'registerPage'])->name('registerPage');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');


Route::get('/students',[StudentController::class,'index'])->name('student.index');
Route::get('/users',[UserController::class,'index'])->name('user.index');
Route::get('/posts',[PostController::class,'index'])->name('post.index');


Route::middleware('check:admin')->group(function(){
    Route::put('/user-rolechange/{id}', [UserController::class, 'changeUserRole']);
});


Route::middleware('check:admin,create')->group(function(){
    Route::get('/student-create',[StudentController::class,'create'])->name('student.create');
    Route::post('/student-store',[StudentController::class,'store'])->name('student.store');

    Route::get('/post-create',[PostController::class,'create'])->name('post.create');
    Route::post('/post-store',[PostController::class,'store'])->name('post.store');

});


Route::middleware('check:admin,show')->group(function(){
    Route::get('/student-show/{student}',[StudentController::class,'show'])->name('student.show');
    Route::get('/post-show/{post}',[PostController::class,'show'])->name('post.show');
});


Route::middleware('check:admin,update')->group(function(){
    Route::get('/student-edit/{student}',[StudentController::class,'edit'])->name('student.edit');
    Route::put('/student-update/{id}',[StudentController::class,'update'])->name('student.update');

    Route::get('/post-edit/{post}',[PostController::class,'edit'])->name('post.edit');
    Route::put('/post-update/{id}',[PostController::class,'update'])->name('post.update');
});

Route::middleware('check:admin,delete')->group(function(){
    Route::delete('/post-delete/{post}',[PostController::class,'destroy'])->name('post.destroy');
    Route::delete('/student-delete/{id}',[StudentController::class,'destroy'])->name('student.destroy');
});



