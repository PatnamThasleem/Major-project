<?php
$command = "python simple_test.py";  // Adjust to full path if necessary
$process = proc_open($command, [
    0 => ["pipe", "r"],
    1 => ["pipe", "w"],
    2 => ["pipe", "w"]
], $pipes);

if (is_resource($process)) {
    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    proc_close($process);

    echo "Output: " . $output;
    echo "Error: " . $error;
}

?>