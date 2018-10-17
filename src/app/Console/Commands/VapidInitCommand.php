<?php

namespace Kotsis\Pushit;

use Illuminate\Console\Command;

class VapidInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vapid:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the VAPID private/public Elliptic Curve p256 key';

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
        //To-do
        //Check if config/pushit.php exists, if not run vendor:publish .... command (php artisan vendor:publish --provider=Kotsis\Pushit\PushitServiceProvider)
        //Open pushit.php and check if values are present, if yes do nothing
        //If values not there create the VAPID key
        //openssl ecparam -name prime256v1 -genkey -noout -out vapid_private.pem
        //openssl ec -in vapid_private.pem -pubout -out vapid_public.pem
        //done!
    }
}
