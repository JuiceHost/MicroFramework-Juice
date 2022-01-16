<?php 
namespace Juice\Traits;

trait RegistryTrait
{
    protected $storage = [];
    
    public function add($key, $value) 
    {
        $this->storage[$key] = $value;
    }
    
    public function get($key)
    {
        return isset($this->storage[$key]) ? $this->storage[$key] : null;
    }
    
    public function existsKey($key) 
    {
        return isset($this->storage[$key]);
    }
    
    public function exists($value) 
    {
        return in_array($value, $this->storage);
    }
    
    public function delete($key) 
    {
        unset($this->storage[$key]);
    }
}