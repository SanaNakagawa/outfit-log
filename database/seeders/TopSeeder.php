<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Top;

class TopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///*実行済み
        Top::create([
            'id'=>'1',
            'name'=>'Tシャツ',
        ]);

        Top::create([
            'id'=>'2',
            'name'=>'タンクトップ',
        ]);

        Top::create([
            'id'=>'3',
            'name'=>'ブラウス/シャツ',
        ]);

        Top::create([
            'id'=>'4',
            'name'=>'ポロシャツ',
        ]);

        Top::create([
            'id'=>'5',
            'name'=>'チュニック',
        ]);

        Top::create([
            'id'=>'6',
            'name'=>'ワンピース',
        ]);

        Top::create([
            'id'=>'7',
            'name'=>'スウェット',
        ]);

        Top::create([
            'id'=>'8',
            'name'=>'パーカー',
        ]);

        Top::create([
            'id'=>'9',
            'name'=>'セーター/ニット',
        ]);

        Top::create([
            'id'=>'10',
            'name'=>'カーディガン',
        ]);
        //*/
    }
}
