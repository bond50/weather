<?php

namespace App\Weather;

class RemoteWeatherFetcher implements WeatherFetcherInterface
{
    public function fetch(string $city): ?WeatherInfo
    {
        $fp = @fsockopen('ssl://downloads.codingcoursestv.eu', 443, $errno, $errstr, 30);

        if (!$fp) {
            echo "Connection failed: $errstr ($errno)\n";
            return null; // Return null in case of failure
        }

        $out = "GET /056%20-%20php/weather/weather.php?" . http_build_query(['city' => $city]) . " HTTP/1.1\r\n";
        $out .= "Host: downloads.codingcoursestv.eu\r\n";
        $out .= "Connection: Close\r\n\r\n";

        fwrite($fp, $out);

        $response = [];
        while (!feof($fp)) {
            $response[] = fgets($fp, 128);
        }
        fclose($fp);

        // Find the empty line that separates headers and body
        $emptyLineIndex = array_search("\r\n", $response);
        if ($emptyLineIndex === false) {
            echo "Invalid response structure.\n";
            return null;
        }

        // Extract the body from the response
        $body = implode('', array_slice($response, $emptyLineIndex + 1));

        // Decode JSON response
        $data = json_decode($body, true);

        // Validate JSON data
        if (!is_array($data) || !isset($data['city'], $data['temperature'], $data['weather'])) {
            echo "Invalid or missing data in response.\n";
            return null;
        }

        // Return a WeatherInfo object
        return new WeatherInfo(
            $data['city'],
            $data['temperature'],
            $data['weather']
        );
    }
}
