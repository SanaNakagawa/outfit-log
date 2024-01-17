<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    use HasFactory;

    public function prefectureUser()
    {
        return $this->belongsTo(PrefectureUser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
