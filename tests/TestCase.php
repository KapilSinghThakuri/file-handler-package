<?php
namespace Kapil\FileHandler\Tests;

use Kapil\FileHandler\FileHandlerServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            FileHandlerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}