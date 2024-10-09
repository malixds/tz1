<?php

namespace Tests\Feature;

use App\Exceptions\LinkIsExpired;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
//    Route::post('/tohash', [LinkController::class, 'toHash'])
//    ->name('tohash');
//
//    Route::get('/geturl/{hash}', [LinkController::class, 'getUrl'])
//    ->name('geturl');
//
//    Route::get('/redirecturl/{hash}', [LinkController::class, 'redirectUrl'])
//    ->name('redirecturl');
//
//    Route::get('/searchurl/{url}', [LinkController::class, 'searchUrl'])
//    ->name('searchurl');
    /**
     * A basic feature test example.
     */
    public function testCodeToHash(): void
    {
        // тест проведем в трех варианта, также проверка на сохраннение в бд
        // 1 - если такой записи нет -> hash
        // 2 - если запись есть и живая -> hash
        // 3 - запись есть и мертвая -> exception

        // 1 - 2
        $response = $this->postJson(route('tohash'), ["url" => "https://mangalib.me/dandadan/v9/c71?page=10"]);
        $this->assertTrue(in_array($response->status(), [200, 201]));
        $this->assertDatabaseHas('links', [
            'url' => urlencode('https://mangalib.me/dandadan/v9/c71?page=10'),
        ]);


        // 1 - 2
        $response = $this->postJson(route('tohash'),
            ["url" => urlencode("https://vk.com")]);
        $this->assertTrue(in_array($response->status(), [200, 201]));

        // 3
        $response = $this->postJson(route('tohash'),
            ["url" => urlencode("https://ok.ru")]);
        $response->assertStatus(500);
    }

    public function testGetUrlFromHash()
    {
        // получаем хэш, возвращаем урл
        // 1 - запись есть и живая -> возвращаем урл
        // 2 - записи нет -> 404
        // 3 - запись умерла -> 404

        // 1
        $response = $this->get(route('geturl'), ['hash' => "maxim"]);
        $response->assertStatus(200);
        // 2
        $response = $this->get(route('geturl'), ['hash' => "artem"]);
        $response->assertStatus(404);

        // 3
        $response = $this->get(route('geturl'), ['hash' => "hello"]);
        $response->assertStatus(404); // Измените на 404

    }

//    public function RedirectTest()
//    {
//        $reposnse = $this->get()
//    }


    // ищем хэш по урл, если нет создаем новый и возвращаем его, если есть то просто возвращаем
    // 1 - есть запись -> hash 200
    // 2 - записи нет -> hash 200 и сохраняем в бд
    public function testSearchUrl()
    {

        // 1
        $response = $this->get('api/searchurl/vk.com');
        $response->assertStatus(200);

        // 2
        $response = $this->get('api/searchurl/vk.comasd');
        $response->assertStatus(200);
    }

    // получаем хэш на соответствующий урл
    // 1 - есть запись -> редирект на урл
    // 2 - записи нет или она старая -> ошибка
    public function testRedirectUrl()
    {
//        $response = $this->get('/api/redirecturl/maxim');
//        $response->assertStatus(200);

        $this->get('/api/redirecturl/hello')->assertStatus(404);


    }
}
