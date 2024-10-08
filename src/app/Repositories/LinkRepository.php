<?php

namespace App\Repositories;

use App\Interfaces\ILinkRepository;
use App\Models\Link;
use Termwind\Components\Li;

class LinkRepository implements ILinkRepository
{
    public function create(array $data): Link
    {
        return Link::query()->create($data);
    }
    public function findUrl(string $url): ?Link
    {
        return Link::query()->where('url', $url)->first();
    }
    public function findHash(string $hash): ?Link
    {
        return Link::query()->where('hash', $hash)->first();
    }
    public function firstOrCreate(string $url, array $data): Link
    {
        return Link::query()->firstOrCreate(['url' => $url], $data);
    }

}
