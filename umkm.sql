-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 08:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sig_umkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `umkm`
--

CREATE TABLE `umkm` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_pengusaha` varchar(100) DEFAULT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `alamat` text NOT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `sektor` varchar(100) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `umkm`
--

INSERT INTO `umkm` (`id`, `user_id`, `nama`, `nama_pengusaha`, `no_hp`, `alamat`, `kecamatan`, `sektor`, `latitude`, `longitude`, `foto`, `status`) VALUES
(50, 1, 'Sewa Speaker', 'Sutrisno Nizar', '6281999407250', 'Nong pote RT/RW 003, 003, Nongpoto, Pragaan Daya, Kec. Pragaan, Kabupaten Sumenep, Jawa Timur 69465', 'Pragaan', 'Jasa', -7.0500420, 113.6669789, '1753932497_thumbnail.jpeg', 'aktif'),
(52, 1, 'Warung Makan Sukses', 'H. Muntasir', '6281999407250', '4P5R+2HJ, Jung Torok Laok, Ambunten Tim., Kec. Ambunten, Kabupaten Sumenep, Jawa Timur 69455', 'Ambunten', 'Pengolahan', -6.8921595, 113.7413957, '1754900326_sukses.jpg', 'aktif'),
(53, 14, 'MYZE Hotel Sumenep', '-', '6285755773417', 'Jl. Arya Wiraraja, Gedungan Timur, Gedungan, Kec. Batuan, Kabupaten Sumenep, Jawa Timur 69451', 'Batuan', 'Jasa', -7.0202809, 113.8553469, '1754900263_hotel.jpg', 'aktif'),
(54, 14, 'Service HP ,alat elektronik,printing,,dll', 'Muksin', '6281999407250', 'Pasar, Bujaan, Lapa Laok, Kec. Dungkek, Kabupaten Sumenep, Jawa Timur', 'Dungkek', 'Jasa', -6.9733477, 114.1066487, '1754900826_service.jpg', 'aktif'),
(55, 8, 'Bengkel Motor', 'Junaidi', '6285755773417', '3RCF+47W, Jalan Raya, Beringin Tengah, Bringin, Dasuk, Sumenep Regency, East Java 69454', 'Dasuk', 'Jasa', -6.9288856, 113.8232292, '1754900177_beng.jpeg', 'aktif'),
(56, 8, 'Warung Pentol Narkoba', 'Siti Aminah', '6285755773417', '4P7Q+JQW, Desa Ambunten Timur, Pragaan, Jung Torok Laok, Ambunten Tim., Kec. Ambunten, Kabupaten Sumenep, Jawa Timur 69455', 'Ambunten', 'Pengolahan', -6.8856368, 113.7394490, '1754900430_narkoba.jpg', 'aktif'),
(57, 8, 'Mixue Sumenep', '-', '6281999407250', 'Jl. Halim Perdana Kusuma No.42, Ps. Sore, Karangduak, Kec. Kota Sumenep, Kabupaten Sumenep, Jawa Timur 69417', 'Kota Sumenep', 'Pengolahan', -7.0047943, 113.8604180, '1754900195_mixue.jpg', 'aktif'),
(58, 8, 'Toko D & R', '-', '6285755773417', 'XVJ5+HGW, Labangseng, Kolor, Kec. Kota Sumenep, Kabupaten Sumenep, Jawa Timur 69417', 'Kota Sumenep', 'Perdagangan', -7.0176318, 113.8588965, '1754900490_dnr.jpg', 'aktif'),
(59, 7, 'Toko Barokah ', 'H.samsul Arifin', '6285755773417', 'XPW4+2FV, Gadu Timur, Gadu Tim., Kec. Ganding, Kabupaten Sumenep, Jawa Timur 69462', 'Ganding', 'Perdagangan', -7.0008682, 113.7058675, '1754900515_barokah.jpg', 'aktif'),
(60, 7, 'Budidaya Lele', 'Wijaya', '6285755773417', 'Guluk Guluk Timur I, Guluk-guluk, Guluk-Guluk, Sumenep Regency, East Java 69463', 'Guluk-Guluk', 'Perikanan', -7.0456226, 113.6754044, '1754900215_lele.jpg', 'aktif'),
(61, 7, 'Budidaya Sayur Selada Hidroponik', 'Siti Aisyah', '6285755773417', 'XQGC+FH9, Samundung Utara, Lenteng Tim., Kec. Lenteng, Kabupaten Sumenep, Jawa Timur 69461', 'Lenteng', 'Pertanian', -7.0078751, 113.7717533, '', 'aktif'),
(62, 7, 'Warung Bakso ', 'Nari', '6281999407250', '22RJ+87P, Kalompang, Jenangger, Kec. Batang Batang, Kabupaten Sumenep, Jawa Timur 69473', 'Batang Batang', 'Pengolahan, Perdagangan', -6.9267880, 114.0283581, '1754459958_baksonari.jpeg', 'aktif'),
(63, 7, 'UD kejing trasu barokah jaya', 'Mogar', '6281999407250', 'Tajjan, Slopeng, Dasuk, Sumenep Regency, East Java 65446', 'Dasuk', 'Kerajinan', -6.8897295, 113.7902327, '1754900393_kejing.jpg', 'Aktif'),
(64, 11, 'Peternak Puyuh ', 'Zubairi', '6281999407250', '3P24+MHP, Unnamed Road, Ares Tengah, Rajun, Kec. Pasongsongan, Kabupaten Sumenep, Jawa Timur 69457', 'Pasongsongan', 'Peternakan', -6.9423172, 113.7068009, '', 'aktif'),
(66, 8, 'Peternakan ayam jago', 'Rahmat', '6285755773417', '3QWR+JX, Tenggina, Slopeng, Kec. Dasuk, Kabupaten Sumenep, Jawa Timur', 'Dasuk', 'Peternakan', -6.9026662, 113.7921263, '1754900755_ayam.jpg', 'aktif'),
(67, 8, 'PENTOL TAYO ', 'ILHAM', '6285755773417', '3VGR+P3G, Marang, Larangan Barma, Kec. Batuputih, Kabupaten Sumenep, Jawa Timur 69453', 'Batuputih', 'Pengolahan, Perdagangan', -6.9219620, 113.8902944, '1754713759_pentol.jpg', 'aktif'),
(68, 8, 'Warung Seblak ', 'Mama Ghina', '6281999407250', 'Jl. Kh. Mahmud Arbaiyah, Jangger Timur, Gading, Kec. Manding, Kabupaten Sumenep, Jawa Timur 69452', 'Manding', 'Pengolahan', -6.9481937, 113.9189855, '', 'aktif'),
(69, 8, 'Cafe Arassa', '-', '6285755773417', 'Dusun, Penang cangka, Aeng Merah, Kec. Batuputih, Kabupaten Sumenep, Jawa Timur 69453', 'Batuputih', 'Perdagangan', -6.9522116, 113.9471004, '1754900139_arassa.jpg', 'aktif'),
(70, 9, 'Pedagang kelapa muda dan kelapa hijau', 'Norrahman', '6285755773417', 'Banyuraba, East Banuaju, Batang Batang, Sumenep Regency, East Java', 'Batang Batang', 'Perdagangan, Pertanian', -6.9339249, 114.0228891, '', 'aktif'),
(71, 9, 'Pabrik Tahu ', 'Bela dan Warli', '6285755773417', 'V934+CX7, jln raya kodas, desa, Koattas, Prambanan, Kec. Gayam, Kabupaten Sumenep, Jawa Timur 69483', 'Gayam', 'Pengolahan', -7.1451944, 114.3575681, '1754900304_tahu.jpg', 'aktif'),
(72, 9, 'Bakso Barokah', 'Lia', '6281999407250', 'V832+M29, Banasen, Kaloang, Kec. Gayam, Kabupaten Sumenep, Jawa Timur 69483', 'Gayam', 'Pengolahan', -7.1446452, 114.3003156, '1754900056_baksopaklia.jpg', 'aktif'),
(73, 13, 'Toko sembako ', 'Rahmani', '6281999407250', 'VF5W+QFP, Noko, Ketupat, Raas, Kabupaten Sumenep, Jawa Timur 69485', 'Raas', 'Perdagangan', -7.1382446, 114.4962898, '1754900414_toko.jpg', 'aktif'),
(74, 13, 'Syaif collektion', 'Syaif', '6285755773417', 'VF3W+PC4, Jln.Raya Desa, Kranji, Ketupat, Raas, Kabupaten Sumenep, Jawa Timur 69485', 'Raas', 'Kerajinan', -7.1449556, 114.4960683, '1754900576_syaif.jpg', 'aktif'),
(75, 13, 'Toko Rico Rivaldi', ' Rico Rivaldi', '6281999407250', 'VG5G+CCJ, Unnamed Road, Jl. Arjuns community, jungkat selatan, Jungkat Selatan, Jungkat, Raas, Kabupaten Sumenep, Jawa Timur 69485', 'Raas', 'Perdagangan', -7.1406728, 114.5260281, '1754900800_tokoriko.jpg', 'aktif'),
(76, 13, 'Rumah Bakso & Mie Ayam Kampoeng Bandalam', 'Samina', '6285755773417', 'Jalan Raya No.3, RT.003/RW.4, Kropoh, Bendelem, Raas, Kabupaten Sumenep, Jawa Timur 69485', 'Raas', 'Pengolahan', -7.1320322, 114.5453832, '1754900914_mieayam.jpg', 'aktif'),
(77, 13, 'Warung Inul Bakso Beranak + Loundry Jannah', 'Ainul', '6285755773417', 'VH6H+JHV, Unnamed Road, Koong, Alasmalang, Raas, Kabupaten Sumenep, Jawa Timur 69485', 'Raas', 'Jasa, Pengolahan', -7.1375207, 114.5788805, '1754900548_inul.jpg', 'aktif'),
(78, 14, 'Becak Hias ', 'Sunawi', '6281999407250', '4P7Q+67W, Jung Torok Laok, Ambunten Tim., Kec. Ambunten, Kabupaten Sumenep, Jawa Timur 69455', 'Ambunten', 'Jasa', -6.8866121, 113.7383332, '1754899930_becak.jpg', 'aktif'),
(79, 14, 'Fieya Beauty & Fashion', 'Silfieya', '6281999407250', 'Jalan raya, Jung Torok Dejeh, Ambunten Tim., partelon, Kabupaten Sumenep, Jawa Timur 69455', 'Ambunten', 'Perdagangan', -6.8882138, 113.7445382, '1754900667_fiya.jpg', 'aktif'),
(80, 14, 'Toko Monalisa', 'Lisa', '6285755773417', 'Jl. Raya Semeru No. 1, Aenganyar, Kec. Giligenteng, Kabupaten Sumenep, Jawa Timur 69482', 'Giligenting', 'Perdagangan', -7.1834040, 113.8980004, '1754900595_monalisa.jpg', 'aktif'),
(81, 14, 'Sempol Ayam', 'Kafilatul Faizah', '6281999407250', 'QWWM+R4X, Jalan Raya, Aenggedang, Gedugan, Giligenteng, Sumenep Regency, East Java 69482', 'Giligenting', 'Pengolahan', -7.2023549, 113.9328336, '1754900713_kafa.jpg', 'aktif'),
(82, 14, 'Sate Taichan Fourbut', 'Abdur', '6281999407250', 'QQJ8+XF5, Kamadu, Banmaleng, Kec. Giligenteng, Kabupaten Sumenep, Jawa Timur 69482', 'Giligenting', 'Pengolahan', -7.2161510, 113.7667452, '1754900350_sate.jpg', 'aktif'),
(83, 14, 'Warung Bakso ', 'Mama Alif', '6281999407250', 'VQFF+RRP, Unnamed Road, Goa-daja, Gua-gua, Raas, Kabupaten Sumenep, Jawa Timur 69492', 'Raas', 'Pengolahan', -7.1247796, 114.7748504, '1754901003_baksoraas.jpg', 'aktif'),
(84, 7, 'ELA Makeup & Decoration', 'Laila', '6281999407250', '2Q3F+4H3, Banyuliang, Mandala, Kec. Rubaru, Kabupaten Sumenep, Jawa Timur 69456', 'Rubaru', 'Jasa', -6.9822749, 113.7731695, '1754718844_mua.jpg', 'aktif'),
(85, 7, 'Yuri Event Organizer', 'Yurianti', '6285755773417', 'WQHW+89C, Ares Timur, Talang, Kec. Saronggi, Kabupaten Sumenep, Jawa Timur 69467', 'Saronggi', 'Jasa', -7.0601120, 113.7954023, '1754719014_yuri.jpg', 'aktif'),
(86, 7, 'Kebun Benih Hortikultira ', 'Salma', '6285755773417', 'Bates Timur, Ellak Daya, Lenteng, Sumenep Regency, East Java 69461', 'Lenteng', 'Pertanian', -7.0103925, 113.7886103, '1754719558_hortikula.jpg', 'aktif'),
(87, 7, 'Kebun Durian Kacong Tani', '-', '6281999407250', 'Kaleleng, Matanair, Rubaru, Sumenep Regency, East Java 69456', 'Rubaru', 'Pertanian', -6.9662321, 113.8287181, '', 'aktif'),
(88, 7, 'Herlinda Homestay', 'Herlinda', '6281999407250', 'Dsn. Nyangkreng, Arjasa, Sumenep Regency, East Java 69491', 'Arjasa', 'Jasa', -6.8560587, 115.2901488, '1754720292_homstay.jpg', 'aktif'),
(89, 7, 'TOKO ABIL', 'Abil', '6285755773417', '3HV2+G7R, Bondat, Kangayan, Kec. Kangayan, Kabupaten Sumenep, Jawa Timur 69491', 'Kangayan', 'Perdagangan', -6.9051008, 115.5508688, '', 'aktif'),
(90, 7, 'Ayam geprek ', 'Yana', '6285755773417', 'RRCQ+GW, Sepanjang, Kec. Sapeken, Kabupaten Sumenep, Jawa Timur 69493', 'Sapeken', 'Pengolahan', -7.0634579, 113.6738205, '', 'Aktif'),
(91, 7, 'Warung Nasi Ibu Hukmi', 'Ibu Hukmi', '6281999407250', 'RQFP+739, Sepanjang, Kec. Sapeken, Kabupaten Sumenep, Jawa Timur 69493', 'Sapeken', 'Pengolahan', -7.1759127, 115.7853586, '1754720942_nasi.jpg', 'aktif'),
(92, 1, 'Kebun Sukun', 'Samsul', '6285755773417', '2VRG+GH, Tj. Pagar, Pagerungan Kecil, Kec. Sapeken, Kabupaten Sumenep, Jawa Timur', 'Sapeken', 'Pertanian', -6.9587075, 115.8764076, '1754721498_kebun.jpg', 'Aktif'),
(93, 11, 'Barokah baru farm sumenep', 'Angsar', '6285755773417', '2VCQ+VV3, Tenonan Barat, Tenunan, Kec. Manding, Kabupaten Sumenep, Jawa Timur 69452', 'Manding', 'Peternakan', -6.9462414, 113.8916766, '1754722525_barokahfarm.jpg', 'aktif'),
(94, 11, 'KIDAS PETERNAKAN AYAM ', 'Darmo', '6285755773417', 'Belakang kantor ninja xpres Dusun Aeng Parao, Area Hutan, Arjasa, Kabupaten Sumenep, Jawa Timur 69491', 'Arjasa', 'Peternakan', -6.8358084, 115.2869403, '1754722789_ternakayam.jpg', 'aktif'),
(95, 11, 'Madura Pusaka', 'Mohammad', '6285755773417', 'Jalan Raya Cemara, Cemara, Nambakor, Kec. Saronggi, Kabupaten Sumenep, Jawa Timur 69467', 'Saronggi', 'Kerajinan', -7.0211940, 113.8408341, '1754723209_pusaka.jpg', 'aktif'),
(96, 11, 'Imra J-na Dekorasi Buket dan Gift Box', 'Imraatul Hasanah', '6281999407250', 'XR63+HV2, Meddelan Barat, Meddelan, Kec. Lenteng, Kabupaten Sumenep, Jawa Timur 69461', 'Lenteng', 'Kerajinan', -7.0199414, 113.8036599, '1754724487_imra.jpg', 'aktif'),
(97, 7, 'Madyaf Cafe cabang Ganding', '-', '6281999407250', 'XM4V+23P, Talambung Laok, Ketawang Karay, Kec. Ganding, Kabupaten Sumenep, Jawa Timur', 'Ganding', 'Pengolahan', -7.0441792, 113.6927081, '1755003707_madyafganding.jpg', 'aktif'),
(98, 1, 'Kafe lele', 'Suki', '6285755773417', 'XMJQ+887, Unnamed Road, Mandala Timur, Gadu Bar., Kec. Ganding, Kabupaten Sumenep, Jawa Timur 69462', 'Ganding', 'Perikanan', -7.0184145, 113.6883280, '1755003854_kafelele.jpg', 'aktif'),
(99, 7, 'Pentol Maknyos', 'Bindes', '6285755773417', 'Pasar baru, Ambunten tengah, Ambunten, sumenep', 'Ambunten', 'Pengolahan', -6.8899554, 113.7391988, '', 'aktif'),
(100, 13, 'Koperasi Lubangsa', 'Lubnagsa', '6285755773417', 'Jl. PP.Annuqayah Guluk, Guluk Guluk Timur I, Guluk-guluk, Kec. Guluk-Guluk, Kabupaten Sumenep, Jawa Timur 69463', 'Guluk-Guluk', 'Perdagangan', -7.0657375, 113.6721383, '1755180205_koperasilubangsa.jpg', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `umkm`
--
ALTER TABLE `umkm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `umkm`
--
ALTER TABLE `umkm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `umkm`
--
ALTER TABLE `umkm`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
