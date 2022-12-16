<?php
    include_once("./config.php");
    $connect=connect();
    $prefix=getPrefix();
    session_start();
    $id=$_POST['id'];
    $sql="UPDATE users SET role='0' WHERE id='$id'";
    $query=mysqli_query($connect,$sql);
    if($query){
        echo 'Nâng cấp thành công';
    }
    else{
        echo 'Đã có lỗi xảy ra trong quá trình nâng cấp người dùng!';
    }
?>