<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * 認証（ログイン・ログアウト）処理を管理するコントローラー
 */
class LoginController extends Controller
{
    /**
     * ログイン画面を表示します。
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // resources/views/auth/login.blade.php を返却します
        return view('auth.login');
    }

    /**
     * ログインの認証処理を実行します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 送信されたログイン資格情報のバリデーションを行います
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Auth::attempt を用いてログインを試みます。
        // 第2引数（任意）に true などを渡すことで「ログイン状態を維持 (Remember Me)」機能を実現することも可能です。
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            /**
             * 【セッション固定攻撃 (Session Fixation) への対策】
             * ログイン成功直後にセッションIDを新しく再生成します。
             * これにより、悪意あるユーザーがあらかじめ用意したセッションIDを被害者に使わせ、
             * ログイン後のセッションを乗っ取る攻撃を防ぎます。
             */
            $request->session()->regenerate();

            // 認証前にアクセスしようとしていたURLがある場合はそこへ、無ければゴルフ場一覧画面へリダイレクトします
            return redirect()->intended(route('golf-courses.index'))
                ->with('success', 'ログインしました。');
        }

        // 認証に失敗した場合は、エラーメッセージ付きでログイン画面に戻します
        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // 日本語リソース等から認証失敗メッセージを読み込みます
        ]);
    }

    /**
     * ログアウト処理を実行します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // ログイン中のユーザーをログアウトさせます（認証セッションの破棄）
        Auth::logout();

        /**
         * 【セッションの無効化 (Invalidate)】
         * 現在のユーザーセッションに紐づくすべてのデータをクリアし、セッション自体を完全に無効化します。
         * ログアウト後も古いセッションが有効なまま残るリスクを排除します。
         */
        $request->session()->invalidate();

        /**
         * 【CSRFトークンの再生成 (Regenerate Token)】
         * CSRF対策用のワンタイムトークンを再生成します。
         * これにより、同一のCSRFトークンがログアウト前後にまたがって悪用されることを防ぎます。
         */
        $request->session()->regenerateToken();

        // ログアウト完了後はログイン画面にリダイレクトします
        return redirect()->route('login')
            ->with('success', 'ログアウトしました。');
    }
}
