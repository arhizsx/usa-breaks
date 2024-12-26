<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use GuzzleHttp\Client;

class ImageDownloadController extends Controller
{
    public function downloadImages($order_id)
    {
        // Query the database for the rows based on the order_id
        $rows = DB::table('view_scraper')->where('order_id', $order_id)->get(['certificate_number', 'certImgFront', 'certImgBack']);

        if ($rows->isEmpty()) {
            return response()->json(['message' => 'No images found for this order.'], 404);
        }

        // Create a unique temporary directory
        $tempDir = storage_path('app/temp/' . Str::uuid());
        if (!Storage::makeDirectory($tempDir)) {
            return response()->json(['message' => 'Failed to create temporary directory.'], 500);
        }

        $client = new Client();

        // Download images and rename them
        foreach ($rows as $row) {
            try {

                $imageContent = $client->get($row->certImgFront)->getBody();

                $filename = $tempDir . '/' . Str::slug($row->certificate_number) . 'A.' . pathinfo($row->certImgFront, PATHINFO_EXTENSION);
                file_put_contents($filename, $imageContent);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error downloading image: ' . $row->certImgFront], 500);
            }

            try {

                $imageContent = $client->get($row->certImgFront)->getBody();
                $filename = $tempDir . '/' . Str::slug($row->certificate_number) . 'B.' . pathinfo($row->certImgBack, PATHINFO_EXTENSION);
                file_put_contents($filename, $imageContent);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error downloading image: ' . $row->certImgBack], 500);
            }

        }

        // Create a zip file
        $zipFile = storage_path('app/temp/images-' . $order_id . '.zip');
        $zip = new ZipArchive;

        if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
            foreach (glob($tempDir . '/*') as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        } else {
            return response()->json(['message' => 'Failed to create zip file.'], 500);
        }

        // Clean up temporary directory
        foreach (glob($tempDir . '/*') as $file) {
            unlink($file);
        }
        rmdir($tempDir);

        // Return the zip file as a response for download
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }
}
