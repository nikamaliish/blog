<?php
use controllers\AbstractController;

class Application
{
    public $controllersPath = '\controllers';

    public function run()
    {
        $controllerParam = isset($_GET['c']) ? $_GET['c'] : 'default';
        $actionParam = isset($_GET['a']) ? $_GET['a'] : 'index';
        // default => \controllers\DefaultController
        $controller_class = $this->controllersPath . '\\' .ucfirst($controllerParam) . 'Controller';
        // index => actionIndex
        $action_method = 'action' . ucfirst($actionParam);

        if (!class_exists($controller_class)) {
            $controller_class = $this->controllersPath . '\ErrorController';
        }

        /** @var AbstractController $controller */
        $controller = new $controller_class(); // new \controllers\DefaultController()
        $controller->_action = $actionParam; // index
        $controller->_controllerId = $controllerParam; // default

        $controller->beforeAction();

        echo $controller->$action_method(); // \controllers\DefaultController::actionIndex():256
    }
}