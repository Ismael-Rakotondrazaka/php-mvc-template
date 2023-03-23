<?php

namespace App\Core\Applications;

use App\Core\Requests\Request;
use App\Core\Responses\Response;
use App\Core\Routes\Router;

class Application
{
    public Router $router;
    private Request $request;
    private Response $response; 

    public function __construct()
    {
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run()
    {
        $this->router->resolve($this->request, $this->response);
    }
}