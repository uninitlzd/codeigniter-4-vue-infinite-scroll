<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContentSeeder extends Seeder
{
        public function run()
        {
                $model = model('ContentModel');
                $faker = \Faker\Factory::create();

                foreach (range(1,100) as $index) {
                    $model->insert([
                        'creator'      => $faker->name(),
                        'description' => $faker->text(),
                    ]);
                }
        }
}