<?php

// Suppress Deprecation Warnings (Laravel 5.8 on PHP 8.x compatibility)
error_reporting(E_ALL ^ E_DEPRECATED);

// Forward Vercel requests to Laravel entry point
require __DIR__ . '/../public/index.php';
