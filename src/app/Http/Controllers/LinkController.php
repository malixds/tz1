<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkIsExpired;
use App\Http\Resources\LinkHashResource;
use App\Http\Resources\LinkUrlResource;
use App\Interfaces\ILinkRepository;
use App\Services\Link\CreateHashLinkService;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
    public function toHash(Request $request, CreateHashLinkService $service): LinkHashResource
    {
        $link = $service->run($request->get('url'));
        return new LinkHashResource($link);
    }

    /**
     * @throws LinkIsExpired
     */
    public function getUrl(string $hash): LinkUrlResource
    {
        $link = $this->repository->findHash($hash);
        if (!$link || $link->isExpired()) {
            throw new LinkIsExpired("Ссылка устарела или не найдена");
        }
        return new LinkUrlResource($link);
    }

    /**
     * @throws LinkIsExpired
     */
    public function redirectUrl(string $hash): Application|Redirector|RedirectResponse
    {
        if (!$this->repository->findHash($hash)) {
            abort(404);
        }
        return redirect($this->getUrl($hash)->url);
    }
    public function searchUrl(string $url): LinkHashResource
    {
        $link = $this->repository->firstOrCreate($url, [
            "url"   => $url,
            "hash"  => Str::random(5),
        ]);
        return new LinkHashResource($link);
    }
//    public function links()
//    {
//        return response()->json(Link::all());
//    }
}
