<?php namespace Test;

use Mockery;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
    
    protected $fresh_app = false;
    
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    
    protected static $cached_app;
    
    public function createApplication()
    {
        if (! static::$cached_app) {
            $app = require __DIR__.'/../bootstrap/app.php';
            $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
            static::$cached_app = $app; 
        }
        return static::$cached_app;
    }   
    
    protected function load_json($file_path)
    {
        $full_file_path = base_path($file_path);
        return json_decode(file_get_contents($full_file_path));
    }
     
    protected function tearDown()
    {
        if (class_exists('Mockery')) {
            Mockery::close();
        }

        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }
        }

        $this->setUpHasRun = false;

        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }

        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];
    }
    
    //Let's make the intent of our tests clearer
    protected function dummy(string $classOrInterface)
    {
        return $this->prophesize($classOrInterface)->reveal();
    }
    
    protected function stub(string $classOrInterface)
    {
        return $this->prophesize($classOrInterface);
    }
     
    protected function mock(string $classOrInterface)
    {
        return $this->prophesize($classOrInterface);
    }
}
