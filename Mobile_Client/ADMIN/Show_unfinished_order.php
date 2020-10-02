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
                $count = 0;
                $select_order = mysqli_query($functions->connection(),
                    "SELECT * FROM cart where delivery_status = '0' AND payment_status = '1' LIMIT 20 OFFSET $offset");

                while ($result = mysqli_fetch_assoc($select_order)){

                    $cart_id = $result['id'];
                    $user_id = $result['user_id'];

                    $select_cart_cont = mysqli_query($functions->connection(),
                        "SELECT * FROM cart_content where cart_id = '$cart_id'");
                    $foods = [];
                    while ($result1 = mysqli_fetch_assoc($select_cart_cont)){

                        $count = $count+1;
                        $item_id = $result1['id'];
                        $food_id = $result1['food_id'];
                        $quantity = $result1['quantitiy'];

                        $select_food_detail = mysqli_query($functions->connection(),
                            "SELECT * FROM foods where id = '$food_id'");

                        while ($result3 = mysqli_fetch_assoc($select_food_detail)){
                            $food_name = $result3['name'];
                            $food_pic = $result3['pic'];
                        }

                        array_push($foods,array("food_id"=>$food_id, "food_name"=>$food_name, "quantity"=>$quantity,"pic"=>$food_pic));


                    }

                    $select_user_detail = mysqli_query($functions->connection(),
                        "SELECT * FROM users where id = '$user_id'");

                    while ($result2 = mysqli_fetch_assoc($select_user_detail)){
                        $user_name =  $result2['name'];
                        $user_address = $result2['address'];
                        $user_tell = $result2['tell'];
                        $lat = $result2['Lat'];
                        $lng = $result2['Lng'];
                    }
                    $arr[] = array(
                        'cart_id' => $cart_id,
                        "username" => $user_name,
                        "user_address" => $user_address,
                        "lat" => $lat,
                        "lng" => $lng,
                        "user_tell" => $user_tell,
                        "items" => $foods
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