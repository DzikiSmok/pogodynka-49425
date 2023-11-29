<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\TestCase;

class ForecastTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['0.5', 32.9],
            ['6.4', 43.52],
            ['11.8', 53.24],
            ['-17.5', 0.5],
            ['17', 62.6],
            ['-100', -148],
            ['-99.9', -147.82],
            ['100', 212],
            ['100.1', 212.18],
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $forecast = new Forecast();

        $forecast->setTemperature($celsius);
        $this->assertEquals($expectedFahrenheit, $forecast->getFahrenheit());
    }
}
