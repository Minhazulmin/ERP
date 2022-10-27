<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Models\Website\Gallery;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
