<?php

namespace App\Http\Controllers;

use App\Models\GolfCourse;
use App\Http\Requests\IndexGolfCourseRequest;
use App\Http\Requests\StoreGolfCourseRequest;
use App\Http\Requests\UpdateGolfCourseRequest;

/**
 * ゴルフ場管理コントローラー
 * 管理者によるゴルフ場の検索、登録、詳細表示、更新、削除、削除済データの管理を行います。
 */
class GolfCourseController extends Controller
{
    /**
     * ゴルフ場の一覧および検索結果を表示します。
     * 
     * @param IndexGolfCourseRequest $request 検索条件バリデーション済リクエスト
     */
    public function index(IndexGolfCourseRequest $request)
    {
        // バリデーション済みの検索クエリを取得します
        $validated = $request->validated();

        // 検索クエリに基づきデータベースから該当するゴルフ場を取得し、
        // 最新のID降順で1ページあたり20件のペジネーションを適用します
        $golfCourses = GolfCourse::query()
            ->search($validated)
            ->orderByDesc('id')
            ->paginate(20)
            ->appends($validated); // ページ遷移時にも検索条件（クエリパラメータ）を維持します

        // ビューファイルにデータを渡します
        return view('golf-courses.index', compact('golfCourses'));
    }

    /**
     * ゴルフ場の新規登録フォームを表示します。
     */
    public function create()
    {
        return view('golf-courses.create');
    }

    /**
     * 新しいゴルフ場情報をデータベースに登録します。
     * 
     * @param StoreGolfCourseRequest $request 新規登録用バリデーション済リクエスト
     */
    public function store(StoreGolfCourseRequest $request)
    {
        // 厳格にバリデーションされた入力値のみを取り出します
        $validated = $request->validated();

        // ゴルフ場レコードを新規作成します
        $golfCourse = GolfCourse::create($validated);

        // 作成されたゴルフ場の詳細画面へリダイレクトし、完了メッセージをセッションに格納します
        return redirect()
            ->route('golf-courses.show', ['id' => $golfCourse->id])
            ->with('success', 'ゴルフ場情報を登録しました。');
    }

    /**
     * 指定されたゴルフ場の詳細画面を表示します。
     * 
     * @param int $id ゴルフ場ID
     */
    public function show($id)
    {
        // 指定されたIDのゴルフ場を取得します。存在しない場合は自動的に404エラーとなります
        $golfCourse = GolfCourse::findOrFail($id);

        return view('golf-courses.show', compact('golfCourse'));
    }

    /**
     * 指定されたゴルフ場の編集フォームを表示します。
     * 
     * @param int $id ゴルフ場ID
     */
    public function edit($id)
    {
        $golfCourse = GolfCourse::findOrFail($id);

        return view('golf-courses.edit', compact('golfCourse'));
    }

    /**
     * 指定されたゴルフ場情報を更新します。
     * 
     * @param UpdateGolfCourseRequest $request 更新用バリデーション済リクエスト
     * @param int $id ゴルフ場ID
     */
    public function update(UpdateGolfCourseRequest $request, $id)
    {
        $golfCourse = GolfCourse::findOrFail($id);
        
        // 厳格にバリデーションされた更新用の入力値のみを取り出します
        $validated = $request->validated();

        // 取得したゴルフ場モデルに値を詰め込んでデータベースに保存します
        $golfCourse->fill($validated);
        $golfCourse->save();

        // 詳細画面へリダイレクトし、更新完了メッセージをセッションに格納します
        return redirect()
            ->route('golf-courses.show', ['id' => $golfCourse->id])
            ->with('success', 'ゴルフ場情報を更新しました。');
    }

    /**
     * 指定されたゴルフ場の削除確認画面を表示します。
     * 
     * @param int $id ゴルフ場ID
     */
    public function delete($id)
    {
        $golfCourse = GolfCourse::findOrFail($id);

        return view('golf-courses.delete', compact('golfCourse'));
    }

    /**
     * 指定されたゴルフ場を論理削除（ソフトデリート）します。
     * 
     * @param int $id ゴルフ場ID
     */
    public function destroy($id)
    {
        $golfCourse = GolfCourse::findOrFail($id);
        $golfCourse->delete();

        // 一覧画面へリダイレクトし、削除完了メッセージをセッションに格納します
        return redirect()
            ->route('golf-courses.index')
            ->with('success', 'ゴルフ場を削除しました。');
    }

    /**
     * 論理削除されたゴルフ場の一覧を表示します。
     */
    public function trashed()
    {
        // 論理削除されたレコードのみを最新順で取得します
        $golfCourses = GolfCourse::onlyTrashed()->latest()->get();

        return view('golf-courses.trashed', compact('golfCourses'));
    }

    /**
     * 論理削除されたゴルフ場を元に戻します（復元）。
     * 
     * @param int $id ゴルフ場ID
     */
    public function restore($id)
    {
        // 論理削除されたデータも含めて検索し、対象レコードを復元します
        $golfCourse = GolfCourse::withTrashed()->findOrFail($id);
        $golfCourse->restore();

        // 一覧画面へリダイレクトし、復元完了メッセージをセッションに格納します
        return redirect()
            ->route('golf-courses.index')
            ->with('success', 'ゴルフ場を復元しました。');
    }
}
