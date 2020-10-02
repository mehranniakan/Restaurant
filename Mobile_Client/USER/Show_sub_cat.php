<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['cat_id']) &&
                !empty($_POST['cat_id'])){

                $cat_id = $functions->real_escape($_POST['cat_id']);
                $select_sub = mysqli_query($functions->connection(),
                    "SELECT * FROM subcat_food where cat_id = '$cat_id'");

                while ($select_result = mysqli_fetch_assoc($select_sub)){
                    $arr[] = array(
                        'id'=>$select_result['id'],
                        'subcat_name'=>$select_result['name'],
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