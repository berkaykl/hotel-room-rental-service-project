<?php

    include("config.php");


    //KAYIT SAYFASINDAKİ OTEL BİLGİLERİ
    foreach($db->query("SELECT * FROM otel_bilgileri") as $otelbilgi) {
        $otelAdres = $otelbilgi["otel_adres"];
        $otelTelNo = $otelbilgi["otel_telno"];
        $otelLogoURL = $otelbilgi["otel_logo_url"];
    }



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["kayit-email"];
        $sifre = $_POST["kayit-sifre"];
      
        $girisKontrol = $db->query("SELECT * FROM kayitli_kullanicilar WHERE kullanici_email = '$email' AND kullanici_sifre = '$sifre' ");
        $girisKontrolSonuc = $girisKontrol->fetch(PDO::FETCH_ASSOC);

        if ($girisKontrolSonuc) {

            session_start();

            $_SESSION['loggedin'] = true;
            $_SESSION['kullanici'] = array (
                "id" => $girisKontrolSonuc["kullanici_id"],
                "isim" => $girisKontrolSonuc["kullanici_isim"],
                "soyisim" => $girisKontrolSonuc["kullanici_soyisim"],
                "email" => $girisKontrolSonuc["kullanici_email"],
                "telno" => $girisKontrolSonuc["kullanici_telno"]
            );

            header("Location: rooms.php");
            exit();

        } else {
            echo "<script>alert('E-mail veya şifre hatalı!')</script>";
        }
    }

    


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, inital-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="registration.css?v=<?php echo time(); ?>">
    <title>Giriş Yap</title>
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
        <h2>ŞİMDİ GİRİŞ YAP!</h1>
        <form action="#" method="POST">
            <div class="registration-main-box">
                <div class="registration-input-box">
                    <span class="registration-input-text">E-mail</span>
                    <input class="registration-input" placeholder="E-mailinizi girin" type="email" name="kayit-email" autocomplete="off">
                </div>

                <div class="registration-input-box">
                    <span class="registration-input-text">Şifre</span>
                    <input class="registration-input" placeholder="Şifrenizi girin" type="password" name="kayit-sifre">
                </div>

                <div style="width: 100%;" class="registration-input-box">
                    <span class="registration-input-text">Giriş Yap</span>
                    <input class="registration-input" type="submit" value="Giriş yap">
                </div>
            </div>
            <div class="uyelik-varsa-giris-container">
                <span>Henüz kayıt olmadın mı?</span> <br>
                <span>O halde <a href="registration.php">Kayıt Ol</a></span>
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