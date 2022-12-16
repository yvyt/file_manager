<?php
session_start();
include_once('./config.php');
$connect = connect();
$login = false;
$username = "";
$email;
$name = "";
$er = "";
$role = $_SESSION['role'];
if ($role == 0) {
    header('Location: indexAdmin.php');
    exit();
}
if (!isset($_SESSION['user'])) {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit();
}
$is_use = 0;
$max = 0;
$login = true;
$email = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE username='" . $email . "' LIMIT 1";
$query = mysqli_query($connect, $sql);
$num_row = mysqli_num_rows($query);
$id = 0;
$num = 0;
if ($num_row > 0) {
    $data = mysqli_fetch_assoc($query);
    $name = $data['name'];
    $is_use = $data['use_size'];
    $max = $data['size_page'];
}
if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    unlink($_SESSION['url']);
    unset($_SESSION['user']);
    header('Location: login.php');
    exit();
}
if (isset($_GET['key'])) {
    $_SESSION['url'] = '/source/';
    $us = "";
    $key = $_GET['key'];
    $select = "SELECT * FROM share WHERE keyShare='$key'";
    $query = mysqli_query($connect, $select);
    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $d = mysqli_fetch_assoc(($query));
            $file_id = $d['id_file'];
            $us = $d['users'];
            $is_all = $d['isAll'];
            if ($is_all == 1) {
                $sel_file = "SELECT * FROM file WHERE id='$file_id'";
                $run_sel = mysqli_query($connect, $sel_file);
                $ins = "INSERT into share_with_me(username,id_file) VALUE('" . $email . "','" . $file_id . "')";
                $query_ins = mysqli_query($connect, $ins);
                $num = mysqli_num_rows($run_sel);
            } else {
                if (strpos($us, $email) !== false) {
                    $sel_file = "SELECT * FROM file WHERE id='$file_id'";
                    $run_sel = mysqli_query($connect, $sel_file);
                    $num = mysqli_num_rows($run_sel);
                } else {
                    $er = "Bạn không có quyền truy cập vào file này";
                }
            }
        }
    }
} else {

    $sql_sl_share = "SELECT * FROM share_with_me,file WHERE share_with_me.username='$email' AND share_with_me.id_file=file.id";
    $run_sel = mysqli_query($connect, $sql_sl_share);

    $num = mysqli_num_rows($run_sel);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="./CSS/styleAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Quản lý dữ liệu-Chia sẻ</title>
</head>

<body>
    <header>
        <h>Chia sẻ với tôi</h>
    </header>
    <div class="container-">
        <nav class="navbar navbar-expand-lg" id="navbar1">
            <div class="container-fluid">
                <img src="./CSS/images/logo.jpg" height="50px" width="50px" style="border-radius: 50px;">
                <a class="navbar-brand" href="index.php" style="padding-left: 50px;color: rgb(66, 72, 116);">Trang Chủ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex" role="search" style="width: 60%; padding-left:10%;">
                        <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" id="charSearch">
                        <button class="btn btn-outline-success" type="submit">Tìm</button>
                    </form>
                    <ul>
                        <li class="nav-item dropdown" id="login">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                if ($name != "") {
                                    echo $name;
                                } else {
                                    echo "User";
                                }
                                ?>
                            </a>
                            <ul class="dropdown-menu" id="dropdownLogin">
                                <li><a class="dropdown-item" href="./editInfor.php">Hồ sơ của tôi</a></li>
                                <li><a class="dropdown-item" href="./changePassword.php">Đổi mật khẩu</a></li>

                                <li><a class="dropdown-item" href="index.php?dangxuat=1">Đăng xuất</a></li>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="row">
        <section>
            <nav id="navbar2">
                <div class="dropdown">
                    <img src="css/images/folder3.png" width="15%" height="15%">
                    <button class="btn btn-secondary dropdown-toggle" id="dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Thư mục của tôi
                    </button>
                    <ul class="dropdown-menu" id="dropdownUL">
                        <li><a class="dropdown-item" href="index.php">Thư mục gốc</a></li>
                        <li><a class="dropdown-item" href="#">Thêm thư mục</a></li>
                        <li><a class="dropdown-item" href="#">Quản lý thư mục</a></li>
                    </ul>
                </div>

                <div class="priority">
                    <img src="css/images/priority5.png" width="15%" height="15%">
                    <a class="btn" id="btnPriority" href="priority.php">Quan trọng</a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">Đã chia sẻ</button> -->
                </div>

                <div class="dropdown">
                    <img src="./CSS/images/share7.png" width="15%" height="15%">
                    <button class="btn btn-secondary dropdown-toggle" id="dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Chia sẻ
                    </button>
                    <ul class="dropdown-menu" id="dropdownUL">
                        <li><a class="dropdown-item" href="share.php">Đã chia sẻ</a></li>
                        <li><a class="dropdown-item" href="share_with_me.php">Chia sẻ với tôi</a></li>

                    </ul>
                </div>
                <div class="recent">
                    <img src="css/images/recent1.png" width="15%" height="15%">
                    <a class="btn" id="btnRecent" href="recent.php">Gần đây</a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">Đã chia sẻ</button> -->
                </div>
                <div class="trash">
                    <img src="css/images/trash1.png" width="15%" height="15%">
                    <a class="btn" id="btnTrash" href="trash.php">Thùng rác</a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">Đã chia sẻ</button> -->
                </div>
                <div class="share">
                    <img src="./CSS/images/priority2.png" width="15%" height="15%">
                    <a class="btn" id="btnTrash" href="upgrade.php">Dung lượng</a>
                    <div>
                        <?php
                        $now_us = ($is_use / $max) * 100;
                        ?>
                        <progress id="file" value="<?php echo $now_us ?>" max="100"></progress>
                    </div>
                </div>
                <div class="priority">

                    <a class="btn" id="btnPriority" href="priority.php"></a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">Đã chia sẻ</button> -->
                </div>

            </nav>

            <article id="art2">
                <div class="row" id="display_file">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" onclick="changePath('NULL')">Chia sẻ với tôi</a></li>
                                <!-- other folders -->
                                <?php
                                $variable = $_SESSION['path'];
                                foreach ($variable as $key) {
                                    if ($key != 'NULL') {
                                ?>
                                        <li class="breadcrumb-item"><a href="#" onclick="changePath('<?= $key ?>')"><?= $key ?></a></li>
                                <?php
                                    }
                                }
                                ?>
                                <li class="breadcrumb-item"><a href="#"></a></li>
                            </ol>
                        </nav>
                    </nav>
                    <?php
                    if ($num == 0) {
                        if (isset($er)) {
                            echo "<h2 style=\"text-align:center\">$er</h2>";
                        } else {
                            echo "<h2 style=\"text-align:center;color:red\">Chưa có dữ liệu nào được chia sẻ với bạn!</h2>";
                        }
                    } else {
                        $file_data = array();
                        while ($row = mysqli_fetch_array($run_sel)) {
                            array_push($file_data, $row);
                    ?>
                            <div class="col-lg-3 col-md-3">
                                <div class="card" style="width: 85%; background-color: rgb(247, 251, 252);border: 0px;">
                                    <img src="./<?php echo $row['image'] ?>" class="card-img-top" height="256px" height="256px">
                                    <div class="card-body">
                                        <p class="card-text" id="file_name"><?php
                                                                            if (strlen($row['file_name']) > 20) {
                                                                                echo substr($row['file_name'], 0, 19) . '...';
                                                                            } else {
                                                                                echo $row['file_name'];
                                                                            }
                                                                            ?></p>
                                        <div class="dropdown" id="dropdownThuMuc" style=" background-color: rgb(247, 251, 252);color: rgb(0, 74, 124);font-family: 'Times New Roman', Times, serif;">
                                            <button id="dropDownOfFile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="./CSS/images/3dot.png" width="15%" height="15%"> </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Tải về</a></li>
                                                <li><a class="dropdown-item" href="#">Xem chi tiết </a></li>
                                                <li><a class="dropdown-item" href="report.php?baocao=<?php echo $row['id'] ?>">Báo cáo</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="openShare(<?php echo $row['id'] ?>)">Quản lý</a></li>
                                                <li><a class="dropdown-item" href="set_starred.php?id=<?php echo $row['id'] ?>"> Thêm vào quan trọng</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </article>
            <div class="shareFile">

                <div class="popup" id="share">
                    <form style=" background: linear-gradient(135deg, #71b7e6, #9b59b6); border-radius:10px; padding:20px">
                        <h style=" color: black; font-size: 25px; font-family: 'Times New Roman', Times, serif; margin-left: 35%;"> Quản lý </h>
                        <input class="form-control" type="text" id="link">
                        <p id="error" style="text-align:center;color:red"></p>
                        <div class="form" style="margin-left:35%;">
                            <button type="button" id="btnAddFile" onclick="closeShare()"> OK </button>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <footer>
        <p>Footer</p>
    </footer>
    <script>
        let popup = document.getElementById("popup");

        function openPopup() {
            popup.classList.add("open-popup");
        }

        function openShare(id) {

            document.getElementById("share").classList.add("open-popup");
            var form_data = new FormData();
            form_data.append("id", id);
            $.ajax({
                url: "shareFile.php?get_link=1",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(dat2) {
                    document.getElementById("link").value = dat2;
                }
            });

        }
        $(document).ready(function() {
            $("#charSearch").on('input', function() {
                var file_data = <?php echo json_encode($file_data) ?>;
                var char = $("#charSearch").val();
                var result = file_data.filter(element => element['file_name'].includes(char));

                var html_result = "";


                if (result.length > 0) {
                    ht2 = "";
                    for (i = 0; i < result.length; i++) {
                        ht2 += "<div class=\"col-lg-3 col-md-3\"> <div class=\"card\" style=\"width: 85%; background-color: rgb(247, 251, 252);border: 0px;\">";
                        ht2 += "<img src=\"./" + result[i]['image'] + '"' + " class=\"card-img-top\" width=\"256px\" height=\"256px\">";
                        ht2 += "<div class=\"card-body\">";
                        ht2 += "<p class=\"card-text\" id=\"file_name\">";
                        ht2 += result[i]['file_name'].substr(0, 19);
                        ht2 += "</p>";
                        ht2 += "<div class=\"dropdown\" id=\"dropdownThuMuc\" style=\"background-color: rgb(247, 251, 252);color: rgb(0, 74, 124);font-family: 'Times New Roman', Times, serif;\">";
                        ht2 += "<button onclick=\"getCurFile(" + "'" + result[i]['file_name'] + "','" + result[i]['id'] + "'" + ')"' + " id=\"dropDownOfFile\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
                        ht2 += "<img src=\"./CSS/images/3dot.png\" width=\"15%\" height=\"15%\">";
                        ht2 += "</button>";
                        ht2 += "<ul class=\"dropdown-menu\">";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"download.php?path=" + result[i]['file_name'] + "&username=" + result[i]['username'] + "\"" + ">Tải về</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"showRenameFile()\">Đổi tên tập tin</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\">Xem chi tiết </a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"openShare(" + result[i]['id'] + ")\"" + ">Chia sẻ</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"set_starred.php?id=" + result[i]['id'] + "\">Thêm vào quan trọng</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"deletedFile(" + result[i]['id'] + ")" + "\">Xóa</a></li>";
                        ht2 += "</ul>";
                        ht2 += "</div>";
                        ht2 += "</div>";
                        ht2 += "</div>";
                        ht2 += "</div>";
                    }
                    html_result += ht2;
                }
                console.log(html_result);
                document.getElementById("display_file").innerHTML = html_result;

            })
        });

        function closeShare() {
            document.getElementById("share").classList.remove("open-popup");
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }
    </script>
</body>

</html>