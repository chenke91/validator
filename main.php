<?php
require '../mmgs_gs_my_99_com/lib/input.cls.php';
require './verify.php';
class validator {
    protected static $error=array();   //错误消息 code,msg,field
    protected static $data;    //验证后的数据

    /**
    * 数据验证配置
    * @example
    * $data_config = array(
    *    'msg' => array(array('required', '请输入msg！'),
    *           array('len', 'min'=>10, 'max'=>'60', 'msg'=>'消息长度为10-60个字符!')),
    */
    protected static $data_config = array();

    public function __construct($data='') {
        self::$data = $data;
        if (empty(self::$data)) {
            $data = $_POST;
        }
    }

    //添加验证
    public function add() {
        if (func_num_args() < 2) {
            throw new Exception("require at least 2 argument");
        }
        $args = func_get_args();
        self::parse_args($args);
    }
    //验证数据
    public function validate() {
        foreach (self::$data_config as $field=>$items) {
            foreach($items as $config) {
                if (!self::dovalidate($field, $config)) {
                    return false;
                }
            }
        }
        return true;
    }

    //获取失败信息
    public function get_error() {
        return self::$error;
    }

    public function get_data() {
        return input::_secure_filter(self::$data);
    }

    public function get($key, $default=null) {
        return isset(self::$data[$key]) ? input::_secure_filter(self::$data[$key]) : $default;
    }

    //解析参数
    protected static function parse_args($args) {
        $key = $args[0];
        self::$data_config[$key] = array();
        $args_len = count($args);
        for ($i=1; $i <$args_len; $i++) {
            $data = array();
            $items = explode(',', $args[$i]);
            foreach ($items as $item) {
                $kw = explode(':', $item, 2);
                if (count($kw) == 2) {
                    $data[trim($kw[0])] = trim($kw[1]);
                } else {
                    $data[] = trim($kw[0]);
                }
            }
            self::$data_config[$key][] = $data;
        }
    }

    //验证参数
    protected static function dovalidate($field, $config) {
        $func = $config[0];
        unset($config[0]);
        array_unshift($config, $field, self::$data);
        if (method_exists('verify', $func)) {
            try {
                $flag = call_user_func_array('verify::'.$func, $config);
            } catch (ValidateException $e) {
                $msg = $e->getMessage();
                $code = $e->getCode();
                if (empty($msg)) {
                    $msg = "field {$field} unvalid";
                }
                self::$error = array('code'=>$code, 'msg'=>$msg, 'field'=>$field);
                return false;
            }
        } else if(function_exists($func)) {
            try {
                $flag = call_user_func_array($func, $config);
            } catch (ValidateException $e) {
                $msg = $e->getMessage();
                $code = $e->getCode();
                if (empty($msg)) {
                    $msg = "field {$field} unvalid";
                }
                self::$error = array('code'=>$code, 'msg'=>$msg, 'field'=>$field);
                return false;
            }
        } else {
            throw new Exception("no such verify function", 2);
        }
        return true;
    }
}


$t = microtime_float();
$test = array('msg' => 'hel"lo', 'age'=>'50', 'ip'=>'192.168.19.215');

$validator = new validator($test);
$validator->add('msg', 'len,1,20,消息长度为1-20个字符');
$validator->add('ip', 'required, 请输入ip','ip, ip地址格式不正确');
$validator->add('age', 'num,,,请输入年龄');
if ($validator->validate()) {
    print_r($validator->get_data());
} else {
    $error = $validator->get_error();
    print_r($error);
}