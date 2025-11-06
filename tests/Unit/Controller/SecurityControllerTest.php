<?php
namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\SecurityController;

class SecurityControllerTest extends TestCase
{
    public function testControllerInstantiation()
    {
        $controller = new SecurityController();
        $this->assertInstanceOf(SecurityController::class, $controller);
    }
}
