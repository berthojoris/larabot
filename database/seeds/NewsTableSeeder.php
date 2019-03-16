<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $count = (int)$this->command->ask('How many news do you need ?', 10);
        // $this->command->info("Creating {$count} genres.");
        $genres = factory(App\News::class, 100)->create();
        $this->command->info('News Created!');
    }
}
