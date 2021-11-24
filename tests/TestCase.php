<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers;

    protected $defaultData;

    public function setUp()
    {
        parent::setUp();    //Llama al padre

        $this->addTestResponseMacros();

        $this->withoutExceptionHandling(); //Para quitar error 500 en todos los test y saber cuál es el error
    }

    public function addTestResponseMacros() : void
    {
        TestResponse::macro('viewData', function ($key) {
            $this->ensureResponseHasView();
            $this->assertViewHas($key);

            return $this->original->$key;
        });

        TestResponse::macro('assertViewCollection', function ($var) {
            return new TestCollectionData($this->viewData($var));
        });
    }
    
}
