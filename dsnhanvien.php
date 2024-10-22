<?php

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
    <title>Danh Sách Nhân Viên</title>
    <style>
    

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        select,
        input[type="submit"] {
            padding: 8px;
            font-size: 16px;
            margin-right: 10px;
        }

        input[type="submit"] {
            color: red;
        }
        h2{color:red; text-align: center;}

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
            width: 1000px;
            margin-top: 20px;
        }

        .footer h4 {
            margin: 5px 0;
            text-align: center;
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
    <h2>DANH SÁCH NHÂN VIÊN</h2>

    <!-- lọc nhân viên theo phòng ban -->
    <div class="filter-form">
        <form method="POST" action="">
            <label for="phongban">Chọn phòng ban:</label>
            <select name="phongban" id="phongban">
                <option value="">-- Tất cả phòng ban --</option>
                <?php

                if ($result_phongban->num_rows > 0) {
                    while ($row_pb = $result_phongban->fetch_assoc()) {
                        $selected = ($chon_phongban == $row_pb['mapb']) ? 'selected' : '';
                        echo "<option value='{$row_pb['mapb']}' $selected>{$row_pb['tenpb']}</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="Tìm kiếm">
        </form>
    </div>

    <!-- danh sách nhân viên -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã NV</th>
                <th>Họ tên</th>
                <th>Phái</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Phòng ban</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_nhanvien->num_rows > 0) {
                $stt = 1;
                while ($row_nv = $result_nhanvien->fetch_assoc()) {
                    $phai_text = ($row_nv['phai'] == 0) ? 'Nam' : 'Nữ';
                    echo "<tr>
                        <td>{$stt}</td>
                        <td>{$row_nv['manv']}</td>
                        <td>{$row_nv['hoten']}</td>
                        <td>{$phai_text}</td>
                        <td>" . date('d-m-Y', strtotime($row_nv['ngaysinh'])) . "</td>
                        <td>{$row_nv['diachi']}</td>
                        <td>{$row_nv['mapb']}</td>
                    </tr>";
                    $stt++;
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>Không có nhân viên nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <footer class="footer">
        <h4>SVTH: Nguyễn Đăng Khoa - Khoa Công Nghệ Thông Tin</h4>
        <h4>Trường: Cao Đẳng Nghề Đồng Nai - Số 8, Nguyễn Văn Hoa, Thống Nhất, Thiên Hòa</h4>
    </footer>

</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>