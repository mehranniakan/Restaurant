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
                isset($_POST['Food_Rate']) &&
                !empty($_POST['Food_Rate'])){

                $food_id = $functions->real_escape($_POST['Food_ID']);
                $food_rate = $functions->real_escape($_POST['Food_Rate']);

                $select_user_id = mysqli_query($functions->connection(),
                    "SELECT id FROM users where token = '$send_token'");
                $user_id0 = mysqli_fetch_assoc($select_user_id);
                $user_id = implode(":",$user_id0);

                $check_last_rate = mysqli_query($functions->connection(),
                    "SELECT * FROM Rate where user_id = '$user_id' AND food_id = '$food_id'");

                if (mysqli_num_rows($check_last_rate)==1){

                    $update_last_rate = mysqli_query($functions->connection(),
                        "UPDATE Rate SET rate = '$food_rate' where food_id = '$food_id' AND  user_id = '$user_id'");

                    if ($update_last_rate){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"ارزشیابی شما با موفقیت ثبت شد"));
                        mysqli_close($functions->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($functions->connection());
                        return;
                    }
                }else{
                    $id = $functions->id_gen();
                    $date = $functions->date_gen();
                    $time = $functions->time_gen();

                    $insert_fodd_rate = mysqli_query($functions->connection(),
                        "INSERT INTO Rate (id, food_id, user_id, rate, reg_time, reg_date) VALUES ('$id','$food_id','$user_id','$food_rate','$time','$date')");
                    if ($insert_fodd_rate){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"ارزشیابی شما با موفقیت ثبت شد"));
                        mysqli_close($functions->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($functions->connection());
                        return;
                    }
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