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
 * CodeIgniter Path Helpers
 *
 * @package		Zrixter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Helven
 * @link		
 */

 

// ------------------------------------------------------------------------

/**
 * Set Sql Limit
 *
 * Returns sql limit from given array
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_limit'))
{
	function set_limit($a_Limit)
	{
		$limit	= '';
		if($a_Limit == 'ALL' || $a_Limit[1] == -1)
		{
			$limit	= '';
		}
		elseif(!isset($a_Limit))
		{
			$limit	= "	LIMIT 0,{$config['row_per_page']}";
		}
		else
		{
			$limit	= '	LIMIT '.((isset($a_Limit[0]) && $a_Limit[0] != '')?$a_Limit[0]:0).','.((isset($a_Limit[1]) && $a_Limit[1] != '')?$a_Limit[1]:$config['row_per_page']);
		}
		
		return $limit;
	}
}

if ( ! function_exists('range_limit'))
{
	function range_limit($s_Index, $e_Index)
	{
		return "	LIMIT {$s_Index},{$e_Index}";
	}
}

// ------------------------------------------------------------------------

/**
 * Set Sql Limit
 *
 * Returns sql condition from given array
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_condition'))
{
	function set_condition($a_Cond)
	{
		if($a_Cond == '' || count($a_Cond) <= 0)
		{
			return '';
		}
		
		$cond	= set_condition_relation($a_Cond);
		
		return "\n	AND ({$cond})";
	}
	
	function set_condition_value($value)
	{
		if(is_string($value))
		{
			$value	= "'{$value}'";
		}
		elseif(is_array($value))
		{
			$value	= implode(',', $value);
		}
		
		return $value;
	}
	
	function set_condition_relation($a_Cond)
	{
		$cond	= '';
		
		if(isset($a_Cond['items']))
		{
			foreach($a_Cond['items'] as $a_Item)
			{
				if($cond != '')
				{
					$cond	.= "	{$a_Cond['relation']} ";
				}
				
				if(isset($a_Item['relation']) && $a_Item['relation'] != '')
				{
					$cond	.= "(".set_condition_relation($a_Item).")";
				}
				else
				{
					$cond	.= ($a_Item['table'] != '')?"{$a_Item['table']}.":'';
					$cond	.= "{$a_Item['field']} {$a_Item['compare']} ";
					switch(strtolower($a_Item['compare']))
					{
						case 'between':
							$cond	.= $a_Item['value'];
							break;
						default:
							$cond	.= set_condition_value($a_Item['value']);
							break;
					}
				}
			}
		}
		else
		{
			$cond	.= ($a_Cond['table'] != '')?"{$a_Cond['table']}.":'';
			$cond	.= "{$a_Cond['field']} {$a_Cond['compare']} ";
			switch(strtolower($a_Cond['compare']))
			{
				case 'between':
					$cond	.= $a_Cond['value'];
					break;
				default:
					$cond	.= set_condition_value($a_Cond['value']);
					break;
			}
		}
		
		return "{$cond}";
	}
}

/* End of file path_helper.php */
/* Location: ./application/helpers/path_helper.php */