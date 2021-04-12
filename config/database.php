<?php
if(strpos($config['base_url'], 'happybrday.baskinrobbins.com.my/staging')) // client staging
{
	$database['host']		= '127.0.0.1';
	$database['password']	= '';
	$database['user']		= '';
	$database['db_name']	= '';
}
elseif(strpos($config['base_url'], 'happybrday.baskinrobbins.com.my')) // live
{
	$database['host']		= '127.0.0.1';
	$database['password']	= '';
	$database['user']		= '';
	$database['db_name']	= '';
}
elseif(strpos($config['base_url'], 'oppo.senjitsu.com')) // staging
{
	$database['host']		= '127.0.0.1';
	$database['password']	= 'Q0dIwxJ4f';
	$database['user']		= 'symphoni_vivospin';
	$database['db_name']	= 'symphoni_vivospin';
}
else // localhost
{
	$database['host']		= 'localhost';
	$database['password']	= '';
	$database['user']		= 'root';
	$database['db_name']	= 'vivo_spin';
}

$database['trans']      = 'COMMIT'; // COMMIT / ROLLBACK