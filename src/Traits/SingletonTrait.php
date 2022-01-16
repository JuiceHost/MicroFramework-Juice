<?php
namespace Juice\Traits;

trait SingletonTrait
{
    protected static $instance;
    
    private function __clone() {}
    
    protected function __construct() {}
    
    public static function create() 
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
