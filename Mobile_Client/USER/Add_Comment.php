<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Food_id']) &&
                !empty($_POST['Food_id']) &&
                isset($_POST['Comment_txt']) &&
                !empty($_POST['Comment_txt'])){

                $food_id = $functions->real_escape($_POST['Food_id']);
                $txt = $functions->real_escape($_POST['Comment_txt']);

                $select_user_id = mysqli_query($functions->connection(),
                    "SELECT id FROM users where token = '$send_token'");
                $user_id0 = mysqli_fetch_assoc($select_user_id);
                $user_id = implode(":",$user_id0);

                $id = $functions->id_gen();
                $date = $functions->date_gen();
                $time = $functions->time_gen();

                $insert_comment = mysqli_query($functions->connection(),
                    "INSERT INTO comment_food (id, food_id, txt, user_id, seen,reg_date, reg_time) VALUES ('$id','$food_id','$txt','$user_id','0','$date','$time')");
                if ($insert_comment){
                    echo json_encode(array("Erorr"=>false,"MSG"=>"نظر شما با موفقیت ثبت شد"));
                    mysqli_close($functions->connection());
                    return;
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                    mysqli_close($functions->connection());
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