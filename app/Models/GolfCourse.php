<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GolfCourse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'country_code',
        'state_prefecture',
        'course_name',
        'kinds',
        'web',
        'phone',
        'address',
        'indoor',
        'outdoor',
        'short_course',
        'long_course',
        'lat',
        'lng',
        'form_email',
        'reservation',
        'reservation_method',
        'remarks',
        'image1',
        'image2',
        'image3',
    ];
}
