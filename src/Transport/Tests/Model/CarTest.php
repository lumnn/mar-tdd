<?php
namespace MarTDD\Transport\Tests\Model;

use PHPUnit\Framework\TestCase;
use MarTDD\Transport\Model\Car;

class CarTest extends TestCase
{
    /**
     * dsasddsds
     * @return [type] [description]
     */
    public function testMileage()
    {
        // create new car
        $car = new Car();

        // drive our car 20 units
        $car->drive(20);

        // test if mileage of the car is 20
        $this->assertEquals(20, $car->getMileage(), 'Mileage should contain sum of all driven distances');

        // dirve another distances
        $car
            ->drive(100)
            ->drive(200)
            ->drive(300);
        
        // check if mileage is correctly saved
        $this->assertEquals(620, $car->getMileage(), 'Mileage should contain sum of all driven distances');
    }

    public function testInvalidDrive()
    {
        $car = new Car();
        $car->drive(200);

        $this->expectException(\InvalidArgumentException::class, 'Funciton drive must allow only positive integers');
        try {
            $car->drive(-100);
        } catch (\InvalidArgumentException $e) {
            $car->drive(100);
            $this->assertEquals(300, $car->getMileage(), 'Mileage should not be changed when passing incorect argument to drive()');
            
            throw $e;
        }
    }

    public function registrationProvider()
    {
        return array(
            array('AAAAAA', 'AAAAAA'),
            array('BBBBBB', 'BBBBBB'),
            array('', false),
            array(null, false),
            array(true, '1')
        );
    }

    /**
     * In this test we're using `dataProvider` docblock statement, which indicates
     * a function which is going to supply a values for this test.
     *
     * This function is excecuted as much as there is arrays returned from `dataProvider`
     * Function is called with parameters from the inner array.
     *
     * @dataProvider registrationProvider
     */
    public function testRegistration($registration, $expectedRegistration)
    {
        $car = new Car();

        $car->setRegistration($registration);
        $this->assertEquals(
            $expectedRegistration,
            $car->getRegistration()
        );
    }

    public function testIfPropertiesArePrivate()
    {
        $car = new Car();

        // make sure that car mileage is a numeric value when created
        $this->assertTrue(is_numeric($car->getMileage()), 'Car initial mileage must be integer.');
        $this->assertEquals(null, $car->getRegistration());

        // generate random number
        $randomNumber = rand(1, 1000);

        // set registration
        $ourReg = 'TEST123';
        $car->setRegistration($ourReg);
        
        // drive the random number distance
        $car->drive($randomNumber);

        // get all public vars from car
        // and change it's its values
        foreach (get_object_vars($car) as $property => $value) {
            $car->$property = 0;
        }

        // check if registration is still correct
        $this->assertEquals(
            $ourReg,
            $car->getRegistration(),
            'Car must not allow to change registration other way than using setRegistration()'
        );
        // check if mileage is still correct
        $this->assertEquals($randomNumber, $car->getMileage(), 'Car must not allow to modify mileage');
    }
}
