<?php
    include_once("./config.php");
    $connect = connect();
    session_start();

    // $_SESSION['assign_path'] = array();
    if(count($_SESSION['path']) != 0) {
        $_SESSION['assign_path'] = $_SESSION['path'];
    } else {
        $_SESSION['assign_path'] = array();
    }

    if(isset($_POST['change_path'])) {
        $cp = $_POST['change_path'];
        if($cp != 'NULL') {
            // array_push($_SESSION['assign_path'], $cp);
            // array_pop($_SESSION['assign_path']);
            if(!in_array($cp, $_SESSION['assign_path'])) {
                array_push($_SESSION['assign_path'], $cp);
            }
            else {
                $index = array_search($cp, $_SESSION['assign_path']);
                if($index != (count($_SESSION['assign_path']) - 1)) {
                    array_splice($_SESSION['assign_path'],  $index+1);
                }
            }
        }
        else {
            array_splice($_SESSION['assign_path'], 0);
        }
        
        $t = 0;
        foreach ($_SESSION['assign_path'] as $key) {
            echo $t.' - '.$key.'<br>';
        }
        echo '<br>';
        $_SESSION['assign_folder'] = $cp;
        echo $_SESSION['assign_folder'];
        die($_SESSION['assign_folder']);
    }

    else if(isset($_POST['username']) && isset($_POST['name']) && isset($_POST['parent'])) {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $parent = $_POST['parent'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $time = date('y-m-d h:i:s');
        
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/source' . '/files/'.$username.'/';
        $dir = $dir.join('/', $_SESSION['assign_path']);
        mkdir($dir.'/'.$_POST['name'], 0777, true);

        if($parent == 'NULL') {
            $query = "INSERT INTO folder(username,name,date_create,modify) VALUE('" . $username . "','" . $name . "','" . $time . "','" . $time . "')";
        }
        else {
            $query = "INSERT INTO folder(username,name,parent,date_create,modify) VALUE('" . $username . "','" . $name . "','" . $parent . "','" . $time . "','" . $time . "')";
        }
        $exec = mysqli_query($connect, $query);
        if($exec) {
            echo "Successful to create folder ".$name;
        }
        else {
            echo "Failed to create folder ".$name;
        }
    }
?>