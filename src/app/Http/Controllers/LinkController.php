<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkIsExpired;
use App\Http\Requests\SearchUrlRequest;
use App\Http\Requests\ToHashRequest;
use App\Http\Resources\LinkHashResource;
use App\Http\Resources\LinkUrlResource;
use App\Interfaces\ILinkRepository;
use App\Models\Link;
use App\Services\Link\CreateHashLinkService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{
    public function __construct(private ILinkRepository $repository)
    {
    }

    /**
     * Получает Hash по заданному URL.
     *
     * @param ToHashRequest $request Кастомный реквест для валидации входных параметров
     *
     * @param CreateHashLinkService $service Объект сервисного слоя
     *
     * @return LinkHashResource Ресурс, содержащий hash
     */
    public function toHash(ToHashRequest $request, CreateHashLinkService $service): LinkHashResource
    {
        $link = $service->run($request->validated('url'));
        return new LinkHashResource($link);
    }

    /**
     * Получает URL по заданному хешу.
     *
     * @param string $hash Хеш ссылки, по которому нужно найти URL.
     *
     * @return LinkUrlResource Ресурс, содержащий информацию о найденной ссылке.
     * @throws LinkIsExpired Если ссылка устарела или не найдена.
     *
     */
    public function getUrl(string $hash): LinkUrlResource
    {
        $link = $this->repository->findHash($hash);
        if (!$link || $link->isExpired()) {
            throw new LinkIsExpired("Ссылка устарела или не найдена");
        }
        $link->url = urldecode($link->url);
        return new LinkUrlResource($link);
    }

    /**
     * Перенаправляет на URL по заданному хешу.
     *
     * @param string $hash Хеш ссылки, по которому нужно найти URL.
     *
     * @return Application|Redirector|RedirectResponse Редирект на найденный URL.
     *
     * @throws NotFoundHttpException Если ссылка не найдена.
     *
     */
    public function redirectUrl(string $hash): Application|Redirector|RedirectResponse
    {
        $link = $this->repository->findHash($hash);
        if (!$link) {
            abort(404);
        }
        $link->url = urldecode($link->url);
        return redirect($link->url);
    }

    /**
     * Ищет URL и создает новую запись, если она не найдена.
     *
     * @param SearchUrlRequest $request Кастомный реквест для валидации входных параметров
     *
     * @return LinkHashResource Ресурс, содержащий информацию о найденной или созданной ссылке.
     */
    public function searchUrl(SearchUrlRequest $request): LinkHashResource
    {
        $link = $this->repository->findUrl(urlencode($request->validated("url")));
        if (!$link) {
            abort(404);
        }
        return new LinkHashResource($link);
    }

    /**
     * Получает все ссылки и возвращает их в формате JSON.
     *
     * @return JsonResponse Ответ в формате JSON, содержащий все ссылки.
     */
    public function links()
    {
        return response()->json(Link::all());
    }
}
