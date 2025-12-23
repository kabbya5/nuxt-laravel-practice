<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class FileUploadJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $uploadId,
        public string $fileName,
        public int $totalChunks,
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tempPath = storage_path("app/public/temp/{$this->uploadId}");
        $finalDir = storage_path("app/public/upload");

        if (!is_dir($finalDir)) {
            mkdir($finalDir, 0777, true); // recursive creation
        }
        
        $finalPath = $finalDir . '/' . $this->fileName;

        $output = fopen($finalPath, 'ab');

        for ($i = 0; $i < $this->totalChunks; $i++) {
            $chunkFile = $tempPath . "/{$i}";
            if (file_exists($chunkFile)) {
                fwrite($output, file_get_contents($chunkFile));
                unlink($chunkFile);
            }
        }

        fclose($output);

        // Delete temp folder safely
        if (File::exists($tempPath)) {
            File::deleteDirectory($tempPath);
        }
    }
}
