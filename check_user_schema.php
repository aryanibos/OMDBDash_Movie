<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $user = App\User::first();
    echo "User found: " . ($user ? 'Yes' : 'No') . "\n";
    if ($user) {
        $attributes = array_keys($user->getAttributes());
        echo "Attributes: " . implode(', ', $attributes) . "\n";
    } else {
        // limit 1
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
        echo "Columns: " . implode(', ', $columns) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
