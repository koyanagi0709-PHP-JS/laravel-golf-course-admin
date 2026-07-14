<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ゴルフ場新規登録用バリデーションリクエスト
 */
class StoreGolfCourseRequest extends FormRequest
{
    /**
     * リクエストの実行権限を判定します。
     * ここでは簡易的にすべてのユーザーに許可（true）としています。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 新規登録時のバリデーションルールを定義します。
     */
    public function rules(): array
    {
        return [
            'locale' => ['required', 'string', 'max:2'],
            'country_code' => ['required', 'string', 'max:2'],
            'state_prefecture' => ['nullable', 'string', 'max:255'],
            'course_name' => ['required', 'string', 'max:255'],
            'kinds' => ['nullable', 'integer'],
            'web' => ['nullable', 'url', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'indoor' => ['nullable', 'boolean'],
            'outdoor' => ['nullable', 'boolean'],
            'short_course' => ['nullable', 'boolean'],
            'long_course' => ['nullable', 'boolean'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'form_email' => ['nullable', 'email', 'max:255'],
            'reservation' => ['nullable', 'string', 'max:255'],
            'reservation_method' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'image1' => ['nullable', 'string', 'max:255'],
            'image2' => ['nullable', 'string', 'max:255'],
            'image3' => ['nullable', 'string', 'max:255'],
        ];
    }
}
