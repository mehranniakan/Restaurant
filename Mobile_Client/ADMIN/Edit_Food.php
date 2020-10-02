<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Food_id']) &&
                !empty($_POST['Food_id']) &&
                isset($_POST['Food_Name']) &&
                !empty($_POST['Food_Name']) &&
                isset($_POST['Food_cat']) &&
                !empty($_POST['Food_cat']) &&
                isset($_POST['Food_sub_cat']) &&
                !empty($_POST['Food_sub_cat']) &&
                isset($_POST['Food_price']) &&
                !empty($_POST['Food_price']) &&
                isset($_POST['recipe']) &&
                !empty($_POST['recipe'])){

                $food_id = $functions->real_escape($_POST['Food_id']);
                $food_name = $functions->real_escape($_POST['Food_Name']);
                $food_cat = $functions->real_escape($_POST['Food_cat']);
                $food_sub_cat = $functions->real_escape($_POST['Food_sub_cat']);
                $food_price = $functions->real_escape($_POST['Food_price']);
                $food_recipe = $functions->real_escape($_POST['recipe']);

                if (isset($_FILES['Image_Up']) &&
                    !empty($_FILES['Image_Up'])){

                    $old_pic_name = mysqli_query($functions->connection(),
                        "SELECT pic FROM foods where id = '$food_id' ");

                    $old_pic_name = mysqli_fetch_assoc($old_pic_name);
                    $old_pic_name = implode(":",$old_pic_name);

                    $dir = '../../Images/';
                    $dirHandle = opendir($dir);

                    $pic_name = $functions->random_char(18);
                    $upload_image = $functions->upload_img_multipart($_FILES['Image_Up'],'../../Images/',$pic_name);


                    if ($upload_image){

                        $edit_food = mysqli_query($functions->connection(),
                            "UPDATE foods SET name = '$food_name' , cat_id = '$food_cat' , sub_cat_id = '$food_sub_cat' , price = '$food_price' , recipe = '$food_recipe' , pic = '$pic_name' WHERE  id = '$food_id'");

                        if ($edit_food){
                            while ($file = readdir($dirHandle)) {
                                if($file==$old_pic_name) {
                                    $delete_old_pic = unlink($dir.'/'.$file);
                                }
                            }
                            if ($delete_old_pic){
                                echo json_encode(array("Erorr"=>false,"MSG"=>"غذای مورد نظر با موفقیت اصلاح شد !","status"=>'0'));
                                mysqli_close($function->connection());
                                return;
                            }else{
                                echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !","status"=>'0.2'));
                                mysqli_close($function->connection());
                                return;
                            }
                        }else{
                            echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !","status"=>'0.3'));
                            mysqli_close($function->connection());
                            return;
                        }
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !","status"=>'0.1'));
                        mysqli_close($function->connection());
                        return;
                    }
                }else{
                    $edit_food = mysqli_query($functions->connection(),
                        "UPDATE foods SET name = '$food_name' ,cat_id = '$food_cat' ,sub_cat_id = '$food_sub_cat' ,price = '$food_price' ,recipe = '$food_recipe' WHERE id = '$food_id'");
                    if ($edit_food){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"غذای مورد نظر با موفقیت اصلاح شد !","status"=>'1'));
                        mysqli_close($function->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($function->connection());
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