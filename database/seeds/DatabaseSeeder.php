<?php

use App\Chat;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Bertho',
                'email' => 'bertho@gmail.com',
                'image' => 'images/man1.png',
                'password' => '$2y$10$KAolN95HRSRoLimEefD3R.Jsi8nGl7PYg4leBS8k.pPIy/SMt8hLC'
            ],
            [
                'name' => 'Brian',
                'email' => 'brian@gmail.com',
                'image' => 'images/man2.png',
                'password' => '$2y$10$KAolN95HRSRoLimEefD3R.Jsi8nGl7PYg4leBS8k.pPIy/SMt8hLC'
            ],
            [
                'name' => 'Doni',
                'email' => 'doni@gmail.com',
                'image' => 'images/man3.png',
                'password' => '$2y$10$KAolN95HRSRoLimEefD3R.Jsi8nGl7PYg4leBS8k.pPIy/SMt8hLC'
            ],
            [
                'name' => 'Arini',
                'email' => 'arini@gmail.com',
                'image' => 'images/woman1.png',
                'password' => '$2y$10$KAolN95HRSRoLimEefD3R.Jsi8nGl7PYg4leBS8k.pPIy/SMt8hLC'
            ],
            [
                'name' => 'Dona',
                'email' => 'dona@gmail.com',
                'image' => 'images/woman2.png',
                'password' => '$2y$10$KAolN95HRSRoLimEefD3R.Jsi8nGl7PYg4leBS8k.pPIy/SMt8hLC'
            ],
            [
                'name' => 'Tari',
                'email' => 'tari@gmail.com',
                'image' => 'images/woman3.png',
                'password' => '$2y$10$KAolN95HRSRoLimEefD3R.Jsi8nGl7PYg4leBS8k.pPIy/SMt8hLC'
            ]
        ];
        User::insert($data);

        $this->call(NewsTableSeeder::class);
        $this->call(BillingTableSeed::class);
    }
}
