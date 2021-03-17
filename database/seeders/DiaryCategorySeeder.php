<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Schema::disableForeignKeyConstraints();
        DB::table('spending_diarie_categories')->truncate();
        DB::table('spending_diarie_categories')->insert([
            [
                'name' => 'Ăn uống',
                'color' => '#ff6162',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Công việc',
                'color' => '#60ce80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Mua sắm vật dụng gia đình',
                'color' => '#330099',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Đi chơi',
                'color' => '#FFC75F',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Mua sắm khác',
                'color' => '#FF6F91',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Chưa xác định',
                'color' => '#4B4453',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
