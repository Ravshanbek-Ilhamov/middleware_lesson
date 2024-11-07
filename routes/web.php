<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/',[AuthController::class,'loginPage'])->name('loginPage');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/registeration',[AuthController::class,'registerPage'])->name('registerPage');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');



Route::middleware('check:admin')->group(function(){
    
    Route::get('/roles',[AuthController::class,'roles'])->name('auth.roles');
    Route::put('/roles/{role}/toggle-status', [AuthController::class, 'toggleStatus'])->name('roles.toggleStatus');

    Route::put('/user-rolechange/{id}', [UserController::class, 'changeUserRole']);
    Route::get('/users',[UserController::class,'index'])->name('user.index');
    Route::get('/user-edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user-store',[UserController::class,'store'])->name('user.store');
    Route::delete('/user-delete/{user}',[UserController::class,'destroy'])->name('user.destroy');

    Route::get('/posts',[PostController::class,'index'])->name('post.index');
    Route::get('/post-edit/{post}',[PostController::class,'edit'])->name('post.edit');
    Route::get('/post-create',[PostController::class,'create'])->name('post.create');
    Route::post('/post-store',[PostController::class,'store'])->name('post.store');
    Route::get('/post-show/{post}',[PostController::class,'show'])->name('post.show');
    Route::put('/post-update/{id}',[PostController::class,'update'])->name('post.update');

    Route::get('/students',[StudentController::class,'index'])->name('student.index');
    Route::get('/student-create',[StudentController::class,'create'])->name('student.create');
    Route::post('/student-store',[StudentController::class,'store'])->name('student.store');
    Route::get('/student-show/{student}',[StudentController::class,'show'])->name('student.show');
    Route::get('/student-edit/{student}',[StudentController::class,'edit'])->name('student.edit');
    Route::put('/student-update/{id}',[StudentController::class,'update'])->name('student.update');
    Route::delete('/student-delete/{id}',[StudentController::class,'destroy'])->name('student.destroy');

    Route::get('/companies',[CompanyController::class,'index'])->name('company.index');
    Route::delete('/company-delete/{company}',[CompanyController::class,'destroy'])->name('company.destroy');

    Route::get('/categories',[CategoryController::class,'index'])->name('category.index');
    Route::delete('/category-delete/{category}',[CategoryController::class,'destroy'])->name('category.destroy');
});

Route::middleware('check:post')->group(function(){

    Route::get('/posts',[PostController::class,'index'])->name('post.index');
    Route::get('/post-edit/{post}',[PostController::class,'edit'])->name('post.edit');

    Route::get('/post-create',[PostController::class,'create'])->name('post.create');
    Route::post('/post-store',[PostController::class,'store'])->name('post.store');
    Route::get('/post-show/{post}',[PostController::class,'show'])->name('post.show');

    Route::put('/post-update/{id}',[PostController::class,'update'])->name('post.update');

});


Route::middleware('check:student')->group(function(){

    Route::get('/students',[StudentController::class,'index'])->name('student.index');
    Route::get('/student-create',[StudentController::class,'create'])->name('student.create');
    Route::post('/student-store',[StudentController::class,'store'])->name('student.store');
    Route::get('/student-show/{student}',[StudentController::class,'show'])->name('student.show');
    Route::get('/student-edit/{student}',[StudentController::class,'edit'])->name('student.edit');
    Route::put('/student-update/{id}',[StudentController::class,'update'])->name('student.update');
    Route::delete('/student-delete/{id}',[StudentController::class,'destroy'])->name('student.destroy');
});


Route::middleware('check:company')->group(function(){
    Route::get('/companies',[CompanyController::class,'index'])->name('company.index');
    Route::delete('/company-delete/{company}',[CompanyController::class,'destroy'])->name('company.destroy');    

});


Route::middleware('check:category')->group(function(){

    Route::get('/categories',[CategoryController::class,'index'])->name('category.index');
    Route::delete('/category-delete/{category}',[CategoryController::class,'destroy'])->name('category.destroy');
});

































