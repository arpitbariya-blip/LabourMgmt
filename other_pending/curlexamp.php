<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://jsonplaceholder.typicode.com/posts/2");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// curl_close($ch);

$data = json_decode($response, true);
echo "<pre>";
print_r($data);
