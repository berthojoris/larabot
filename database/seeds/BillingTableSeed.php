<?php

use Illuminate\Database\Seeder;

class BillingTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Billing::class, 10)->create();
        $this->command->info('Billing Created!');
    }
}
