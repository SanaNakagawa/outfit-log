<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Jacket;
use App\Models\Top;
use App\Models\Bottom;
use App\Models\Shoe;


class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    protected $appends = ['photo_url'];
    protected $selected_date =['selected_date'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function jackets() {
        return $this->belongsToMany(Jacket::class, 'photo_jacket_color')->withPivot('color_id');
    }
    
    public function tops() {
        return $this->belongsToMany(Top::class, 'photo_top_color')->withPivot('color_id');
    }

    public function bottoms() {
        return $this->belongsToMany(Bottom::class, 'photo_bottom_color')->withPivot('color_id');
    }

    public function shoes() {
        return $this->belongsToMany(Shoe::class, 'photo_shoe_color')->withPivot('color_id');
    }

    public function getPhotoUrlAttribute()
    {
        return Storage::url('images/'. $this->filename);
    }

    //天気
    public function weathers()
    {
        return $this->hasOne(Weather::class);
    }

    //評価
    public function photoRating()
    {
        return $this->hasOne(PhotoRating::class);
    }
    
}
