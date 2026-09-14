<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'Nabrijan',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'https://nabrijan.site',
    'domain' => $_ENV['APP_DOMAIN'] ?? 'nabrijan.site',
    'timezone' => $_ENV['TIMEZONE'] ?? 'Asia/Dhaka',
    'locale' => $_ENV['LOCALE'] ?? 'bn',
    'upload_max_size' => (int)($_ENV['UPLOAD_MAX_SIZE'] ?? 2097152),
    'max_storage_mb' => (int)($_ENV['MAX_STORAGE_MB'] ?? 2048),
];
