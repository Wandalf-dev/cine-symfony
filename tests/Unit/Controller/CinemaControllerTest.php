<?php
namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\CinemaController;

class CinemaControllerTest extends TestCase
{
    public function testControllerInstantiation()
    {
        $controller = new CinemaController();
        $this->assertInstanceOf(CinemaController::class, $controller);
    }
}
