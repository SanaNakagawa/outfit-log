<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoTopColor extends Model
{
    use HasFactory;

    protected $table = 'photo_top_color';

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function top() {
        return $this->belongsTo('App\Top');
    }

    public function color() {
        return $this->belongsTo('App\Color');
    }
    
}
