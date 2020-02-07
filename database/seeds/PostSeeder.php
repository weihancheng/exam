<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 默认分类列表
        \App\Models\Post::create([
            'name' => '默认分类',
            'sort' => 100
        ]);

        \App\Models\Post::create([
            'name' => '财务部',
            'sort' => 100
        ]);

        \App\Models\Post::create([
            'name' => '行政部',
            'sort' => 100
        ]);

        \App\Models\Post::create([
            'name' => '采购部',
            'sort' => 100
        ]);


    }
}
