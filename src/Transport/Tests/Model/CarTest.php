<?php
namespace MarTDD\Transport\Tests\Model;

use PHPUnit\Framework\TestCase;
use MarTDD\Transport\Model\Car;

class CarTest extends TestCase
{
    public function testMileage()
    {
        $car = new Car();

        $car->drive(20);

        $this->assertEquals(20, $car->getMileage());

        $car
            ->drive(100)
            ->drive(200)
            ->drive(300);
        
        $this->assertEquals(620, $car->getMileage());
    }

    public function testInvalidDrive()
    {
        $car = new Car();
        $car->drive(200);

        $this->expectException(\InvalidArgumentException::class);
        try {
            $car->drive(-100);
        } catch (\InvalidArgumentException $e) {
            $car->drive(100);
            $this->assertEquals(300, $car->getMileage());
            
            throw $e;
        }

    }
}
