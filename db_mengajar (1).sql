-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 27, 2025 at 04:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mengajar`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nidn` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_dosen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nidn`, `id_prodi`, `nama_dosen`) VALUES
('100001', 'P40', 'Agus Suprajitno, ST., MT'),
('100002', 'P40', 'Dedi Nugroho, ST., MT'),
('100003', 'P40', 'Akhmad Syakhroni, ST., M.Eng'),
('100004', 'P41', 'Jenny Putri Hapsari, ST., MТ.'),
('100005', 'P42', 'Mustafa, ST., MM., M.Kom'),
('100006', 'P42', 'Ir. Sri Mulyono, M.Eng'),
('100007', 'P42', 'Muhammad Qomaruddin, ST, M.Sc., Ph.D'),
('100008', 'P42', 'Bagus Satrio Waluyo Poetro, S.Kom., M.Cs'),
('100009', 'P42', 'Moch Taufik, ST,MIT'),
('100010', 'P40', 'Muhammad Khosyi\'in, ST., MT.'),
('100011', 'P40', 'Munaf Ismail, ST., MT.'),
('100012', 'P40', 'Dr. Hj. Sri Arttini Dwi P., M.Si'),
('100013', 'P40', 'Dr. Bustanul Arifin, ST., MT.'),
('100014', 'P40', 'Eka Nuryanto Budisusila, ST., MT'),
('100015', 'P40', 'Agus Suprayitno, ST., MT'),
('100016', 'P41', 'Irwan Sukendar, ST., MT., ASEAN Eng.'),
('100017', 'P41', 'Wiwiek Fatmawati, ST., M.Eng.'),
('100018', 'P41', 'H. Andre Sugiyono, ST., MM., Ph.D'),
('100020', 'P41', 'Brav Deva Bernadhi, ST., MT.'),
('100021', 'P41', 'Dr. Ir. Hj. Novi Marlyana, ST., MT., IPU., ASEAN Eng.'),
('100022', 'P41', 'Ir. Hj. Eli Mas\'idah, MT.'),
('100023', 'P41', 'Dr. Ir. Hj. Sukarno Budi Utomo, MT.'),
('100024', 'P41', 'Nuzulia Khoiriyah, ST., MT.'),
('100025', 'P41', 'M. Sagaf, ST., MT.'),
('100026', 'P41', 'Rieska Ernawati, ST., MT.'),
('100027', 'P41', 'Nurwidiana, ST., MT.'),
('100028', 'P42', 'Sam Farisa Chaerul Haviana, ST., M.Kom'),
('100029', 'P42', 'Imam Much Ibnu Subroto, ST., M.Sc., Ph.D'),
('100030', 'P42', 'Dedy Kurniadi, ST., M.Kom'),
('100031', 'P42', 'Andi Riansyah, ST., M.Kom'),
('100032', 'P42', 'Badie\'ah, ST., M.Kom.'),
('100033', 'P42', 'Ghufron, ST., M.Kom'),
('100034', 'P42', 'Ir. Hj. Ida Widihastuti, MT'),
('100035', 'P42', 'Arief Marwanto, ST., M.Eng., Ph.D'),
('200001', 'P12', 'Prof. Ir. Pratikso, MST., Ph.D'),
('200002', 'P12', 'Prof. Dr. Ir. Slamet Imam Wahyudi, DEA'),
('200003', 'P12', 'Prof. Dr. Ir. Antonius, MT'),
('200004', 'P12', 'Prof. Dr. Ir. Henny Pratiwi Adi, ST., MT.'),
('200005', 'P12', 'Dr. Abdul Rochim, ST., MT'),
('200006', 'P12', 'Ir. Rachmat Mudiyono, MT., Ph.D'),
('200007', 'P12', 'Dr. Ir. Kartono Wibowo, MM., MT'),
('200008', 'P12', 'Ir. Prabowo Setiyawan, MT., Ph.D'),
('200009', 'P12', 'Dr. Ir. Soedarsono, MSi.'),
('200010', 'P12', 'Dr. Hermin Poedjiastoeti, SSi., MSi'),
('200011', 'P12', 'Lala Anggraini, ST., MT'),
('200012', 'P13', 'Dr. Ir. Mohammad Agung Ridlo, MT'),
('200013', 'P13', 'Dr. Jamilla Kautsary, ST., MT'),
('200014', 'P13', 'Dr. Agus Rochani, ST., MT'),
('200015', 'P13', 'Dr. Abied Rizky Putra Muttaqien, ST., MT., M.Pwk'),
('200016', 'P13', 'Ir. Tjoek Suroso Hadi, MT'),
('200017', 'P13', 'Ir. Eppy Yuliani, MT.'),
('200018', 'P13', 'Ardiana Yuli Puspitasari, ST., MT.'),
('200019', 'P13', 'Dr. Abdul Fikri Faqih, MM'),
('400001', 'P33', 'Dr. Muchamad Coirun Nizar, S.H.I., S.Hum., M.H.I.'),
('400002', 'P33', 'Fadzlurrahman, S.H., M.H.'),
('400003', 'P33', 'Anis Tyas Kuncoro, S.Ag., MA.'),
('400004', 'P33', 'Dr. H. Ghofar Shidiq, M.Ag.'),
('400005', 'P33', 'Dr. Drs. H. Nur\'l Yakin Mch, SH., M.Hum.'),
('400006', 'P32', 'Ahmad Muflihin, S.Pd.I., M.Pd.I.'),
('400007', 'P32', 'Dr. Toha Makhsun, S.Pd.I., M.Pd.I'),
('400008', 'P32', 'Dr. Agus Irfan, SHI., MPI.'),
('400009', 'P32', 'Dr. Ahmad Mujib, S.Th.I., MA.'),
('400010', 'P32', 'Dr. Zaenurrosyid, MA'),
('400011', 'P34', 'Dr. Agus Irfan, S.H.I., M.P.I.'),
('400012', 'P34', 'Dr. Muna Yastuti Madrah, S.T., MA'),
('400013', 'P34', 'Asmaji, Ph.D'),
('400014', 'P34', 'Dr. Drs. H. Didiek Ahmad Supadie MY, MM.'),
('400015', 'P34', 'Dr. H. Rozihan, S.H., M.Ag');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_fakultas` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
('F01', 'Fakultas Teknologi Industri'),
('F02', 'Fakultas Teknik'),
('F03', 'Fakultas Kedokteran'),
('F04', 'Fakultas Kedokteran Gigi'),
('F05', 'Fakultas Farmasi'),
('F06', 'Fakultas Ekonomi'),
('F07', 'Fakultas Psikologi'),
('F08', 'Fakultas Keguruan dan Ilmu Pendidikan'),
('F09', 'Fakultas Agama Islam'),
('F10', 'Fakultas Ilmu Komunikasi'),
('F11', 'Fakultas Bahasa, Sastra, dan Budaya'),
('F12', 'Fakultas Ilmu Keperawatan');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kode_mk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mk` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sks` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`kode_mk`, `id_prodi`, `nama_mk`, `sks`) VALUES
('IC216009001', 'P40', 'Programmable Logic Controller', 3),
('IC216209014', 'P40', 'Komunikasi Nirkabel', 2),
('IC236008006', 'P40', 'Fisika Mekanika & Termodinamika', 3),
('IC236008026', 'P40', 'Dasar Sistem Kendali', 2),
('IC6006005', 'P40', 'Pancasila', 2),
('IC6006006', 'P40', 'Kewarganegaraan', 2),
('IC6006007', 'P40', 'Bahasa Indonesia', 2),
('IC6007009', 'P40', 'Fiqih Ibadah', 2),
('IC6007011', 'P40', 'Islam Disiplin Ilmu', 3),
('IC6007015', 'P40', 'Peradaban Islam', 2),
('IC6007016', 'P40', 'Kewirausahaan Syariah', 2),
('IC6007017', 'P40', 'Teknologi Digital Informasi untuk Akademik', 2),
('IC6007018', 'P40', 'Bahasa Inggris', 2),
('IC6008001', 'P40', 'Dasar Teknik Elektro', 3),
('IC6008002', 'P40', 'Kalkulus 1', 3),
('IC6008005', 'P40', 'Prak. Dasar Komputer dan Pemrograman', 1),
('IC6008006', 'P40', 'Prak. Fisika Listrik dan Magnet', 1),
('IC6008007', 'P40', 'Kalkulus 2', 3),
('IC6008008', 'P40', 'Dasar Elektronika', 3),
('IC6008010', 'P40', 'Teknologi Bahan Listrik', 2),
('IC6008011', 'P40', 'Probabilitas & Statistik', 2),
('IC6008012', 'P40', 'Prak. Dasar Elektronika', 1),
('IC6008013', 'P40', 'Matematika Teknik', 3),
('IC6008014', 'P40', 'Medan Elektromagnetik', 3),
('IC6008015', 'P40', 'Rangkaian Listrik 2', 2),
('IC6008017', 'P40', 'Pengukuran & Alat Ukur Listrik', 3),
('IC6008018', 'P40', 'Prak. Rangkaian Listrik', 1),
('IC6008019', 'P40', 'Prak. Teknik Digital', 1),
('IC6008020', 'P40', 'Prak. Pengukuran & Alat Ukur Listrik', 1),
('IC6008021', 'P40', 'Dasar Sistem Kendali', 3),
('IC6008022', 'P40', 'Dasar Telekomunikasi', 2),
('IC6008023', 'P40', 'Elektronika Daya', 3),
('IC6008025', 'P40', 'Kuliah Kerja Lapangan', 1),
('IC6008026', 'P40', 'Prak. Dasar Sistem Kendali', 1),
('IC6008027', 'P40', 'Prak. Dasar Telekomunikasi', 1),
('IC6008028', 'P40', 'Prak. Elektronika Daya', 1),
('IC6008031', 'P40', 'Sistem Mikroprosessor', 3),
('IC6008032', 'P40', 'Prak. Mikroprosessor', 1),
('IC6008035', 'P40', 'Metode Penelitian', 2),
('IC6008038', 'P40', 'Dasar Komputer dan Pemrograman', 2),
('IC6008039', 'P40', 'Fisika Listrik dan Magnet', 2),
('IC6008040', 'P40', 'Rangkaian Listrik 1', 2),
('IC6008041', 'P40', 'Teknik Digital', 2),
('IC6008042', 'P40', 'Sistem Linier', 2),
('IC6008043', 'P40', 'Kuliah Kerja Nyata (KKN)', 3),
('IC6009001', 'P40', 'Programmable Logic Controller', 3),
('IC6009002', 'P40', 'Prak. Programmable Logic Controller', 1),
('IC6009003', 'P40', 'SCADA', 3),
('IC6009004', 'P40', 'Kerja Praktek dan Seminar KP', 3),
('IC6009006', 'P40', 'Etika Profesi', 2),
('IC6009009', 'P40', 'Sistem Pakar', 3),
('IC6012001', 'P40', 'Seminar Tugas Akhir', 2),
('IC6012002', 'P40', 'Tugas Akhir', 4),
('IC6108002', 'P40', 'Pembangkit Tenaga Listrik', 3),
('IC6108003', 'P40', 'Sistem Penyaluran Daya Listrik', 3),
('IC6108005', 'P40', 'Prak. Perencanaan Instalasi Listrik', 1),
('IC6108006', 'P40', 'Analisa Sistem Tenaga Listrik', 3),
('IC6108007', 'P40', 'Mesin Listrik 2', 2),
('IC6108008', 'P40', 'Prak. Mesin Listrik', 1),
('IC6108012', 'P40', 'Mesin Listrik I', 3),
('IC6108013', 'P40', 'Perencanaan Instalasi Listrik', 2),
('IC6109006', 'P40', 'Manajemen Energi Listrik', 2),
('IC6109008', 'P40', 'Teknik Tegangan Tinggi', 3),
('IC6208001', 'P40', 'Elektronika Analog', 2),
('IC6208002', 'P40', 'Elektronika Digital', 3),
('IC6208003', 'P40', 'Operasional Amplifier', 3),
('IC6208004', 'P40', 'Prak. Elektronika Analog', 1),
('IC6208005', 'P40', 'Prak. Elektronika Digital', 1),
('IC6208007', 'P40', 'Pengolahan Sinyal Digital', 2),
('IC6208011', 'P40', 'Sensor dan Aktuator', 3),
('IC6209010', 'P40', 'Komunikasi Data', 2),
('IC6209011', 'P40', 'Kendali Cerdas', 3),
('IC6209014', 'P40', 'Komunikasi Nirkabel', 2),
('IC6x09007', 'P40', 'Sistem Proteksi', 2),
('IE216006005', 'P41', 'Pendidikan Pancasila', 2),
('IE216006006', 'P41', 'Kewarganegaraan', 2),
('IE216006007', 'P41', 'Bahasa Indonesia', 2),
('IE216006008', 'P41', 'PAI (Aqidah Akhlak)', 2),
('IE216007009', 'P41', 'Fiqih Ibadah dan Muamalah', 2),
('IE216007011', 'P41', 'Islam Disiplin Ilmu', 3),
('IE216007015', 'P41', 'Peradaban Islam', 2),
('IE216007016', 'P41', 'Kewirausahaan Syariah', 2),
('IE216007017', 'P41', 'Teknologi Digital Informasi Untuk Akademik', 2),
('IE216007018', 'P41', 'Bahasa Inggris', 2),
('IE216008021', 'P41', 'Kalkulus Dasar I', 3),
('IE216008022', 'P41', 'Fisika Dasar I', 2),
('IE216008023', 'P41', 'Pengantar Teknik Industri', 2),
('IE216008024', 'P41', 'Sistem Lingkungan Industri', 2),
('IE216008025', 'P41', 'Menggambar Teknik', 2),
('IE216008026', 'P41', 'Praktikum Menggambar Teknik', 1),
('IE216008027', 'P41', 'Kalkulus Dasar II', 3),
('IE216008028', 'P41', 'Fisika Dasar II', 2),
('IE216008029', 'P41', 'Pengantar Ekonomika', 2),
('IE216008030', 'P41', 'Programa Komputer', 2),
('IE216008031', 'P41', 'Praktikum Fisika Dasar', 1),
('IE216008032', 'P41', 'Praktikum Programa Komputer', 1),
('IE216008033', 'P41', 'Mekanika Teknik', 2),
('IE216008034', 'P41', 'Aljabar Linier', 2),
('IE216008035', 'P41', 'Organisasi dan Manajemen Perusahaan Industri', 2),
('IE216008036', 'P41', 'Statistika I', 3),
('IE216008037', 'P41', 'Ergonomi', 2),
('IE216008038', 'P41', 'Analisis Biaya', 2),
('IE216008039', 'P41', 'Psikologi Industri', 2),
('IE216008040', 'P41', 'Material Teknik', 2),
('IE216008042', 'P41', 'Kalkulus Dasar III', 2),
('IE216008043', 'P41', 'Statistika II', 3),
('IE216008044', 'P41', 'Penelitian Operasional 1', 3),
('IE216008046', 'P41', 'Perencanaan & Pengendalian Produksi', 3),
('IE216008047', 'P41', 'Metodologi Penelitian', 2),
('IE216008048', 'P41', 'Perancangan Sistem Kerja', 2),
('IE216008052', 'P41', 'Proses Manufaktur', 2),
('IE216008054', 'P41', 'Ekonomi Teknik', 2),
('IE216008055', 'P41', 'Pemodelan Sistem', 2),
('IE216008056', 'P41', 'Pengendalian & Penjaminan Mutu', 3),
('IE216008057', 'P41', 'Penelitian Operasional 2', 3),
('IE216008058', 'P41', 'Praktikum Proses Manufaktur', 1),
('IE216008060', 'P41', 'Praktikum Perancangan Teknik Industri 1', 1),
('IE216008061', 'P41', 'Perancangan Tata Letak Fasilitas (PTLF)', 2),
('IE216008062', 'P41', 'Analisis dan Perancangan Perusahaan (APP)', 3),
('IE216008063', 'P41', 'Keselamatan, Kesehatan, dan Lingkungan Kerja', 2),
('IE216008064', 'P41', 'Praktikum Perancangan Teknik Industri 2', 1),
('IE216008065', 'P41', 'Kerja Praktek (KP)', 2),
('IE216008066', 'P41', 'Seminar Kerja Praktek', 1),
('IE216008067', 'P41', 'Praktikum Perancangan Tata Letak Fasilitas', 1),
('IE216008070', 'P41', 'Analisis dan Perancangan Sistem Informasi (APSI)', 2),
('IE216008072', 'P41', 'Simulasi Komputer', 2),
('IE216008073', 'P41', 'Praktikum Analisis dan Perancangan Sistem Informasi', 1),
('IE216008074', 'P41', 'Praktikum Simulasi Komputer', 1),
('IE216008075', 'P41', 'Kuliah Kerja Nyata (KKN)', 3),
('IE216008079', 'P41', 'Sistem Logistik & Rantai Pasok', 2),
('IE216008080', 'P41', 'Praktikum Statistika', 1),
('IE216008082', 'P41', 'Praktikum Ergonomi', 1),
('IE216008083', 'P41', 'Praktikum Perencanaan & Pengendalian Produksi', 1),
('IE216008084', 'P41', 'Mekatronika', 2),
('IE216008085', 'P41', 'CAD CAM', 3),
('IE216008086', 'P41', 'Perancangan dan Pengembangan Produk', 2),
('IE216008088', 'P41', 'Data Mining', 2),
('IE216008089', 'P41', 'Fisiologi dan Anatomi Manusia', 2),
('IE216008091', 'P41', 'Critical Thinking and Problem Solving', 2),
('IE216008092', 'P41', 'Proyek Perancangan', 2),
('IE216008093', 'P41', 'Kimia', 2),
('IE216012001', 'P41', 'Tugas Akhir', 4),
('IE216012002', 'P41', 'Seminar Tugas Akhir', 2),
('IF216008058', 'P42', 'Etika Profesional', 2),
('IF216009069', 'P42', 'Information Retrieval B', 2),
('IF216009071', 'P42', 'Manajemen Server B', 2),
('IF216019076', 'P42', 'Sistem Informasi Manajemen B', 2),
('IF246008018', 'P42', 'Arsitektur Sistem Komputer B', 2),
('IF6006005', 'P42', 'Pancasila', 2),
('IF6006006', 'P42', 'Pendidikan Kewarganegaraan', 2),
('IF6006007', 'P42', 'Bahasa Indonesia', 2),
('IF6006008', 'P42', 'Pendidikan Agama Islam', 2),
('IF6007009', 'P42', 'Islam Disiplin Ilmu', 3),
('IF6007011', 'P42', 'Fiqih Ibadah', 2),
('IF6007015', 'P42', 'Kewirausahaan Syariah', 2),
('IF6007016', 'P42', 'Peradaban Islam', 2),
('IF6007017', 'P42', 'Teknologi Digital Informasi Untuk Akademik', 2),
('IF6007018', 'P42', 'Bahasa Inggris', 2),
('IF6008001', 'P42', 'Kalkulus', 3),
('IF6008002', 'P42', 'Matematika Diskrit 1', 3),
('IF6008003', 'P42', 'Algoritma & Struktur Data', 3),
('IF6008004', 'P42', 'Praktikum Algoritma Dan Struktur Data', 1),
('IF6008020', 'P42', 'Pengantar Sistem Digital', 2),
('IF6008021', 'P42', 'Matriks & Transformasi Linier', 3),
('IF6008022', 'P42', 'Matematika Diskrit 2', 2),
('IF6008023', 'P42', 'Dasar Pemrograman', 3),
('IF6008024', 'P42', 'Praktikum Dasar Pemrograman', 1),
('IF6008025', 'P42', 'Desain Basis Data', 3),
('IF6008026', 'P42', 'Praktikum Desain Basis Data', 1),
('IF6008027', 'P42', 'Arsitektur Sistem Komputer', 2),
('IF6008028', 'P42', 'Pemrograman Berorientasi Objek', 3),
('IF6008029', 'P42', 'Rekayasa Perangkat Lunak', 2),
('IF6008030', 'P42', 'Statistik & Probabilitas', 2),
('IF6008031', 'P42', 'Sistem Operasi', 2),
('IF6008032', 'P42', 'Basis Data Terapan', 3),
('IF6008033', 'P42', 'Praktikum Pemrograman Berorientasi Objek', 1),
('IF6008034', 'P42', 'Praktikum Sistem Operasi', 1),
('IF6008035', 'P42', 'Praktikum Basis Data Terapan', 1),
('IF6008036', 'P42', 'Keamanan Komputer', 2),
('IF6008037', 'P42', 'Web Programming', 3),
('IF6008038', 'P42', 'Praktikum Web Programming', 1),
('IF6008039', 'P42', 'Cloud Computing', 2),
('IF6008040', 'P42', 'Praktikum Cloud Computing', 1),
('IF6008041', 'P42', 'Komputer Grafik', 3),
('IF6008042', 'P42', 'Jaringan Komputer & Komunikasi Data', 3),
('IF6008043', 'P42', 'Praktikum Jaringan Komputer & Komunikasi Data', 1),
('IF6008044', 'P42', 'Mobile Programming', 3),
('IF6008045', 'P42', 'Praktikum Mobile Programming', 1),
('IF6008046', 'P42', 'Kecerdasan Buatan', 2),
('IF6008047', 'P42', 'Pengolahan Citra Digital', 3),
('IF6008048', 'P42', 'Interaksi Manusia dan Komputer', 2),
('IF6008049', 'P42', 'Pengujian Perangkat Lunak', 2),
('IF6008050', 'P42', 'Data Mining & Business Intelligence', 3),
('IF6008051', 'P42', 'Praktikum Data Mining & Business Intelligence', 1),
('IF6008052', 'P42', 'Praktikum Pengujian Perangkat Lunak', 1),
('IF6008053', 'P42', 'Multimedia', 2),
('IF6008054', 'P42', 'Kunjungan Industri ICT', 1),
('IF6008055', 'P42', 'Metodologi Penelitian dan Proposal Tugas Akhir', 3),
('IF6008057', 'P42', 'KKN / KPT', 3),
('IF6008059', 'P42', 'Proyek Kerja Kelompok / Magang', 2),
('IF6012058', 'P42', 'Tugas Akhir', 4),
('IF6012059', 'P42', 'Seminar Tugas Akhir', 2),
('MTE0001', 'P43', 'Matematika Terapan', 3),
('MTE0002', 'P43', 'Kecerdasan Buatan Lanjut', 3),
('MTE0003', 'P43', 'Manajemen Energi Listrik', 3),
('MTE0004', 'P43', 'Sistem Instrumentasi Lanjut', 3),
('MTE0005', 'P43', 'Energi Terbarukan', 3),
('MTE0006', 'P43', 'Metodologi Riset & Penulisan Ilmiah', 2),
('MTE0007', 'P43', 'Seminar Proposal Tesis', 2),
('MTE0008', 'P43', 'TESIS', 6),
('MTE0009', 'P43', 'Kuliah Kerja Industri (KKI)', 1),
('MTE0010', 'P43', 'Kualitas Daya Listrik', 3),
('MTE0011', 'P43', 'Demand Side Management', 3),
('MTE0012', 'P43', 'SCADA', 3),
('MTE0013', 'P43', 'Operasi Ekonomi Sistem Tenaga Listrik', 3),
('MTE0014', 'P43', 'Analisa Sistem Tenaga Listrik', 3),
('MTE0015', 'P43', 'Perancangan Sistem Digital', 3),
('MTE0016', 'P43', 'Sistem Mikrokontroler', 3),
('MTE0017', 'P43', 'Elektronika Terapan', 3),
('MTE0018', 'P43', 'Jaringan Komputer', 3),
('MTE0019', 'P43', 'Instrumentasi Medis', 3),
('MTE0020', 'P43', 'Data Mining dan Business Intelligence', 3),
('MTE0021', 'P43', 'Manajemen Sistem Informasi', 3),
('MTE0022', 'P43', 'Jaringan Komputer', 3),
('MTE0023', 'P43', 'Software Engineering', 3),
('MTE0024', 'P43', 'Image Processing', 3),
('MTE0025', 'P43', 'Teknik Pengukuran Alat Medis', 3),
('MTE0026', 'P43', 'Teknik Diagnostik & Teknologi Terapi Medis', 3),
('MTE0027', 'P43', 'Teknik Robotika Medis & Bio Mekanis', 3),
('MTE0028', 'P43', 'Biomedical Informatics', 3),
('MTE0029', 'P43', 'Pengolahan Citra Medis', 3),
('MTE0030', 'P43', 'Epistemology Islam', 2),
('MTE0031', 'P43', 'Islamic World View', 2),
('SBB62071', 'P32', 'PERBANDINGAN HUKUM KELUARGA ISLAM', 2),
('SKB22061', 'P32', 'HUKUM PERDATA BENDA / P1', 2),
('SKB22062', 'P32', 'HUKUM PERDATA TERIKATAN / P2', 2),
('SKB42042', 'P32', 'FIQH MUNAKAHAT', 2),
('SKB42043', 'P32', 'FIQH MAWARIS', 2),
('SKB42047', 'P32', 'HUKUM ACARA PERADILAN AGAMA', 2),
('SKB42049', 'P32', 'HUKUM PERKAWINAN ISLAM DI INDONESIA', 2),
('SKB42057', 'P32', 'HUKUM ACARA PIDANA', 2),
('SKB62044', 'P32', 'FIQH JINAYAH', 2),
('SKB62052', 'P32', 'PRAKTEK PERADILAN (PPL)', 2),
('SKB62053', 'P32', 'QOWAIDUL FIQHIYAH', 2),
('SKB62056', 'P32', 'SOSIOLOGI HUKUM ISLAM', 2),
('SKB62058', 'P32', 'PERADILAN TATA USAHA NEGARA', 2),
('SKB62063', 'P32', 'PERADILAN MILITER', 2),
('SKB72045', 'P32', 'FIQH SIYASAH', 2),
('SKB82054', 'P32', 'SKRIPSI', 6),
('SKK12033', 'P32', 'ILMU KALAM', 2),
('SKK22017', 'P32', 'ULUMUL QUR\'AN', 2),
('SKK22018', 'P32', 'ULUMUL HADIS', 2),
('SKK22020', 'P32', 'FILSAFAT', 2),
('SKK22023', 'P32', 'SEJARAH PERADILAN ISLAM', 2),
('SKK22028', 'P32', 'PERADILAN AGAMA DI INDONESIA', 2),
('SKK42015', 'P32', 'USHUL FIQH II', 2),
('SKK42036', 'P32', 'TAFSIR AHKAM I', 2),
('SKK42037', 'P32', 'HADIS AHKAM I', 2),
('SKK52032', 'P32', 'STUDI NASKAH FIQH II', 2),
('SKK62029', 'P32', 'ILMU FALAK', 2),
('SKK62030', 'P32', 'BIMBINGAN PENULISAN ILMIAH', 2),
('SKP22007', 'P32', 'BAHASA INGGRIS II', 2),
('SKP22010', 'P32', 'BAHASA ARAB II', 2),
('SKP22014', 'P32', 'ISLAMIC WORDLVIEW', 2),
('SKP22022', 'P32', 'IAD & IBD', 2),
('SKP42012', 'P32', 'BAHASA ARAB IV', 2),
('SKP52004', 'P32', 'BAHASA INDONESIA', 2),
('SPB22065', 'P32', 'TEKNOLOGI INFORMASI', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mengajar`
--

CREATE TABLE `mengajar` (
  `id_mengajar` int NOT NULL,
  `id_fakultas` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_mk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nidn` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_akademik` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mengajar`
--

INSERT INTO `mengajar` (`id_mengajar`, `id_fakultas`, `id_prodi`, `kode_mk`, `nidn`, `tahun_akademik`, `semester`) VALUES
(1, 'F01', 'P40', 'IC216009001', '100001', '2024/2025', 'Ganjil'),
(2, 'F01', 'P40', 'IC236008026', '100002', '2024/2025', 'Ganjil'),
(3, 'F01', 'P40', 'IC236008006', '100003', '2024/2025', 'Ganjil'),
(4, 'F01', 'P40', 'IC216209014', '100004', '2024/2025', 'Ganjil'),
(5, 'F01', 'P42', 'IF216009069', '100005', '2024/2025', 'Ganjil'),
(6, 'F01', 'P42', 'IF216009071', '100006', '2024/2025', 'Ganjil'),
(7, 'F01', 'P42', 'IF246008018', '100007', '2024/2025', 'Ganjil'),
(8, 'F01', 'P42', 'IF216008058', '100008', '2024/2025', 'Ganjil'),
(9, 'F01', 'P42', 'IF216019076', '100009', '2024/2025', 'Ganjil'),
(10, 'F01', 'P42', 'IF6008023', '100009', '2024/2025', 'Genap');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `id_fakultas` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_prodi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenjang` enum('Profesi','D3','S1','S2','S3') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `id_fakultas`, `nama_prodi`, `jenjang`) VALUES
('P01', 'F03', 'Kedokteran Umum', 'S1'),
('P02', 'F03', 'Profesi Dokter', 'Profesi'),
('P03', 'F03', 'Magister Biomedik', 'S2'),
('P04', 'F03', 'Doktor Ilmu Biomedis', 'S3'),
('P05', 'F04', 'Kedokteran Gigi', 'S1'),
('P06', 'F04', 'Profesi Dokter Gigi', 'Profesi'),
('P07', 'F04', 'Magister Ilmu Kedokteran Gigi', 'S2'),
('P08', 'F05', 'Farmasi', 'S1'),
('P09', 'F05', 'Profesi Apoteker', 'Profesi'),
('P10', 'F05', 'Kebidanan', 'S1'),
('P11', 'F05', 'Profesi Bidan', 'Profesi'),
('P12', 'F02', 'Teknik Sipil', 'S1'),
('P13', 'F02', 'Perencanaan Wilayah & Kota', 'S1'),
('P14', 'F02', 'Magister Teknik Sipil', 'S2'),
('P15', 'F02', 'Doktor Teknik Sipil', 'S3'),
('P16', 'F06', 'Ilmu Hukum', 'S1'),
('P17', 'F06', 'Magister Ilmu Hukum', 'S2'),
('P18', 'F06', 'Magister Kenotariatan', 'S2'),
('P19', 'F06', 'Doktor Ilmu Hukum', 'S3'),
('P20', 'F11', 'Pendidikan Bahasa Inggris', 'S1'),
('P21', 'F11', 'Sastra Inggris', 'S1'),
('P22', 'F06', 'Manajemen', 'S1'),
('P23', 'F06', 'Akuntansi', 'S1'),
('P24', 'F06', 'Akuntansi(D3)', 'D3'),
('P25', 'F06', 'Magister Manajemen', 'S2'),
('P26', 'F06', 'Magister Akuntansi', 'S2'),
('P27', 'F06', 'Doktor Ilmu Manajemen', 'S3'),
('P28', 'F12', 'Ilmu Keperawatan', 'S1'),
('P29', 'F12', 'Profesi Ners', 'Profesi'),
('P30', 'F12', 'Keperawatan', 'D3'),
('P31', 'F12', 'Magister Keperawatan', 'S2'),
('P32', 'F09', 'Tarbiyah', 'S1'),
('P33', 'F09', 'Syari’ah', 'S1'),
('P34', 'F09', 'Magister Pend. Agama Islam', 'S2'),
('P35', 'F08', 'Pendidikan Matematika', 'S1'),
('P36', 'F08', 'Pendidikan Bahasa dan Sastra Indonesia', 'S1'),
('P37', 'F08', 'Pendidikan Guru Sekolah Dasar', 'S1'),
('P38', 'F08', 'Pendidikan Profesi Guru', 'Profesi'),
('P39', 'F08', 'Magister Pendidikan Dasar', 'S2'),
('P40', 'F01', 'Teknik Elektro', 'S1'),
('P41', 'F01', 'Teknik Industri', 'S1'),
('P42', 'F01', 'Teknik Informatika', 'S1'),
('P43', 'F01', 'Magister Teknik Elektro', 'S2'),
('P44', 'F10', 'Ilmu Komunikasi', 'S1'),
('P45', 'F07', 'Psikologi', 'S1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','operator') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', '$2y$10$sBNPkG3hVzSPygK.b7XCseejBpHEioV150Ef4MPPvk5.dfZNlwpPS', 'Administrator Web', 'admin'),
(2, 'danu123', '$2y$10$Urb4pmUAlE7NpSEJFyTCOOW1iaadpGNhzCkdtJijhRovo3fGOvHtO', 'Danu', 'operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nidn`),
  ADD KEY `fk_dosen_prodi` (`id_prodi`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kode_mk`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indexes for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id_mengajar`),
  ADD KEY `id_fakultas` (`id_fakultas`),
  ADD KEY `id_prodi` (`id_prodi`),
  ADD KEY `kode_mk` (`kode_mk`),
  ADD KEY `nidn` (`nidn`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `id_fakultas` (`id_fakultas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id_mengajar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `fk_dosen_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`);

--
-- Constraints for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD CONSTRAINT `matakuliah_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`);

--
-- Constraints for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD CONSTRAINT `mengajar_ibfk_1` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`),
  ADD CONSTRAINT `mengajar_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`),
  ADD CONSTRAINT `mengajar_ibfk_3` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliah` (`kode_mk`),
  ADD CONSTRAINT `mengajar_ibfk_4` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`);

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_ibfk_1` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
