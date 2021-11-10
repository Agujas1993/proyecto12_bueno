<?php

namespace Tests;

use App\Profession;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers;

    protected $defaultData;

    public function setUp()
    {
        parent::setUp();    //Llama al padre
        $this->withoutExceptionHandling(); //Para quitar error 500 en todos los test y saber cuál es el error
    }
}
