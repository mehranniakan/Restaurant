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
                !empty($_POST['Comment_id'])){

               $cm_id = $functions->real_escape($_POST['Comment_id']);

               $Update_cm = mysqli_query($functions->connection(),
                   "UPDATE comment_food SET seen='1' where id = '$cm_id'");
               if ($Update_cm){
                   echo json_encode(array("Erorr"=>false));
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