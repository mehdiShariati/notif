<?php
namespace App\Controller;

use Slim\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class _Controller
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }

    /**
     * Get Slim Container
     *
     * @return Container
     */
    protected function getContainer()
    {
        return $this->container;
    }



}
