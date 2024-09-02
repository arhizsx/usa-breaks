<?php
$order_id = $_GET['order_id'];
$zip_filename = "images_$order_id.zip";

$command = escapeshellcmd("python3 /home/arhizsx/download_images.py $order_id $zip_filename");

// Initialize output and return variables
$output = [];
$return_var = 0;

// Execute the command
exec($command, $output, $return_var);

if ($return_var === 0) {
    $zip_file_path = trim(implode("\n", $output));

    if (file_exists($zip_file_path)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zip_file_path) . '"');
        header('Content-Length: ' . filesize($zip_file_path));

        flush();
        readfile($zip_file_path);
        unlink($zip_file_path);  // Optionally, delete the file after download
        exit;
    } else {
        echo "Failed to create ZIP file.";
    }
} else {
    echo "Failed to execute command.";
}
?>
