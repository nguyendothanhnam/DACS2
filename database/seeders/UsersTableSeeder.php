<?php

namespace Database\Seeders;
use App\Models\Admin;
use App\Models\Roles;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate();
        $adminRoles = Roles::where('name', 'admin')->first();
        $authorRoles = Roles::where('name', 'author')->first();
        $userRoles = Roles::where('name', 'user')->first();

        $admin = Admin::create([
            'admin_name' => 'Admin',
            'admin_email' => 'admin@gmail.com',
            'admin_password' => bcrypt('123123'),
            'admin_phone' => '07396238847'
        ]);
        $author = Admin::create([
            'admin_name' => 'Author',
            'admin_email' => 'author@gmail.com',
            'admin_password' => bcrypt('123123'),
            'admin_phone' => '07396238847'
        ]);
        $user = Admin::create([
            'admin_name' => 'User',
            'admin_email' => 'user@gmail.com',
            'admin_password' => bcrypt('123123'),
            'admin_phone' => '07396238847'
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);
        
        Admin::factory()->count(5)->create();
    }
}
