<?php
/**
 * Lightweight reversible hash generator (no composer required)
 * Converts numeric IDs into short alphanumeric hashes and back.
 */
class Hashids
{
    private $salt;
    private $minLength;
    private $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    public function __construct($salt = 'default_salt', $minLength = 8)
    {
        $this->salt = $salt;
        $this->minLength = $minLength;
    }

    /** Encode a numeric ID to a short hash */
    public function encode($number)
    {
        if (!is_numeric($number)) return '';
        $hash = substr(md5($this->salt . $number), 0, $this->minLength);
        $base = base_convert($number, 10, 36);
        return $hash . $base;
    }

    /** Decode a hash back to the numeric ID */
    public function decode($hash)
    {
        if (strlen($hash) <= $this->minLength) return null;
        $base = substr($hash, $this->minLength);
        $num = base_convert($base, 36, 10);
        return is_numeric($num) ? (int)$num : null;
    }
}
