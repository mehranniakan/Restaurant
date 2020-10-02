<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if (isset($_POST['Token']) && !empty($_POST['Token'])){
        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){
            if (isset($_POST['Food_ID']) &&
                !empty($_POST['Food_ID'])){

                $food_id = $functions->real_escape($_POST['Food_ID']);
                $check_food_stat = mysqli_query($functions->connection(),
                    "SELECT recomended FROM foods where id='$food_id'");

                $food_stat = mysqli_fetch_assoc($check_food_stat);
                $food_stat = implode(":",$food_stat);

                if ($food_stat=='0' || $food_stat==0){
                    $update = mysqli_query($functions->connection(),
                        "UPDATE foods SET recomended='1' where id='$food_id'");
                    if ($update){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"غذای مورد نظر به پیشنهاد شده ها اضافه شد !","stat"=>'1'));
                        mysqli_close($function->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($function->connection());
                        return;
                    }
                }else{
                    $update = mysqli_query($functions->connection(),
                        "UPDATE foods SET recomended='0' where id='$food_id'");
                    if ($update){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"غذای مورد نظر از پیشنهاد شده ها حذف شد !","stat"=>'0'));
                        mysqli_close($function->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
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
