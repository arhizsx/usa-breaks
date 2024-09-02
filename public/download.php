<?php
$order_id = $_GET['order_id'];
$zip_filename = "testing.zip";

$command = escapeshellcmd("python3 /home/arhizsx/download_images.py $order_id $zip_filename");
$output = shell_exec($command);

$output = "/var/www/scraper/public/files/" . $zip_filename;

if (file_exists(trim($output))) {
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($output) . '"');
    header('Content-Length: ' . filesize($output));

    flush();
    readfile($output);
    unlink($output);  // Optionally, delete the file after download
    exit;
} else {
    echo "Failed to create ZIP file.";
}
?>
