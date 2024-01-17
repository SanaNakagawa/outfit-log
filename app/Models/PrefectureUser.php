<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrefectureUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'prefecture_id'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}
