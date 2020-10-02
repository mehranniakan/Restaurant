<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            $select_cat = mysqli_query($functions->connection(),
                "SELECT * FROM food_category");

            while ($select_result = mysqli_fetch_assoc($select_cat)){
                $arr[] = array(
                    'id'=>$select_result['id'],
                    'cat_name'=>$select_result['name'],
                    'pic'=>$select_result['pic'],
                );
            }

            if (!empty($arr) && isset($arr)) {
                $data = array("Erorr" => false, "result" => $arr);
                echo json_encode($data);
                mysqli_close($function->connection());
                return;
            } else {
                $data = array("Erorr" => true, "result" => "موردی برای نمایش یافت نشد");
                echo json_encode($data);
                mysqli_close($function->connection());
                return;
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