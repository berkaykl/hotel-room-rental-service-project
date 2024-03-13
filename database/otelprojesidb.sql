-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3307
-- Üretim Zamanı: 21 Oca 2024, 15:18:53
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `otelprojesidb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kayitli_kullanicilar`
--

CREATE TABLE `kayitli_kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_isim` varchar(30) NOT NULL,
  `kullanici_soyisim` varchar(30) NOT NULL,
  `kullanici_email` varchar(50) NOT NULL,
  `kullanici_telno` int(15) NOT NULL,
  `kullanici_dogumtarihi` date NOT NULL,
  `kullanici_sifre` varchar(50) NOT NULL,
  `eklenme_tarihi` date DEFAULT curdate(),
  `isAdmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kayitli_kullanicilar`
--

INSERT INTO `kayitli_kullanicilar` (`kullanici_id`, `kullanici_isim`, `kullanici_soyisim`, `kullanici_email`, `kullanici_telno`, `kullanici_dogumtarihi`, `kullanici_sifre`, `eklenme_tarihi`, `isAdmin`) VALUES
(3, 'Berkay', 'Kol', 'berkay.kol@bilgiedu.net', 2147483647, '2005-07-11', 'berkay123', '2024-01-21', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `otel_bilgileri`
--

CREATE TABLE `otel_bilgileri` (
  `otel_logo_url` varchar(200) NOT NULL,
  `otel_telno` int(11) NOT NULL,
  `otel_adres` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `otel_bilgileri`
--

INSERT INTO `otel_bilgileri` (`otel_logo_url`, `otel_telno`, `otel_adres`) VALUES
('https://cdn.discordapp.com/attachments/913942781498630157/1188257981561847818/oelogofarkli2.png?ex=6599de7b&is=6587697b&hm=7c19136dd9eba5d2bfbd067aebf9a99da3294a39c4a1f941da943f3f6d610ee2&', 123456789, 'Akasya Mahallesi, Menekşe Caddesi, Morova Sokak, No:1121, İstanbul/Ataşehir');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `otel_musteriler`
--

CREATE TABLE `otel_musteriler` (
  `musteri_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `musteri_isim` varchar(30) DEFAULT NULL,
  `musteri_soyisim` varchar(30) DEFAULT NULL,
  `musteri_telno` int(15) DEFAULT NULL,
  `musteri_oda` int(11) DEFAULT NULL,
  `musteri_eklenme` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `otel_musteriler`
--

INSERT INTO `otel_musteriler` (`musteri_id`, `kullanici_id`, `musteri_isim`, `musteri_soyisim`, `musteri_telno`, `musteri_oda`, `musteri_eklenme`) VALUES
(1, 3, 'Berkay', 'Kol', 2147483647, 3, '2024-01-21'),
(2, 3, 'Berkay', 'Kol', 2147483647, 4, '2024-01-21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `otel_odalari`
--

CREATE TABLE `otel_odalari` (
  `oda_id` int(11) NOT NULL,
  `oda_isim` varchar(100) NOT NULL,
  `oda_adres` varchar(100) NOT NULL,
  `oda_aciklama` text NOT NULL,
  `oda_degerlendirme` bigint(11) NOT NULL,
  `oda_oylama` decimal(10,1) NOT NULL,
  `oda_gorsel` varchar(255) DEFAULT NULL,
  `oda_fiyat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `otel_odalari`
--

INSERT INTO `otel_odalari` (`oda_id`, `oda_isim`, `oda_adres`, `oda_aciklama`, `oda_degerlendirme`, `oda_oylama`, `oda_gorsel`, `oda_fiyat`) VALUES
(1, 'Grand Hotel', '123 Main Street, New York, ABD', 'Rahat ve modern bir konaklama deneyimi sunan odalarımızda ücretsiz Wi-Fi, düz ekran TV ve minibar bulunmaktadır. Şık dekorasyon ve konforlu yataklarla unutulmaz bir konaklama imkanı sunuyoruz.', 657, 6.4, 'https://cdn.discordapp.com/attachments/913942781498630157/1198606185901854810/photo-1611892440504-42a792e24d32.png?ex=65bf83ff&is=65ad0eff&hm=7cd46914dc66a75d9dab9cf95deba7cc03d34a31a71917e43319deae729f0c5c&', 1500),
(2, 'Sea Breeze Resort', '456 Ocean Avenue Miami ABD', 'Deniz manzaralı lüks odalarımızda dinlenmek için ideal bir ortam sunuyoruz. Özel balkonlardan gün batımını izleyebilir ve plaja sadece birkaç adımla ulaşabilirsiniz. Konforlu yataklar ve modern olanaklarla donatılmıştır.', 713, 3.1, 'https://cdn.discordapp.com/attachments/913942781498630157/1198606742926405652/miami-florida-hotel-room-wallpaper-preview.png?ex=65bf8484&is=65ad0f84&hm=8ff62d0b4ce05985b7c5862021a505990b617005f50d82e87b286f7a48e59960&', 2000),
(3, 'Mountain Lodge', '789 Pine Road Alpler İsviçre', 'Dağ manzaralı şirin odalarımızda doğanın tadını çıkarabilirsiniz. Rustik tarzda dekore edilmiş odalarımızda şömine, ahşap mobilyalar ve rahat koltuklar bulunmaktadır. Serin dağ havası ve huzurlu bir atmosfer sunuyoruz.', 552, 9.3, 'https://cdn.discordapp.com/attachments/913942781498630157/1198606835280777237/pngtree-bedroom-guest-room-five-star-hotel-image_990205.png?ex=65bf849a&is=65ad0f9a&hm=3ff4a4c1bf612cdfac991562173ba3942bfefb19d50624cc5474318c13bb3428&', 2500),
(4, 'City Lights Hotel', '321 Downtown Avenue Paris Fransa', 'Şehir merkezinde yer alan otelimizde konforlu ve modern odalar sunuyoruz. Konuklarımıza ücretsiz kahvaltı, fitness merkezi ve 24 saat resepsiyon hizmeti sağlıyoruz. Şehrin tarihi ve turistik yerlerine kolay erişim imkanı sunmaktayız.', 1161, 3.1, 'https://cdn.discordapp.com/attachments/913942781498630157/1198606999886245898/360_F_271082810_CtbTjpnOU3vx43ngAKqpCPUBx25udBrg.png?ex=65bf84c1&is=65ad0fc1&hm=111c8a675e2b1c5344ab6d0663e43f7d3dcee6a1315182146c8d2151b1fa3019&', 1800),
(5, 'Paradise Beach Resort', '987 Palm Street Maldivler', 'Beyaz kumlu plajlara sahip olan tatil köyümüzde rüya gibi bir konaklama deneyimi yaşayabilirsiniz. Lüks bungalov odalarımızda özel havuz, deniz manzarası ve jakuzi bulunmaktadır. Doğal güzellikleriyle kendinizi şımartın.', 386, 8.8, 'https://cdn.discordapp.com/attachments/913942781498630157/1198607044773683250/photo-1618773928121-c32242e63f39.png?ex=65bf84cc&is=65ad0fcc&hm=f317fe639613a9ae5ec7c03f8d6a703c170f7099f5282b4d80bfd9f48c3b420c&', 3000),
(6, 'Alpine Retreat', '654 Snowy Lane, İsviçre Alpleri', 'Alp dağlarının eteklerinde yer alan otelimizde huzurlu bir tatil sunuyoruz. Şık ve modern dağ evi tarzında dekore edilmiş odalarımızda panoramik manzaralar, şömine ve spa küveti bulunmaktadır. Doğa ile iç içe bir konaklama deneyimi yaşayın.', 278, 7.5, 'https://cdn.discordapp.com/attachments/913942781498630157/1198607089086505041/HD-wallpaper-hotel-room-hotel-beautiful-art-house-romantic-black-yellow-luxury-rooms-bedrooms-decor-nice-beige-style.png?ex=65bf84d7&is=65ad0fd7&hm=b0b11c4305918a6432c2adbb1f6c8', 3000),
(7, 'Royal Palace Hotel', '543 Kings Road Londra İngiltere', 'Kraliyet tarzında dekore edilmiş zarif odalarımızda lüks ve rahat bir konaklama sunuyoruz. Antika mobilyalar, kristal avizeler ve özel banyolarla donatılmış odalarımızda kusursuz bir konfor sağlıyoruz. Şehir merkezine yakın konumda yer almaktayız.', 565, 4.9, 'https://cdn.discordapp.com/attachments/913942781498630157/1198607379957284934/photo-1631049307264-da0ec9d70304.png?ex=65bf851c&is=65ad101c&hm=a7cd17a182a6457c802282878ba3dfd9ad542775d7cd72e84dde58430f13e4ae&', 2800),
(8, 'Tropical Oasis Resort', '432 Palm Tree Avenue Bali Endonezya', 'Tropikal bahçelerle çevrili plaja yakın lüks odalar. Özel plaj erişimi, su sporları aktiviteleri ve rahatlatıcı spa olanakları mevcuttur.', 855, 7.5, 'https://cdn.discordapp.com/attachments/913942781498630157/1198607126357090423/b15f257289f1d06d0e4dd4fc332de429.png?ex=65bf84df&is=65ad0fdf&hm=496b9ab5c2d61cda2fbe30a7992dc7c7dd3929074a64b002ef496875bb837211&', 2500),
(9, 'Sunset Hotel', '1234 Elm Street Anytown ABD ', 'Doğal güzelliklere sahip dağ manzaralı odalar. Şömine, ahşap dekorasyon ve yürüme parkurlarıyla çevrili konforlu bir konaklama.', 587, 2.5, 'https://cdn.discordapp.com/attachments/913942781498630157/1198607161740238929/HD-wallpaper-bedroom-hotel-room-light-design-modern-apartment-interior-idea-modern-design.png?ex=65bf84e8&is=65ad0fe8&hm=50be887256b74f572b7e37886f9dd2503a6e595de230129406a7e80a', 2350),
(10, 'City Center Hotel', '3456 Main Boulevard Downtown', 'Şehir merkezinde yer alan modern ve şık odalar. Restoranlar, alışveriş merkezleri ve turistik yerlere yakın konumda. Dilediğiniz gibi tadını çıkarın.', 491, 4.2, 'https://cdn.discordapp.com/attachments/913942781498630157/1198607290870280303/desktop-wallpaper-high-quality-hotel-room-luxury-hotel.png?ex=65bf8507&is=65ad1007&hm=22767a5655273822147b9775ac5dad9be5c485155b20cc29d7c99c550eac7184&', 2150);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kayitli_kullanicilar`
--
ALTER TABLE `kayitli_kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `otel_musteriler`
--
ALTER TABLE `otel_musteriler`
  ADD PRIMARY KEY (`musteri_id`),
  ADD KEY `test` (`musteri_oda`),
  ADD KEY `test2` (`kullanici_id`);

--
-- Tablo için indeksler `otel_odalari`
--
ALTER TABLE `otel_odalari`
  ADD PRIMARY KEY (`oda_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kayitli_kullanicilar`
--
ALTER TABLE `kayitli_kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `otel_musteriler`
--
ALTER TABLE `otel_musteriler`
  MODIFY `musteri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `otel_odalari`
--
ALTER TABLE `otel_odalari`
  MODIFY `oda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `otel_musteriler`
--
ALTER TABLE `otel_musteriler`
  ADD CONSTRAINT `test` FOREIGN KEY (`musteri_oda`) REFERENCES `otel_odalari` (`oda_id`),
  ADD CONSTRAINT `test2` FOREIGN KEY (`kullanici_id`) REFERENCES `kayitli_kullanicilar` (`kullanici_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
