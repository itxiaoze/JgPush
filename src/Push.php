<?php
namespace Xiaoze\JgPush;
use Xiaoze\JgPush\Tools\Config;
use Xiaoze\JgPush\Tools\HTTP;

/**
 * 极光推送
 * Class Push
 * @package Xiaoze\JgPush
 */
class Push
{
    /**
     * 接口地址
     * @var string
     */
    protected $api = 'https://bjapi.push.jiguang.cn/v3/push';

    /**
     * 推送平台
     */
    private $platform = 'all';
    /**
     * 别名
     */
    protected $alias;
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
    private $alert = null;

    /**
     * 消息体
     */

    private $message;

    /**
     * 推送目标
     * @var string
     */
    private $audience = 'all';

    /**
     * 配置实例
     * @var \Xiaoze\JgPush\Tools\Config
     */
    private $config;

    /**
     * 设置安卓发送内容
     */

    private $Androidbody;

    /**
     * 设置苹果发送内容
     * @var
     */
    private $iOSbody;

    /**
     * 设置winphoen发送内容
     * @var
     */
    private $Windowsbody;

    /**
     *
     * cid
     */

    private $cid;

    /**
     *
     * @var
     */
    private $options;

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
        return $this;
    }

    function set_option($options)
    {
        $this -> options = $options;
        return $this;
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

    function set_message($message)
    {
        $this->message = $message;
        return $this;
    }
    /**
     * 设置推送平台
     * @param $platform
     * @return $this
     */
    function set_platform($platform)
    {
        $this -> platform = $platform;
        return $this;
    }

    /**
     * 设置 别名
     * @param $alias
     * @return $this
     */
    function set_alias($alias)
    {
        $this -> alias = $alias;
        return $this;
    }




    /**
     * 设置附加数据
     * @param $extras
     * @return $this
     */
    function set_extras($extras)
    {
        $this -> extras = $extras;
        return $this;
    }

    /**
     * 设置内容
     * @param $content
     * @return $this
     */
    function set_alert($alert)
    {
        $this -> alert = $alert;
        return $this;
    }

    /**
     * 推送
     */
    function push()
    {

        return HTTP::getInterface($this -> config) -> post($this -> api,$this->build());
    }


    /**
     * 设置安卓发送内容
     * @param string $alert
     * @param array $notification
     * @return $this
     */
    function set_Androidbody()
    {
        $android = [];
       if(isset($this -> title) && !empty($this -> title))
       {
           $android['title'] = $this->title;
       }
       if(isset($this->alert) && !empty($this->alert))
       {
           $android['alert'] = $this->alert;
       }
       if(isset($this -> extras) && !empty($this -> extras))
       {
           $android['extras'] = $this->extras;
       }
        $this -> Androidbody = $android;
        return $this;

    }


    function set_iOSbody()
    {
        $ios = array();
        $ios['alert'] = (is_string($this->alert) || is_array($this -> alert)) ? $this -> alert : '';

        if(isset($this->extras) && !empty($this->extras))
        {
            $ios['extras'] = $this->extras;
        }
        if (!isset($ios['sound'])) {
            $ios['sound'] = '';
        }
        if (!array_key_exists('badge', $ios)) {
            $ios['badge'] = '+1';
        }
        $this -> iOSbody = $ios;
        return $this;
    }

    /**
     * 设置windowsphone
     * @param $msg_content
     * @param array $msg
     * @return $this
     */
    function  set_Windowsbody()
    {

            $message = array();
           # $message['msg_content'] = isset($this -> alert)?$this->alert:'';
           if(isset($this->title) && !empty($this->title))
           {
            $message['title'] = $this->title;
           }
           if(isset($this->extras) && !empty($this->extras))
           {
               $message['extras'] = $this->extras;
           }
           if(isset($this->alert) && !empty($this->alert))
           {
               $message['alert'] = $this->alert;
           }
            $this->Windowsbody = $message;

        return $this;
    }


    public function setCid() {
        $this->cid = date('YmdHis') . random(6, true);
        return $this;
    }
    /**
     * 数据内容构造器
     * @return array
     */
    public function build() {



        $payload = array();
        // validate platform
        if (is_null($this->platform)) {
            throw new InvalidArgumentException("platform must be set");
        }
        $payload["platform"] = $this->platform;

        if (!is_null($this->cid)) {
            $payload['cid'] = $this->cid;
        }

        if($this->platform=='all')
        {
            $this->set_Windowsbody();
            $this->set_iOSbody();
            $this->set_Androidbody();
        }
        // validate audience
        $audience = array();

        if (!is_null($this->alias)) {
            $audience["alias"] = $this->alias;
        }
        if (is_null($this->audience) && count($audience) <= 0) {
            throw new \Exception("audience must be set");
        } else if (!is_null($this->audience) && count($audience) > 0) {
            throw new \Exception("you can't add tags/alias/registration_id/tag_and when audience='all'");
        } else if (is_null($this->audience)) {
            $payload["audience"] = $audience;
        } else {
            $payload["audience"] = $this->audience;
        }


        // validate notification
        $notification = array();

        if (!is_null($this -> alert)) {
            $notification['alert'] = $this -> alert;
        }

        if (!is_null($this->Androidbody)) {
            $notification['android'] = $this->Androidbody;
            if (is_null($this->Androidbody['alert'])) {
                if (is_null($this->alert)) {
                    throw new InvalidArgumentException("Android alert can not be null");
                } else {
                    $notification['android']['alert'] = $this->alert;
                }
            }
        }

        if (!is_null($this->iOSbody)) {
            $notification['ios'] = $this->iOSbody;
            if (is_null($this->iOSbody['alert'])) {
                if (is_null($this->alert)) {
                    throw new InvalidArgumentException("iOS alert can not be null");
                } else {
                    $notification['ios']['alert'] = $this->alert;
                }
            }
        }

        if (!is_null($this->Windowsbody)) {
            $notification['winphone'] = $this->Windowsbody;
            if (is_null($this->Windowsbody['alert'])) {
                if (is_null($this->Windowsbody)) {
                    throw new InvalidArgumentException("WinPhone alert can not be null");
                } else {
                    $notification['winphone']['alert'] = $this->alert;
                }
            }
        }

        if (count($notification) > 0) {
            $payload['notification'] = $notification;
        }

        if (!is_null($this->message)) {
            $payload['message'] = $this->message;
        }
        if (!array_key_exists('notification', $payload) && !array_key_exists('message', $payload)) {
            throw new InvalidArgumentException('notification and message can not all be null');
        }

        if (is_null($this->options)) {
            throw new InvalidArgumentException('options  can not all be null');
        }

        $payload['options'] = $this->options;
        return $payload;
    }




}