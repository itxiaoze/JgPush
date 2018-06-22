# JgPush



集成了极光推送的部分实例 

统一设置数据发送ios 安卓

调用实例

Push::getInterface(new \Xiaoze\JgPush\Tools\Config($config))<br>
    ->set_title('测试') // 标题<br>
    ->set_alert('测试内容') //内容 <br>
    ->set_alias(['xxxx']) //别名 不设置默认发送所有在线用户<br>
    ->set_extras(['action'=>'order','status'=>200]) //附加数据<br>
    ->set_message()// 自定义数据<br>
    ->set_option([ 'sendno' => 100,'time_to_live' => 100,'apns_production'=>'false'])//参数设置 默认;
    
     $res = $info->push(); //推送