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
        //$token = $this->hasToken();
        session_start();
        if(isset($_SESSION['username'])){
            header("location:http://www.testb.com/index.php/success");
        }else{
            header("location:http://www.sso.com/index.php/login?url=www.testb.com");
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
            header("location:http://www.sso.com/index.php/login?url=www.testb.com");
        }
        echo $_SESSION['username']."您好  欢迎访问B服务";
        $html=<<<EOF
<br>
<a href="http://www.testa.com/index.php/logout">退出</a>
EOF;
        echo $html;
    }
}