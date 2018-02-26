<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_Client;
use Google_Service_Drive;

class Googl extends Controller
{
    /**
     * Create a new google client instance.
     * 
     * @return $client
     */
    public function client()
    {
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
        $client->setScopes(explode(',', env('GOOGLE_SCOPES')));
        $client->setApprovalPrompt(env('GOOGLE_APPROVAL_PROMPT'));
        $client->setAccessType(env('GOOGLE_ACCESS_TYPE'));

        return $client;
    }

    /**
     * Create a new google drive instance.
     * 
     * @param  array  $client
     * @return $drive
     */
    public function drive($client)
    {
        $drive = new \Google_Service_Drive($client);
        return $drive;
    }
}
