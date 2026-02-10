<?php

// Suppress Deprecation Warnings (Laravel 5.8 on PHP 8.x compatibility)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Forward Vercel requests to Laravel entry point
require __DIR__ . '/../public/index.php';
