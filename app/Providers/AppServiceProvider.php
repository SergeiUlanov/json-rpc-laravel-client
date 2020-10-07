<?php

namespace App\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 1. Контроллер отправки данных с формы виджета формирует массив с данными для заполнения
        // полей формы при ошибках и сообщение от сервера с результатом выполнения запроса.
        // Главный шаблон ожидает его для передачи в виждет в переменной $pageDate.
        // View::share('widgetData', array());
        //
        // 2. Второй способ отказаться от глобальной переменной и использовать в шаблоне конструкцию:
        // @if(! empty($pageDate))
        //     @widget('FormOneWidget', $widgetData)
        // @else
        //     @widget('FormOneWidget')
        // @endif
    }
}
