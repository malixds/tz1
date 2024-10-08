<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkIsExpired;
use App\Http\Requests\HashUrlRequest;
use App\Http\Resources\LinkHashResource;
use App\Http\Resources\LinkResource;
use App\Http\Resources\LinkUrlResource;
use App\Interfaces\ILinkRepository;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function __construct(private ILinkRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws LinkIsExpired
     */
    public function toHash(Request $request)
    {
        $link = $this->repository->firstOrCreate($request->get('url'), [
            "url" => $request->get('url'),
            "hash" => Str::random(5)
        ]);
        if ($link->isExpired()) {
            throw new LinkIsExpired("Ссылка устарела");
        }
        return new LinkHashResource($link);
    }

    /**
     * @throws LinkIsExpired
     */
    public function getUrl(string $hash)
    {
        $link = $this->repository->findHash($hash);
        if (!$link || $link->isExpired()) {
            throw new LinkIsExpired("Ссылка устарела или не найдена");
        }
        return new LinkUrlResource($link);
    }

    public function redirectUrl(string $hash)
    {
        if (!$this->repository->findHash($hash)) {
            abort(404);
        }
        return redirect($this->getUrl($hash)->url);
    }

    public function searchUrl(string $url)
    {
        $link = $this->repository->firstOrCreate($url, [
            "url"   => $url,
            "hash"  => Str::random(5),
        ]);
        return new LinkHashResource($link);
    }

    public function links()
    {
        return response()->json(Link::all());
    }
}
