<?php

    include("config.php");



    //KAYIT SAYFASINDAKİ OTEL BİLGİLERİ
    foreach($db->query("SELECT * FROM otel_bilgileri") as $otelbilgi) {
        $otelAdres = $otelbilgi["otel_adres"];
        $otelTelNo = $otelbilgi["otel_telno"];
        $otelLogoURL = $otelbilgi["otel_logo_url"];
    }



    class kullanici {
        
        public function kullaniciEkle($isim, $soyisim, $email, $telno, $dogumTarihi, $sifre) {
            $kullanici_ekle = $GLOBALS['db']->prepare("INSERT INTO kayitli_kullanicilar (kullanici_isim, kullanici_soyisim, kullanici_email, kullanici_telno, kullanici_dogumtarihi, kullanici_sifre)
            VALUES (?,?,?,?,?,?)");
            $kullanici_ekle->execute (array($isim, $soyisim, $email, $telno, $dogumTarihi, $sifre));

            // if ($kullanici_ekle) {
            //     echo "son eklenen kaydin id: ".$db->lastInsertId();
            // }
        }
        
    }

    $kullaniciNesne = new kullanici();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $isim = $_POST["kayit-isim"];
        $soyisim = $_POST["kayit-soyisim"];
        $email = $_POST["kayit-email"];
        $telno = $_POST["kayit-telno"];
        $dogumTarihi = $_POST["kayit-dogumTarihi"];
        $sifre = $_POST["kayit-sifre"];
        $sifreTekrar = $_POST["kayit-sifreTekrar"];

        if (!empty(!empty($isim) && !empty($soyisim) && !empty($email) && !empty($telno) && !empty($dogumTarihi) && !empty($sifre) && !empty($sifreTekrar))) {

            if ($sifre == $sifreTekrar) {

                //ayni e mail ile birden fazla hesap açılmasın kontrolü
                $kayitEmailKontrol = $db->query("SELECT kullanici_email FROM kayitli_kullanicilar WHERE kullanici_email = '$email'");
                $kayitEmailKontrolSonuc = $kayitEmailKontrol->fetch(PDO::FETCH_OBJ);
                
                if ($kayitEmailKontrolSonuc) {
                    echo "<script>alert('Bu email zaten kullanılıyor!')</script>";
                } else {
                    $kullaniciNesne->kullaniciEkle($isim, $soyisim, $email, $telno, $dogumTarihi, $sifre, $sifreTekrar);
                    header("Location: logIn.php");
                    //echo "bu emailden baska yok kayit eklenir";
                }

            } else {
                echo "<script>alert('Lütfen tekrar girdiğiniz şifrenin aynı olduğuna dikkat edin!')</script>";
            }

        } else {
            echo "<script>alert('Lütfen değer giriniz')</script>";
        }

    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="registration.css?v=<?php echo time(); ?>">
    <title>Kayıt Ol</title>
</head>
<body>


    <header>
        <div class="logo">Berkay Otel</div>
        <nav>
            <a href="registration.php">
                <i class="fa-solid fa-house"></i>
                Ana Sayfa
            </a>
            <!-- <a href="rooms.php">
                <i class="fa-solid fa-bed"></i>
                Odalar
            </a> -->
            <a href="#">
                <i class="fa-solid fa-circle-info"></i>
                Hakkımızda
            </a>
            <a href="#">
                <i class="fa-solid fa-question"></i>
                S.S.S
            </a>
            <a href="" class="navbar-callme-button">
                <i class="fa-solid fa-phone"></i>
                +90 <?php echo $otelTelNo; ?>
            </a>
            
        </nav>
    </header>

    <div class="kucukResim">
        <img src="https://cdn.discordapp.com/attachments/913942781498630157/1186042882067546163/7caf97fb2cd2e56494e055db557f8ffe.jpg?ex=6591cf82&is=657f5a82&hm=93ba3193fa4d8e78ebf93d5e3ad8ce3235f9980d0a99fb16b020d8efaf904fcb&" alt="">
    </div>

    <div class="registration-container">
        <h2>SİMDİ REZERVASYON İÇİN KAYIT OL!</h1>
        <form action="#" method="POST">
            <div class="registration-main-box">
                <div class="registration-input-box">
                    <span class="registration-input-text">İsim</span>
                    <input class="registration-input" placeholder="İsminizi girin" type="text" name="kayit-isim" autocomplete="off">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">Soyisim</span>
                    <input class="registration-input" placeholder="Soyisminizi girin" type="text" name="kayit-soyisim" autocomplete="off">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">E-mail</span>
                    <input class="registration-input" placeholder="E-mailinizi girin" type="email" name="kayit-email" autocomplete="off">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">Telefon</span>
                    <input class="registration-input" placeholder="Telefon numaranızı girin" type="text" name="kayit-telno" autocomplete="off">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">Doğum Tarihi</span>
                    <input class="registration-input" type="date" name="kayit-dogumTarihi">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">Şifre</span>
                    <input class="registration-input" placeholder="Şifrenizi girin" type="password" name="kayit-sifre">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">Şifre Tekrar</span>
                    <input class="registration-input" placeholder="Şifrenizi tekrar girin" type="password" name="kayit-sifreTekrar">
                </div>
                <div class="registration-input-box">
                    <span class="registration-input-text">Kayıt Ol</span>
                    <input class="registration-input" type="submit" value="Kayıt ol">
                </div>
            </div>
            <div class="uyelik-varsa-giris-container">
                <span>Daha önce kayıt oldun mu?</span> <br>
                <span>O halde <a href="logIn.php">Giriş Yap</a></span>
            </div>
        </form>
    </div>

    <footer class="registration-footer">

        <div class="registration-footer-contactus-container">
            <h1>BİZİMLE İLETİŞİME GEÇ</h1>
            <div class="registration-footer-contactus-section">
                <div class="registration-footer-contactus-section-number">
                    <img class="contact-us-tr-flage" src="https://cdn.discordapp.com/attachments/913942781498630157/1186366082475364522/Flag_of_Turkey.svg.png?ex=6592fc83&is=65808783&hm=d4988c86964041a79f3eec5637d3225308e9152b0a3c5965e16d0cc98bdcef2f&" alt="">
                    <div>
                        Sirket Numarası <br>
                        +90 <?php echo $otelTelNo; ?>
                    </div>  
                </div>  
                <p> <?php echo $otelAdres; ?> </p>
            </div>
        </div>

        <div class="registration-footer-otel-features">
            <div class="registration-footer-otel-feature">
                <i class="fa-solid fa-bed"></i>
                Özel odalar
            </div>
            <div class="registration-footer-otel-feature">
            <i class="fa-solid fa-utensils"></i>
                Yemek Çeşitleri
            </div>
            <div class="registration-footer-otel-feature">
                <i class="fa-solid fa-wifi"></i>
                Ücretsiz Wi-Fi
            </div>
            <div class="registration-footer-otel-feature">
                <i class="fa-solid fa-user"></i>
                4581 Mutlu Müşteri
            </div>
            <div class="registration-footer-otel-feature">
                <i class="fa-solid fa-bed"></i>
                Oda Servisi
            </div>
            <div class="registration-footer-otel-feature">
                <i class="fa-solid fa-tv"></i>
                Televizyon
            </div>
            <div class="registration-footer-otel-feature">
                <i class="fa-solid fa-thumbs-up"></i>
                7/24 Destek
            </div>
        </div>

    </footer>

</body>
<script src="script.js"></script>
<script src="https://kit.fontawesome.com/1967035ddc.js" crossorigin="anonymous"></script>
</html>