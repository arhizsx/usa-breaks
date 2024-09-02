<?php
$order_id = $_GET['order_id'];
$zip_filename = "images_$order_id.zip";

$command = escapeshellcmd("python3 /home/arhizsx/download_images.py $order_id $zip_filename");
$output = shell_exec($command);

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
