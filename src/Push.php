<?php
namespace Xiaoze\JgPush;
use Xiaoze\JgPush\Tools\Config;
use Xiaoze\JgPush\Tools\HTTP;

/**
 * 推送
 * Class Push
 * @package Xiaoze\JgPush
 */
class Push
{
    /**
     * 接口地址
     * @var string
     */
    protected $api = 'https://api.jpush.cn/v3/push';

    /**
     * 推送平台
     */
    private $platform = 'all';
    /**
     * 别名
     */
    protected $alias = [];
    /**
     * 附加数据
     */
    private $extras = [];
    /**
     * 标题
     */
    private $title = null;
    /**
     * 内容
     */
    private $content = null;

    /**
     * 配置实例
     * @var \Xiaoze\JgPush\Tools\Config
     */
    private $config;
    /**
     * 获取一个实例
     * @return Push
     */
    public static function getInterface(\Xiaoze\JgPush\Tools\Config $config)
    {
        return new static($config);
    }

    /**
     * 构造器
     * Push constructor.
     * @param Config $config
     */
    function __construct(\Xiaoze\JgPush\Tools\Config $config)
    {
        $this -> config = $config;
    }

    /**
     * 设置推送的标题
     * @param $title
     * @return $this
     */
    function set_title($title)
    {
        $this -> title = $title;
        return $this;
    }

    /**
     * 推送
     */
    function push()
    {



        HTTP::getInterface($this -> config) -> post($this -> api,[]);
    }



}