<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            $select_user_id = mysqli_query($functions->connection(),
                "SELECT id FROM users where token = '$send_token'");
            $user_id0 = mysqli_fetch_assoc($select_user_id);
            $user_id = implode(":",$user_id0);

            $select_foods = mysqli_query($functions->connection(),
                "SELECT * FROM favorite_food where user_id = '$user_id'");
            $food_id = array();
            while ($res = mysqli_fetch_assoc($select_foods)){
                array_push($food_id,$res['food_id']);
            }
            $foods_result = [];
            foreach ($food_id as $value){

                $rate_num = 0.0;
                $select_foods = mysqli_query($functions->connection(),
                    "SELECT * FROM foods where id = '$value'");

                while ($select_result1 = mysqli_fetch_assoc($select_foods)){


                    $select_rate = mysqli_query($functions->connection(),
                        "SELECT * FROM Rate where food_id = '$value'");


                    if (mysqli_num_rows($select_rate) != 0){
                        $rate_res_num = mysqli_num_rows($select_rate);

                        while ($rate_res = mysqli_fetch_assoc($select_rate)){
                            $rate_num = $rate_num+$rate_res['rate'];
                        }

                        $rate_num = $rate_num/$rate_res_num;
                    }else{
                        $rate_num = 1.1;
                    }

                    $select_fav_stat = mysqli_query($functions->connection(),
                        "SELECT * FROM favorite_food where food_id = '$value' AND user_id = '$user_id'");
                    if (mysqli_num_rows($select_fav_stat)==1){
                        $fav_stat = '1';
                    }else{
                        $fav_stat = '0';
                    }
                    array_push($foods_result,
                        array(
                        'id'=>$select_result1['id'],
                        'Food_name'=>$select_result1['name'],
                        'cat_id'=>$select_result1['cat_id'],
                        'sub_cat_id'=>$select_result1['sub_cat_id'],
                        'price'=>$select_result1['price'],
                        'Rate'=>$rate_num,
                        'Fav'=>$fav_stat,
                        'pic'=>$select_result1['pic'],
                        'recipe'=>$select_result1['recipe'],
                        'recommened'=>$select_result1['recomended'],
                    ));
                }
            }
            if (!empty($foods_result) && isset($foods_result)) {
                $data = array("Erorr" => false, "result" => $foods_result);
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