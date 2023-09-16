<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the location entered by the user
    $location = $_POST['location'];
    $result = '';
    $currentDayData = ''; // Store current day's data separately

    // Replace 'YOUR_POSITIONSTACK_API_KEY' with your actual Positionstack API key
    $positionstack_api_key = '8dffbdec1cdc02cc5b5e2cbfb62bdb69';

    // Replace 'YOUR_OPENWEATHERMAP_API_KEY' with your actual OpenWeatherMap API key
    $openweathermap_api_key = '4d3cdd60814fc80ba5dc03352851748f';

    // Function to process and display current day's weather data
    function processCurrentDayData($forecast, $currentDay, $location, &$result) {
        // Extract weather data for the current day
        $temperature = $forecast['main']['temp'];
        $precipitation = $forecast['pop'] * 100; // Convert precipitation probability to percentage
        $windSpeed = $forecast['wind']['speed'];
        $windDirectionDegrees = $forecast['wind']['deg'];

        // Use the OpenWeatherMap icon URL directly based on the weather condition code
        if (isset($forecast['weather'][0]['icon'])) {
            $weatherCondition = $forecast['weather'][0]['icon'];
        } else {
            // Set a default weather condition code if not available
            $weatherCondition = '01d'; // Default to clear sky icon code for day
        }

        // Map OpenWeatherMap condition codes to your local icon filenames
        $weatherIcons = array(
            '01d' => '4.png',   // Clear sky (day)
            '01n' => '4n.png',  // Clear sky (night)
            '02d' => '10.png',  // Few clouds (day)
            '02n' => '10n.png', // Few clouds (night)
            '03d' => '10.png',  // Scattered clouds (day)
            '03n' => '10n.png', // Scattered clouds (night)
            '04d' => '16.png',  // Broken clouds (day)
            '04n' => '16.png',  // Broken clouds (night)
            '09d' => '19.png',  // Shower rain (day)
            '09n' => '19.png',  // Shower rain (night)
            '10d' => '15.png',  // Rain (day)
            '10n' => '15.png',  // Rain (night)
            '11d' => '6.png',   // Thunderstorm (day)
            '11n' => '6.png',   // Thunderstorm (night)
            '13d' => '14.png',  // Snow (day)
            '13n' => '14.png',  // Snow (night)
            '50d' => '13.png',  // Mist (day)
            '50n' => '13.png',  // Mist (night)
        );

        // Get the appropriate icon filename based on the OpenWeatherMap condition code
        $iconFilename = isset($weatherIcons[$weatherCondition]) ? $weatherIcons[$weatherCondition] : 'default.png';
        $weatherIconUrl = "http://openweathermap.org/img/w/{$weatherCondition}.png";

        // Convert temperature from Kelvin to Celsius
        $temperatureCelsius = $temperature - 273.15;

        // Implement the getWindDirection function to convert degrees to cardinal directions
        $windDirection = getWindDirection($windDirectionDegrees);

        // Display current day's weather data in the HTML structure
        $result .= '
        <div class="today forecast ">
            <div class="forecast-header">
                <div class="day">' . $currentDay . '</div>
                <div class="date">' . date('j M') . '</div>
            </div> <!-- .forecast-header -->
            <div class="forecast-content">
                <div class="location">' . ucwords($location) . '</div>
                <div class="degree">
                    <div class="num">' . round($temperatureCelsius) . '<sup>o</sup>C</div>
                    <div class="forecast-icon" style="height: auto;">
                        <img src="images/icons/' . $iconFilename . '" alt="Weather Icon" width=90>
                    </div>
                </div>
                <span><img src="images/icon-umberella.png" alt="Umbrella">' . $precipitation . '%</span>
                <span><img src="images/icon-wind.png" alt="Wind">' . $windSpeed . ' m/s</span>
                <span><img src="images/icon-compass.png" alt="Compass">' . $windDirection . '</span>
            </div>
        </div>';
    }

    // Function to process and display weather data for a day
    function processWeatherData($forecast, $fullDayName, &$result) {
        // Extract other weather data as needed
        $temperature = $forecast['main']['temp'];
        $precipitation = $forecast['pop'] * 100; // Convert precipitation probability to percentage
        $windSpeed = $forecast['wind']['speed'];
        $windDirectionDegrees = $forecast['wind']['deg'];

        // Use the OpenWeatherMap icon URL directly based on the weather condition code
        if (isset($forecast['weather'][0]['icon'])) {
            $weatherCondition = $forecast['weather'][0]['icon'];
        } else {
            // Set a default weather condition code if not available
            $weatherCondition = '01d'; // Default to clear sky icon code for day
        }

        // Map OpenWeatherMap condition codes to your local icon filenames
        $weatherIcons = array(
            '01d' => '4.png',   // Clear sky (day)
            '01n' => '4n.png',  // Clear sky (night)
            '02d' => '10.png',  // Few clouds (day)
            '02n' => '10n.png', // Few clouds (night)
            '03d' => '10.png',  // Scattered clouds (day)
            '03n' => '10n.png', // Scattered clouds (night)
            '04d' => '16.png',  // Broken clouds (day)
            '04n' => '16.png',  // Broken clouds (night)
            '09d' => '19.png',  // Shower rain (day)
            '09n' => '19.png',  // Shower rain (night)
            '10d' => '15.png',  // Rain (day)
            '10n' => '15.png',  // Rain (night)
            '11d' => '6.png',   // Thunderstorm (day)
            '11n' => '6.png',   // Thunderstorm (night)
            '13d' => '14.png',  // Snow (day)
            '13n' => '14.png',  // Snow (night)
            '50d' => '13.png',  // Mist (day)
            '50n' => '13.png',  // Mist (night)
        );

        // Get the appropriate icon filename based on the OpenWeatherMap condition code
        $iconFilename = isset($weatherIcons[$weatherCondition]) ? $weatherIcons[$weatherCondition] : 'default.png';
        $weatherIconUrl = "http://openweathermap.org/img/w/{$weatherCondition}.png";

        // Convert temperature from Kelvin to Celsius
        $temperatureCelsius = $temperature - 273.15;

        // Implement the getWindDirection function to convert degrees to cardinal directions
        $windDirection = getWindDirection($windDirectionDegrees);

        // Display weather data for the day in the HTML structure
        $result .= '
        <div class="forecast ">
            <div class="forecast-header">
                <div class="day">' . $fullDayName . '</div>
            </div> <!-- .forecast-header -->
            <div class="forecast-content">
                <div class="forecast-icon">
                    <img src="images/icons/' . $iconFilename . '" alt="" width=48>
                </div>
                <div class="degree">' . round($temperatureCelsius) . '<sup>o</sup>C</div>
                <small>' . $precipitation . '<sup>o</sup></small>
            </div>
        </div>';
    }

    // Function to convert degrees to cardinal directions
    function getWindDirection($degrees) {
        $cardinalDirections = array(
            'North', 'North-Northeast', 'Northeast', 'East-Northeast',
            'East', 'East-Southeast', 'Southeast', 'South-Southeast',
            'South', 'South-Southwest', 'Southwest', 'West-Southwest',
            'West', 'West-Northwest', 'Northwest', 'North-Northwest'
        );

        $degreeStep = 22.5; // Each cardinal direction spans 22.5 degrees

        $index = round($degrees / $degreeStep) % count($cardinalDirections);

        return $cardinalDirections[$index];
    }

    // Function to fetch and process weather data
    function fetchAndProcessWeatherData($location, &$result) {
        global $positionstack_api_key, $openweathermap_api_key, $currentDayData;

        // Make a request to the Positionstack API to get location data
        $positionstack_url = "http://api.positionstack.com/v1/forward?access_key=$positionstack_api_key&query=$location";
        $positionstack_response = @file_get_contents($positionstack_url);

        if ($positionstack_response === false) {
            // Handle request error
            throw new Exception('<h4 style="text-align: center; color: #ec2024"> Something Went wrong. Try later');
        }

        // Process the Positionstack API response (you can decode it as JSON)
        $positionstack_data = json_decode($positionstack_response, true);

        if (!isset($positionstack_data['data'][0])) {
            // Handle API response error from Positionstack
            throw new Exception('<h4 style="text-align: center;">Location not found.');
        }

        // Extract latitude and longitude from the Positionstack response
        $latitude = $positionstack_data['data'][0]['latitude'];
        $longitude = $positionstack_data['data'][0]['longitude'];

        // Make a request to the OpenWeatherMap API to get weather data
        $openweathermap_url = "https://api.openweathermap.org/data/2.5/forecast?lat=$latitude&lon=$longitude&appid=$openweathermap_api_key";
        $openweathermap_response = @file_get_contents($openweathermap_url);

        if ($openweathermap_response === false) {
            // Handle request error
            throw new Exception("Error: Unable to connect to the OpenWeatherMap API.");
        }

        // Process the OpenWeatherMap API response (you can decode it as JSON)
        $openweathermap_data = json_decode($openweathermap_response, true);

        if (!isset($openweathermap_data['list'])) {
            // Handle API response error from OpenWeatherMap
            throw new Exception('<h4 style="text-align: center; color: #ec2024"> Something Went wrong. Try later');
        }

        // Keep track of the current day to skip duplicate entries
        $currentDay = '';

        // Loop through the forecasts
        $forecastCount = 0;
        foreach ($openweathermap_data['list'] as $forecast) {
            // Extract the timestamp for the forecast
            $timestamp = $forecast['dt'];

            // Convert the timestamp to a full day name (e.g., Monday, Tuesday)
            $fullDayName = date('l', $timestamp);

            // Check if this is a new day
            if ($fullDayName !== $currentDay) {
                // Process and display weather data for the day
                if ($currentDay === '') {
                    // Store the current day's data separately
                    processCurrentDayData($forecast, $fullDayName, $location, $currentDayData);
                } else {
                    // Display other days' data
                    processWeatherData($forecast, $fullDayName, $result);
                }

                // Update the current day
                $currentDay = $fullDayName;

                // Increment the forecast count
                $forecastCount++;

                // Exit the loop if we have displayed 7 days
                if ($forecastCount === 7) {
                    break;
                }
            }
        }
    }

    try {
        // Call the function to fetch and process weather data
        fetchAndProcessWeatherData($location, $result);

        // Add the current day's data at the beginning
        $result = $currentDayData . $result;

        // Output the final result
        echo $result;
    } catch (Exception $e) {
        // Handle exceptions and display meaningful error messages
        echo '<h4 style="text-align: center;">' . $e->getMessage() . '</h4>';
    }
}
?>
