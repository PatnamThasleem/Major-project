<?php
// Sample comments array to test - Replace this with actual data from your database
$comments = ["I love this video", "I hate this video"];

// Convert the comments array to JSON
$comments_json = json_encode($comments);

// Debugging: Check if $comments_json contains the expected JSON string
echo "Comments JSON: " . $comments_json . "<br>";

$command = "python sentiment_analysis.py";  // Define the Python script to run

// Open a process to run the Python script
$process = proc_open($command, [
    0 => ["pipe", "r"],  // Input
    1 => ["pipe", "w"],  // Output
    2 => ["pipe", "w"]   // Error
], $pipes);

if (is_resource($process)) {
    fwrite($pipes[0], $comments_json);  // Send comments directly to Python script
    fclose($pipes[0]);

    $output = stream_get_contents($pipes[1]);  // Capture the output
    fclose($pipes[1]);

    $error = stream_get_contents($pipes[2]);  // Capture errors
    fclose($pipes[2]);

    // Close process
    $return_value = proc_close($process);

    // Debugging: Show the output from the Python script
    echo "Python Script Output: " . $output . "<br>";

    // Trim the output to remove any unexpected newlines or spaces
    $output = trim($output);

    // Decode the JSON result from Python
    $sentiment_results = json_decode($output, true);

    // Check if the sentiment analysis results are valid
    if ($sentiment_results) {
        echo "Positive Comments: " . $sentiment_results['positive_count'] . "<br>";
        echo "Negative Comments: " . $sentiment_results['negative_count'] . "<br>";
    } else {
        // Display any JSON decoding error
        echo "Error: Unable to decode sentiment analysis results.<br>";
        echo "JSON Decode Error: " . json_last_error_msg() . "<br>";  // Show the specific decoding error
        echo "Python Error: " . $error . "<br>";  // Display the error from the Python script
    }
}
?>
