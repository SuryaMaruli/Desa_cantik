<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncStorage extends Command
{
    protected $signature = 'storage:sync';
    protected $description = 'Sync storage files from app/public to public/storage';

    public function handle()
    {
        $source = storage_path('app/public');
        $destination = public_path('storage');

        $this->info("Syncing storage from {$source} to {$destination}");
        
        // Remove existing destination if it's a directory
        if (is_dir($destination)) {
            File::deleteDirectory($destination);
            $this->info("Removed existing {$destination}");
        }
        
        // Copy all files recursively
        File::copyDirectory($source, $destination);
        
        $this->info("Storage synced successfully!");
        
        return 0;
    }
}
