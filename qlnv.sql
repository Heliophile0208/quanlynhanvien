-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th10 05, 2024 lúc 01:31 PM
-- Phiên bản máy phục vụ: 5.7.34
-- Phiên bản PHP: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlnv`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `manv` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phai` tinyint(1) NOT NULL,
  `ngaysinh` date NOT NULL,
  `diachi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapb` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`manv`, `hoten`, `phai`, `ngaysinh`, `diachi`, `mapb`) VALUES
('CNTT01', 'Nguyễn Đăng Khoa', 0, '1978-11-05', '250 tổ 6, KP1, Tân Hiệp', 'CNTT'),
('CNTT02', 'Nguyễn Long Hậu', 0, '1973-03-10', '50/2 Đồng Khôi, Trảng Dài', 'CNTT'),
('CNTT03', 'Trần Thị Ngọc Mai', 1, '1979-08-08', '305/2 Huỳnh Văn Nghệ, Bửu Long, Biên Hòa', 'CNTT'),
('CNTT04', 'Thái Quốc Thắng', 0, '1973-03-10', '2/3/4 ĐT 620, Bửu Long. Biên Hòa', 'CNTT'),
('CNTT05', 'Nguyễn Quốc Phong', 0, '1978-08-15', '4 Nguyễn Thiện Thuật TPHCM', 'CNTT'),
('CNTT06', 'Lý Vĩnh Toàn', 0, '1985-04-06', '3/2 Tân Vạn, BH', 'CNTT'),
('DDT01', 'Lê Vân Em', 0, '1976-05-05', '3/4 Đồng Khởi, Tam Hiệp. Biên Hòa', 'DDT'),
('CNTT07', 'Trần Minh Quang', 0, '1984-02-16', '12 Đường số 3, Tân Bình, TP.HCM', 'CNTT'),
('CNTT08', 'Nguyễn Thị Lan', 1, '1990-07-22', '45 Nguyễn Văn Cừ, Quận 5, TP.HCM', 'CNTT'),
('DDT02', 'Phạm Văn Hải', 0, '1982-09-12', '15A Đồng Khởi, Biên Hòa', 'DDT'),
('DDT03', 'Ngô Thị Hương', 1, '1989-11-03', '29 Lý Thường Kiệt, Biên Hòa', 'DDT'),
('HC01', 'Vũ Anh Tú', 0, '1975-06-19', '102 Cách Mạng Tháng 8, Quận 10, TP.HCM', 'HC'),
('HC02', 'Lê Thị Hoa', 1, '1981-05-30', '88 Hai Bà Trưng, Quận 1, TP.HCM', 'HC');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phongban`
--

CREATE TABLE `phongban` (
  `mapb` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tenpb` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phongban`
--

INSERT INTO `phongban` (`mapb`, `tenpb`) VALUES
('CNTT', 'Công Nghệ Thông Tin'),
('DDT', 'Điện ĐT'),
('HC', 'Hành Chính'),
('KT', 'Kế Toán'),
('NS', 'Nhân Sự');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`manv`),
  ADD KEY `mapb` (`mapb`);

--
-- Chỉ mục cho bảng `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`mapb`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
