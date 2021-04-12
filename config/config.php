<?php
global $config;
$config = array();
$config['protocol'] = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
$config['base_url'] = $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);
$config['base_url'] = $config['protocol'].((isset($config['base_url']))?$config['base_url']:'vivo-spin-microsite.test');

if(strpos($config['base_url'], 'happybrday.baskinrobbins.com.my/staging'))
{
    $config['active_group'] = 'client_staging';
}
elseif(strpos($config['base_url'], 'happybrday.baskinrobbins.com.my'))
{
    $config['active_group'] = 'live';
}
elseif(strpos($config['base_url'], 'vivomicro.senjitsu.com'))
{
    $config['active_group'] = 'staging';
}
else
{
    $config['active_group'] = 'dev';
}

$config['live']['environment']      = 'live';
$config['live']['dir_base_url']     = 'https://'.((isset($config['live']['base_url']))?$config['live']['base_url']:'happybrday.baskinrobbins.com.my'); 
$config['live']['base_url']         = 'https://'.((isset($config['live']['base_url']))?$config['live']['base_url']:'happybrday.baskinrobbins.com.my');
$config['live']['media_url']        = $config['live']['base_url'].'/media';
$config['live']['site_url']         = 'https://happybrday.baskinrobbins.com.my';
$config['live']['storage_url']      = '';
$config['live']['storage_path']     = '../storage/';
$config['live']['mail_admin_email'] = 'marketing@vivo.com.my';
$config['live']['mail_admin_name']  = 'vivo';
$config['live']['mail_mailtype']    = 'html';

$config['client_staging']['environment']        = 'staging';
$config['client_staging']['dir_base_url']       = 'https://'.((isset($config['client_staging']['base_url']))?$config['client_staging']['base_url']:'happybrday.baskinrobbins.com.my/staging'); 
$config['client_staging']['base_url']           = 'https://'.((isset($config['client_staging']['base_url']))?$config['client_staging']['base_url']:'happybrday.baskinrobbins.com.my/staging');
$config['client_staging']['media_url']          = $config['client_staging']['base_url'].'/media';
$config['client_staging']['site_url']           = 'happybrday.baskinrobbins.com.my/staging';
$config['client_staging']['storage_url']        = '';
$config['client_staging']['storage_path']       = '../storage/';
$config['client_staging']['mail_admin_email']   = 'marketing@vivo.com.my';
$config['client_staging']['mail_admin_name']    = 'vivo';
$config['client_staging']['mail_mailtype']      = 'html';

$config['staging']['environment']       = 'staging';
$config['staging']['dir_base_url']      = $config['protocol'].((isset($config['staging']['base_url']))?$config['staging']['base_url']:'vivomicro.senjitsu.com'); 
$config['staging']['base_url']          = $config['protocol'].((isset($config['staging']['base_url']))?$config['staging']['base_url']:'vivomicro.senjitsu.com');
$config['staging']['media_url']         = $config['staging']['base_url'].'/media';
$config['staging']['site_url']          = $config['protocol'].'vivomicro.senjitsu.com';
$config['staging']['storage_url']       = $config['protocol'].'www.senjitsu.com/vivostorage';
$config['staging']['storage_path']       = '../vivostorage/';
$config['staging']['mail_admin_email']  = 'marketing@vivo.com.my';
$config['staging']['mail_admin_name']   = 'vivo';
$config['staging']['mail_mailtype']     = 'html';

$config['dev']['environment']       = 'dev';
$config['dev']['base_url']          = str_replace('\\','', $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']));
$config['dev']['base_url']          = 'http://'.((isset($config['dev']['base_url']))?$config['dev']['base_url']:'vivo-spin-microsite.test');
$config['dev']['media_url']         = $config['dev']['base_url'].'/media';
$config['dev']['site_url']          = 'http://vivo-spin-microsite.test';
$config['dev']['mail_admin_email']  = 'marketing@vivo.com.my';
$config['dev']['mail_admin_name']   = 'vivo';
$config['dev']['mail_mailtype']     = 'html';
$config = $config[$config['active_group']];

$config['row_per_page'] = 10;

$config['title']    = 'vivo';
$config['og_title'] = 'vivo';
$config['og_desc']  = 'vivo';

$config['area_prize']   = array(
    '1' => 6,
    '2' => 6,
    '3' => 6,
    '4' => 6,
    '5' => 6,
    '6' => 6,
    '7' => 6,
    '8' => 6,
    '9' => 6,
    '10' => 6,
    '11' => 6,
);