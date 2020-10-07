<?php

namespace App\Contracts;



/**
 * Существует много библиотек для работы с JSON-RPC,
 * использую интерфейс для возможности смены библиотеки.
 *
 * Interface JsonRpcClientInterface
 * @package App\Contracts
 */
interface JsonRpcClientInterface
{
    public function send(string $rpcMethod, array $rpcParams) : array;
}
