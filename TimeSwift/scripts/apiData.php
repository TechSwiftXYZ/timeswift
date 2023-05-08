<?php
// Get latitude and longitude from frontend
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Define API endpoint and parameters
$endpoint = "https://api.weatherapi.com/v1/forecast.json";
$params = array(
    "key" => "api_key_removed_for_security",
    "q" => $latitude . "," . $longitude,
    "days" => "3"
);

// Check if cache file exists and is less than 15 minutes old
$cacheDir = dirname(__FILE__) . '/cache/';
$cacheFile = $cacheDir . "weather_" . md5(serialize($params)) . ".json";
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 900)) {
    // Serve cached data
    $response = file_get_contents($cacheFile);
} else {
    // Create cURL handle
    $curl = curl_init();

    // Set cURL options
    curl_setopt($curl, CURLOPT_URL, $endpoint . '?' . http_build_query($params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json"
    ));

    // Execute cURL request and retrieve response
    $response = curl_exec($curl);

    // Close cURL handle
    curl_close($curl);

    // Save response to cache file
    file_put_contents($cacheFile, $response);
}

// Process response data
$data = json_decode($response, true);

// Return data to the front-end
echo json_encode($data);
?>