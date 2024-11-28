<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $people = [
            [
                'name' => 'Amukelani',
                'surname' => 'Maceve',
                'id_number' => '9010175800085',
                'mobile_number' => '082857498',
                'email' => 'Amukelani.Maceve@gmail.com',
                'birth_date' => '1990-01-01',
                'language_id' => 1,
                'interests' => [1, 2, 3],
            ],
            [
                'name' => 'Gethrude',
                'surname' => 'Kubayi',
                'id_number' => '9010014800080',
                'mobile_number' => '082857598',
                'email' => 'Gethrude.Kubayi@gmail.com',
                'birth_date' => '1990-10-01',
                'language_id' => 1,
                'interests' => [4, 5, 3],
            ],
            [
                'name' => 'Micheal',
                'surname' => 'Shoeman',
                'id_number' => '9610175800082',
                'mobile_number' => '082997498',
                'email' => 'Micheal.Shoeman@gmail.com',
                'birth_date' => '1996-10-17',
                'language_id' => 1,
                'interests' => [7, 1, 8],
            ],
            [
                'name' => 'Pinky',
                'surname' => 'Khumalo',
                'id_number' => '9605074800084',
                'mobile_number' => '082857498',
                'email' => 'Pinky.Khumalo@gmail.com',
                'birth_date' => '1996-05-07',
                'language_id' => 1,
                'interests' => [5, 2, 5],
            ],
        ];

        foreach ($people as $personData) {
            $person = Person::create([
                'name' => $personData['name'],
                'surname' => $personData['surname'],
                'id_number' => $personData['id_number'],
                'mobile_number' => $personData['mobile_number'],
                'email' => $personData['email'],
                'birth_date' => $personData['birth_date'],
                'language_id' => $personData['language_id'],
            ]);

            $person->interests()->attach($personData['interests']);
        }
    }
}
