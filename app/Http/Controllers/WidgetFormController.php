<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Widgets\FormWidget;
//use App\Contracts\JsonRpcClientInterface;



/**
 * Контроллер формы виджета. Отправляет введённые данные с формы на удалённый сервер.
 *
 * Class WidgetFormController
 * @package App\Http\Controllers
 */
class WidgetFormController extends Controller
{

    /**
     * Обработка данных с формы виджета. Отправка данных на удалённый сервер.
     *
     * @param Request $request
     * @param FormWidget $wg
     * @return Application|Factory|View
     */
    public function storeWidgetForm(Request $request, FormWidget $wg)
    {
        $request->validate([
            'user_name' => 'required|min:3|max:14',
            'user_text' => 'required|min:16|max:127',
        ]);

        $pageUID  = FormWidget::getPageUID();
        $userName = $this->filterString( $request->input('user_name') );
        $userText = $this->filterString( $request->input('user_text') );

        $widgetData = array(
            'user_name' => $userName,
            'user_text' => $userText,
        );
        $widgetData = $wg->savePageDate($pageUID, $widgetData);

        return view($pageUID, ['widgetData' => $widgetData]);
    }



    /**
     * Очистка строк, поступивших из браузера
     *
     * @param string $str
     * @return string
     */
    private function filterString(?string $str) : string
    {
        return trim( htmlentities($str, ENT_QUOTES, "UTF-8") );
    }



    ///**
    // * Метод для целей отладки
    // * @param JsonRpcClientInterface $rpcClient
    // */
    //public function storeWidgetFormDebug(JsonRpcClientInterface $rpcClient)
    //{
    //    $rpcMethod = 'read';
    //    $rpcParams = array('about');
    //    $serverData = $rpcClient->send($rpcMethod, $rpcParams);
    //    dump($serverData);
    //}
/*
Парамеры запроса для отладки в Postman:
{
    "jsonrpc": "2.0",
    "id": "1602050478",
    "method": "srvAdd",
    "params": {
        "page_uid":  "about",
        "user_name": "Колобок",
        "user_text": "Я колобок!"
    }
}
*/


}   // end class
