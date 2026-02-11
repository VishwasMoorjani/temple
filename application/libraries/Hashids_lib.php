<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'third_party/Hashids.php');

class Hashids_lib
{
    private $hashids;

    public function __construct()
    {
        // Use your constant from constants.php or fallback salt
        $salt = defined('HASH_SALT') ? HASH_SALT : 'BuyYourMart2025';
        $this->hashids = new Hashids($salt, 8);
    }

    public function encode($id)
    {
        return $this->hashids->encode($id);
    }

    public function decode($hash)
    {
        return $this->hashids->decode($hash);
    }
}
