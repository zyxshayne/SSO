<?php

class Session{

    public static $redis = NULL;
    public static $conf = NULL;
    public function __construct($conf= array("HOST" => '127.0.0.1',"PORT" => '6379'))
    {
        self::$conf = $conf;
        //session_module_name('user');
        //session_set_save_handler("sessionBegin","sessionEnd","sessionWrite","sessionRead","sessionDelete","sessionGc");
        session_set_save_handler(
            array("Session", "sessionBegin"),
            array("Session", "sessionEnd"),
            array("Session", "sessionRead"),
            array("Session", "sessionWrite"),
            array("Session", "sessionDelete"),
            array("Session", "sessionGc")
        );
        register_shutdown_function('session_write_close');
    }


    public static function sessionBegin(){

        if(self::$conf== NULL){
            throw new Exception("session profile  is error");
        }
        try{
            self::$redis = new Redis();
            self::$redis->connect(self::$conf['HOST'],self::$conf['PORT']);
        }catch (Exception $exception){
            throw $exception;
        }

    }

    static public function sessionWrite($session_id,$content){


        $key = $session_id;
        if(!self::$redis->exists($key)){

            self::$redis->hset($key,'last_time',time());
        }else{

            self::$redis->hMset($key,array('last_time'=>time(),'data'=>$content));
        }
        return true;

    }

    public static function sessionRead($session_id){

        $key = $session_id;
        //读取当前sessionid下的data数据
        $res =  self::$redis->hGet($key,'data');
        //读取完成以后 更新时间，说明已经操作过session
        self::$redis->hSet($key,'last_time',time());
        return $res;
    }

    public static function sessionGc(){

    }


    public static function sessionDelete($session_id){
//        self::$redis->hDel($session_id);
        self::$redis->Del($session_id);

    }
    public static function sessionEnd(){

    }
}