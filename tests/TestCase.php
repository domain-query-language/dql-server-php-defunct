<?php namespace Test;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    /**
     * @var \Illuminate\Foundation\Application 
     */
    private $application;
    
    public function app()
    {
        if (!$this->application) {
            $this->application = $this->createApplication();
        }
        return $this->application;
    }
    
    protected function load_json($file_path)
    {
        $ast_file = base_path($file_path);
        return json_decode(file_get_contents($ast_file));
    }
}
