<?php 
    include("config.php");

    session_start();

    // oturum kontrolu, kullanici giris yapmamissa giris asayfasina geri yonlendirme
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit();
    }

    $kullanici = array (
        "id" => $_SESSION['kullanici']["id"],
        "isim" => $_SESSION['kullanici']["isim"]." ".$_SESSION['kullanici']["soyisim"],
        "email" => $_SESSION['kullanici']["email"]
    );


    $kullaniciId = $kullanici['id'];

    $uyeSorgu = $db->query("SELECT * FROM kayitli_kullanicilar WHERE kullanici_id = '$kullaniciId' ");
    $uyeSorguSonuc = $uyeSorgu->fetch(PDO::FETCH_ASSOC);

    $musteriSorgu = $db->query("SELECT * FROM otel_musteriler WHERE kullanici_id = '$kullaniciId' ");
    $musteriSorguSonuc = $musteriSorgu->fetchAll(PDO::FETCH_ASSOC);


    //kisinin kiraladigi oda sayisini cekme
    $kiralananOdaSayisiSorgu = $db->prepare("SELECT COUNT(*) as oda_sayi FROM otel_musteriler WHERE kullanici_id = '$kullaniciId' ");
    $kiralananOdaSayisiSorgu->execute();
    $kiralananOdaSayisiSonuc = $kiralananOdaSayisiSorgu->fetch(PDO::FETCH_ASSOC);

    $kiralananOdaSayi = $kiralananOdaSayisiSonuc["oda_sayi"];

    //STATIC DEGİSKEN FONKSİYON İLE KULLANIMI kiralik odalari listeleyen sayfada kac tane kiralik oda oldugu yazdirma
    function kiralananOdaSayisiYazdir() {
        STATIC $kiralananOdaSayiFunc = 0;
        $kiralananOdaSayiFunc++;
        return $kiralananOdaSayiFunc - 1;
    }
    for ($i=0; $i < $kiralananOdaSayi; $i++) { 
        kiralananOdaSayisiYazdir();
    }



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //cikis yap;
        session_destroy();
        header("Location: logIn.php");
        exit();
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profile.css?v=<?php echo time(); ?>">
    <title>Profil</title>
</head>
<body>

    <header>
        <div class="logo">Berkay Otel</div>
        <nav>
            <a href="rooms.php">
                <i class="fa-solid fa-hotel"></i>
                Oda Kirala
            </a>
            <a href="#">
                <i class="fa-solid fa-question"></i>
                S.S.S
            </a>

            <?php if ($uyeSorguSonuc["isAdmin"] == 1) { ?>
                <a href="admin_panel.php">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Admin Panel
                </a>
            <?php } ?>
            

            <a href="profile.php">
                <i class="fa-solid fa-user"></i>
                Hesabım
            </a>

            
        </nav>
    </header>


    <div class="profil-bilgileri-container">
        <div style="display: flex;">
            <div class="profil-bilgileri-resim-container">
                <img src="https://www.gravatar.com/avatar/6573efdd61d86fcd223452a2467586f4?s=80&d=mp&r=g" alt="">
            </div>
            <div class="profil-bilgileri-isim-container">
                <div class="profil-bilgileri-isim-container-isim"><?php echo $uyeSorguSonuc["kullanici_isim"]." ".$uyeSorguSonuc["kullanici_soyisim"]; ?></div>
                <div class="profil-bilgileri-isim-container-musteri">Müşteri</div>
            </div>
            <div class="profil-bilgileri-odaBilgileri">
                <div class="profil-bilgileri-isim-container-isim kiralananOdaSayi"><?php echo kiralananOdaSayisiYazdir(); ?></div>
                <div class="profil-bilgileri-isim-container-musteri">Kiralanan Oda</div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; justify-content: center;">
            <form action="" method="POST">
                <input type="submit" class="profil-cikisYap" name="profile-CikisYap" value="Çıkış Yap">
                <div class="profile-istekOneriSikayet">Istek/Oneri/Sikayet</div>
            </form>
        </div>
        
    </div>



    <div class="profil-odalar-bilgiler-container">

        <div class="profil-bilgileri-kiralanan-odalar">

            <?php if($kiralananOdaSayi == 0) {
                echo '<h1 class="kiraladigin-odalar-liste-baslik">Kiraladıgın bir oda yok</h1>';
            } else { ?>
                <h1 class="kiraladigin-odalar-liste-baslik">Kiraladığın Odalar</h1>

                <?php foreach($musteriSorguSonuc as $musteri): ?>         
                    <?php $musteriOdaId= $musteri["musteri_oda"];

                    $musteriOdaSorgu = $db->query("SELECT * FROM otel_odalari WHERE oda_id = '$musteriOdaId' ");
                    $musteriOdaSorguSonuc = $musteriOdaSorgu->fetchAll(PDO::FETCH_ASSOC); ?>

                    <?php foreach($musteriOdaSorguSonuc as $oda): ?>

                        <div class="odaKirala-oda-item">
                            <div class="odaKirala-oda-image-container">
                                <img src="<?php echo $oda["oda_gorsel"]; ?>" alt="">
                            </div>
            
                            <div style="width: 100%;">
                                <div style="display: flex; flex-direction:row; justify-content:space-between">
                                    <div class="odaKirala-oda-bilgileri-container">
                                        <h1 class="odaKirala-oda-bilgileri-odaIsmi"><?php echo $oda["oda_isim"]; ?></h1>
                                        <span class="odaKirala-oda-bilgileri-adres"><?php echo $oda["oda_adres"]; ?></span>
                                    </div>
            
                                    <div class="odaKirala-oda-degerlendirme-container">
                                        <div style="display: flex; flex-direction: row;">
                                            <div class="odaKirala-oda-degerlendirme">
                                                <h1>Müthiş</h1>
                                                <span><?php echo $oda["oda_degerlendirme"]; ?> değerlendirme</span>
                                            </div>
                                            <div class="odaKirala-oda-degerlendirmeOrtalama-kutusu"><?php echo $oda["oda_oylama"]; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="odaKirala-oda-bilgileri-aciklama"><?php echo $oda["oda_aciklama"]; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php } ?>

        </div>



        <div class="profil-bilgileri-right-section-container">
            <ul>
                <li>
                    <div class="bilgiTitle">Adı</div>
                    <div class="bilgiValue"><?php echo $uyeSorguSonuc["kullanici_isim"]; ?></div>
                </li>
                <li>
                    <div class="bilgiTitle">Soyadı</div>
                    <div class="bilgiValue"><?php echo $uyeSorguSonuc["kullanici_soyisim"]; ?></div>
                </li>
                <li>
                    <div class="bilgiTitle">E-mail Adresi</div>
                    <div class="bilgiValue"><?php echo $uyeSorguSonuc["kullanici_email"]; ?></div>
                </li>
                <li>
                    <div class="bilgiTitle">Telefon Numarası</div>
                    <div class="bilgiValue"><?php echo $uyeSorguSonuc["kullanici_telno"]; ?></div>
                </li>
                <li>
                    <div class="bilgiTitle">Doğum Tarihi</div>
                    <div class="bilgiValue"><?php echo$uyeSorguSonuc["kullanici_dogumtarihi"]; ?></div>
                </li>
                <li>
                    <div class="bilgiTitle">Üyelik Tarihi</div>
                    <div class="bilgiValue"><?php echo $uyeSorguSonuc["eklenme_tarihi"]; ?></div>
                </li>
            </ul>
        </div>
    </div>




</body>

<script>
</script>

<script src="script.js"></script>
<script src="https://kit.fontawesome.com/1967035ddc.js" crossorigin="anonymous"></script>
</html>