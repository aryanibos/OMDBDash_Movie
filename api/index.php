<?php

// 1. Force Debugging
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

// 2. Shutdown Handler to catch Fatal Errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && ($error['type'] === E_ERROR || $error['type'] === E_PARSE || $error['type'] === E_COMPILE_ERROR)) {
        echo "<h1>Fatal Error Caught</h1>";
        echo "<pre>" . print_r($error, true) . "</pre>";
        echo "<br>PHP Version: " . phpversion();
        // Check Vendor
        echo "<br>Vendor Exists: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'Yes' : 'No');
        die();
    }
});

// 3. Check for specific common issues
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("<h1>Error: vendor/autoload.php not found. Run 'composer install'.</h1>");
}

// 4. Manual APP_KEY fallback if missing
if (!getenv('APP_KEY')) {
    putenv('APP_KEY=base64:XxxxxXxxxxXxxxxXxxxxXxxxxXxxxxXxxxxXxxxxX='); // Dummy 32 char key for debug
}

// 5. Try to load Laravel
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>Exception Caught</h1>";
    echo "Message: " . $e->getMessage();
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
