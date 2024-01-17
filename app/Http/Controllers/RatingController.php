<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\PhotoRating;
use App\Models\Rating;

class RatingController extends Controller
{
    public function saveRating(Photo $photo, Request $request)
    {
        $photoRating = optional($photo->ratings)->first();
        
        if ($photoRating){
            $photoRating -> update([
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment', null)
            ]);

        } else {
            $photoRating = new PhotoRating;
            $photoRating -> photo_id = $photo->id;
            $photoRating -> rating_id = $request->input('rating');
            $photoRating -> comment = $request->input('comment', null);
            $photoRating -> save();
        }
        
        return back();
    }

    public function destroyRating(Photo $photo)
    {
        PhotoRating::where('photo_id', $photo->id)->delete();

        return back();
    }
}
