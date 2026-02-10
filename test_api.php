<?php
require 'vendor/autoload.php';
$client = new GuzzleHttp\Client();
try {
    $response = $client->get('http://www.omdbapi.com/?apikey=466636a9&s=Batman');
    echo $response->getBody();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
