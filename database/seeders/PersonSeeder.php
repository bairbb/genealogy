<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grandparent = Person::factory()->create();
        $parents = Person::factory()->count(3)->create([
            'parent_id' => $grandparent->id,
        ]);

        foreach ($parents as $parent) {
            Person::factory()->count(2)->create([
                'parent_id' => $parent->id,
            ]);
        }
    }
}
