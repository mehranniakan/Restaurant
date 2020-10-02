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
                !empty($_POST['Food_id'])){

                $food_id = $functions->real_escape($_POST['Food_id']);
                $select_user_id = mysqli_query($functions->connection(),
                    "SELECT id FROM users where token = '$send_token'");
                $user_id0 = mysqli_fetch_assoc($select_user_id);
                $user_id = implode(":",$user_id0);

                $checck_fav = mysqli_query($functions->connection(),
                    "SELECT * FROM favorite_food where food_id = '$food_id' AND user_id = '$user_id'");

                if (mysqli_num_rows($checck_fav)==0){

                    $id = $functions->id_gen();
                    $date = $functions->date_gen();
                    $time = $functions->time_gen();

                    $insert_food = mysqli_query($functions->connection(),
                        "INSERT INTO favorite_food (id, food_id, user_id, reg_date, reg_time) VALUES ('$id','$food_id','$user_id','$date','$time')");
                    if ($insert_food){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"غذای مورد نظر با موفقیت به علاقه مندی ها اضافه شد"));
                        mysqli_close($functions->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($functions->connection());
                        return;
                    }
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"این غذا هم اکنون در لیست علاقه مندی شما وجود دارد"));
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