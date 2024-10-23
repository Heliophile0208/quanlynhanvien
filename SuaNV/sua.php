<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlnv";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
// Lấy danh sách nhân viên
$sql = "SELECT * FROM nhanvien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
    <style>
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
            margin:0 auto;
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
            width: 1000px;
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

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            width: 600px;
            margin: 30px auto;

        }

        .container h1 {
            color: red;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: red;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        .edit-link {
            color: blue;
            text-decoration: none;
        }

        .edit-link:hover {
            text-decoration: underline;
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
    <h2>Sửa Thông Tin</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Giới Tính</th>
                <th>Ngày Sinh</th>
                <th>Địa Chỉ</th>
                <th>Phòng Ban</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody style="font-size:14px;">
            <?php
            if ($result->num_rows > 0) {
                $stt = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $stt++ . "</td>";
                    echo "<td>" . $row['manv'] . "</td>";
                    echo "<td>" . $row['hoten'] . "</td>";
                    echo "<td>" . ($row['phai'] == 0 ? 'Nam' : 'Nữ') . "</td>";
                    echo "<td>" . date('d-m-Y', strtotime($row['ngaysinh'])) . "</td>";
                    echo "<td>" . $row['diachi'] . "</td>";
                    echo "<td>" . $row['mapb'] . "</td>";
                    echo "<td><a class='edit-link' href='sua_nhan_vien.php?manv=" . $row['manv'] . "'>Sửa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Không có dữ liệu nhân viên.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <footer class="footer">
        <h4>SVTH: Lê Thị Kim Ngân - Khoa Công Nghệ Thông Tin</h4>
        <h4>Trường: Cao Đẳng Nghề Đồng Nai - Số 8, Nguyễn Văn Hoa, Thống Nhất, Thiên Hòa</h4>
    </footer>
</body>

</html>

<?php
$conn->close();
?>