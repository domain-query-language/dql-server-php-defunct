<?php namespace Infrastructure\App\Interpreter\EventHandler;

class Interpreter implements \App\Interpreter\Interpreter
{    
    public function interpret(\App\Interpreter\Context $context)
    {
        $root = $context->get_property('root');
        $event = $context->get_property('event');
        
        $root->is_created = true;
    }
}

