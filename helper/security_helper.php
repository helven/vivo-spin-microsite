<?php

if (!function_exists('sec_db_clean'))
{
    function sec_db_clean($link, $str)
    {
        return mysqli_real_escape_string($link, $str);
    }
}

if (!function_exists('sec_clean_all_post'))
{
    function sec_clean_all_post($link)
    {
        foreach($_POST as &$post)
        {
            if(!is_array($post))
            {
                $post	= sec_db_clean($link, $post);
            }
        }
    }
}

if (!function_exists('sec_clean_all_get'))
{
    function sec_clean_all_get($link)
    {
        foreach($_GET as &$get)
        {
            if(!is_array($get))
            {
                $get	= sec_db_clean($link, $get);
            }
        }
    }
}

if(!function_exists('encrypt_str'))
{
    function encrypt_str($str, $secret='')
    {
        $key        = md5("doyouknowwhoislimpeh".$secret);
        $encrypted  = openssl_encrypt($str, "AES-128-ECB", $key);

        return $encrypted;
    }
}

if(!function_exists('decrypt_str'))
{
    function decrypt_str($str, $secret='')
    {
        $key        = md5("doyouknowwhoislimpeh".$secret);
        $decrypted  = openssl_decrypt($str, "AES-128-ECB", $key);

        return $decrypted;
    }
}

if(!function_exists('encrypt_password'))
{
    function encrypt_password($str)
    {
        $key        = '';

        $salt1      = hash('sha512', $key . $str);
        $salt2      = hash('sha512', $str . $key);
        $encrypted  = hash('sha512', $salt1 . $str . $salt2);

        return $encrypted;
    }
}