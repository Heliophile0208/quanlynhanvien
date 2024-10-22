<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: dangnhap.php");
    exit();
}
else
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlnv";

// Kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

mysqli_set_charset($conn, 'utf8');

// Lấy danh sách phòng ban
$phong_ban = [];
$sql = "SELECT * FROM phongban";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $phong_ban[] = $row;
    }
}

$thong_bao = '';
$nhan_vien_moi = ''; // Biến để lưu thông tin nhân viên mới thêm

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ma_nhan_vien = $_POST['ma_nhan_vien'] ?? '';
    $ho_tenlot = $_POST['ho_tenlot'] ?? '';
    $ten = $_POST['ten'] ?? '';
    $ngay_sinh = ($_POST['nam_sinh'] ?? '') . '-' . str_pad(($_POST['thang_sinh'] ?? 0), 2, '0', STR_PAD_LEFT) . '-' . str_pad(($_POST['ngay_sinh'] ?? 0), 2, '0', STR_PAD_LEFT);
    $gioi_tinh = $_POST['gioi_tinh'] ?? '';
    $dia_chi = $_POST['dia_chi'] ?? '';
    $ma_phong_ban = $_POST['ma_phong_ban'] ?? '';
    $ho_ten = $ho_tenlot . ' ' . $ten;

    // Câu lệnh SQL thêm nhân viên sử dụng câu lệnh chuẩn bị
    $stmt = $conn->prepare("INSERT INTO nhanvien (manv, hoten, phai, ngaysinh, diachi, mapb) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $ma_nhan_vien, $ho_ten, $gioi_tinh, $ngay_sinh, $dia_chi, $ma_phong_ban);

    if ($stmt->execute()) {
        $thong_bao = "<div class='alert success'>Thêm nhân viên thành công!</div>";

        // Lấy thông tin nhân viên mới thêm
        $stmt = $conn->prepare("SELECT manv, hoten, phai, ngaysinh, diachi, mapb FROM nhanvien WHERE manv = ?");
        $stmt->bind_param("s", $ma_nhan_vien);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Lưu nội dung hiển thị thông tin nhân viên mới thêm vào biến
            $nhan_vien_moi .= '<div class="khung">';
            $nhan_vien_moi .= '<h2 class="tieudemoi">Thông tin nhân viên mới thêm:</h2>';
            $nhan_vien_moi .= "<table class='ketqua'>";
            $nhan_vien_moi .= "<tr><th>STT</th><th>Mã NV</th><th>Họ tên</th><th>Phái</th><th>Ngày Sinh</th><th>Địa Chỉ</th><th>Mã PB</th></tr>";

            $stt = 1;
            while ($row = $result->fetch_assoc()) {
                $nhan_vien_moi .= "<tr>";
                $nhan_vien_moi .= "<td>" . $stt++ . "</td>";
                $nhan_vien_moi .= "<td>" . $row['manv'] . "</td>";
                $nhan_vien_moi .= "<td>" . $row['hoten'] . "</td>";
                $nhan_vien_moi .= "<td>" . ($row['phai'] == 0 ? 'Nam' : 'Nữ') . "</td>";
                $nhan_vien_moi .= "<td>" . $row['ngaysinh'] . "</td>";
                $nhan_vien_moi .= "<td>" . $row['diachi'] . "</td>";
                $nhan_vien_moi .= "<td>" . $row['mapb'] . "</td>";
                $nhan_vien_moi .= "</tr>";
            }
            $nhan_vien_moi .= "</table>";
            $nhan_vien_moi .= '</div>';
        } else {
            $nhan_vien_moi = "<p style='color:red;'>Không tìm thấy thông tin nhân viên.</p>";
        }
    } else {
        $thong_bao = "<div class='alert error'>Lỗi khi thêm nhân viên.</div>";
    }
    $stmt->close();
}
$conn->close();


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên Mới</title>
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: calc(100% - 10px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .date-group {
            display: flex;
            justify-content: space-between;
        }

        .date-group input {
            width: 30%;
        }

        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 20%;
            margin: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button:hover {
            background-color: darkblue;
        }


        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }

        .link {
            text-decoration: none;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 20%;
            margin: 5px;
            background-color: blue;
            text-align: center;
            font-size: 14px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .ketqua {
            border: 1px solid;
        }
        .footer h4 {
            margin: 5px 0;
            text-align: center;
        }
    </style>
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
        <h1>THÊM NHÂN VIÊN MỚI</h1>

        <form method="POST">
            <div class="form-group">
                <label for="ma_nhan_vien">Mã Nhân Viên:</label>
                <input type="text" id="ma_nhan_vien" name="ma_nhan_vien" required>
            </div>

            <div class="form-group">
                <label for="ho_tenlot">Họ và Tên Lót:</label>
                <input type="text" id="ho_tenlot" name="ho_tenlot" required>
            </div>

            <div class="form-group">
                <label for="ten">Tên Nhân Viên:</label>
                <input type="text" id="ten" name="ten" required>
            </div>

            <div class="form-group">
                <label for="gioi_tinh">Giới Tính:</label>
                <select name="gioi_tinh" id="gioi_tinh" required>
                    <option value="0">Nam</option>
                    <option value="1">Nữ</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ngày Sinh:</label>
                <div class="date-group">
                    <input type="number" name="ngay_sinh" min="1" max="31" required placeholder="Ngày">
                    <span style="font-size: 30px;">/</span>
                    <input type="number" name="thang_sinh" min="1" max="12" required placeholder="Tháng">
                    <span style="font-size: 30px;">/</span>
                    <input type="number" name="nam_sinh" min="1900" required placeholder="Năm">
                </div>
            </div>

            <div class="form-group">
                <label for="dia_chi">Địa Chỉ:</label>
                <input type="text" id="dia_chi" name="dia_chi" required>
            </div>

            <div class="form-group">
                <label for="ma_phong_ban">Phòng Ban:</label>
                <select name="ma_phong_ban" id="ma_phong_ban" required>
                    <?php foreach ($phong_ban as $pb) { ?>
                        <option value="<?php echo $pb['mapb']; ?>"><?php echo $pb['tenpb']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="button">Thêm Mới</button>
                <button type="button" class="button secondary" onclick="window.history.back();">Quay Về</button>
                <a class="link" href="dangnhap.php">Thoát</a>
                <a class="link" href="index.php">Trang Chủ</a>
            </div>
        </form>
    </div>
        <?php echo $thong_bao; 
        echo $nhan_vien_moi;
        
        ?>
    <footer class="footer">
        <h4>SVTH: Nguyễn Đăng Khoa - Khoa Công Nghệ Thông Tin</h4>
        <h4>Trường: Cao Đẳng Nghề Đồng Nai - Khoa CNTT</h4>
    </footer>
</body>

</html>
