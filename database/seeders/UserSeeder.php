<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') !== 'production') {
            $users = [
                [
                    'id' => 1,
                    'username' => 'Developer',
                    'email' => 'developer@gmail.com',
                    'password' => Hash::make('password')
                ]
            ];
            foreach ($users as $user) {
                $fillableData = Arr::only($user, User::getModel()->getFillable());
                User::query()->updateOrCreate(['id' => $user['id']], $fillableData);
            }
        }
    }
}
