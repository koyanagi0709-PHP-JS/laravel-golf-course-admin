<?php

namespace App\Http\Controllers;

use App\Models\GolfCourse;
use App\Http\Requests\IndexGolfCourseRequest;
use App\Http\Requests\StoreGolfCourseRequest;
use App\Http\Requests\UpdateGolfCourseRequest;
use Illuminate\Support\Facades\Storage;

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
     * 現在の検索条件に一致するゴルフ場の一覧をCSVとしてダウンロードします。
     * 
     * @param IndexGolfCourseRequest $request 検索条件バリデーション済リクエスト
     */
    public function export(IndexGolfCourseRequest $request)
    {
        $validated = $request->validated();

        // ページネーションを使わず、条件に一致する全件を取得します
        $golfCourses = GolfCourse::query()
            ->search($validated)
            ->orderByDesc('id')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="golf_courses_' . date('Ymd_His') . '.csv"',
        ];

        // -------------------------------------------------------------
        // CSVストリーム出力処理
        // 大量のデータを一括でメモリに読み込むのを防ぐため、
        // streamDownload を使用して1行ずつ出力バッファに書き込みます。
        // また、Excel等で文字化けしないよう、先頭にBOM (\xEF\xBB\xBF) を出力します。
        // -------------------------------------------------------------
        $callback = function () use ($golfCourses) {
            $file = fopen('php://output', 'w');

            // BOM (Byte Order Mark) を書き込み（Excelでの文字化け対策）
            fwrite($file, "\xEF\xBB\xBF");

            // CSVのヘッダー行を定義
            fputcsv($file, [
                'ID',
                '施設名',
                '都道府県',
                '言語コード',
                '国コード',
                '屋内コース',
                '屋外コース',
                'ショートコース',
                'ロングコース',
                '緯度',
                '経度',
                '公式サイトURL',
                '代表電話番号',
                '住所',
            ]);

            // データ行を1件ずつ書き込み
            foreach ($golfCourses as $gc) {
                fputcsv($file, [
                    $gc->id,
                    $gc->course_name,
                    $gc->state_prefecture,
                    $gc->locale,
                    $gc->country_code,
                    $gc->indoor ? 'あり' : 'なし',
                    $gc->outdoor ? 'あり' : 'なし',
                    $gc->short_course ? 'あり' : 'なし',
                    $gc->long_course ? 'あり' : 'なし',
                    $gc->lat,
                    $gc->lng,
                    $gc->web,
                    $gc->phone,
                    $gc->address,
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'golf_courses.csv', $headers);
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

        // -------------------------------------------------------------
        // 画像アップロード処理
        // 各画像（image1, image2, image3）がアップロードされているか確認し、
        // 公開ディスク（publicディスク）の 'golf_courses' ディレクトリ内に保存します。
        // 保存後、データベースに登録するためのファイルパスを配列に設定します。
        // -------------------------------------------------------------
        foreach (['image1', 'image2', 'image3'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                // ファイルを保存し、その相対パス（例: "golf_courses/xxxxxx.jpg"）を取得します
                $path = $request->file($imageKey)->store('golf_courses', 'public');
                $validated[$imageKey] = $path;
            }
        }

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

        // -------------------------------------------------------------
        // 画像アップロード・差し替え処理・個別削除処理
        // 新しい画像ファイルがアップロードされた場合、既存の古い画像があれば
        // ストレージから物理的に削除した上で、新しい画像を保存しパスを更新します。
        // 個別削除チェックがONの場合は、古い画像を物理削除してパスをnull化します。
        // -------------------------------------------------------------
        foreach (['image1', 'image2', 'image3'] as $imageKey) {
            // 個別削除フラグがONで、既存画像がある場合
            $deleteKey = 'delete_' . $imageKey;
            if ($request->boolean($deleteKey) && $golfCourse->$imageKey) {
                Storage::disk('public')->delete($golfCourse->$imageKey);
                $validated[$imageKey] = null;
                $golfCourse->$imageKey = null; // $validatedに上書きされないようにモデルにも反映（後のfillのため）
            }

            if ($request->hasFile($imageKey)) {
                // 古い画像が存在すれば物理削除する
                if ($golfCourse->$imageKey) {
                    Storage::disk('public')->delete($golfCourse->$imageKey);
                }
                
                // 新しい画像を保存しパスを格納する
                $path = $request->file($imageKey)->store('golf_courses', 'public');
                $validated[$imageKey] = $path;
            }
        }

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
        $golfCourses = GolfCourse::onlyTrashed()->latest()->paginate(20);

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

    /**
     * 論理削除されたゴルフ場を完全に物理削除します（完全削除）。
     * 
     * @param int $id ゴルフ場ID
     */
    public function forceDelete($id)
    {
        // 論理削除されたデータも含めて対象レコードを取得します
        $golfCourse = GolfCourse::withTrashed()->findOrFail($id);

        // -------------------------------------------------------------
        // 画像ファイルの物理削除
        // データベースからレコードを物理削除する前に、
        // 紐づいているすべてのアップロード画像もストレージから削除します。
        // -------------------------------------------------------------
        foreach (['image1', 'image2', 'image3'] as $imageKey) {
            if ($golfCourse->$imageKey) {
                Storage::disk('public')->delete($golfCourse->$imageKey);
            }
        }

        // データベースから物理削除を実行します
        $golfCourse->forceDelete();

        // ゴミ箱画面へリダイレクトし、完了メッセージをセッションに格納します
        return redirect()
            ->route('golf-courses.trashed')
            ->with('success', 'ゴルフ場データを完全に物理削除しました。');
    }
}
