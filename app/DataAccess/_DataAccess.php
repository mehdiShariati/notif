<?php


namespace App\DataAccess;
use Slim\Container;

abstract class _DataAccess
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
    protected function getContainer()
    {
        return $this->container;
    }
}