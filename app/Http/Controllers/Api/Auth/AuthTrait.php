<?php

namespace App\Http\Controllers\Api\Auth;

use DB;

trait AuthTrait
{
    protected $client;

    public function getParams($r, $grantType = 'password')
    {
        $this->getClient();
        return [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $r->email,
            'password' => $r->password,
            'scope' => "*",
            // 'client' => $this->client
        ];
    }

    private function getClient()
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
    }
}
