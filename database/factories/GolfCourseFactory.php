<?php

namespace Database\Factories;

use App\Models\GolfCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GolfCourse>
 */
class GolfCourseFactory extends Factory
{
    protected $model = GolfCourse::class;

    public function definition(): array
    {
        $prefectures = [
            '東京都',
            '大阪府',
            '福岡県',
            '北海道',
            '宮城県',
            '愛知県',
            '京都府',
            '兵庫県',
        ];

        return [
            'locale' => 'ja',
            'country_code' => 'JP',
            'state_prefecture' => $this->faker->randomElement($prefectures),
            'course_name' => $this->faker->company() . 'ゴルフ場',
            'kinds' => $this->faker->numberBetween(1, 9),
            'web' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'indoor' => $this->faker->boolean(20),
            'outdoor' => $this->faker->boolean(80),
            'short_course' => $this->faker->boolean(35),
            'long_course' => $this->faker->boolean(65),
            'lat' => $this->faker->latitude(24, 46),
            'lng' => $this->faker->longitude(123, 146),
            'form_email' => $this->faker->safeEmail(),
            'reservation' => $this->faker->url(),
            'reservation_method' => $this->faker->randomElement(['電話', 'WEB', 'メール']),
            'remarks' => $this->faker->sentence(),
            'image1' => null,
            'image2' => null,
            'image3' => null,
        ];
    }
}
