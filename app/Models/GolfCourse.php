<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GolfCourse extends Model
{
    use HasFactory;
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

    public function scopeSearch($query, array $filters)
    {
        $q = trim((string) ($filters['q'] ?? ''));
        $prefecture = trim((string) ($filters['prefecture'] ?? ''));
        $locale = trim((string) ($filters['locale'] ?? ''));
        $kind = trim((string) ($filters['kind'] ?? ''));

        return $query
            ->when($q !== '', function ($query) use ($q) {
                $escaped = addcslashes($q, '%_\\');

                $query->where(function ($query) use ($escaped) {
                    $query->where('course_name', 'like', '%' . $escaped . '%')
                        ->orWhere('address', 'like', '%' . $escaped . '%');
                });
            })
            ->when($prefecture !== '', function ($query) use ($prefecture) {
                $query->where('state_prefecture', $prefecture);
            })
            ->when($locale !== '', function ($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->when($kind !== '', function ($query) use ($kind) {
                $columns = [
                    'indoor' => 'indoor',
                    'outdoor' => 'outdoor',
                    'short' => 'short_course',
                    'long' => 'long_course',
                ];

                $column = $columns[$kind] ?? null;

                if ($column) {
                    $query->where($column, true);
                }
            });
    }
}
