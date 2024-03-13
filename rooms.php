<?php 

    include("config.php");


    session_start();

    // oturum kontrolu, kullanici giris yapmamissa giris asayfasina geri yonlendirme
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit();
    }

    $kullanici = array (
        "id" => $_SESSION['kullanici']["id"]
    );

    $kullaniciId = $kullanici['id'];

    //oturumdaki kullanici
    $uyeSorgu = $db->query("SELECT * FROM kayitli_kullanicilar WHERE kullanici_id = '$kullaniciId' ");
    $uyeSorguSonuc = $uyeSorgu->fetch(PDO::FETCH_ASSOC);


    //odalari veritabanindan cekme
    $otelOdalari = $db->query("SELECT * FROM otel_odalari");
    $otelOdalariSonuc = $otelOdalari->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profile.css?v=<?php echo time(); ?>">
    <title>Odalar</title>
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


    <div class="hesabim-odaKirala">

        <div class="odaKirala-search-container">
            <div class="odaKirala-search-main">
                <div class="odaKirala-search-input-container">
                    <h1>Sizin Için Mükemmel Otelinizi Arayın </h1>

                    <div class="odaKirala-search-input-konum-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <input id="roomsSearchBar" type="text" placeholder="Aradığınız otelin özelliklerini yazın">
                    
                    <div class="odaKirala-search-input-search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
            <img src="https://cdn.discordapp.com/attachments/913942781498630157/1186042882067546163/7caf97fb2cd2e56494e055db557f8ffe.jpg?ex=65ad7f02&is=659b0a02&hm=ad4851c597c2fcf7ad356eaca7d55a015ac86492cfc852ea3c5908811519bd8e&" alt="">
        </div>


        <div class="odaKirala-otel-features-container">

            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-bed"></i>
                Özel odalar
            </div>
            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-utensils"></i>
                Yemek Çeşitleri
            </div>
            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-wifi"></i>
                Ücretsiz Wi-Fi
            </div>
            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-user"></i>
                4581 Mutlu Müşteri
            </div>
            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-bed"></i>
                Oda Servisi
            </div>
            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-tv"></i>
                Televizyon
            </div>
            <div class="odaKirala-otel-feature-item">
                <i class="fa-solid fa-thumbs-up"></i>
                7/24 Destek
            </div>
        </div>

        <h2 style="text-align: center; text-decoration:underline; color: var(--registrationPageColor1)">Kiralık Odalar</h2>

        <div class="odaKirala-section-container">
         
            <!-- veritabanindan alininan otel bilgilerini ekrana yazdirma -->
            <?php foreach($otelOdalariSonuc as $oda): ?>

                <?php 
                $oylamaPuani = $oda['oda_oylama'];

                if ($oylamaPuani >= 3 && $oylamaPuani < 6) {
                    $oylamaYazisi = "İyi";
                } elseif ($oylamaPuani >= 6 && $oylamaPuani < 9) {
                    $oylamaYazisi = "Çok İyi";
                } elseif ($oylamaPuani >= 9) {
                    $oylamaYazisi = "Müthiş";
                } else {
                    $oylamaYazisi = "Ortalama";
                }
                ?>

                <div class="odaKirala-oda-item" data-oda-adi="<?php echo $oda['oda_isim']; ?>">
                    <div class="odaKirala-oda-image-container">
                        <img src="<?php echo $oda['oda_gorsel']; ?>" alt="">
                    </div>

                    <div style="width: 100%;">
                        <div style="display: flex; flex-direction:row; justify-content:space-between">

                            <div class="odaKirala-oda-bilgileri-container">
                                <h1 class="odaKirala-oda-bilgileri-odaIsmi"><?php echo $oda['oda_isim']; ?></h1>
                                <span class="odaKirala-oda-bilgileri-adres"><?php echo $oda['oda_adres']; ?></span>
                            </div>

                            <div class="odaKirala-oda-degerlendirme-container">
                                <div style="display: flex; flex-direction: row;">
                                    <div class="odaKirala-oda-degerlendirme">
                                        <h1><?php echo $oylamaYazisi; ?> </h1>
                                        <span><?php echo $oda['oda_degerlendirme']; ?> değerlendirme</span>
                                    </div>
                                    <div class="odaKirala-oda-degerlendirmeOrtalama-kutusu"><?php echo $oda['oda_oylama']; ?></div>
                                </div>

                                
                                <form action="kullaniciOdaEkle.php" method="POST">
                                    <input type="hidden" name="oda_id" value="<?php echo $oda['oda_id']; ?>">
                                    <button type="submit" name="oda-kirala" class="odaKirala-oda-satinAl">
                                        <i class="fa-solid fa-basket-shopping"></i>
                                        $<?php echo $oda['oda_fiyat']; ?> Kirala
                                    </button>
                                </form>
                                    
                            </div>

                        </div>
                        <div class="odaKirala-oda-bilgileri-aciklama"><?php echo $oda['oda_aciklama']; ?></div>

                    </div>
                </div>

            <?php endforeach; ?>

            
        </div>


    </div>


</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $("#roomsSearchBar").on("input", function () {
            var arananKelime = $(this).val().toLowerCase();

            $(".odaKirala-oda-item").each(function () {
                var otelAdi = $(this).data("oda-adi").toLowerCase();

                // Otel adı, aranan kelimeyi içeriyorsa göster, içermiyorsa gizle
                if (otelAdi.includes(arananKelime)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
<script src="https://kit.fontawesome.com/1967035ddc.js" crossorigin="anonymous"></script>
</html>