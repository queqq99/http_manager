<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, 'vendor/autoload.php'));
use queqq99\http_manager\client\http_client;

class request_http_post_test
{
    //テスト対象オブジェクト
    private $http_client = null;
    //テスト対象オブジェクトプロパティリスト
    private $reflection_property_list = [];


    function __construct()
    {
        echo 'START_TEST'.PHP_EOL;

        $this->http_client = new http_client();
/*
        $reflection_class = new Reflectionclass($this->http_client);
        $reflection_property_list = $reflection_class->getProperties();
 */
        $this->reflection_property_list = [];

        foreach((new Reflectionclass($this->http_client))->getProperties() as $key => $reflection_property)
        {
            $reflection_property->setAccessible(true);
            $this->reflection_property_list[$reflection_property->getName()] = $reflection_property;
/*
            $this->reflection_property_list[$reflection_property-.\>] =
            $this->reflection_property_list[$key]->setAccessible(true);
            print_r($this->reflection_property_list[$key]->getValue($this->http_client));
            print_r($this->reflection_property_list[$key]->getName().PHP_EOL);
 */
        }
    }

    /*
     * 正常系テスト
     * ヘッダー、POST値を設定
     * ヘッダー、POST値を設定
     */
    function requestHttpPostTest()
    {
        $this->reflection_property_list['header_list']->setValue($this->http_client, ['1111', '22222', 'test' => 'hedaer']);
        foreach($this->reflection_property_list as $key => $reflection_property_list)
        {
            var_dump($reflection_property_list->getValue($this->http_client));
        }
        //POST値設定


    }
}

$request_http_post_test = new request_http_post_test();
$request_http_post_test->requestHttpPostTest();
