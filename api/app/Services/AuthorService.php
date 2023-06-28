<?php


namespace App\Services;

use Throwable;
use App\Models\Author;
use App\Http\Requests\SortRequest;
use App\Repositories\AuthorRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Author\AuthorCreateDto;
use App\Http\Requests\Author\AuthorUpdateDto;

class AuthorService
{
    public function __construct(private AuthorRepository $authorRepository) {}

    public function getAll(SortRequest $search): Collection
    {
        return $this->authorRepository->all($search);
    }

    public function find(int $id): ?Author
    {
        return $this->authorRepository->find($id);
    }

    public function store(AuthorCreateDto $dto): Author
    {
        $author = new Author($dto->safe()->all());

        $author->save();

        return $author;
    }

    public function update(AuthorUpdateDto $dto, Author $author)
    {
        $author->fill($dto->safe()->all());

        $author->save();

        return $author;
    }

    public function destroy(Author $author)
    {
        Author::destroy($author->id);
    }
}
