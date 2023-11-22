<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Entity\Forecast;
use App\Repository\CityRepository;
use App\Repository\ForecastRepository;

class WeatherUtil
{
    public function __construct(
        private CityRepository $cityRepository,
        private ForecastRepository $forecastRepository,
    )
    {
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCity(City $city): array
    {
        return $this->forecastRepository->findByLocation($city);
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $name): array
    {
        $city = $this->cityRepository->findOneBy([
            'country' => $countryCode,
            'name' => $name,
        ]);

        return $this->getWeatherForCity($city);
    }
}