<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['FOOD_NAME']) &&
                !empty($_POST['FOOD_NAME']) &&
                isset($_POST['Cat_id']) &&
                !empty($_POST['Cat_id']) &&
                isset($_POST['sub_Cat_id']) &&
                !empty($_POST['sub_Cat_id'])){

                $food_name = $functions->real_escape($_POST['FOOD_NAME']);
                $cat_id = $functions->real_escape($_POST['Cat_id']);
                $sub_cat_id = $functions->real_escape($_POST['sub_Cat_id']);

                $select_by_name = mysqli_query($functions->connection(),
                    "SELECT * FROM foods where name LIKE '%$food_name%' AND cat_id = '$cat_id' AND sub_cat_id = '$sub_cat_id'");

                if (mysqli_num_rows($select_by_name)==0){

                    $data = array("Erorr" => true, "result" => "موردی برای نمایش یافت نشد");
                    echo json_encode($data);
                    mysqli_close($function->connection());
                    return;

                }else{
                    $rate_num = 0.0;

                    $select_user_id = mysqli_query($functions->connection(),
                        "SELECT id FROM users where token = '$send_token'");
                    $user_id0 = mysqli_fetch_assoc($select_user_id);
                    $user_id = implode(":",$user_id0);

                    while ($select_result1 = mysqli_fetch_assoc($select_by_name)){

                        $food_id = $select_result1['id'];

                        $select_rate = mysqli_query($functions->connection(),
                            "SELECT * FROM Rate where food_id = '$food_id'");


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
                            "SELECT * FROM favorite_food where food_id = '$food_id' AND user_id = '$user_id'");
                        if (mysqli_num_rows($select_fav_stat)==1){
                            $fav_stat = '1';
                        }else{
                            $fav_stat = '0';
                        }

                        $arr[] = array(
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
                }

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