<?php

namespace Juice\Util;

use Juice\Traits\SingletonTrait;
use Juice\Traits\RegistryTrait;
use Symfony\Component\Dotenv\Dotenv;

class Config
{
    use RegistryTrait, SingletonTrait;

    private function __construct()
    {
        $this->add('ROOT_DIR', dirname(dirname(__DIR__)));
        $env = new Dotenv();
        $env->LoadEnv($this->getRootDir().'/.env');
        foreach($_ENV as $key => $value){
            $this->add($key, $value);
        }
    }

    public function getRootDir()
    {
        return $this->get('ROOT_DIR');
    }

    public function getEnv()
    {
        return $this->get('APP_ENV');
    }

    public function getConfigDir()
    {
        return $this->getRootDir().'/config';
    }

    public function getTemplateDir()
    {
        return $this->getRootDir().'/templates';
    }

    public function getBaseUri()
    {
        return $this->get('BASE_URI');
    }

    public function getPublicUri()
    {
        return $this->get('BASE_URI').'/public';
    }

}