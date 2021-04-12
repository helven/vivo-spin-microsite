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
    function sec_clean_all_post($link, $str='', $escape=TRUE)
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