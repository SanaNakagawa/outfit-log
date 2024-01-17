<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shoe;

class ShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///*実行済み
        Shoe::create([
            'id'=>'1',
            'name'=>'スニーカー',
        ]);

        Shoe::create([
            'id'=>'2',
            'name'=>'サンダル',
        ]);

        Shoe::create([
            'id'=>'3',
            'name'=>'パンプス',
        ]);

        Shoe::create([
            'id'=>'4',
            'name'=>'ローファー',
        ]);

        Shoe::create([
            'id'=>'5',
            'name'=>'ブーツ',
        ]);

        Shoe::create([
            'id'=>'6',
            'name'=>'フラットシューズ',
        ]);
        //*/
    }
}
