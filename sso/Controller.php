<?php
class Controller {

    public $url = null;
    public function index(){

        $user = array(
            "Alice" => '123456',
            'Shayne' => '456789',
        );
        $fp = fopen('User.txt','w');
        fwrite($fp,json_encode($user));
        fclose($fp);
    }

    public function login(){

        session_start();
        //还需要判断重定向过来的有没有携带sso.com的sessionid
        if(isset($_SESSION['username'])){
            header("location:http://".$this->url.'/index.php/success?token='.session_id());
        }
        if(isset($_POST['username'])){
            $connec = mysqli_connect('localhost','root','qq864636252','sso',3306);
            $sql = "select * from user where username = '".$_POST['username']."'";
            $user = mysqli_query($connec,$sql);
            //$user = mysqli_fetch_array($user);
            if($user){
                $user = mysqli_fetch_row($user);
                if($user[2] ==$_POST['password']){
                    session_start();
                    $sessionid = session_id();
                    $_SESSION['username'] = $user[1];
                    header("location:http://".$this->url.'/index.php/success?token='.$sessionid);
                }else{
                    echo "密码不正确";
                }
            }else{
                echo "用户不存在";
            }
        }else{
            header("Content-type: text/html; charset=uft8");
            include __DIR__.'\\'.'view\index.html';
        }
    }

    public function vaild($token){

        $fp = fopen('Token.txt','a+');
        $tokenArray = json_decode(fread($fp,filesize('Token.txt')),1);
        if($tokenArray[0] == $token){
            $array= array('status' => 'ok');
            $response = json_encode($array);
            echo  ('{"status":"ok"}');
        }else{
            echo json_encode(array('status' => 'error'));
        }
    }
}