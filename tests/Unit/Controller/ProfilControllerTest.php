<?php
namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\ProfilController;

class ProfilControllerTest extends TestCase
{
    public function testControllerInstantiation()
    {
        $controller = new ProfilController();
        $this->assertInstanceOf(ProfilController::class, $controller);
    }
}
