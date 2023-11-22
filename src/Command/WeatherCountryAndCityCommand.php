<?php

namespace App\Command;

use App\Repository\CityRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:countryAndCity',
    description: 'Prints weather forecasts for city in country',
)]
class WeatherCountryAndCityCommand extends Command
{
    public function __construct(
    private CityRepository $cityRepository,
    private WeatherUtil $weatherUtil,
    string $name = null,
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country_code', InputArgument::REQUIRED, 'Country code [eg. PL]')
            ->addArgument('city_name', InputArgument::REQUIRED, 'City name [eg. Szczecin]')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('country_code');
        $cityName = $input->getArgument('city_name');

        $city = $this->cityRepository->findOneBy([
            'country' => $countryCode,
            'name' => $cityName,
        ]);

        $measurements = $this->weatherUtil->getWeatherForCity($city);
        $io->writeln(sprintf('Location: %s', $city->getName()));
        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: %s",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getTemperature()."°C"
            ));
        }
        return Command::SUCCESS;
    }
}
