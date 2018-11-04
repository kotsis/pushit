<?php

namespace Kotsis\Pushit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PushitController extends Controller
{
    //
    public function index(){
        return view('kmak/pushit::admin');
    }

    public function subscribe(Request $request){

        $bodyContent = $request->getContent();
        $subscription = json_decode($bodyContent, true);
        if (!isset($subscription['endpoint'])) {
            echo 'Error: not a subscription';
            return;
        }

        $method = $request->method();

        switch ($method) {
            case 'POST':
                // create a new subscription entry in your database (endpoint is unique)
                break;
            case 'PUT':
                // update the key and token of subscription corresponding to the endpoint
                break;
            case 'DELETE':
                // delete the subscription corresponding to the endpoint
                break;
            default:
                echo "Error: method not handled";
                return;
        }
    }
}
