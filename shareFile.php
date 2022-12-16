<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once('vendor/autoload.php');

    include_once("./config.php");

    $connect=connect();
    session_start();
    $prefix=getPrefix();
    $key = bin2hex(random_bytes(32));

    
    if(isset($_GET['get_link']) && $_GET['get_link']==1){
        $id=$_POST['id'];
        $select="SELECT * FROM share WHERE id_file='$id'";
        $q=mysqli_query($connect,$select);
        if($q){
            if(mysqli_num_rows($q)>0){
                $data=mysqli_fetch_assoc($q);
                $k=$data['keyShare'];
                echo $prefix . '/share_with_me.php?key='.$k;
            }
        }
    }
    else{
    $id_file = $_POST['id_file'];
    $user_share = $_POST['users'];
    $is_all = $_POST['isAll'];
    $sql = "INSERT INTO share(id_file,users,keyShare,isAll) VALUE('" . $id_file . "','" . $user_share . "','" . $key . "','" . $is_all . "')";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        $update = "UPDATE file SET share='1' WHERE id='$id_file'";
        $query = mysqli_query($connect, $update);
        if ($query) {
            if ($is_all == 0) {
                $user_name = json_decode($user_share);
                foreach ($user_name as $k => $v) {
                    $ins = "INSERT into share_with_me(username,id_file) VALUE('" . $v . "','" . $id_file . "')";
                    $query_ins = mysqli_query($connect, $ins);
                    if ($query_ins) {
                        echo 'Chia sẻ file thành công';
                    }
                }
                $k = $key;
                sendToUser($user_share, $k);
            }
            else{
                echo 'Chia sẻ file thành công';
            }
            
        } else {
            echo 'Đã xảy ra lỗi.Vui lòng thử lại';
        }
    } else {
        echo 'Đã xảy ra lỗi.Vui lòng thử lại';
    }
    }
function sendToUser($user_share,$key_share){
    $username = $_SESSION['user'];
    $user_name=json_decode($user_share);
    foreach($user_name as $k=>$v){
        sendMail($v,$username, $key_share);
    }
}
function sendMail($email,$username, $key_share)
{
    
    $prefix = getPrefix();
    $href= $prefix . '/share_with_me.php?key=' . $key_share;
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8'; //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'vytuong2903@gmail.com'; //SMTP username
        $mail->Password = 'dylbprsjmoxllict'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('vytuong2903@gmail.com', 'File Manager');
        $mail->addAddress($email, 'Receiver'); //Add a recipient

        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Chia sẻ tệp tin';
        $mail->Body = "<p>Xin chào, '" . $email . "'! Tôi là quản trị viên trang web File Manager,</p>
        <p>Bạn vừa được '$username' chia sẻ một file.!</p>
        <p>Click vào<a href ='".$href."'> đây</a> để truy cập!</p>";
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo $e;
        return false;
    }
}
?>