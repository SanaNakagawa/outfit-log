<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'photo_jacket_color')->withPivot('jacket_id')
                    ->union($this->belongsToMany(Photo::class, 'photo_top_color')->withPivot('top_id'))
                    ->union($this->belongsToMany(Photo::class, 'photo_bottom_color')->withPivot('bottom_id'))
                    ->union($this->belongsToMany(Photo::class, 'photo_shoe_color')->withPivot('shoe_id'));
    }

    public function jackets()
    {
        return $this->belongsToMany(Jacket::class, 'photo_jacket_color')->withPivot('photo_id');
    }
    
    public function tops()
    {
        return $this->belongsToMany(Top::class, 'photo_top_color')->withPivot('photo_id');
    }

    public function bottoms()
    {
        return $this->belongsToMany(Bottom::class, 'photo_bottom_color')->withPivot('photo_id');
    }

    public function shoes()
    {
        return $this->belongsToMany(Shoe::class, 'photo_shoe_color')->withPivot('photo_id');
    }
    
}
