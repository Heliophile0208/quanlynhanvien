<?php

session_start();

$message = "";


$username = 'admin';
$password = password_hash('123', PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = trim($_POST['username']);
    $inputPassword = $_POST['password'];
    if ($inputUsername === $username && password_verify($inputPassword, $password)) {

        $_SESSION['username'] = $username;
        header("Location: quanly.php");
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "qlnv";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

$sql_phongban = "SELECT * FROM phongban";
$result_phongban = $conn->query($sql_phongban);

$where_clause = '';
$chon_phongban = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['phongban']) && !empty($_POST['phongban'])) {
        $chon_phongban = $_POST['phongban'];
        $where_clause = " WHERE mapb = '$chon_phongban'";
    }
}


$sql_nhanvien = "SELECT manv, hoten, phai, ngaysinh, diachi, mapb FROM nhanvien" . $where_clause;
$result_nhanvien = $conn->query($sql_nhanvien);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>


        h2 {
            color: red;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        input[type="submit"] {
            padding: 8px;
            font-size: 16px;
            margin-right: 10px;
            color: red;
        }

        .filter-form {
            text-align: center;
            margin-bottom: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            padding: 0;
            width: 1000px;
            
        }

        .header,
        .footer {
            background-color: #1E90FF;
            color: white;
            padding: 10px;
            text-align: center;
            width: 1000px;
        }

        .header {
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            border-top: 1px solid #ccc;
            position: relative;
            bottom: 0;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .anh {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .middle {
            background-color: #1E90FF;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 130px;
            color: white;
            text-align: center;
        }

        .middle span {
            font-weight: bold;
            text-shadow: 1px 1px 2px white, 0 0 25px rgba(0, 0, 0, 0.5), 0 0 5px white;
            padding: 0px;
            border-radius: 5px;
            margin: 0;
        }
        .footer {
            text-align: center;
            background-color: #1E90FF;
            color: blue;
            padding: 20px;
            border-top: 1px solid #ccc;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }

        .footer h4 {
            margin: 5px 0;
        }

        .form {
            text-align: center;
        }

        .container {
            text-align: center;
        }

        table {
            border: none;
            width: 500px;
            border-collapse: collapse;
            margin-top: 20px;

        }
    </style>
</head>

<body>
    <header>
        <a class="header" href="../index.php" style="text-decoration:none;">
            <img src="../PNG/logo.png" alt="Logo" class="logo">
            <div class="middle">
                <p style="color:red; font-size:20px">ỦY BAN NHÂN DÂN TỈNH ĐỒNG NAI</p>
                <span style="color:blue; font-size:28px;">TRƯỜNG CAO ĐẲNG NGHỀ ĐỒNG NAI</span>
                <p style="color:black">DONG NAI VOCATIONAL COLLEGE</p>
                <span style="color:red; font-size:30px">NHẤT NGHỆ TINH - NHẤT THÂN VINH</span>
            </div>
            <img src="../PNG/nhaxanh.jpg" alt="Anh" class="anh">
        </a>
    </header>
    <div class="container">
        <div style="margin:10px auto;">
            <h2>ĐĂNG NHẬP</h2>
        </div>

        <?php if ($message): ?>
            <div class="error-message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form class="form" method="post" action="">
            <table style="margin:0 auto;">
                <tr>
                    <th><label for="username">Tên Đăng Nhập:</label></th>
                    <th><input type="text" id="username" name="username" placeholder="Username" required></th>
                </tr>
                <tr>
                    <th><label for="password">Mật Khẩu:</label></td>
                    <th><input type="password" id="password" name="password" placeholder="Password" required></th>
                </tr>
                <tr>
                    <td style="text-align: right;"><button type="submit">Đăng Nhập</button></td>
                    <td><button type="submit"><a style="text-decoration: none; color:black;" href="index.php">Trang Chủ</a></button></td>
                </tr>
            </table>
        </form>
    </div>
    <footer class="footer">
        <h4>SVTH: Lê Thị Kim Ngân - Khoa Công Nghệ Thông Tin</h4>
        <h4>Trường: Cao Đẳng Nghề Đồng Nai - Số 8, Nguyễn Văn Hoa, Thống Nhất, Thiên Hòa</h4>
    </footer>

</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>