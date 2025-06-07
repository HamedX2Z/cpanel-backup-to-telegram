<?php
// CONFIG SECTION
$botToken = 'YOUR_TELEGRAM_BOT_TOKEN';
$chatId   = 'YOUR_TELEGRAM_CHAT_ID';

$dbHost   = 'localhost';
$dbName   = 'your_db_name';
$dbUser   = 'your_db_user';
$dbPass   = 'your_db_password';

$cpanelUser = 'YOUR_CPANEL_USERNAME';
$projectFolder = "/home/{$cpanelUser}/public_html"; // Backup target
$backupDir = "/home/{$cpanelUser}/backup_temp"; // Place to store temporary backup files

// PREPARE
$date = date('Y-m-d_H-i-s');
$filename = "backup_{$date}";
$sqlFile = "{$backupDir}/{$filename}.sql";
$zipFile = "{$backupDir}/{$filename}.zip";

// CREATE BACKUP DIR IF NEEDED
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// 1. EXPORT DATABASE
$cmd = "mysqldump -h {$dbHost} -u {$dbUser} -p'{$dbPass}' {$dbName} > {$sqlFile}";
system($cmd, $retval);
if ($retval !== 0) {
    die("❌ Failed to dump database.\n");
}

// 2. ZIP SQL + public_html
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE) !== TRUE) {
    die("❌ Cannot open <$zipFile>\n");
}
$zip->addFile($sqlFile, basename($sqlFile));

// Add all files from public_html
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($projectFolder, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $file) {
    $filePath = $file->getRealPath();
    $relativePath = substr($filePath, strlen($projectFolder) + 1);

    // Skip backup dir and the script itself
    if (
        strpos($filePath, $backupDir) === false &&
        basename($filePath) !== basename(__FILE__)
    ) {
        $zip->addFile($filePath, "public_html/{$relativePath}");
    }
}
$zip->close();

// 3. SEND TO TELEGRAM
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot{$botToken}/sendDocument");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'chat_id' => $chatId,
    'caption' => "📦 Backup of public_html and database on {$date}",
    'document' => new CURLFile($zipFile)
]);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo '❌ Curl error: ' . curl_error($ch) . "\n";
} else {
    echo "✅ Backup sent to Telegram.\n";
}
curl_close($ch);

// 4. CLEANUP
unlink($sqlFile);
unlink($zipFile);
?>