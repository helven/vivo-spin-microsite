<?php
/**
 * Base Url
 *
 * Return Base Url
 *
 * @access  public
 * @param   $boolean
 * @return  unknown
 */
function base_url($slash=TRUE)
{
    global $config;
    return ($slash)?add_end_slash($config['base_url']):$config['base_url'];
}

/**
 * Site Url
 *
 * Return Site Url
 *
 * @access  public
 * @param   $boolean
 * @return  unknown
 */
function site_url($slash=TRUE)
{
    global $config;
    return ($slash)?add_end_slash($config['site_url']):$config['site_url'];
}

/**
 * Media Url
 *
 * Return Media Url
 *
 * @access  public
 * @param   $boolean
 * @return  unknown
 */
function media_url($slash=TRUE)
{
    global $config;
    return ($slash)?add_end_slash($config['media_url']):$config['media_url'];
}

/**
 * Slash item
 *
 * Return parameter with backslash
 *
 * @access  public
 * @param   $string
 * @return  string
 */
function add_end_slash($str)
{
    if(substr($str, -1) != '/')
    {
        return $str.'/';
    }
    
    return $str;
}