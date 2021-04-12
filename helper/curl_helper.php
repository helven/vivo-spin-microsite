<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		Zrixter
 * @author		Helven
 * @copyright	Copyright (c) 2009 - 2010, Zrixter Studio
 * @license		http://www.zrixter.net
 * @link		http://www.zrixter.net
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter CURL Helpers
 *
 * @package		Zrixter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Helven
 * @link		
 */

 

// ------------------------------------------------------------------------

/**
 * Set CURL Post
 *
 * Returns html string
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('curl_post'))
{
	function curl_post($curlURL, $a_Post, $port = 80)
	{
		// URL-IFY the data for the POST
		$queryString	= '';
		foreach($a_Post as $key => $value)
		{
			$queryString .= $key.'='.urlencode($value).'&';
		}
		rtrim($queryString, '&');
		
		$o_Curl		= curl_init();
		curl_setopt($o_Curl, CURLOPT_TIMEOUT, 360);
		curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($o_Curl, CURLOPT_URL, $curlURL);
		curl_setopt($o_Curl, CURLOPT_PORT, $port);
		curl_setopt($o_Curl, CURLOPT_POST, count($a_Post));
		curl_setopt($o_Curl, CURLOPT_POSTFIELDS, $queryString);
		
		// SIMULATING actual browsing
		curl_setopt($o_Curl, CURLOPT_REFERER, 'https://www.google.com/');
		curl_setopt($o_Curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36');
		curl_setopt($o_Curl, CURLOPT_HTTPHEADER, array(
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Connection: Keep-Alive',
			'Content-type: application/x-www-form-urlencoded;charset=UTF-8',
		));
		
		// EXECUTE curl
		$htmlStr	= curl_exec($o_Curl);
		
		if($htmlStr == '' || $htmlStr === FALSE)
		{
			$htmlStr	= '';
		}
		
		// CLOSE curl connection
		curl_close($o_Curl);
		
		return $htmlStr;
	}
}

// ------------------------------------------------------------------------

/**
 * Set CURL Get
 *
 * Returns html string
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('curl_get'))
{
	function curl_get($curlURL, $port = 80)
	{
		$o_Curl		= curl_init();
		curl_setopt($o_Curl, CURLOPT_TIMEOUT, 360);
		curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($o_Curl, CURLOPT_URL, $curlURL);

		// SIMULATING actual browsing
		curl_setopt($o_Curl, CURLOPT_REFERER, 'https://www.google.com/');
		curl_setopt($o_Curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($o_Curl, CURLOPT_CUSTOMREQUEST, "GET");

		curl_setopt($o_Curl, CURLOPT_ENCODING, 'gzip, deflate');

		$a_Headers	= array();
		$a_Headers[]	= "Dnt: 1";
		$a_Headers[]	= "Accept-Encoding: gzip, deflate, br";
		$a_Headers[]	= "Accept-Language: en-US,en;q=0.9,vi;q=0.8";
		$a_Headers[]	= "Upgrade-Insecure-Requests: 1";
		$a_Headers[]	= "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36";
		$a_Headers[]	= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
		$a_Headers[]	= "Connection: keep-alive";
		curl_setopt($o_Curl, CURLOPT_HTTPHEADER, $a_Headers);

		// EXECUTE curl
		$htmlStr	= curl_exec($o_Curl);
		if (curl_errno($o_Curl)) {
			//echo 'Error:' . curl_error($o_Curl);
		}
		
		if($htmlStr == '' || $htmlStr === FALSE)
		{
			$htmlStr	= '';
		}
		
		// CLOSE curl connection
		curl_close($o_Curl);
		
		return $htmlStr;
	}
}

/* End of file curl_helper.php */
/* Location: ./application/helpers/curl_helper.php */