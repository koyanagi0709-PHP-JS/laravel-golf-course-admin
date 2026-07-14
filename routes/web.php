<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GolfCourseController;

Route::get('/', function () {
    return view('welcome');
});

// Route::redirect('/','/golf-courses');

Route::middleware('guest')->group(function(){
    //     Route::get('/login', [LoginController::class, 'show'])->name('login');
    // Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
        //--- 認証 ---//
    // Route::get('/login',[LoginController::class, 'show'])->name('login');
    // Route::post('/login',[LoginController::class, 'store'])->name('login.store');
});

Route::prefix('golf-courses')->name('golf-courses.')->group(function () {
    //--- 一覧・新規作成 ---//
    Route::get('/',[GolfCourseController::class,'index'])->name('index'); // 一覧画面
    Route::get('/create',[GolfCourseController::class,'create'])->name('create'); //新規作成
    Route::post('/',[GolfCourseController::class,'store'])->name('store');//新規作成 処理

    //--- 削除済 ---//
    Route::get('/trashed',[GolfCourseController::class,'trashed'])->name('trashed'); //削除済 一覧
    Route::post('/{id}/restore',[GolfCourseController::class,'restore'])->name('restore')->whereNumber('id'); //復元処理
    
    //--- 個別画面・更新・削除 ---//
    Route::get('/{id}',[GolfCourseController::class,'show'])->name('show')->whereNumber('id');//詳細画面
    Route::get('/{id}/edit',[GolfCourseController::class,'edit'])->name('edit')->whereNumber('id');//編集
    Route::put('/{id}',[GolfCourseController::class,'update'])->name('update')->whereNumber('id');//更新処理
    Route::get('/{id}/delete',[GolfCourseController::class,'delete'])->name('delete')->whereNumber('id');//削除画面
    Route::delete('/{id}',[GolfCourseController::class,'destroy'])->name('destroy')->whereNumber('id');//削除処理

});