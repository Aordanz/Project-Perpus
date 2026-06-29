<?php
// Test langsung API Groq
$key = env('GROQ_API_KEY');
echo "Key: " . ($key ? substr($key, 0, 15) . '...' : 'KOSONG') . "\n";

// Test via config
$configKey = config('services.groq.key');
echo "Config Key: " . ($configKey ? substr($configKey, 0, 15) . '...' : 'KOSONG') . "\n";
