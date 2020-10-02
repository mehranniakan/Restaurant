<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST["Cat-id"]) &&
                !empty($_POST["Cat-id"]) &&
                isset($_POST["Food_Price"]) &&
                !empty($_POST["Food_Price"]) &&
                isset($_POST["Food_Name"]) &&
                !empty($_POST["Food_Name"]) &&
                isset($_POST["Sub_cat_id"]) &&
                !empty($_POST["Sub_cat_id"]) &&
                isset($_POST["Recipe"]) &&
                !empty($_POST["Recipe"]) &&
                isset($_POST["Recommned"]) &&
                isset($_FILES['Image_Up']) &&
                !empty($_FILES['Image_Up'])){

                $id = $functions->id_gen();
                $reg_date = $functions->date_gen();
                $reg_time = $functions->time_gen();
                $cat_id = $functions->real_escape($_POST["Cat-id"]);
                $Food_Name = $functions->real_escape($_POST["Food_Name"]);
                $Sub_cat_id = $functions->real_escape($_POST["Sub_cat_id"]);
                $Recipe = $functions->real_escape($_POST["Recipe"]);
                $Food_Price = $functions->real_escape($_POST["Food_Price"]);
                $Recommned = $functions->real_escape($_POST["Recommned"]);
                $pic_name = $functions->random_char(18);
                $upload_image = $functions->upload_img_multipart($_FILES['Image_Up'],'../../Images/',$pic_name);

                if ($Recommned=='1'){
                    $rec = '1';
                }elseif($Recommned=='0'){
                    $rec = '0';
                }
                $insert_food = mysqli_query($functions->connection(),
                    "INSERT INTO foods (id, name, cat_id, sub_cat_id, price, pic, recipe,recomended ,reg_date, reg_time) VALUES ('$id','$Food_Name','$cat_id','$Sub_cat_id','$Food_Price','$pic_name','$Recipe',$rec,'$reg_date','$reg_time')");

                if ($insert_food){
                    echo json_encode(array("Erorr"=>false,"MSG"=>"غذای مورد نظر با موفقیت ثبت شد !"));
                    mysqli_close($function->connection());
                    return;
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
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