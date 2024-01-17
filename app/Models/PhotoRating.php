<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoRating extends Model
{
    use HasFactory;

    protected $fillable = ['photo_id', 'rating_id', 'comment'];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }
}
