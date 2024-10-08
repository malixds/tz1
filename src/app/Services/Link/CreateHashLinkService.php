<?php

namespace App\Services\Link;

use App\Exceptions\LinkIsExpired;
use App\Interfaces\ILinkRepository;
use App\Models\Link;
use http\Env\Request;
use Illuminate\Support\Str;

class CreateHashLinkService
{
    public function __construct(private ILinkRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws LinkIsExpired
     */
    public function run(string $url): Link
    {
        $link = $this->repository->firstOrCreate($url,[
            "url" => $url,
            "hash" => Str::random(5)
        ]);
        if ($link->isExpired()) {
            throw new LinkIsExpired("Ссылка устарела");
        }
        return $link;
    }

}
