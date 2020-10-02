<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Food_Id']) &&
                !empty($_POST['Food_Id']) &&
                isset($_POST['Quantity'])){

                $food_id = $functions->real_escape($_POST['Food_Id']);
                $quantity = $functions->real_escape($_POST['Quantity']);

                $select_user_id = mysqli_query($functions->connection(),
                    "SELECT id FROM users where token = '$send_token'");
                $user_id0 = mysqli_fetch_assoc($select_user_id);
                $user_id = implode(":",$user_id0);

                $check_opencart = mysqli_query($functions->connection(),
                    "SELECT * FROM cart where user_id = '$user_id' AND payment_status = '0'");

                if (mysqli_num_rows($check_opencart)==1){

                    while ($select_result = mysqli_fetch_assoc($check_opencart)){
                        $cart_id = $select_result['id'];
                    }
                    $check_food_in_cart = mysqli_query($functions->connection(),
                        "SELECT * FROM cart_content where cart_id = '$cart_id' AND food_id = '$food_id'");

                    if (mysqli_num_rows($check_food_in_cart) == 1){

                        if ($quantity=="0"){

                            $delete_food = mysqli_query($functions->connection(),
                                "DELETE FROM cart_content WHERE food_id = '$food_id'");

                            if ($delete_food){
                                echo json_encode(array("Erorr"=>false,"MSG"=>"غذای موردنظر با موفقیت از سبد شما حذف شد"));
                                mysqli_close($functions->connection());
                                return;
                            }else{
                                echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                                mysqli_close($functions->connection());
                                return;
                            }
                        }else{
                            $update_quantity = mysqli_query($functions->connection(),
                                "UPDATE cart_content SET quantitiy = '$quantity' where food_id = '$food_id' AND cart_id = '$cart_id'");

                            if ($update_quantity){
                                echo json_encode(array("Erorr"=>false,"MSG"=>"غذای موردنظر با موفقیت به سبد شما اضافه شد"));
                                mysqli_close($functions->connection());
                                return;
                            }else{
                                echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                                mysqli_close($functions->connection());
                                return;
                            }
                        }

                    }else{
                        $id = $functions->id_gen();
                        $date = $functions->date_gen();
                        $time = $functions->time_gen();

                        $insert_food = mysqli_query($functions->connection(),
                            "INSERT INTO cart_content (id, cart_id, food_id, quantitiy, reg_date, reg_time) VALUES ('$id','$cart_id','$food_id','$quantity','$date','$time')");

                        if ($insert_food){
                            echo json_encode(array("Erorr"=>false,"MSG"=>"غذای موردنظر با موفقیت به سبد شما اضافه شد"));
                            mysqli_close($functions->connection());
                            return;
                        }else{
                            echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                            mysqli_close($functions->connection());
                            return;
                        }
                    }
                }else{
                    $cart_id = $functions->id_gen();
                    $date = $functions->date_gen();
                    $time = $functions->time_gen();

                    $insert_new_cart = mysqli_query($functions->connection(),
                        "INSERT INTO cart (id, user_id, payment_status, reg_date, reg_time) VALUES ('$cart_id','$user_id','0','$date','$time')");
                    if ($insert_new_cart){
                        $content_id = $functions->id_gen();

                        $insert_food = mysqli_query($functions->connection(),
                            "INSERT INTO cart_content (id, cart_id, food_id, quantitiy, reg_date, reg_time) VALUES ('$content_id','$cart_id','$food_id', '$quantity','$date','$time')");

                        if ($insert_food){
                            echo json_encode(array("Erorr"=>false,"MSG"=>"غذای موردنظر با موفقیت به سبد شما اضافه شد"));
                            mysqli_close($functions->connection());
                            return;
                        }else{
                            echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                            mysqli_close($functions->connection());
                            return;
                        }
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