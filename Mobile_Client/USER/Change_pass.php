<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['New_Pass']) &&
                !empty($_POST['New_Pass'])){

                $pass = $functions->hashing($_POST['New_Pass']);

                $change_pass = mysqli_query($functions->connection(),
                    "UPDATE users Set password = '$pass' where token = '$send_token'");
                if ($change_pass){
                    echo json_encode(array("Erorr"=>false,"MSG"=>"پسورد شما با موفقیت تغییر یافت !"));
                    mysqli_close($function->connection());
                    return;
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                    mysqli_close($function->connection());
                    return;
                }
            }else{

            }
        }else{
            echo json_encode(array("Erorr"=>true,"MSG"=>"لطفا مجددا وارد شوید !","Login"=>false));
            mysqli_close($functions->connection());
            return;
        }
    }else{

    }
}else{

}