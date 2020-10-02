<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST["User-Name"]) &&
        !empty($_POST["User-Name"]) &&
        isset($_POST["Pass-Word"]) &&
        !empty($_POST["Pass-Word"])){

        $username = $functions->real_escape($_POST["User-Name"]);
        $password = $functions->hashing($_POST["Pass-Word"]);

        $check_users = mysqli_query($functions->connection(),
            "SELECT * FROM users where username = '$username' AND  password = '$password'");

        if (mysqli_num_rows($check_users)==1){

            $token = bin2hex(openssl_random_pseudo_bytes(64));
            $update_token = mysqli_query($functions->connection(),
                "UPDATE users Set token = '$token' where username = '$username'");

            if ($update_token){
                $select_res = mysqli_fetch_assoc($check_users);
                $full_name = $select_res['name'];
                echo json_encode(array("Erorr"=>false,
                    "MSG"=>"ورود شما با موفقیت انجام شد",
                    "Full_name"=>$full_name,
                    "token"=>$token,
                    "Login"=>true));
                mysqli_close($functions->connection());
                return;

            }else{
                echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                mysqli_close($functions->connection());
                return;
            }
        }else{
            echo json_encode(array("Erorr"=>true,"MSG"=>"نام کاربری یا کلمه عبور اشتباه است"));
            mysqli_close($functions->connection());
            return;
        }
    }else{

    }

}else{

}