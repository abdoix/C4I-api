<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\sendsms;
use App\Models\winner;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Client\ClientExceptionInterface;
use Vonage\Client\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class send_sms extends Command
{
    use GeneralTrait;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'winner:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send sms to winners';

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
     * @return int
     */
    public function handle()
    {
        $response = Http::post('http://172.16.1.231/c4i/api/test', [
            'name' => 'Steve',
            'role' => 'Network Administrator',
        ]);

    }
}
