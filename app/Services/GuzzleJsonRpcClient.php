<?php

namespace App\Services;


use App\Contracts\JsonRpcClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\GuzzleException;



/**
 * Класс для работы с JSON-RPC через использование библиотеки GuzzleHttp.
 * Одна из возможных реализаций JSON-RPC-клиента.
 *
 * Class GuzzleJsonRpcClient
 * @package App\Services
 */
class GuzzleJsonRpcClient implements JsonRpcClientInterface
{
    const JSON_RPC_VERSION = '2.0';

    protected string $baseUri;
    protected string $methodUri;
    protected int    $timeOut;

    protected Client $client;



    /**
     * Создание и инициализация клиентского объекта для работы JSON-RPC
     */
    public function __construct()
    {
        $this->baseUri   = config('services.form-widget.api-base-uri');
        $this->methodUri = config('services.form-widget.api-method-uri');
        $this->timeOut   = config('services.form-widget.api-timeout');

        $config = array(
            'headers'  => array('Content-Type' => 'application/json'),
            'base_uri' => $this->baseUri,
            'timeout'  => $this->timeOut,
        );
        $this->client = new Client($config);
    }



    /**
     * Выполнение запроса к серверу и получение ответа.
     *
     * @param string $rpcMethod
     * @param array $rpcParams
     * @return array
     */
    public function send(string $rpcMethod, array $rpcParams) : array
    {
        $rpcRequest = array(
            RequestOptions::JSON => array(
                'jsonrpc' => self::JSON_RPC_VERSION,
                'id'      => time(),
                'method'  => $rpcMethod,
                'params'  => $rpcParams
            )
        );

        try {
            $response = $this->client->post($this->methodUri, $rpcRequest);
            $content = $response->getBody()->getContents();
            $result = json_decode($content, true);
        }
        catch(GuzzleException  $e) {
            $result = array();                                           // Описание ошибок сети (например если сервер не найден)
            $result['error']['code'] = $e->getCode();                    // может быть довольно длинное. Требуется
            $result['error']['message'] = strip_tags($e->getMessage());  // todo формировать более краткое описание ошибок сети
        }                                                                // Например использовать строки, взятые по коду ошибки

        return $result;
    }


}   // end class
