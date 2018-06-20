<?php
namespace Xiaoze\JgPush\Tools;

class Config
{
    private $config = [];
    function __construct($config)
    {
        $this -> config = $config;
    }
    function get($name)
    {
        return isset($this -> config[$name])?$this -> config[$name]:null;
    }
}