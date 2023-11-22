<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\ForecastRepository;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{name}/{country}', defaults: ['country' => null])]
    public function city(
        #[MapEntity(mapping: ['name' => 'name', 'country' => 'country'], stripNull: true)]
        City $city,
        WeatherUtil $util,
    ): Response
    {
        $measurements = $util->getWeatherForCity($city);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'measurements' => $measurements,
        ]);
    }
}
