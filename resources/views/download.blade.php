<?php
$order_id = $_GET['order_id'];

$order = DB::table("orders")->where("id", $order_id)->first();

$zip_filename = "/var/www/scraper/public/files/" . $order->user_id . "-" .  $order->filename;
$command = escapeshellcmd("python3 /home/arhizsx/download_images.py $order_id $zip_filename");
$output = shell_exec($command);

echo $output;

?>
