<?php
class verify {
    public static function required($field, $form, $msg='') {
        if (empty($form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function len($field, $form, $min=0, $max=0, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (is_numeric($min) && strlen($form[$field]) < $min) {
            throw new ValidateException($msg, 1);
        }
        if (is_numeric($max) && strlen($form[$field])>$max) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function email($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[\w\.\-]{2,}@([\w\.\-]{2,}){1,}\.(me|info|com|net|org|cn)$/i', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function equalto($field, $form, $tofield, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!isset($form[$tofield])) {
            throw new Exception("请输入正确的字段", 1);
        }
        if ($form[$field] != $form[$tofield]) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function ip($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/i', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function num($field, $form, $min, $max, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!is_numeric($form[$field])) {
            throw new ValidateException($msg, 1);
        }
        if (is_numeric($min) && $form[$field] < $min) {
            throw new ValidateException($msg, 1);
        }
        if (is_numeric($max) && $form[$field] > $max) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function regex($field, $form, $pattern, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match($pattern, $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public  static function url($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^http[s]?:\/\/.*$/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public  static function qq($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[1-9]{1}[0-9]{5,18}$/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function pwd($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[^\s]{6,16}$/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public static function tel($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[0-9]{3,4}[\-]?[0-9]{7,8}$/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }
    
    public static function mobile($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[+86]?1[354678][0-9]{9}$/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }
    
    public static function domain($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[\w\.]{2,}\.(com|cn|net|me|hk|info|dev)$/i', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }
    
    public static function date($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[0-9]{4}[\-\/]?[0-9]{1,2}[\-\/]?[0-9]{1,2}/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public  static function ukey($field, $form, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        if (!preg_match('/^[0-9]{1,}\-[0-9]{1,}\-[0-9]{1,}\-[0-9]{1,}$/', $form[$field])) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public  static function anyof($field, $form, $value, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        $value = explode('|', $value);
        if (!in_array($form[$field], $value)) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }

    public  static function noneof($field, $form, $value, $msg='') {
        if (empty($form[$field])) {
            return true;
        }
        $value = explode('|', $value);
        if (in_array($form[$field], $value)) {
            throw new ValidateException($msg, 1);
        }
        return true;
    }
}

class ValidateException extends Exception {
    public function __construct($message, $code=0) {
        parent::__construct($message, $code);
    }
}
