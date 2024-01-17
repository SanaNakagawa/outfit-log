<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Top extends Model
{
    use HasFactory;

    public function photos() {
        return $this->belongsToMany(Photo::class, 'photo_top_color')->withPivot('color_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'photo_top_color')->withPivot('photo_id');
    }
}
