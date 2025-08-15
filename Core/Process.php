<?php

$accepted_hosts = array('localhost','127.0.0.1');
$accepted_method = 'POST';
$correct_user = "Admin";
$correct_pass = "Admin";

$txt_user = ( (isset($_POST["txt_user"])) ? $_POST["txt_user"] : null);
$txt_pass = ( (isset($_POST["txt_pass"])) ? $_POST["txt_pass"]: null);

$token = "";

if(in_array($_SERVER["HTTP_HOST"], $accepted_hosts))
{
    if($_SERVER["REQUEST_METHOD"]== $accepted_method)
    {
        if(isset($txt_user) && !empty($txt_empty))
        {
            if(isset($txt_pass) && !empty($txt_pass))
            {
                if($txt_user==$correct_user)
                {
                    if($txt_pass==$correct_pass)
                    {
                        $route = "welcome.php";
                        $msg = "";
                        $state_code = 200;
                        $state_text = "OK";
                        list($usec,$sec) = explode(' ', microtime());
                        $token = base64_encode(date("Y-m-d H:i:s", $sec).substr($usec,1));

                    }
                    else
                    {
                        //valor de password incorrecto
                        $route = "";
                        $msg = "INCORRECT PASSWORD";
                        $state_code = 401;
                        $state_text = "UNAUTHORIZED";
                        $token = "";
                    }

                }
                else
                {
                    //valor de usuario incorrecto
                    $route = "";
                        $msg = "UNKNOWN USER";
                        $state_code = 401;
                        $state_text = "UNAUTHORIZED";
                        $token = "";
                    
                }
            }
            else
            {
                //password vacio
                $route = "";
                $msg = "EMPTY PASSWORD";
                $state_code = 401;
                $state_text = "UNAUTHORIZED";
                $token = "";
            }

        }
        else
        {
            //password vacio
            $route = "";
            $msg = "EMPTY USER";
            $state_code = 401;
            $state_text = "UNAUTHORIZED";
            $token = "";

        }
    }
    else
    {
        //password vacio
        $route = "";
        $msg = "METODO NOT ALLOWED";
        $state_code = 405;
        $state_text = "METHOD NOT ALLOWED";
        $token = "";
    }

}
else
{
    //password vacio
    $route = "";
    $msg = "DEVICE UNAUTHORIZED TO COMPLETE REQUEST";
    $state_code = 403;
    $state_text = "FORBIDDEN";
    $token = "";

}

$response_array = array(
    "status" => ((intval($state_code)==200) ? "OK":"ERROR"  ),
    "error" => ((intval($state_code)==200) ? "":array("code"=>$state_code,"message"=>$msg)),
    "data" => array(
        "url" => $route,
        "token" => $token
    ),
    "count" => 1
);

header("HTTP/1.1".$state_code." ".$state_text);
header("Content-Type: Application/json");
echo(json_encode($response_array));

