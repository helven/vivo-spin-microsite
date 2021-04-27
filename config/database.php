<?php
if(strpos($config['base_url'], 'vivocampaign.com/staging') || strpos($config['base_url'], 'omega.sfdns.net/~vivocamp/staging')) // client staging
{
	$database['host']		= '127.0.0.1';
	$database['password']	= ')YwZ5@+8W6bj';
	$database['user']		= 'vivocamp_spin';
	$database['db_name']	= 'vivocamp_spin_stage';
}
elseif(strpos($config['base_url'], 'vivocampaign.com') || strpos($config['base_url'], 'omega.sfdns.net/~vivocamp')) // live
{
	$database['host']		= '127.0.0.1';
	$database['password']	= ')YwZ5@+8W6bj';
	$database['user']		= 'vivocamp_spin';
	$database['db_name']	= 'vivocamp_spin';
}
elseif(strpos($config['base_url'], 'vivospin.senjitsu.com')) // staging
{
	$database['host']		= '127.0.0.1';
	$database['password']	= 'g0tr7HFpBs';
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