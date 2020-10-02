<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Comment_ID']) &&
                !empty($_POST['Comment_ID']) &&
                isset($_POST['User_ID']) &&
                !empty($_POST['User_ID']) &&
                isset($_POST['Rep_txt']) &&
                !empty($_POST['Rep_txt']) &&
                isset($_POST['Food_ID']) &&
                !empty($_POST['Food_ID'])){

                $comment_id = $functions->real_escape($_POST['Comment_ID']);
                $food_id = $functions->real_escape($_POST['Food_ID']);
                $user_id = $functions->real_escape($_POST['User_ID']);
                $txt = $functions->real_escape($_POST['Rep_txt']);

                $check_comment = mysqli_query($functions->connection(),
                    "SELECT * FROM comment_food where id = '$comment_id' AND user_id = '$user_id' AND food_id = '$food_id'");

                if (mysqli_num_rows($check_comment)==1){

                    $id = $functions->id_gen();
                    $reg_date = $functions->date_gen();
                    $reg_time = $functions->time_gen();

                    $insert_reply = mysqli_query($functions->connection(),
                        "INSERT INTO Reply_comment (id, Comment_id ,user_id, food_id, reply_txt, reg_date, reg_time) VALUES ('$id','$comment_id','$user_id','$food_id','$txt','$reg_date','$reg_time')");
                    if ($insert_reply){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"جواب مورد نظر با موفقیت ثبت شد !"));
                        mysqli_close($function->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($function->connection());
                        return;
                    }
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"این کامنت دیگر وجود ندارد !"));
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