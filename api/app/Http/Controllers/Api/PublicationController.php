<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SortRequest;
use App\Http\Controllers\Controller;
use App\Services\PublicationService;
use App\Http\Resources\BookmarkResouce;
use App\Http\Resources\PublicationResource;
use App\Http\Requests\Bookmarks\BookmarkCreateDto;
use App\Http\Requests\Publication\PublicationCreateDto;
use App\Http\Requests\Publication\PublicationUpdateDto;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicationController extends Controller
{
    public function __construct(private PublicationService $publicationService) {}

    public function index(SortRequest $request): JsonResponse
    {
        return response()->json(
            PublicationResource::collection(
                $this->publicationService->getAll($request)
            )
        );
    }

    public function store(PublicationCreateDto $dto): JsonResponse
    {
        return response()->json(
            new PublicationResource($this->publicationService->store($dto))
        );
    }

    public function show($id)
    {
        return response()->json(
            new PublicationResource(
                $this->publicationService->find($id)
            )
        );
    }

    public function update(PublicationUpdateDto $dto, $id)
    {
        $publication = $this->publicationService->find($id);

        // $this->authorize('update', $publication);

        return response()->json(
            new PublicationResource($this->publicationService->update($dto, $publication))
        );
    }

    public function destroy($id)
    {
        $publication = $this->publicationService->find($id);

        $this->authorize('delete', $publication);

        $this->publicationService->delete($publication);
    }

    public function addBookmark(BookmarkCreateDto $dto, int $id): JsonResponse
    {
        $publication = $this->publicationService->find($id);

        return response()->json(
            new BookmarkResouce($this->publicationService->addBookmark($dto, $publication))
        );
    }

    public function getDocumentOrigin(int $id): BinaryFileResponse
    {
        $publication = $this->publicationService->find($id);

        return response()->file($this->publicationService->getFileDocumentPathOrigin($publication));
    }

    public function getDocumentText(int $id): BinaryFileResponse|JsonResponse
    {
        $publication = $this->publicationService->find($id);
        $path = $this->publicationService->getFileDocumentPathText($publication);

        if (!$path) {
            return response()->json([
                "file" => false
            ]);
        }

        return response()->file($path);
    }
}
