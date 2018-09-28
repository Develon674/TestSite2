<?php

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class WP_Options_Container implements ContainerInterface {
    
    use Dhii\Data\Container\CreateNotFoundExceptionCapableTrait;
    
    protected $falseValue;
    
    public function __construct($falseValue) {
        $this->falseValue = $falseValue;
    }
    
    public function get($key) {
        $falseValue = $this->falseValue;
        $option = get_option($key, $falseValue);
        if ($option !== $falseValue) {
            return $option;
        }
        
        throw $this->_createNotFoundException(
            sprintf('Could not find option for key "%1$s', $key),
            0,
            null,
            $this,
            $key
        );
    }
    
    public function has($key) {
        try {
            $this->get($key);
            
            return true;
        }
        catch (NotFoundExceptionInterface $e) {
            return false;
        }
    }
}
