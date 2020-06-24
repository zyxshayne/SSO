<?php
class Controller {

    protected function hasToken(){
        $header = array_change_key_case(apache_request_headers());
        if(isset($header['authorization'])){
            return $header['authorization'];
        }
        return false;
    }

    public function index(){
//        echo 111;exit;
        session_start();
        if(isset($_SESSION['username'])){
            header("location:http://www.testa.com/index.php/success");
        }else{
            header("location:http://www.sso.com/index.php/login?url=www.testa.com");
        }
    }

    public function success(){

        $query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
        if($query){
            $query = explode('=',$query);
            session_id($query[1]);
            session_start();

        }
        if(!isset($_SESSION['username'])){
            header("location:http://www.sso.com/index.php/login?url=www.testa.com");
        }
        echo $_SESSION['username']."您好  欢迎访问A";
        $html=<<<EOF
<br>
<a href="http://www.testa.com/index.php/logout">退出</a>
EOF;
echo $html;
    }

    public function logout(){
        session_start();
        $_SERVER = array();
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(),'',time()-1,'/');
        }
        session_destroy();
        echo "成功退出";
        //header("location:http://www.testa.com/index.php/index");
    }
}