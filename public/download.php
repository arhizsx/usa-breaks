<?php
$order_id = 1;
$zip_filename = "try.zip";
$command = "python3 /var/www/scraper/download_images.py $order_id $zip_filename 2>&1"; // Capture both stdout and stderr


// Execute the Python script and capture output and errors
$output = shell_exec($command);

print_r($output);

?>
