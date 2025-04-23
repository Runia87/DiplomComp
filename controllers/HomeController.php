<?php

namespace controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use model\QueryBuilder;

class HomeController
{
    private Engine $engine;
    private QueryBuilder $builder;
    private Auth $auth;
    public function __construct(Engine $engine, QueryBuilder $builder, Auth $auth)
    {
        $this->engine = $engine;
        $this->builder = $builder;
        $this->auth = $auth;
    }

    /**
     * @param array $data
     */

    public function index(): void
    {
        echo $this->engine->render('index.view');
    }
}
