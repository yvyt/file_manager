<?php
session_start();
include_once('./config.php');
$connect = connect();
$login = false;
$username = "";
$email;
$name = "";
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
$sql_sl = "SELECT * FROM file WHERE priority='1' and deleted=0 and username='$email'";
$run_sql = mysqli_query($connect, $sql_sl);
$num = mysqli_num_rows($run_sql);
$select_folder = "SELECT * FROM folder WHERE priority='1' and deleted='0' and username='$email'";
$exec_folder = mysqli_query($connect, $select_folder);
if ($exec_folder) {
    $fnum = mysqli_num_rows($exec_folder);
} else {
    $fnum = 0;
    echo mysqli_error($connect);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/styleAdmin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Qu???n l?? d??? li???u-Quan tr???ng</title>
</head>

<body>
    <header>
        <h>Quan tr???ng</h>
    </header>
    <div class="container-">
        <nav class="navbar navbar-expand-lg" id="navbar1">
            <div class="container-fluid">
                <img src="./CSS/images/logo.jpg" height="50px" width="50px" style="border-radius: 50px;">
                <a class="navbar-brand" href="index.php" style="padding-left: 50px;color: rgb(66, 72, 116);">Trang Ch???</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form action="index.php?search=1" method="POST" class="d-flex" role="search" style="width: 60%; padding-left:10%;">
                        <input class="form-control me-2" name="search" type="search" placeholder="T??m ki???m" aria-label="Search" id="charSearch">
                        <button class="btn btn-outline-success" name="submit" value="submit-search" type="submit">T??m</button>
                    </form>
                    <ul>
                        <li class="nav-item dropdown" id="login">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                if ($name != "") {
                                    if ($_SESSION['cur_folder'] === "NULL") {
                                        echo $name . ' - ' . 'Root';
                                    } else {
                                        echo $name . ' - ' . $_SESSION['cur_folder'];
                                    }
                                } else {
                                    echo "User";
                                }
                                ?>
                            </a>
                            <ul class="dropdown-menu" id="dropdownLogin">
                                <li><a class="dropdown-item" href="./editInfor.php">H??? s?? c???a t??i</a></li>
                                <li><a class="dropdown-item" href="./changePassword.php">?????i m???t kh???u</a></li>

                                <li><a class="dropdown-item" href="index.php?dangxuat=1">????ng xu???t</a></li>
                            </ul>
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
                    <img src="./CSS/images/folder3.png" width="15%" height="15%">
                    <button class="btn btn-secondary dropdown-toggle" id="dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Th?? m???c c???a t??i
                    </button>
                    <ul class="dropdown-menu" id="dropdownUL">
                        <li><a class="dropdown-item" href="index.php" onclick="changePath('NULL')">Th?? m???c g???c</a></li>
                        <li><a class="dropdown-item" href="#">Qu???n l?? th?? m???c</a></li>
                    </ul>
                </div>


                <!-- edit folder -->
                <div>
                    <div class="popup" id="popupEditFolder">
                        <form style=" background: linear-gradient(135deg, #71b7e6, #9b59b6); border-radius:10px; padding:20px">
                            <h style=" color: black; font-size: 25px; font-family: 'Times New Roman', Times, serif; margin: 25%">
                                ?????i t??n th?? m???c</h>
                            <input class="form-control" type="text" id="idEditFolderName">
                            <p id="error" style="text-align:center;color:red"></p>
                            <div class="formAdd" style="display: flex;">
                                <button type="button" id="btnAddFile" onclick="cfEditFolderName()"> ?????i </button>
                                <button type="button" id="btnCancel" onclick="cancelEditFolder()"> H???y </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- edit file -->
                <div>
                    <div class="popup" id="popupEditFile">
                        <form style=" background: linear-gradient(135deg, #71b7e6, #9b59b6); border-radius:10px; padding:20px">
                            <h style=" color: black; font-size: 25px; font-family: 'Times New Roman', Times, serif; margin: 25%">
                                ?????i t??n t???p tin</h>
                            <input class="form-control" type="text" id="idEditFileName">
                            <p id="error" style="text-align:center;color:red"></p>
                            <div class="formAdd" style="display: flex;">
                                <button type="button" id="btnAddFile" onclick="cfEditFileName()"> ?????i </button>
                                <button type="button" id="btnCancel" onclick="cancelEditFile()"> H???y </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="priority">
                    <img src="./CSS/images/priority5.png" width="15%" height="15%">
                    <a class="btn" id="btnPriority" href="priority.php">Quan tr???ng</a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">???? chia s???</button> -->
                </div>
                <div class="dropdown">
                    <img src="./CSS/images/share7.png" width="15%" height="15%">
                    <button class="btn btn-secondary dropdown-toggle" id="dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Chia s???
                    </button>
                    <ul class="dropdown-menu" id="dropdownUL">
                        <li><a class="dropdown-item" href="share.php">???? chia s???</a></li>
                        <li><a class="dropdown-item" href="share_with_me.php">Chia s??? v???i t??i</a></li>

                    </ul>
                </div>
                <div class="recent">
                    <img src="./CSS/images/recent1.png" width="15%" height="15%">
                    <a class="btn" id="btnRecent" href="recent.php">G???n ????y</a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">???? chia s???</button> -->
                </div>
                <div class="trash">
                    <img src="./CSS/images/trash1.png" width="15%" height="15%">
                    <a class="btn" id="btnTrash" href="trash.php">Th??ng r??c</a>
                    <!-- <button type="button" class="btn btn-light" id = "btnShare">???? chia s???</button> -->
                </div>
                <div class="share">
                    <img src="./CSS/images/priority2.png" width="15%" height="15%">
                    <a class="btn" id="btnTrash" href="upgrade.php">Dung l?????ng</a>
                    <div>
                        <?php
                        $now_us = ($is_use / $max) * 100;
                        ?>
                        <progress id="file" value="<?php echo $now_us ?>" max="100"></progress>
                    </div>
                </div>
            </nav>

            <div style="display: none;">Here</div>
            <article id="art2">
                <div class="row" id="display_file">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" onclick="changePath('NULL')">Quan tr???ng</a></li>
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
                    <?php
                    
                    $folder_data = array();
                    if ($fnum != 0) {
                        while ($row = mysqli_fetch_array($exec_folder)) {
                            array_push($folder_data, $row)
                    ?>
                            <div class="col-lg-3 col-md-3">
                                <div class="card" style="width: 85%; background-color: rgb(247, 251, 252);border: 0px;">
                                    <img src="./CSS/images/folder.webp" class="card-img-top" width="256px" height="256px">
                                    <div class="card-body">
                                        <p class="card-text" id="folder_name">
                                            <?php echo $row['name'] ?>
                                        </p>
                                        <div class="dropdown" id="dropdownThuMuc" style=" background-color: rgb(247, 251, 252);color: rgb(0, 74, 124);font-family: 'Times New Roman', Times, serif;">
                                            <button onclick="getCurFolder('<?= $row['name'] ?>', '<?= $row['id'] ?>')" id="dropDownOfFile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="./CSS/images/3dot.png" width="15%" height="15%">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="download.php?path=<?php echo $row['name'] ?>&username=<?php echo $row['username'] ?>">T???i v???</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="showRenameFolder()">?????i t??n th?? m???c</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changePath('<?php echo $row['name'] ?>')">Xem chi ti???t </a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Chia s???</a></li>
                                                <li><a class="dropdown-item" href="set_starred.php?folder_huy=<?php echo $row['id'] ?>">Lo???i b??? quan tr???ng</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="deletedFolder('<?= $row['id'] ?>')">X??a</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    $file_data = array();
                    if ($num == 0 && $fnum == 0) {
                        echo "<h2 style=\"text-align:center\">Ch??a c?? d??? li???u l??u tr???</h2>";
                    } else {
                        while ($row = mysqli_fetch_array($run_sql)) {
                            array_push($file_data, $row);
                    ?>
                            <div class="col-lg-3 col-md-3">
                                <div class="card" style="width: 85%; background-color: rgb(247, 251, 252);border: 0px;">
                                    <img src="./<?php echo $row['image'] ?>" class="card-img-top" width="256px" height="256px">
                                    <div class="card-body">
                                        <p class="card-text" id="file_name">
                                            <?php
                                            if (strlen($row['file_name']) > 20) {
                                                echo substr($row['file_name'], 0, 19) . '...';
                                            } else {
                                                echo $row['file_name'];
                                            }
                                            ?>
                                        </p>
                                        <div class="dropdown" id="dropdownThuMuc" style=" background-color: rgb(247, 251, 252);color: rgb(0, 74, 124);font-family: 'Times New Roman', Times, serif;">
                                            <button onclick="getCurFile('<?= $row['file_name'] ?>', '<?= $row['id'] ?>')" id="dropDownOfFile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="./CSS/images/3dot.png" width="15%" height="15%">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="download.php?path=<?php echo $row['file_name'] ?>&username=<?php echo $row['username'] ?>">T???i v???</a></li>
                                                <li><a class=" dropdown-item" href="#" onclick="showRenameFile()">?????i t??n t???p tin</a></li>
                                                <li><a class="dropdown-item" href="#">Xem chi ti???t </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="openShare(<?php echo $row['id'] ?>)">Chia s???</a></li>
                                                <li><a class="dropdown-item" href="set_starred.php?huy=<?php echo $row['id'] ?>">Lo???i b??? quan tr???ng</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="deletedFile(<?php echo $row['id'] ?>)">X??a</a></li>
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
                <div class="shareFile">

                    <div class="popup" id="share">
                        <form style=" background: linear-gradient(135deg, #71b7e6, #9b59b6); border-radius:10px; padding:20px">
                            <h style=" color: black; font-size: 25px; font-family: 'Times New Roman', Times, serif; margin-left: 35%;">
                                Chia s??? </h>
                            <input class="form-control" type="text" id="users">
                            <input class="form-control" type="hidden" id="id_file">
                            <p id="error" style="text-align:center;color:red"></p>
                            <div class="form" style="display: flex;">
                                <button type="button" id="btnAddFile" onclick="shareFile()"> Th??m </button>
                                <button type="button" id="btnCancel" onclick="closeShare()"> H???y </button>
                            </div>
                        </form>
                    </div>
                </div>

            </article>
        </section>
    </div>
    <footer>
        <p>Footer</p>
    </footer>
    <script>
        var popup = document.getElementById("popup");
        var popupFolder = document.getElementById("popupFolder");
        var popupEditFolder = document.getElementById("popupEditFolder");
        var popupEditFile = document.getElementById("popupEditFile");

        var temp = {
            id: -1,
            curFile: 'file',
            curFolder: 'folder',
            isFile: false
        }

        function openPopup() {
            popup.classList.add("open-popup");
        }

        function openShare(id) {
            document.getElementById("share").classList.add("open-popup");
            document.getElementById("id_file").value = id;
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }

        function closeShare() {
            document.getElementById("share").classList.remove("open-popup");
        }

        function deletedFile(id) {
            var del = confirm("B???n c?? ch???c ch???n x??a file n??y kh??ng? File s??? ???????c chuy???n v??o th??ng r??c v?? t??? ?????ng x??a sau 30 ng??y.");
            var form_data = new FormData();
            form_data.append("id", id);
            if (del == true) {
                console.log(id);
                $.ajax({
                    url: "deleted.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(dat2) {
                        alert(dat2);
                        location.reload();
                    }
                });
            } else {

            }
            return del;
        }

        function deletedFolder(id) {
            var del = confirm("B???n c?? ch???c ch???n x??a th?? m???c n??y kh??ng? Th?? m???c s??? ???????c chuy???n v??o th??ng r??c v?? t??? ?????ng x??a sau 30 ng??y.");
            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("del_folder_to_trash", 'ok');
            if (del == true) {
                console.log(id);
                $.ajax({
                    url: "deleted.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(dat2) {
                        alert(dat2);
                        location.reload();
                    }
                });
            } else {

            }
            return del;
        }

        function shareFile() {
            users = document.getElementById("users").value;
            id_file = document.getElementById("id_file").value;
            var is_all = 0; //false
            if (users === '') {
                is_all = 1;
            }
            var user_arr = [];
            if (users !== '') {
                user_arr = users.split(",");
            }

            user_share = JSON.stringify(user_arr);
            console.log(user_share);
            var form_data = new FormData();
            form_data.append("id_file", id_file);
            form_data.append("users", user_share);
            form_data.append("isAll", is_all);
            $.ajax({
                url: "shareFile.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(dat2) {
                    alert(dat2);
                    location.reload();
                }
            });
        }

        function openPopupFolder() {
            popupFolder.classList.add("open-popup");
        }

        function closePopupFolder() {
            popupFolder.classList.remove("open-popup");
        }

        function changePath(cur) {
            console.log(cur)
            $.ajax({
                url: "folder_service.php",
                type: "POST",
                dataType: 'json',
                data: {
                    change_path: cur
                },
                success: function(dataResponse) {
                    console.log("change path ok")
                },
                error: function(dataResponse) {
                    console.log("change path khok")
                }
            });
            location.href = 'index.php';
            location.reload()
        }

        function getCurFolder(cfo, id) {
            temp.curFolder = cfo
            temp.id = id
            temp.isFile = false
        }

        function getCurFile(cfi, id) {
            temp.curFile = cfi
            temp.id = id
            temp.isFile = true
        }

        function showRenameFolder() {
            popupEditFolder.classList.add("open-popup");
            $('#idEditFolderName').val(temp.curFolder)
        }

        function showRenameFile() {
            popupEditFile.classList.add("open-popup");
            $('#idEditFileName').val(temp.curFile)
        }

        function cancelEditFolder() {
            popupEditFolder.classList.remove("open-popup");
        }

        function cancelEditFile() {
            popupEditFile.classList.remove("open-popup");
        }

        function cfEditFolderName() {
            var efo = $('#idEditFolderName').val()
            console.log("efo = " + efo)
            console.log($.trim(efo))
            if ($.trim(efo) != '') {
                $.ajax({
                    url: 'rename.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        usernameFO: '<?= $email ?>',
                        new_nameFO: efo,
                        idFO: temp.id,
                        old_nameFO: temp.curFolder,
                    },
                    success: function(data) {
                        alert('ok')
                    },
                    error: function(data) {
                        alert('?????i t??n th??nh c??ng!')
                    }
                })
                location.href = 'index.php';
                location.reload()
            } else {
                alert('T??n th?? m???c kh??ng th??? tr???ng!')
            }
        }

        function cfEditFileName() {
            var efi = $('#idEditFileName').val()
            if ($.trim(efi) != '') {
                $.ajax({
                    url: 'rename.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        usernameFI: '<?= $email ?>',
                        new_nameFI: efi,
                        idFI: temp.id,
                        old_nameFI: temp.curFile,
                    },
                    success: function(data) {

                    },
                    error: function(data) {
                        alert('?????i t??n th??nh c??ng!')
                    }
                })
                location.href = 'index.php';
                location.reload()
            } else {
                alert('T??n t???p tin kh??ng th??? tr???ng!')
            }
        }
        $(document).ready(function() {
            $("#charSearch").on('input', function() {
                var file_data = <?php echo json_encode($file_data) ?>;
                var folder_data = <?php echo json_encode($folder_data) ?>;
                var char = $("#charSearch").val();
                var result = file_data.filter(element => element['file_name'].includes(char));
                var resulte = folder_data.filter(element => element['name'].includes(char));
                // for(i=0;i<resulte.length;i++){
                //     result.push(resulte[i]);
                // }
                var html_result = "";
                if (resulte.length > 0) {
                    var ht1 = "";
                    for (i = 0; i < resulte.length; i++) {
                        ht1 += "<div class=\"col-lg-3 col-md-3\"> <div class=\"card\" style=\"width: 85%; background-color: rgb(247, 251, 252);border: 0px;\">";
                        ht1 += "<img src=\"./CSS/images/folder.webp\" class=\"card-img-top\" width=\"256px\" height=\"256px\">";
                        ht1 += "<div class=\"card-body\">";
                        ht1 += "<p class=\"card-text\" id=\"file_name\">";
                        ht1 += resulte[i]['name'].substr(0, 19);
                        ht1 += "</p>";
                        ht1 += "<div class=\"dropdown\" id=\"dropdownThuMuc\" style=\"background-color: rgb(247, 251, 252);color: rgb(0, 74, 124);font-family: 'Times New Roman', Times, serif;\">";
                        ht1 += "<button onclick=\"getCurFile(" + "'" + resulte[i]['name'] + "','" + resulte[i]['id'] + "'" + ')"' + " id=\"dropDownOfFile\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
                        ht1 += "<img src=\"./CSS/images/3dot.png\" width=\"15%\" height=\"15%\">";
                        ht1 += "</button>";
                        ht1 += "<ul class=\"dropdown-menu\">";
                        ht1 += "<li><a class=\"dropdown-item\" href=\"download.php?path=" + resulte[i]['name'] + "&username=" + resulte[i]['username'] + "\"" + ">T???i v???</a></li>";
                        ht1 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"showRenameFile()\">?????i t??n th?? m???c</a></li>";
                        ht1 += "<li><a class=\"dropdown-item\" href=\"#\">Xem chi ti???t </a></li>";
                        ht1 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"openShare(" + resulte[i]['id'] + ")\"" + ">Chia s???</a></li>";
                        ht1 += "<li><a class=\"dropdown-item\" href=\"set_starred.php?id=" + resulte[i]['id'] + "\">Th??m v??o quan tr???ng</a></li>";
                        ht1 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"deletedFile(" + resulte[i]['id'] + ")" + "\">X??a</a></li>";
                        ht1 += "</ul>";
                        ht1 += "</div>";
                        ht1 += "</div>";
                        ht1 += "</div>";
                        ht1 += "</div>";
                    }
                    html_result += ht1;
                }

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
                        ht2 += "<li><a class=\"dropdown-item\" href=\"download.php?path=" + result[i]['file_name'] + "&username=" + result[i]['username'] + "\"" + ">T???i v???</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"showRenameFile()\">?????i t??n t???p tin</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\">Xem chi ti???t </a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"openShare(" + result[i]['id'] + ")\"" + ">Chia s???</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"set_starred.php?id=" + result[i]['id'] + "\">Th??m v??o quan tr???ng</a></li>";
                        ht2 += "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"deletedFile(" + result[i]['id'] + ")" + "\">X??a</a></li>";
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
    </script>
</body>


</html>