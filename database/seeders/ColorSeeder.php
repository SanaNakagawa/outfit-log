<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///*実行済み
        Color::create([
            'id'=>'1',
            'name'=>'ブラック',
        ]);

        Color::create([
            'id'=>'2',
            'name'=>'ホワイト',
        ]);

        Color::create([
            'id'=>'3',
            'name'=>'グレー',
        ]);

        Color::create([
            'id'=>'4',
            'name'=>'ブラウン',
        ]);

        Color::create([
            'id'=>'5',
            'name'=>'ベージュ',
        ]);
        
        Color::create([
            'id'=>'6',
            'name'=>'カーキ',
        ]);

        Color::create([
            'id'=>'7',
            'name'=>'レッド',
        ]);

        Color::create([
            'id'=>'8',
            'name'=>'ブルー',
        ]);

        Color::create([
            'id'=>'9',
            'name'=>'イエロー',
        ]);

        Color::create([
            'id'=>'10',
            'name'=>'パープル',
        ]);

        Color::create([
            'id'=>'11',
            'name'=>'グリーン',
        ]);

        Color::create([
            'id'=>'12',
            'name'=>'オレンジ',
        ]);

        Color::create([
            'id'=>'13',
            'name'=>'ピンク',
        ]);

        Color::create([
            'id'=>'14',
            'name'=>'シルバー',
        ]);

        Color::create([
            'id'=>'15',
            'name'=>'ゴールド',
        ]);
        
        Color::create([
            'id'=>'16',
            'name'=>'デニム',
        ]);

        Color::create([
            'id'=>'17',
            'name'=>'その他',
        ]);

        //*/
    }
}
