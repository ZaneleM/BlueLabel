<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interests = [
            'Animation',
            'Creative activities',
            'Creative writing',
            'Drawing',
            'Filmmaking',
            'Flower arranging',
            'Furniture building',
            'Furniture restoration',
            'Blogging',
            'Copywriting',
            'Essay writing',
            'Fan fiction',
            'Bullet journaling',
            'Budgeting',
            'Attending literary events',
            'Book clubs',
            'Content creation',
            'Creative writing',
        ];

        foreach ($interests as $interest) {
            Interest::create([
                'name' => $interest,
            ]);
        }
    }
}
