<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoShoeColor extends Model
{
    use HasFactory;

    protected $table = 'photo_shoe_color';

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function shoe() {
        return $this->belongsTo('App\Shoe');
    }

    public function color() {
        return $this->belongsTo('App\Color');
    }
}
