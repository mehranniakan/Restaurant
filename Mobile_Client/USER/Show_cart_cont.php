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

            $check_open_cart = mysqli_query($functions->connection(),
                "SELECT id FROM cart where user_id = '$user_id' AND  payment_status = '0'");

            if (mysqli_num_rows($check_open_cart) == '1'){

                $cart_id0 = mysqli_fetch_assoc($check_open_cart);
                $cart_id = implode(":",$cart_id0);
                $check_content = mysqli_query($functions->connection(),
                    "SELECT * FROM cart_content where cart_id = '$cart_id'");
                $cart_price = 0;

                while ($select_result = mysqli_fetch_assoc($check_content)){

                    $quantity = $select_result['quantitiy'];
                    $food_id = $select_result['food_id'];
                    $check_food_price = mysqli_query($functions->connection(),
                        "SELECT * FROM foods where id = '$food_id'");
                    $check_food_price = mysqli_fetch_assoc($check_food_price);
                    $price = $check_food_price['price'];
                    $pic = $check_food_price['pic'];
                    $food_name = $check_food_price['name'];
                    $cart_price = $cart_price+($quantity*$price);

                    $arr[] = array(
                        'id'=>$select_result['id'],
                        'cart_id'=>$select_result['cart_id'],
                        'food_id'=>$food_id,
                        'food_name'=>$food_name,
                        'unit_price'=>$price,
                        'pic'=>$pic,
                        'nums'=>$quantity,
                    );
                }

                if (!empty($arr) && isset($arr)) {
                    $data = array("Erorr" => false, "result" => $arr,"Cart_price"=>$cart_price);
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
                $cart_id = $functions->id_gen();
                $date = $functions->date_gen();
                $time = $functions->time_gen();
                $insert_new_cart = mysqli_query($functions->connection(),
                    "INSERT INTO cart (id, user_id, payment_status, reg_date, reg_time) VALUES ('$cart_id','$user_id','0','$date','$time')");

                if ($insert_new_cart){
                    $check_content = mysqli_query($functions->connection(),
                        "SELECT * FROM cart_content where cart_id = '$cart_id'");
                    $cart_price = 0;
                    while ($select_result = mysqli_fetch_assoc($check_content)){

                        $food_id = $select_result['food_id'];
                        $quantity = $select_result['quantity'];
                        $check_food_price = mysqli_query($functions->connection(),
                            "SELECT * FROM foods where id = '$food_id'");
                        $check_food_price = mysqli_fetch_assoc($check_food_price);
                        $price = $check_food_price['price'];
                        $pic = $check_food_price['pic'];
                        $food_name = $check_food_price['name'];
                        $cart_price = $cart_price+($quantity*$price);

                        $arr[] = array(
                            'id'=>$select_result['id'],
                            'cart_id'=>$select_result['cart_id'],
                            'food_id'=>$food_id,
                            'unit_price'=>$price,
                            'food_name'=>$food_name,
                            'pic'=>$pic,
                            'nums'=>$quantity,
                        );
                    }
                    if (!empty($arr) && isset($arr)) {
                        $data = array("Erorr" => false, "result" => $arr, "Cart_price"=>$cart_price);
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
                    echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                    mysqli_close($functions->connection());
                    return;
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