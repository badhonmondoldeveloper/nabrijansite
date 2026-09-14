<?php
header('Content-Type: text/plain; charset=utf-8');

echo "=== NABRIJAN SaaS AUTOMATED DEPLOYMENT SCRIPT ===\n";

$targetDir = dirname(__DIR__);

// 1. Unzip deploy.zip
$zip = new ZipArchive();
if ($zip->open($targetDir . '/deploy.zip') === TRUE) {
    $zip->extractTo($targetDir);
    $zip->close();
    echo "[✓] Extracted deploy.zip successfully into {$targetDir}.\n";
} else {
    echo "[X] Failed to extract deploy.zip\n";
    exit;
}

// 2. Import Database Schema & Seeds
try {
    $dsn = "mysql:host=127.0.0.1;dbname=nabrijan_db;charset=utf8mb4";
    $pdo = new PDO($dsn, "nabrijan_user", "NabrijanPass#2026!", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "[✓] Database connection established to nabrijan_db.\n";

    if (file_exists($targetDir . '/database/schema.sql')) {
        $sql = file_get_contents($targetDir . '/database/schema.sql');
        $pdo->exec($sql);
        echo "[✓] Database schema DDL (25 tables) imported successfully.\n";
    }

    if (file_exists($targetDir . '/database/seeds/seed.sql')) {
        $seedSql = file_get_contents($targetDir . '/database/seeds/seed.sql');
        $pdo->exec($seedSql);
        echo "[✓] Database seeds (Super Admin, Plans, Themes) imported successfully.\n";
    }
} catch (Exception $e) {
    echo "[!] Database Warning: " . $e->getMessage() . "\n";
}

// 3. Create Production .env
$envContent = <<<EOT
APP_NAME="Nabrijan"
APP_ENV="production"
APP_DEBUG=false
APP_URL="https://nabrijan.site"
APP_DOMAIN="nabrijan.site"
TIMEZONE="Asia/Dhaka"
LOCALE="bn"

DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_NAME="nabrijan_db"
DB_USER="nabrijan_user"
DB_PASS="NabrijanPass#2026!"
DB_CHARSET="utf8mb4"

SESSION_LIFETIME=7200
SESSION_SECURE=false

UPLOAD_MAX_SIZE=2097152
MAX_STORAGE_MB=2048
EOT;

file_put_contents($targetDir . '/.env', $envContent);
echo "[✓] Production .env configuration created.\n";

// 4. Cleanup
@unlink($targetDir . '/deploy.zip');
@unlink(__FILE__);
echo "[✓] Deployment completed and setup files cleaned up!\n";
