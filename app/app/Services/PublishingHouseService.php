<?php


namespace App\Services;

use App\Models\PublishingHouse;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\PublishingHouseRepository;
use App\Http\Requests\PublishingHouse\PublishingHouseCreateDto;
use App\Http\Requests\PublishingHouse\PublishingHouseUpdateDto;

class PublishingHouseService
{
    public function __construct(private PublishingHouseRepository $publishingHouseRepository) {}

    public function getAll(?string $search): Collection
    {
        return $this->publishingHouseRepository->all($search);
    }

    public function find(int $id): ?PublishingHouse
    {
        return $this->publishingHouseRepository->find($id);
    }

    public function store(PublishingHouseCreateDto $dto): ?PublishingHouse
    {
        $publishingHouse = new PublishingHouse($dto->safe()->all());

        $publishingHouse->save();

        return $publishingHouse;
    }

    public function update(PublishingHouseUpdateDto $dto, PublishingHouse $publishingHouse): PublishingHouse
    {
        $publishingHouse->fill($dto->safe()->all());

        $publishingHouse->save();

        return $publishingHouse;
    }

    public function destroy(PublishingHouse $publishingHouse): void
    {
        PublishingHouse::destroy($publishingHouse->id);
    }
}
