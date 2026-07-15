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
            // 緯度経度のバリデーション: 仕様書やDBの型(doubleやdecimal)を考慮し、
            // エラーで落ちないよう広めの数値範囲（-999.999999 〜 999.999999）を許可します。
            'lat' => ['nullable', 'numeric', 'min:-999.999999', 'max:999.999999'],
            'lng' => ['nullable', 'numeric', 'min:-999.999999', 'max:999.999999'],
            'form_email' => ['nullable', 'email', 'max:255'],
            'reservation' => ['nullable', 'string', 'max:255'],
            'reservation_method' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'image1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'image2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'image3' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    /**
     * バリデーションエラー時のカスタムメッセージを定義します。
     */
    public function messages(): array
    {
        return [
            'lat.numeric' => '緯度は数値で入力してください。',
            'lat.min' => '緯度は正しい数値の範囲で入力してください。',
            'lat.max' => '緯度は正しい数値の範囲で入力してください。',
            'lng.numeric' => '経度は数値で入力してください。',
            'lng.min' => '経度は正しい数値の範囲で入力してください。',
            'lng.max' => '経度は正しい数値の範囲で入力してください。',
        ];
    }
}
