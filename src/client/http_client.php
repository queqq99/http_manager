<?php
namespace queqq99\http_manager\client;
use queqq99\http_manager\client\lib\lib1;
class http_client
{
	function __construct()
	{
	}
	function getData()
	{
		$lib1 = new lib1;
		$data = $lib1->getData();
		return $data;
	}
}
