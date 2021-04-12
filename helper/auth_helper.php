<?php
function check_auth()
{
	return isset($_SESSION['ss_Public']);
}