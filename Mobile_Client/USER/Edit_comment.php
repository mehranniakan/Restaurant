<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Food_ID']) &&
                !empty($_POST['Food_ID']) &&
                isset($_POST['comment_ID']) &&
                !empty($_POST['comment_ID']) &&
                isset($_POST['new_Text']) &&
                !empty($_POST['new_Text'])){

                $food_id = $functions->real_escape($_POST['Food_ID']);
                $comment_id = $functions->real_escape($_POST['comment_ID']);
                $txt = $functions->real_escape($_POST['new_Text']);

                $select_user_id = mysqli_query($functions->connection(),
                    "SELECT id FROM users where token = '$send_token'");
                $user_id0 = mysqli_fetch_assoc($select_user_id);
                $user_id = implode(":",$user_id0);

                $check_txt_owner = mysqli_query($functions->connection(),
                    "SELECT user_id FROM comment_food where id = '$comment_id'");
                $user_id_verify = mysqli_fetch_assoc($check_txt_owner);
                $user_id_verify = implode(":",$user_id_verify);

                if ($user_id == $user_id_verify){

                    $check = mysqli_query($functions->connection(),
                        "SELECT * FROM comment_food where id = '$comment_id' AND food_id = '$food_id' AND user_id = '$user_id'");

                    if (mysqli_num_rows($check)==1){

                        $update_comment = mysqli_query($functions->connection(),
                            "UPDATE comment_food SET txt = '$txt' where id='$comment_id' AND user_id='$user_id' AND food_id = '$food_id'");

                        if ($update_comment){
                            echo json_encode(array("Erorr"=>false,"MSG"=>"نظر شما با موفقیت ویرایش شد"));
                            mysqli_close($functions->connection());
                            return;
                        }else{
                            echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                            mysqli_close($functions->connection());
                            return;
                        }
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($functions->connection());
                        return;
                    }
                }else{

                }
            }else{

            }
        }else{

        }
    }else{

    }
}else{

}