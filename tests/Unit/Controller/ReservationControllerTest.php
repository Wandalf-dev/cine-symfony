<?php
namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\ReservationController;

class ReservationControllerTest extends TestCase
{
    public function testControllerInstantiation()
    {
        $controller = new ReservationController();
        $this->assertInstanceOf(ReservationController::class, $controller);
    }
}
