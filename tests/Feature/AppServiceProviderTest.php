<?php

    // this test is fully written buy ChatGPT
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\URL;

class AppServiceProviderTest extends TestCase
{
    public function testBootMethodInProductionEnvironment()
    {
        // Set the application environment to 'production'
        $this->app->detectEnvironment(function () {
            return 'production';
        });

        // Call the `boot` method of your AppServiceProvider
        $appServiceProvider = new \App\Providers\AppServiceProvider($this->app);
        $appServiceProvider->boot();

        // Generate the URL and assert that it starts with 'https://'
        $url = URL::to('/');
        $this->assertTrue(str_starts_with($url, 'https://'));
    }

    public function testBootMethodInNonProductionEnvironment()
    {
        // Set the application environment to a non-production value
        $this->app->detectEnvironment(function () {
            return 'local';
        });

        // Call the `boot` method of your AppServiceProvider
        $appServiceProvider = new \App\Providers\AppServiceProvider($this->app);
        $appServiceProvider->boot();

        // Generate the URL and assert that it does not start with 'https://'
        $url = URL::to('/');
        $this->assertFalse(str_starts_with($url, 'https://'));
    }
}
