<?php

namespace Kotsis\Pushit;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        //By running vendor:publish .... command (php artisan vendor:publish --provider=Kotsis\Pushit\PushitServiceProvider)
        //we make sure the pushit.php config file is created if not there.
        //If it is there, then nothing happens.
        Artisan::call('vendor:publish', [
            '--provider' => 'Kotsis\Pushit\PushitServiceProvider'
        ]);

        //read the config file
        $str=file_get_contents('./config/pushit.php');

        $patternPriv = "/['\"]privkey['\"].*?=>.*?['\"](.*?)['\"]/s";
        $patternPub = "/['\"]pubkey['\"].*?=>.*?['\"](.*?)['\"]/s";

        if(preg_match_all($patternPriv, $str, $matchPriv)==1 && preg_match_all($patternPub, $str, $matchPub)==1){
            //ok we have matches of public and private key values, if they are not empty then
            //we don't need to do anything we exit.
            if(strlen(trim($matchPriv[1][0])) > 0 || strlen(trim($matchPub[1][0])) > 0){
                echo "No action taken, 'privkey' and 'pubkey' values seem to be already in place\n";
                return;
            }
        }
        else{
            echo "Could not locate one 'privkey' and one 'pubkey' item in the file ...\n";
            return;
        }

        //If we are here then we must create a new VAPID private/public key pair
        //openssl ecparam -name prime256v1 -genkey -noout -out vapid_private.pem
        //openssl ec -in vapid_private.pem -pubout -out vapid_public.pem
        $config = array(
            "private_key_type" => OPENSSL_KEYTYPE_EC,
            'curve_name' => 'prime256v1'
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        if($res === FALSE){
            echo "For PHP function openssl_pkey_new() to work please read this: http://php.net/manual/en/openssl.installation.php\n";
            return;
        }

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        //We remove new lines and BEGIN/END lines , we only keep the single line base64 encoded section
        $pubKey = str_replace("-----BEGIN PUBLIC KEY-----", "", $pubKey);
		$pubKey = str_replace("-----END PUBLIC KEY-----", "", $pubKey);
        $pubKey = str_replace("\n", "", $pubKey);

        $privKey = str_replace("-----BEGIN EC PRIVATE KEY-----", "", $privKey);
		$privKey = str_replace("-----END EC PRIVATE KEY-----", "", $privKey);
        $privKey = str_replace("\n", "", $privKey);

        $str = preg_replace($patternPriv, "'privkey' => '$privKey'", $str);
        $str = preg_replace($patternPub, "'pubkey' => '$pubKey'", $str);

        //write the entire string
        file_put_contents('./config/pushit.php', $str);

        echo "VAPID public/private key pair has been created and saved in config/pushit.php\n";
    }
}
