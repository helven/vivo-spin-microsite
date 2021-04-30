<?php
global $config;
$config = array();
$config['protocol'] = (stripos($_SERVER['SERVER_PROTOCOL'],'https') === true || $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
$config['base_url'] = $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);
$config['base_url'] = $config['protocol'].((isset($config['base_url']))?$config['base_url']:'vivo-spin-microsite.test');

if(strpos($config['base_url'], 'vivocampaign.com/staging') || strpos($config['base_url'], 'omega.sfdns.net/~vivocamp/staging'))
{
    $config['active_group'] = 'client_staging';
}
elseif(strpos($config['base_url'], 'vivocampaign.com') || strpos($config['base_url'], 'omega.sfdns.net/~vivocamp'))
{
    $config['active_group'] = 'live';
}
elseif(strpos($config['base_url'], 'vivospin.senjitsu.com'))
{
    $config['active_group'] = 'staging';
}
else
{
    $config['active_group'] = 'dev';
}

$config['live']['environment']      = 'live';
$config['live']['dir_base_url']     = ((isset($config['base_url']))?$config['base_url']:'vivocampaign.com'); 
$config['live']['base_url']         = ((isset($config['base_url']))?$config['base_url']:'vivocampaign.com');
$config['live']['media_url']        = $config['live']['base_url'].'/media';
$config['live']['site_url']         = 'https://vivocampaign.com';
$config['live']['storage_url']      = '';
$config['live']['storage_path']     = getcwd().'/storage/';
$config['live']['mail_admin_email'] = 'marketing@vivo.com.my';
$config['live']['mail_admin_name']  = 'vivo';
$config['live']['mail_mailtype']    = 'html';

$config['client_staging']['environment']        = 'staging';
$config['client_staging']['dir_base_url']       = ((isset($config['base_url']))?$config['base_url']:'vivocampaign.com/staging'); 
$config['client_staging']['base_url']           = ((isset($config['base_url']))?$config['base_url']:'vivocampaign.com/staging');
$config['client_staging']['media_url']          = $config['client_staging']['base_url'].'/media';
$config['client_staging']['site_url']           = 'https://vivocampaign.com/staging';
$config['client_staging']['storage_url']        = '';
$config['client_staging']['storage_path']       = getcwd().'/staging/storage/';
$config['client_staging']['mail_admin_email']   = 'marketing@vivo.com.my';
$config['client_staging']['mail_admin_name']    = 'vivo';
$config['client_staging']['mail_mailtype']      = 'html';

$config['staging']['environment']       = 'staging';
$config['staging']['dir_base_url']      = ((isset($config['base_url']))?$config['base_url']:'vivospin.senjitsu.com'); 
$config['staging']['base_url']          = ((isset($config['base_url']))?$config['base_url']:'vivospin.senjitsu.com');
$config['staging']['media_url']         = $config['staging']['base_url'].'/media';
$config['staging']['site_url']          = $config['protocol'].'vivospin.senjitsu.com';
$config['staging']['storage_url']       = $config['protocol'].'www.senjitsu.com/vivostorage';
$config['staging']['storage_path']       = '../vivostorage/';
$config['staging']['mail_admin_email']  = 'marketing@vivo.com.my';
$config['staging']['mail_admin_name']   = 'vivo';
$config['staging']['mail_mailtype']     = 'html';

$config['dev']['environment']       = 'dev';
$config['dev']['dir_base_url']      = str_replace('\\','', $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']));
$config['dev']['base_url']          = ((isset($config['base_url']))?$config['base_url']:'vivo-spin-microsite.test');
$config['dev']['media_url']         = $config['dev']['base_url'].'/media';
$config['dev']['site_url']          = 'http://vivo-spin-microsite.test';
$config['dev']['mail_admin_email']  = 'marketing@vivo.com.my';
$config['dev']['mail_admin_name']   = 'vivo';
$config['dev']['mail_mailtype']     = 'html';
$config = $config[$config['active_group']];

$config['row_per_page'] = 10;

$config['title']    = 'vivo';
$config['og_title'] = 'vivo spin & Win';
$config['og_desc']  = 'Hati rapat raya berkat. You can now buy a vivo phone and stand a chance to win fabulous prizes worth up to RM 68,888 from 1st May 2021 until 16th May 2021.';

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