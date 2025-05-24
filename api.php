<?php
$apiKey = "a7feb38ad3cf82d3021a94e715d725ab30208ad039dcada83edd6ae7";
// User comment to analyze
$user_comment = "I love this product!"; // Example user comment

// API Endpoint
$url = "https://api.textrazor.com/";

// Set up the data for the POST request
$postData = [
    'text' => $user_comment,
    'extractors' => 'sentiment,entities,topics' // Request sentiment, entities, and topics
];

// Set up the headers
$headers = [
    "x-textrazor-key: $apiKey",
    "Content-Type: application/x-www-form-urlencoded"
];

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // URL-encode the data
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute the request
$response = curl_exec($ch);

// Check for errors in the cURL request
if ($response === false) {
    echo "Error with cURL request: " . curl_error($ch);
    exit;
}

// Close cURL session
curl_close($ch);

// Decode the response to an associative array
$result = json_decode($response, true);

// Check if sentiment is available in the response
if (isset($result['response']['sentiment']['score'])) {
    $score = $result['response']['sentiment']['score'];
    if ($score > 0) {
        echo "Positive Comment!";
    } else {
        echo "Negative Comment!";
    }
} else {
    echo "Sentiment could not be detected or no sentiment data available.";
    echo "<br><strong>Response:</strong> " . print_r($result, true); // For debugging
}
?>
