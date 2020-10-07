<?php

namespace App\Providers;


use App\Contracts\JsonRpcClientInterface;
use App\Services\GuzzleJsonRpcClient;
use Illuminate\Support\ServiceProvider;



/**
 * Регистрация используемого на сайте JSON-RPC-клиента,
 * работающего с конкретной библиотекой.
 *
 * Class JsonRpcClientServiceProvider
 * @package App\Providers
 */
class JsonRpcClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(JsonRpcClientInterface::class, function ($app) { return new GuzzleJsonRpcClient(); });
    }
}
