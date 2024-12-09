<?php

namespace App\Weather;

class WeatherInfo
{
    public function __construct(
        public string $city,
        public int    $temperatureK,
        public string $weatherType,
    )
    {
    }

    public function getFahrenheit(): string
    {
        return round(($this->temperatureK - 273.15) * (9 / 5) + 32);
    }

    public function getCelsius(): string
    {
        return round($this->temperatureK - 273.15);
    }

}