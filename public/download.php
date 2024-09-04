<?php
$order_id = 1;  // Example order ID
$zip_filename = "/var/www/scraper/public/files/try.zip";
$command = escapeshellcmd("sudo python3 /va/www/scraper/download_images.py $order_id $zip_filename 2>&1");

$output = [];
$return_var = 0;

// Execute the Python script and capture output and errors
$output = shell_exec($command);

print_r($output);

?>
