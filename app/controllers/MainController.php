<?php

namespace app\controllers;

use app\core\Controller;

/**
 * Class MainController
 * @package app\controllers
 */
class MainController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);
    }

    public function indexAction()
    {
        $params = [
            'uptime' => $this->model->serverUpTime(),
            'stats' => $this->model->serverStats(),
            'servers' => $this->model->getAllServersData(),
        ];
        $this->view->render($params);
    }

    public function startAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->startServer($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $this->view->message('success', 'Сервер успешно запущен!');
        }
    }

    public function stopAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->stopServer($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $this->view->message('success', 'Сервер успешно остановлен!');
        }
    }

    public function serverAction()
    {
        if (empty($this->route['id'])) {
            $this->view->redirect('/server/1');
        }
        $params = [
            'srv' => $this->model->getServerDataById($this->route['id']),
            'logs' => $this->model->getServerLogs($this->route['id']),
        ];
        $this->view->render($params);
    }

    public function cleanAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->deleteServerLogs($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $this->view->message('success', 'Логи успешно очищены!');
        }
    }
}