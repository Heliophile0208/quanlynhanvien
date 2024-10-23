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
$thong_bao = '';

if (isset($_GET['manv'])) {
    $ma_nhan_vien = $_GET['manv'];

    $sql = "SELECT * FROM nhanvien WHERE manv = '$ma_nhan_vien'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $nhan_vien = $result->fetch_assoc();
    } else {
        $thong_bao = "<div class='alert error'>Nhân viên không tồn tại.</div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_nhan_vien = $_POST['ma_nhan_vien'] ?? '';
    $ho_ten = trim($_POST['ho_ten']) ?? '';
    $ngay_sinh = ($_POST['nam_sinh'] ?? '') . '-' . str_pad($_POST['thang_sinh'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($_POST['ngay_sinh'], 2, '0', STR_PAD_LEFT);
    $gioi_tinh = $_POST['phai'];
    $dia_chi = trim($_POST['dia_chi']) ?? '';
    $ma_phong_ban = $_POST['ma_phong_ban'] ?? '';


    if ($ma_phong_ban == '' || empty($ma_nhan_vien) || empty($ho_ten) || empty($ngay_sinh) || !isset($gioi_tinh) || empty($dia_chi)) {
        $thong_bao = "<div class='alert error'>Vui lòng điền đầy đủ thông tin.</div>";
    } else {

        $sql = "UPDATE nhanvien SET hoten='$ho_ten', ngaysinh='$ngay_sinh', phai='$gioi_tinh', diachi='$dia_chi', mapb='$ma_phong_ban' WHERE manv='$ma_nhan_vien'";

        if ($conn->query($sql) === TRUE) {
            $thong_bao = "<div class='alert success'>Cập nhật nhân viên thành công!</div>";
        } else {
            $thong_bao = "<div class='alert error'>Lỗi: " . $conn->error . "</div>";
        }
    }
}


$phong_ban = [];
$sql = "SELECT * FROM phongban";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $phong_ban[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cật Nhật Thông Tin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            padding: 0;
            width: 1000px;
            
        }
        .footer h4 {
            margin: 5px 0;
            text-align: center;
        }
        .header,
        .footer {
            background-color: #1E90FF;
            color: white;
            padding: 10px;
            text-align: center;
            width: 100%;
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
            width: 1000px;
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
            width: 400px;
            margin:0 auto;
        }

        .title {
            color: red;
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
        }

        .sub-title {
            color: red;
            font-size: 20px;
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
            justify-content: space-between;
            margin-top: 10px;

        }

        .button {
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin: 5px;
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
        <img src="../PNG/nhaxanh.jpg" alt="Anh" class="anh"></a>
    </header>
    <div class="container">
        <div class="title">CẬP NHẬT THÔNG TIN NHÂN VIÊN</div>
        <div class="sub-title">SỬA THÔNG TIN NHÂN VIÊN</div>
        <?php echo $thong_bao; ?>
        <?php if (isset($nhan_vien)): ?>
            <form method="POST">
                <input type="hidden" name="ma_nhan_vien" value="<?php echo $nhan_vien['manv']; ?>">
                <div class="form-group">
                    <label for="ho_ten">Họ Tên:</label>
                    <input type="text" id="ho_ten" name="ho_ten" value="<?php echo $nhan_vien['hoten']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Ngày Sinh:</label>
                    <div class="date-group">
                        <input type="number" name="ngay_sinh" min="1" max="31" value="<?php echo date('d', strtotime($nhan_vien['ngaysinh'])); ?>" required placeholder="Ngày">
                        <input type="number" name="thang_sinh" min="1" max="12" value="<?php echo date('m', strtotime($nhan_vien['ngaysinh'])); ?>" required placeholder="Tháng">
                        <input type="number" name="nam_sinh" min="1900" value="<?php echo date('Y', strtotime($nhan_vien['ngaysinh'])); ?>" required placeholder="Năm">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phai">Giới Tính:</label>
                    <select name="phai" id="phai" required>
                        <option value="0" <?php echo $nhan_vien['phai'] == 0 ? 'selected' : ''; ?>>Nam</option>
                        <option value="1" <?php echo $nhan_vien['phai'] == 1 ? 'selected' : ''; ?>>Nữ</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dia_chi">Địa Chỉ:</label>
                    <input type="text" id="dia_chi" name="dia_chi" value="<?php echo $nhan_vien['diachi']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="ma_phong_ban">Phòng Ban:</label>
                    <select name="ma_phong_ban" id="ma_phong_ban" required>
                        <option value="">Chọn phòng ban</option> <!-- Tuỳ chọn mặc định -->
                        <?php foreach ($phong_ban as $pb) { ?>
                            <option value="<?php echo $pb['mapb']; ?>" <?php echo $nhan_vien['mapb'] == $pb['mapb'] ? 'selected' : ''; ?>><?php echo $pb['tenpb']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="button-group">
                    <button type="submit" class="button">Cập Nhật</button>
                    <button type="button" class="button secondary" onclick="window.location.href='sua.php';">Quay Về</button>
                    <button type="button" class="button secondary"><a style="text-decoration:none; color:white" href="../dangnhap.php">Thoát</a></button>
                    <button type="button" class="button secondary"><a style="text-decoration:none; color:white" href="../index.php">Trang Chủ</a></button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert error">Không tìm thấy thông tin nhân viên.</div>
        <?php endif; ?>
    </div>
    <footer class="footer">
        <h4>SVTH: Lê Thị Kim Ngân - Khoa Công Nghệ Thông Tin</h4>
        <h4>Trường: Cao Đẳng Nghề Đồng Nai - Số 8, Nguyễn Văn Hoa, Thống Nhất, Thiên Hòa</h4>
    </footer>
</body>

</html>