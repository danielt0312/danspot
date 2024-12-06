<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        \Log::info('MyJob ha sido creado.');
    }
    
    /**
     * Execute the job.
     */
    public function handle()
    {
        // Lógica del trabajo
        \Log::info('MyJob ha sido procesado.');
    }
}
