<?php
namespace controllers;

class ErrorController extends AbstractController
{
    public function actionIndex()
    {
        return 'Не найден контроллер ' . $this->_controllerId . ', перейдите на <a href="/">главную</a> страницу';
    }
}