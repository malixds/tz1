<?php

namespace App\Interfaces;

use App\Models\Link;

interface ILinkRepository
{
    public function create(array $data): Link;
    public function findUrl(string $url): ?Link;
    public function findHash(string $hash): ?Link;

    public function firstOrCreate(string $url, array $data): Link;
}
