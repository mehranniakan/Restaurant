<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Comment_id']) &&
                !empty($_POST['Comment_id']) &&
                isset($_POST['user_id']) &&
                !empty($_POST['user_id'])){

                $cm_id = $functions->real_escape($_POST['Comment_id']);
                $user_id = $functions->real_escape($_POST['user_id']);

                $check_cm_id = mysqli_query($functions->connection(),
                    "SELECT * FROM comment_food where id = '$cm_id'");

                if (mysqli_num_rows($check_cm_id)==1){

                    $delete_cm = mysqli_query($functions->connection(),
                        "DELETE FROM comment_food where id = '$cm_id'");

                    $delete_cm_rep = mysqli_query($functions->connection(),
                        "DELETE FROM Reply_comment where Comment_id = '$cm_id' AND user_id = '$user_id'");

                    if ($delete_cm && $delete_cm_rep){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"کامنت مورد نظر با موفقیت حذف شد !"));
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