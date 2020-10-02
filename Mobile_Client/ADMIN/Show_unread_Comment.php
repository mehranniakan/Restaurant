<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['OFFset'])){

                $offset = $functions->real_escape($_POST['OFFset']);
                $show_cm = mysqli_query($functions->connection(),
                    "SELECT * FROM comment_food where seen = '0' LIMIT 20 offset $offset");
                $show_tottal_cm = mysqli_query($functions->connection(),
                    "SELECT * FROM comment_food where seen = '0'");

                $cm_num = mysqli_num_rows($show_tottal_cm);

                while ($result = mysqli_fetch_assoc($show_cm)){

                    $food_id = $result['food_id'];
                    $usr_id = $result['user_id'];
                    $select_username = mysqli_query($functions->connection(),
                        "SELECT name FROM users where id = '$usr_id'");
                    $user_name = mysqli_fetch_assoc($select_username);
                    $user_name = implode(":",$user_name);

                    $food_detail = mysqli_query($functions->connection(),
                        "SELECT * FROM foods where id = '$food_id'");

                    while ($result1 = mysqli_fetch_assoc($food_detail)){
                        $cat_id = $result1['cat_id'];
                        $sub_cat_id = $result1['sub_cat_id'];
                        $food_name = $result1['name'];
                    }

                    $arr[] = array(
                        'id'=>$result['id'],
                        'user_name'=>$user_name,
                        'text'=>$result['txt'],
                        'food_name'=>$food_name,
                        'food_id'=>$food_id,
                        'cat_id'=>$cat_id,
                        'sub_cat_id'=>$sub_cat_id,
                    );
                }
                if (!empty($arr) && isset($arr)) {
                    $data = array("Erorr" => false, "result" => $arr, "tottal_cm"=>$cm_num);
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