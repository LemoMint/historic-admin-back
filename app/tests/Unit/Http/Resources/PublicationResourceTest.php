<?php


namespace Tests\Unit\Http\Resources;

use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use App\Models\PublishingHouse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PublicationResourceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_author_resource()
    {
        $publication = Publication::first();
        $publicationResponseDto = new PublicationResource($publication);

        $assertion = [
            'id' =>  $publication->toArray()['id'],
            'name' =>  $publication->toArray()['name'],
            'description'=>  $publication->toArray()['description'],
            'publication_year'=>  $publication->toArray()['publication_year'],
            'publication_century'=>  $publication->toArray()['publication_century'],
            'created_at'=>  $publication->toArray()['created_at'],
            'updated_at'=>  $publication->toArray()['updated_at'],
            'deleted_at'=>  $publication->toArray()['deleted_at'],
            'authors' => $publication->authors()->get(['id', 'name', 'surname', 'patronymic_name', 'authors.created_at', 'authors.updated_at', 'authors.user_id'])->makeHidden('pivot')->toArray(),
            'publishing_house' => $publication->publishingHouse()->get(['id', 'name', 'address', 'publishing_houses.user_id'])->makeHidden('pivot')->toArray()[0],
            'user' => $publication->user()->with('role')->get(['id', 'name', 'email','users.created_at', 'users.updated_at'])->toArray()[0]
        ];

        $this->assertEquals($assertion, json_decode($publicationResponseDto->toJson(), true));
    }
}
