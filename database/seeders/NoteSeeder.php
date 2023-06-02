<?php

namespace Database\Seeders;

use App\Models\Note;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 20; $i++){
            $note = new Note;

            $note->title = $faker->sentence;
            $note->content = $faker->paragraph;


            $note->save();
        }
        //
    }
}
