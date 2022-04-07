<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'Deepak Mehra',
            'email' => 'Deepak2000mehra@gmail.com',
            'password' => bcrypt('deepak'),
        ];
        Admin::create($admin);
    }
}
