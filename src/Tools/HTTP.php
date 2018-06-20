<?php
namespace Xiaoze\JgPush\Tools;
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
    public function post($uri,$data)
    {
        $this -> config -> get('appid');
        $this -> config -> get('key');
    }
    public function get()
    {

    }

    public function request()
    {

    }

}