<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ゴルフ場検索用バリデーションリクエスト
 */
class IndexGolfCourseRequest extends FormRequest
{
    /**
     * リクエストの実行権限を判定します。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 検索条件のバリデーションルールを定義します。
     * すべての項目はフィルタリング条件のため nullable とします。
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'prefecture' => ['nullable', 'string', 'max:255'],
            'locale' => ['nullable', 'string', 'in:ja,en'],
            'kind' => ['nullable', 'string', 'in:indoor,outdoor,short,long'],
        ];
    }
}
