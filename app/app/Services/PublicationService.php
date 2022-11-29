<?php


namespace App\Services;

use App\Models\User;
use App\Models\Document;
use App\Models\Publication;
use App\Helpers\FileStorageHelper;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\FileNotCreatedException;
use App\Repositories\PublicationRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Publication\PublicationCreateDto;
use App\Http\Requests\Publication\PublicationUpdateDto;
use App\Http\Requests\Publication\PublicationSortRequest;

class PublicationService
{
    public function __construct(private PublicationRepository $publicationRepository) {}

    public function getAll(PublicationSortRequest $params): Collection
    {
        return $this->publicationRepository->all($params);
    }

    public function find(int $id): ?Publication
    {
        return $this->publicationRepository->find($id);
    }

    public function store(PublicationCreateDto $dto): Publication
    {
        $publication = null;

        try {
            $document = FileStorageHelper::saveFile($dto->file('document'));
        } catch (\Throwable $e) {
            throw new FileNotCreatedException();
        }

        $publication = new Publication($dto->safe()->all());
        $publication->document()->associate($document->id);

        $publication->save();

        foreach ($dto->safe(["authors"]) as $author) {
            $publication->authors()->attach($author);
        }

        return $publication;
    }

    public function update(PublicationUpdateDto $dto, Publication $publication)
    {
        if ($dto->hasFile('document')) {
            $oldDocument = $publication->document;

            $document = FileStorageHelper::saveFile($dto->file('document'));

            FileStorageHelper::deleteFile($oldDocument);
            $publication->document()->dissociate();
            Document::destroy($oldDocument->id);

            $publication->document()->associate($document->id);
        }

        $publication->fill($dto->safe()->all());

        $publication->save();

        $publication->authors()->detach();
        foreach ($dto->safe(["authors"]) as $author) {
            $publication->authors()->attach($author);
        }

        return $publication;
    }

    public function delete(Publication $publication)
    {
       $publication->deleted_at ? $publication->restore() : $publication->delete();
    }
}
