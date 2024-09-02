<?php
$order_id = 1;  // Example order ID
$zip_filename = "try.zip";
$command = escapeshellcmd("python3 /home/arhizsx/download_images.py $order_id $zip_filename 2>&1");

$output = [];
$return_var = 0;

exec($command, $output, $return_var);

if ($return_var !== 0) {
    echo "Failed to execute command. Output: " . implode("\n", $output);
} else {
    // Process output if needed
    echo "Command executed successfully.";
}
?>
