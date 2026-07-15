<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GolfCourseController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| アプリケーションのルーティング定義です。
| セキュリティ上の理由から、ログインの有無（guest/authミドルウェア）により
| アクセス制御を適切にグループ分けして定義しています。
|
*/

// トップページ（ウェルカム画面）
Route::redirect('/','/golf-courses');

// =========================================================================
// 1. 認証・ログイン関連ルート
// =========================================================================

// 【ゲスト（未ログイン）専用】
// 既にログインしているユーザーがアクセスした場合は、自動的にリダイレクトされます（RedirectIfAuthenticated）
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');          // ログイン画面表示
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');    // ログイン処理実行
});

// 【ログイン済み専用】
// ログインしているユーザーのみアクセス可能です
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');    // ログアウト処理 (セッション破棄・トークン再生成)
});

// =========================================================================
// 2. ゴルフ場管理 (golf-courses) 関連ルート
// =========================================================================
Route::prefix('golf-courses')->name('golf-courses.')->group(function () {

    // -------------------------------------------------------------
    // 【管理者専用ルート】ログインしている場合のみ操作・アクセスが許可される画面
    // -------------------------------------------------------------
    Route::middleware('auth')->group(function () {
        // 一覧・CSVダウンロード・詳細
        Route::get('/', [GolfCourseController::class, 'index'])->name('index');                         // ゴルフ場一覧画面
        Route::get('/export', [GolfCourseController::class, 'export'])->name('export');                 // CSVダウンロード

        Route::get('/{id}', [GolfCourseController::class, 'show'])->name('show')->whereNumber('id');    // ゴルフ場詳細画面

        // 新規登録関連
        Route::get('/create', [GolfCourseController::class, 'create'])->name('create');            // 新規作成画面表示
        Route::post('/', [GolfCourseController::class, 'store'])->name('store');                   // 新規登録保存処理

        // 削除済みデータ（ゴミ箱）の管理
        Route::get('/trashed', [GolfCourseController::class, 'trashed'])->name('trashed');         // 削除済みデータ一覧
        Route::post('/{id}/restore', [GolfCourseController::class, 'restore'])->name('restore')->whereNumber('id'); // 削除データの復元処理
        Route::delete('/{id}/force', [GolfCourseController::class, 'forceDelete'])->name('force-delete')->whereNumber('id'); // 完全削除処理

        // 編集・更新関連
        Route::get('/{id}/edit', [GolfCourseController::class, 'edit'])->name('edit')->whereNumber('id'); // 編集画面表示
        Route::put('/{id}', [GolfCourseController::class, 'update'])->name('update')->whereNumber('id');   // 更新保存処理

        // 削除確認・削除実行
        Route::get('/{id}/delete', [GolfCourseController::class, 'delete'])->name('delete')->whereNumber('id'); // 削除確認画面表示
        Route::delete('/{id}', [GolfCourseController::class, 'destroy'])->name('destroy')->whereNumber('id');    // 論理削除実行処理
    });

});