<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bottom;

class BottomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///*実行済み
        Bottom::create([
            'id'=>'1',
            'name'=>'スキニー',
        ]);

        Bottom::create([
            'id'=>'2',
            'name'=>'ストレートパンツ',
        ]);

        Bottom::create([
            'id'=>'3',
            'name'=>'ワイドパンツ',
        ]);

        Bottom::create([
            'id'=>'4',
            'name'=>'バギーパンツ',
        ]);

        Bottom::create([
            'id'=>'5',
            'name'=>'裾フレアパンツ',
        ]);

        Bottom::create([
            'id'=>'6',
            'name'=>'カーゴパンツ',
        ]);

        Bottom::create([
            'id'=>'7',
            'name'=>'ショートパンツ',
        ]);

        Bottom::create([
            'id'=>'8',
            'name'=>'スカート',
        ]);

        Bottom::create([
            'id'=>'9',
            'name'=>'ロングスカート',
        ]);

        //*/
    }
}
