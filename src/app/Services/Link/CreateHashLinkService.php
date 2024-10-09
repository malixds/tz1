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
    }

    /**
     * @throws LinkIsExpired
     */
    public function run(string $url): Link
    {
        $url = urlencode($url);
        $link = $this->repository->firstOrCreate($url,[
            "url" => $url,
            "hash" => Str::random(5)
        ]);
        if ($link->isExpired()) {
            dd('asdasd');
            $link->hash = Str::random(5);
            $link->created_at = now();
            $link->save();
            throw new LinkIsExpired();
        }
        return $link;
    }

}
