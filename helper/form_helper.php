<?php
function set_value($field, $default='')
{
	return (isset($_POST[$field]) && $_POST[$field] != '')?$_POST[$field]:$default;
}