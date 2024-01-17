<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///*実行済み
        Rating::create([
            'id'=>'1',
            'name'=>'寒かった',
        ]);

        Rating::create([
            'id'=>'2',
            'name'=>'ちょうど良かった',
        ]);

        Rating::create([
            'id'=>'3',
            'name'=>'暑かった',
        ]);
        //*/
        
    }
}
