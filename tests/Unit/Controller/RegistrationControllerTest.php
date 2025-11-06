<?php
namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\RegistrationController;

class RegistrationControllerTest extends TestCase
{
    public function testControllerInstantiation()
    {
        $controller = new RegistrationController();
        $this->assertInstanceOf(RegistrationController::class, $controller);
    }
}
