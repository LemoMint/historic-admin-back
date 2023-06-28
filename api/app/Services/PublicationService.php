<?php


namespace App\Services;

use App\Models\Bookmark;
use App\Models\Document;
use App\Models\Publication;
use App\Helpers\FileStorageHelper;
use App\Http\Requests\SortRequest;
use App\Exceptions\FileNotCreatedException;
use App\Repositories\PublicationRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Bookmarks\BookmarkCreateDto;
use App\Http\Requests\Publication\PublicationCreateDto;
use App\Http\Requests\Publication\PublicationUpdateDto;
use Illuminate\Support\Facades\Auth;

class PublicationService
{
    public function __construct(private PublicationRepository $publicationRepository, private BookmarkService $bookmarkService) {}

    public function getAll(SortRequest $params): Collection
    {
        return $this->publicationRepository->all($params, Auth::user()->grantedAdminRoles());
    }

    public function find(int $id): ?Publication
    {
        return $this->publicationRepository->find($id, Auth::user()->grantedAdminRoles());
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

        foreach ($dto->safe(["categories"]) as $category) {
            $publication->categories()->attach($category);
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

    public function addBookmark(BookmarkCreateDto $dto, Publication $publication): Bookmark
    {
        $bookmark = $this->bookmarkService->store($dto);

        if ($bookmark) {
            $publication->document()->associate($bookmark);
        }

        return $bookmark;
    }

    public function getFileDocumentPathOrigin(Publication $publication): ?string
    {
        return FileStorageHelper::getFilePath($publication->document);
    }

    public function getFileDocumentPathText(Publication $publication): ?string
    {
        return FileStorageHelper::getFilePath($publication->document, false);
    }
}
