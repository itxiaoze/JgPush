<?php
namespace Xiaoze\JgPush\Tools;
use GuzzleHttp\Client;

/**
 * http请求工具类
 * Class HTTP
 * @package Xiaoze\JgPush\Tools
 */
class HTTP
{
    protected $host = null;
    protected $api = null;
    protected $body = null;
    protected $contentType = null;
    /**
     * @var \Xiaoze\JgPush\Tools\Config
     */
    private $config;

    /**
     * 获取一个实例
     * @return HTTP
     */
    public static function getInterface(\Xiaoze\JgPush\Tools\Config $config)
    {
        return new static($config);
    }

    /**
     * HTTP 工具类构造器
     * HTTP constructor.
     * @param array $config
     */
    public function __construct(\Xiaoze\JgPush\Tools\Config $config)
    {

    }
    public function post($url,$datas)
    {
        $this -> config -> get('appid');
        $this -> config -> get('key');
        //构造所需要的参数
        $data = [
          'auth'=>
          [$this -> config -> get('appid'),$this -> config -> get('key'),'digest'],
            'headers'=>[
                'Content-Type: application/json',
                'Connection: Keep-Alive'
            ],
        ];
        //添加body体内容

        $data['body'] = $datas;
       return  (new Client())->request('POST',$url,$data);
    }

    function set_body()
    {
        //获取header
    }


//    function
    public function get()
    {

    }

    public function request()
    {

    }

}