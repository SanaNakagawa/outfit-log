<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoJacketColor extends Model
{
    use HasFactory;

    protected $table = 'photo_jacket_color';

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function jacket() {
        return $this->belongsTo('App\Jacket');
    }

    public function color() {
        return $this->belongsTo('App\Color');
    }
}
