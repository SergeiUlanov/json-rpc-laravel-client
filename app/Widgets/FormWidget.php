<?php

namespace App\Widgets;


use App\Contracts\JsonRpcClientInterface;
use Arrilot\Widgets\AbstractWidget;
use DateTime;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use system\Exceptions\DateError;
use Carbon\Carbon;



class FormWidget extends AbstractWidget
{
    private JsonRpcClientInterface $rpcClient;

    private string $localTimeZone;    // Временная зона сервера может отличаться от текущей. Поэтому использую настройки
    private string $serverTimeZone;   // временных зон для расчёта времени, исходя из временной зоны сайта пользователя
    private string $dateFormat;       // Формат даты/времени для сервера клиентского сайта


    /**
     * Инициализация полей формы виджета.
     *
     * Установка переменных для полей формы вижджета в пустые значения по умолчанию.
     * Загрузка в них ранее введённых данных, которые могут поступить из контроллера.
     *
     * @param array $config - массив со значениями для заполнения полей формы при ошибках
     */
    public function __construct(array $config = [])
    {
        $this->rpcClient  = app::make('App\Contracts\JsonRpcClientInterface');
        $this->dateFormat = config('services.form-widget.date-format');
        $this->localTimeZone  = config('app.timezone');
        $this->serverTimeZone = config('services.form-widget.server-timezone');

        $pageUID = $this->getPageUID();

        $this->addConfigDefaults(array(
            'page_uid'    => $pageUID,      // Устанавливаю значения по умолчанию для полей формы на виждете, они
            'user_name'   => '',            // используются когда нет данных из контроллера.
            'user_text'   => '',            // В ходе вызова конструктора родительского класса если имеются данные,
            'server_data' => array()        // поступившие из контроллера, они перезапишут эти пустые значения.
        ));

        parent::__construct($config);       // перезапись пустых данных данными из контроллера, если они имеются
    }



    /**
     * При запуске виджета запрашиваю с удалённого сервера данные, имеющиеся для странички.
     */
    public function run()
    {
        $pageUID =$this->config['page_uid'];
        $this->config['page_recs'] = $this->readPageDate($pageUID);

        // dump($this->config);

        return view('widgets.form_widget', [
            'config' => $this->config,
        ]);
    }



    /**
     * В качестве page_uid страницы пусть будет имя маршрута.
     *
     * @return string
     */
    public static function getPageUID() : string
    {
        return Route::currentRouteName();
    }



    /**
     * Выполнение запроса к удалённому серверу с командой сохранения данных странички.
     *
     * В случае ошибок
     *
     * @param string $pageUID
     * @param array $widgetData
     * @return array
     */
    public function savePageDate(string $pageUID, array $widgetData) : array
    {
        $name = $widgetData['user_name'];
        $text = $widgetData['user_text'];

        $rpcMethod = 'srvAdd';
        $rpcParams = array($pageUID, $name, $text);
        $serverData = $this->rpcClient->send($rpcMethod, $rpcParams);

        // Добавление введённых данных для вывода в полях формы при ошибках
        $serverData['user_name'] = $name;
        $serverData['user_text'] = $text;

        if(! isset($serverData['result'])  &&  ! isset($serverData['error'])) {
            $serverData['error']['message'] = 'Ошибка, возможно сервер не ответил';
        }
        elseif(isset($serverData['result']['error'])) {
            $serverData['error']['message'] = $serverData['result']['error'];
        }
        return $serverData;
    }



    /**
     * Запрос данных для странички с удалённого сервера.
     *
     * @param string $pageUID
     * @return array
     */
    public function readPageDate(string $pageUID) : array
    {
        $rpcMethod = 'srvRead';
        $rpcParams = array($pageUID);
        $serverData = $this->rpcClient->send($rpcMethod, $rpcParams);

        foreach($serverData['result'] as $key=>$rec) {
            $serverUtfDate = $serverData['result'][$key]['time'] . ' ' . $this->serverTimeZone;
            $localDate = Carbon::parse($serverUtfDate)->timezone($this->localTimeZone)->translatedFormat($this->dateFormat);
            $serverData['result'][$key]['time'] = $localDate;
        }

        if(! isset($serverData['result'])  &&  ! isset($serverData['error'])) {
            $serverData['error']['message'] = 'Ошибка, возможно сервер не ответил';
        }
        return $serverData;
    }


}   // end class
