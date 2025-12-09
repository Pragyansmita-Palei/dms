<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@example.com',
            'password'=>Hash::make('password'),
            'role'=>'admin'
        ]);

        User::create([
            'name'=>'Customer',
            'email'=>'customer@example.com',
            'password'=>Hash::make('password'),
            'role'=>'customer'
        ]);

        Product::create(['name'=>'Product A','description'=>'Test product A','price'=>100,'stock'=>10]);
        Product::create(['name'=>'Product B','description'=>'Test product B','price'=>250,'stock'=>5]);
        Product::create(['name'=>'Product C','description'=>'Test product C','price'=>50,'stock'=>0]); // out of stock
    }
}
