<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jacket;

class JacketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///*実行済み
        Jacket::create([
            'id'=>'1',
            'name'=>'コート',
        ]);

        Jacket::create([
            'id'=>'2',
            'name'=>'ダウンジャケット',
        ]);

        Jacket::create([
            'id'=>'3',
            'name'=>'デニムジャケット',
        ]);

        Jacket::create([
            'id'=>'4',
            'name'=>'レザージャケット',
        ]);
        
        Jacket::create([
            'id'=>'5',
            'name'=>'ブレザー'
        ]);

        Jacket::create([
            'id'=>'6',
            'name'=>'ブルゾン'
        ]);

        Jacket::create([
            'id'=>'7',
            'name'=>'パーカー'
        ]);

        Jacket::create([
            'id'=>'8',
            'name'=>'カーディガン'
        ]);

        Jacket::create([
            'id'=>'9',
            'name'=>'ベスト'
        ]);


        //*/
    }
}
