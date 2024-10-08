<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Link;

class SendLinks extends Command
{
    protected $signature = 'links:send';
    protected $description = 'Send new links to the specified endpoint';

    public function handle()
    {
        $endpoint = config('links.links_endpoint');
        $links = Link::query()->where('sent', false)->get();
        foreach ($links as $link) {
            $response = Http::post($endpoint, [
                'url' => $link->url,
                'created_at' => $link->created_at,
            ]);

            if ($response->successful()) {
                $link->sent = true;
                $link->save();
            }
        }
        $this->info('все ок');
    }
}
