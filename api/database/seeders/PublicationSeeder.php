<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Document;
use App\Models\Publication;
use App\Models\PublishingHouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user = User::factory()->count(1)->create()->first();
        $publishingHouse = PublishingHouse::factory()->count(1)->create()->first();
        $document = Document::factory()->count(1)->create()->first();
        Author::factory()->count(2)->create();

        $publicationId = DB::table('publications')->insertGetId([
            'name' => $faker->unique()->word(),
            'description' => $faker->unique()->sentence(),
            'publication_year' => $faker->unique()->year(),
            'publication_century' => 20,
            'user_id' => $user->id,
            'publishing_house_id' => $publishingHouse->id,
            'document_id' => $document->id
        ]);

        Author::all()->each(function($author) use ($publicationId) {
            DB::table('author_publication')->insert([
                'author_id' => $author->id,
                'publication_id' => $publicationId
            ]);
        });
    }
}
