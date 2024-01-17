<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoBttomColor extends Model
{
    use HasFactory;

    protected $table = 'photo_bottom_color';

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function bottom() {
        return $this->belongsTo('App\Bottom');
    }

    public function color() {
        return $this->belongsTo('App\Color');
    }
    
}
