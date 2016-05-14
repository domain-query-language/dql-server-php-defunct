<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

class Statement
{
    public $assert;
    public $event;
    
    public function interpret($content)
    {
        if ($this->assert) {
            return $this->assert->interpret($content);
        }
        
        if ($this->event) {
            return $this->event->interpret($content);
        }
    }
}

