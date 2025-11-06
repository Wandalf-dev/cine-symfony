<?php
namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\HomeController;

class HomeControllerTest extends TestCase
{
    public function testControllerInstantiation()
    {
        $controller = new HomeController();
        $this->assertInstanceOf(HomeController::class, $controller);
    }
}
