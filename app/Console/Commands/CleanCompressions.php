<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\ImageCompression;
use Illuminate\Console\Command;

class CleanCompressions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compressions:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old compression zips';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $imageCompressions = ImageCompression::where('created_at', '<', Carbon::now()->subDay())
            ->get();

        foreach($imageCompressions as $imageCompression) {
            if(file_exists($imageCompression->file_uri)) {
                unlink($imageCompression->file_uri);
            }

            $imageCompression->delete();
        }
    }
}
