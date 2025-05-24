<?php
echo shell_exec("/usr/bin/python3 -c \"import textblob; print('TextBlob is working!')\" 2>&1"); // Linux/macOS
echo shell_exec("C:\\Python39\\python.exe -c \"import textblob; print('TextBlob is working!')\" 2>&1"); // Windows

?>
