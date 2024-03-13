<?php 

    include("config.php");

    //admin paneli otel bilgilerini guncellediginde aynanda sayfada da guncellenmesi icin bir fonksiyon olusturdum guncellemeden sonra kullanıyorum
    function CekOtelBilgileri() {
        foreach($GLOBALS['db']->query("SELECT * FROM otel_bilgileri") as $otelbilgi) {
            $GLOBALS['otelAdres'] = $otelbilgi["otel_adres"];
            $GLOBALS['otelTelNo'] = $otelbilgi["otel_telno"];
            $GLOBALS['otelLogoURL'] = $otelbilgi["otel_logo_url"];
        }
    }
    CekOtelBilgileri();



    //websiteye kayitli kullanicilari cekme 
    $kullanicilarSorgu = $db->query("SELECT * FROM kayitli_kullanicilar");
    $kullanicilarSorguSonuc = $kullanicilarSorgu->fetchAll(PDO::FETCH_ASSOC);

    //websiteye kayit olup oda kiralayan kullanicilari cekme (musteriler)
    $musterilerSorgu = $db->query("SELECT * FROM otel_musteriler");
    $musterilerSorguSonuc = $musterilerSorgu->fetchAll(PDO::FETCH_ASSOC);

    //veritabanindaki oda listesini cekme
    $odalarSorgu = $db->query("SELECT * FROM otel_odalari");
    $odalarSorguSonuc = $odalarSorgu->fetchAll(PDO::FETCH_ASSOC);
    

    
    //aynı php dosyasında birden fazla form olduğu için nerede form kullanacaksam içine bir hidden input koydum ve inputun valuesine göre işlem yaptiriyorum
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //admin paneli otel bilgileri kısmı
        if ($_POST["adminPanel-formType"] == "formType-OtelAdresGuncelle") {
            $otelAdresGuncelleInput = $_POST["otelAdresGuncelle"];
            $OtelAdresGuncelle = $db->exec("UPDATE otel_bilgileri SET otel_adres = '$otelAdresGuncelleInput' ");
            CekOtelBilgileri();

        } else if ($_POST["adminPanel-formType"] == "formType-OtelTelnoGuncelle") {
            $OtelTelnoGuncelleInput = $_POST["OtelTelnoGuncelle"];
            $OtelTelnoGuncelle = $db->exec("UPDATE otel_bilgileri SET otel_telno = '$OtelTelnoGuncelleInput' ");
            CekOtelBilgileri();

        } else if ($_POST["adminPanel-formType"] == "formType-OtelLogoUrlGuncelle") {
            $OtelLogoUrlGuncelleInput = $_POST["OtelLogoUrlGuncelle"];
            $OtelLogoUrlGuncelle = $db->exec("UPDATE otel_bilgileri SET otel_logo_url = '$OtelLogoUrlGuncelleInput' ");
            CekOtelBilgileri();
        }


        //admin paneli oda ekleme kısmı
        if ($_POST["adminPanel-formType"] == "formType-otelOdasiEkle") {
            $odaIsim = $_POST["oda_isim"];
            $odaAdres = $_POST["oda_adres"];
            $odaAciklama = $_POST["oda_aciklama"];

            //otel odasi icin veritabanina rastgele sayi olusturma - oda degerlendirmesi ve oda puanlama rastgele bir sekilde uretilmistir
            $odaDegerlendirme = mt_rand(200, 1500);
            $odaOylama = mt_rand(1, 9).".".mt_rand(1, 9); //örn 5.8

            $odaFiyat = (int)$_POST["oda_fiyat"];
            $odaGorsel = $_POST["oda_gorsel"];

            $odaEkleSorgu = $db->prepare("INSERT INTO otel_odalari (oda_isim, oda_adres, oda_aciklama, oda_degerlendirme, oda_oylama, oda_gorsel, oda_fiyat) VALUES('$odaIsim', '$odaAdres', '$odaAciklama', '$odaDegerlendirme', '$odaOylama', '$odaGorsel', '$odaFiyat')");
            $odaEkleSorgu->execute();
        }

        if ($_POST["adminPanel-formType"] == "formType-otelOdasiSil") {
            
            $odaId = $_POST["odaSilOdaId"];
            $odaSilSorgu = $db->prepare("DELETE FROM otel_odalari WHERE oda_id = '$odaId'");
            $odaSilSorgu->execute();


        }

    }




?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="admin_panel.css?v=<?php echo time(); ?>">
    <title>Panel</title>
</head>
<body>

    <div id="adminPanel-sidenav" class="adminPanel-sidenav">
        <img src="https://cdn.discordapp.com/attachments/913942781498630157/1188257981561847818/oelogofarkli2.png?ex=6599de7b&is=6587697b&hm=7c19136dd9eba5d2bfbd067aebf9a99da3294a39c4a1f941da943f3f6d610ee2&" alt="">
        <a href="#" onclick="showContent('hakkinda')"><i class="fa-solid fa-house"></i>Hakkında</a>
        <a href="#" onclick="showContent('otelBilgileri')"><i class="fa-solid fa-circle-info"></i>Otel Bilgileri</a>
        <a href="#" onclick="showContent('kayitliKullanicilar')"><i class="fa-solid fa-users"></i>Kayıtlı Kullanıcılar</a>
        <a href="#" onclick="showContent('musteriler')"><i class="fa-solid fa-building-user"></i>Müşteri Listesi</a>
        <a href="#" onclick="showContent('odaEkle')"><i class="fa-solid fa-building"></i>Oda Ekle</a>
        <a href="#" onclick="showContent('odaListesi')"><i class="fa-regular fa-building"></i>Oda Listesi</a>
        <a href="#" onclick="showContent('istekOneriSikayet')"><i class="fa-solid fa-envelope"></i>İstek/Öneri/Şikayet</a>
        <a href="profile.php" id="adminPanel-cikis"><i class="fa-solid fa-arrow-right-from-bracket"></i>Çıkış</a>
    </div>

    <div id="toggle-sidenav-container"><i class="fa-solid fa-bars"></i></div>

    <div class="adminPanel-main">

        <div id="hakkinda" class="adminPanel-content">
            <h1>Hakkında</h2>
            <p style="margin-bottom: 60px;">Admin paneli, otel yöneticilerine otel operasyonlarını etkili bir şekilde yönetme imkanı sunan kapsamlı bir ara yüzdür. Panel, sol tarafta bulunan bir sidebar ile erişilen farklı modüllerden oluşmaktadır.</p>
            <ul style="margin-bottom: 60px;">
                <li>
                    <h2>Otel Bilgileri</h2>
                    <p>Bu bölümde otelin temel bilgileri bulunmaktadır. Otel adı, konum, iletişim bilgileri gibi genel bilgiler burada düzenlenebilir.</p>
                </li>
                <li>
                    <h2>Kayıtlı Kullanıcılar</h2>
                    <p>Otele kayıt olmuş kullanıcıların listesini içerir. İsim, e-posta, üyelik tarihi gibi bilgilere erişim sağlar ve gerektiğinde kullanıcı bilgilerini güncelleme veya silme imkanı sunar.</p>
                </li>
                <li>
                    <h2>Oda Ekle</h2>
                    <p>Yeni bir oda eklemek için kullanılır. Otel adresi, fiyatı gibi bilgileri içerir. Yeni oda eklemek için gerekli formu doldurarak otelinize yeni seçenekler ekleyebilirsiniz.</p>
                </li>
                <li>
                    <h2>Oda Listesi</h2>
                    <p>Var olan odaları listeden seçip silme işlemi gerçekleştirilir. Odaların güncel durumunu kontrol edebilir ve istenmeyen odaları kaldırabilirsiniz.</p>
                </li>
                <li>
                    <h2>Müşteri İstek ve Önerileri</h2>
                    <p>Bu bölüm, konaklayan müşterilerin yaptığı istekler, öneriler ve şikayetleri içerir. Bu geri bildirimleri değerlendirerek hizmet kalitesini artırabilirsiniz.</p>
                </li>
            </ul>
            <h2>Kullanım</h2>
            <ul>
                <li><p>Sidebar üzerinden istediğiniz modüle kolayca erişim sağlayabilirsiniz.</p></li>
                <li><p>Her bölümde bulunan formlar ve tablolar kullanıcı dostu arayüzlerle tasarlanmıştır.</p></li>
                <li><p>Bilgileri güncellemek, eklemek veya silmek için ilgili bölümlerdeki form ve tabloları kullanabilirsiniz.</p></li>
                <li><p>Panel, otel yönetiminin ihtiyaçlarına uygun olarak tasarlanmış olup, kullanıcı dostu ara yüzüyle hızlı ve etkili bir kullanım sağlar.</p></li>
            </ul>
        </div>
        
        <div id="otelBilgileri" class="adminPanel-content">
            <h1>Otel Bilgileri</h1>
            <p>Bu bölümde otelin temel bilgileri bulunmaktadır. Otel adı, konum, iletişim bilgileri gibi genel bilgiler burada düzenlenebilir.</p>

            <div class="adminPanel-content-otelBilgileri-form-container">

                <div class="adminPanel-content-otelBilgileri-item">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> <!-- güvenlik açığı önlemek için htmlspecialchars -->
                        <input type="hidden" name="adminPanel-formType" value="formType-OtelAdresGuncelle">

                        <p>Otel Adresi</p>
                        <input name="otelAdresGuncelle" type="text" value="<?php echo $otelAdres; ?>">
                        <input class="adminPanel-content-otelBilgileri-item-submit" type="submit" value="Adres Güncelle">
                    </form>
                </div>

                <div class="adminPanel-content-otelBilgileri-item">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="hidden" name="adminPanel-formType" value="formType-OtelTelnoGuncelle">

                        <p>Otel Telefon Numarası</p>
                        <input name="OtelTelnoGuncelle" type="number" value="<?php echo $otelTelNo; ?>">
                        <input class="adminPanel-content-otelBilgileri-item-submit" type="submit" value="Telefon Numarası Güncelle">
                    </form>
                </div>

                <div class="adminPanel-content-otelBilgileri-item">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="hidden" name="adminPanel-formType" value="formType-OtelLogoUrlGuncelle">

                        <p>Otel Logo URL</p>
                        <input name="OtelLogoUrlGuncelle" type="text" value="<?php echo $otelLogoURL; ?>">
                        <input class="adminPanel-content-otelBilgileri-item-submit" type="submit" value="Otel Logo URL Güncelle">
                    </form>
                </div>

            </div>
        </div>

        <div id="kayitliKullanicilar" class="adminPanel-content">
            <h1>Kayıtlı Kullanıcılar</h1>
            <p>Otele kayıt olmuş kullanıcıların listesini içerir. İsim, e-posta, üyelik tarihi gibi bilgilere erişim sağlar ve gerektiğinde kullanıcı bilgilerini güncelleme veya silme imkanı sunar.</p>

            <div class="adminPanel-content-kayitliListesi-container">
                <div class="adminPanel-kayitliListesi-satir adminPanel-kayitliListesi-satir-titles">
                    <div class="adminPanel-kayitliListesi-satir-sutun kullaniciId"><span>Müşteri ID</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun kullaniciIsim"><span>Kullanıcı ID</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun kullaniciEmail"><span>İsim Soyisim</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun kullaniciTelno"><span>Telefon Numarası</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun kullaniciDogumtarihi"><span>Doğum Tarihi</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun kullaniciKayittarihi"><span>Kayıt Tarihi</span></div>
                </div>

                <!-- admin paneli kayitli kullanicilari cekip yazdirma -->
                <?php foreach ($kullanicilarSorguSonuc as $kullanici): ?>
                    
                    <div class="adminPanel-kayitliListesi-satir list-background">
                        <div class="adminPanel-kayitliListesi-satir-sutun kullaniciId"><span><?php echo $kullanici["kullanici_id"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun kullaniciIsim"><span><?php echo $kullanici["kullanici_isim"]." ".$kullanici["kullanici_soyisim"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun kullaniciEmail"><span><?php echo $kullanici["kullanici_email"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun kullaniciTelno"><span><?php echo $kullanici["kullanici_telno"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun kullaniciDogumtarihi"><span><?php echo $kullanici["kullanici_dogumtarihi"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun kullaniciKayittarihi"><span><?php echo $kullanici["eklenme_tarihi"]; ?></span></div>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        
        <div id="musteriler" class="adminPanel-content">
            <h1>Website Müşterileri</h1>
            <p>Rezevasyon yapmış kullanıcıların listesini içerir. İsim, e-posta, üyelik tarihi, oda bilgisi gibi bilgilere erişim sağlar ve gerektiğinde kullanıcı bilgilerini güncelleme veya silme imkanı sunar.</p>

            <div class="adminPanel-content-kayitliListesi-container">
                <div class="adminPanel-kayitliListesi-satir adminPanel-kayitliListesi-satir-titles">
                    <div class="adminPanel-kayitliListesi-satir-sutun musteriId"><span>Müşteri ID</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun musteriKullaniciId"><span>Kullanıcı ID</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun musteriIsim"><span>İsim Soyisim</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun musteriTelno"><span>Telefon Numarası</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun musteriOdano"><span>Oda No.</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun musteriKayitTarihi"><span>Kiralama Tarihi</span></div>
                </div>

                <!-- admin paneli kayitli kullanicilari cekip yazdirma -->
                <?php foreach ($musterilerSorguSonuc as $musteri): ?>
                    
                    <div class="adminPanel-kayitliListesi-satir list-background">
                        <div class="adminPanel-kayitliListesi-satir-sutun musteriId"><span><?php echo $musteri["musteri_id"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun musteriKullaniciId"><span><?php echo $musteri["kullanici_id"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun musteriIsim"><span><?php echo $musteri["musteri_isim"]." ".$musteri["musteri_soyisim"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun musteriTelno"><span><?php echo $musteri["musteri_telno"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun musteriOdano"><span><?php echo $musteri["musteri_oda"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun musteriKayitTarihi"><span><?php echo $musteri["musteri_eklenme"]; ?></span></div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>

        <div id="odaEkle" class="adminPanel-content">
            <h1>Otel Odası Ekle</h1>
            <p>Yeni bir oda eklemek için kullanılır. Otel adresi, fiyatı gibi bilgileri içerir. Yeni oda eklemek için gerekli formu doldurarak otelinize yeni seçenekler ekleyebilirsiniz</p>

            <div class="adminPanel-content-kiralikOdalar-form-container">
                <form action="#" method="POST">
                    <input type="hidden" name="adminPanel-formType" value="formType-otelOdasiEkle">

                    <div class="adminPanel-content-kiralikOdalar-form-item">
                        <p>Otel İsmi</p>
                        <input type="text" name="oda_isim" placeholder="otel ismini giriniz" >
                    </div>
                    <div class="adminPanel-content-kiralikOdalar-form-item">
                        <p>Otel Odası Adresi</p>
                        <input type="text" name="oda_adres" placeholder="Otel adresini giriniz" >
                    </div>
                    <div class="adminPanel-content-kiralikOdalar-form-item">
                        <p>Oda Açıklama</p>
                        <textarea type="text" name="oda_aciklama" placeholder="Oda açıklamasını giriniz (300 karakter)" maxlength="300" required></textarea>
                    </div>
                    <div class="adminPanel-content-kiralikOdalar-form-item">
                        <p>Oda Fiyat</p>
                        <input type="number" name="oda_fiyat" placeholder="Oda fiyatını giriniz" >
                    </div>
                    <div class="adminPanel-content-kiralikOdalar-form-item">
                        <p>Oda Görsel</p>
                        <input type="text" name="oda_gorsel" placeholder="Odanın görsel URL'sini giriniz" >
                    </div>
                    <input class="adminPanel-content-kiralikOdalar-odaEkle" type="submit" name="oda_ekle" value="Oda Ekle">
                </form>
            </div>
        </div>

        <div id="odaListesi" class="adminPanel-content">
            <h1>Oda Listesi</h1>
            <p>Var olan odaları listeden seçip silme işlemi gerçekleştirilir. Odaların güncel durumunu kontrol edebilir ve istenmeyen odaları kaldırabilirsiniz.</p>

            <div class="adminPanel-content-kayitliListesi-container">
                <div class="adminPanel-kayitliListesi-satir adminPanel-kayitliListesi-satir-titles">
                    <div class="adminPanel-kayitliListesi-satir-sutun odaId"><span>Oda ID</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun odaIsim"><span>Oda Isim</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun odaAdres"><span>Oda Adres</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun odaDegerlendirme"><span>Oda Degerlendirme</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun odaOylama"><span>Oda Oylama</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun odaFiyat"><span>Oda Fiyat</span></div>
                    <div class="adminPanel-kayitliListesi-satir-sutun odaIslem"><span>Oda Islem</span></div>
                </div>

                <!-- admin paneli kayitli kullanicilari cekip yazdirma -->
                <?php foreach ($odalarSorguSonuc as $oda): ?>
                    
                    <div class="adminPanel-kayitliListesi-satir list-background">
                        <div class="adminPanel-kayitliListesi-satir-sutun odaId"><span><?php echo $oda["oda_id"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun odaIsim"><span><?php echo $oda["oda_isim"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun odaAdres"><span><?php echo $oda["oda_adres"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun odaDegerlendirme"><span><?php echo $oda["oda_degerlendirme"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun odaOylama"><span><?php echo $oda["oda_oylama"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun odaFiyat"><span><?php echo $oda["oda_fiyat"]; ?></span></div>
                        <div class="adminPanel-kayitliListesi-satir-sutun odaIslem odaSilSutun">
                            <form action="" method="POST">
                                <input type="hidden" name="adminPanel-formType" value="formType-otelOdasiSil">
                                <input type="hidden" name="odaSilOdaId" value="<?php echo $oda["oda_id"]; ?>">
                                <input type="submit" name="odaSil" value="Sil">
                            </form>
                        </div>
                        
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
        
        <div id="istekOneriSikayet" class="adminPanel-content">
            <h1>İstek Öneri Şikayet</h1>
            <p>This is the Contact page content.</p>
        </div>

    </div>

    
</body>
    <script>
       
    //admin panelindeki sidenav in isleyisi
    function showContent(contentId) {
        document.querySelectorAll('.adminPanel-content').forEach(content => {
            content.style.display = 'none';
        });

        document.getElementById(contentId).style.display = 'block';

        window.onload = function() {
            window.scrollTo(0, 0);
        };
    }
    showContent('hakkinda');

    //kayit listesindeki listenin bir normal olarak hos durmasi icin kod
    var adminpanelKayitListesi = document.querySelectorAll('.list-background');
    adminpanelKayitListesi.forEach(function(div, index) {
        if (index % 2 != 0 ) {
            let renk = 'adminPanel-content-kayitliListesi-background-renk';
            div.classList.add(renk);
        }
    });

    //admin panelindeki side nav bar in ekran kucukken toggle islemini saglama
    let sideNavBar = document.getElementById("adminPanel-sidenav");
    let toggleButton = document.getElementById("toggle-sidenav-container");

    toggleButton.addEventListener("click", function() {
        if ( sideNavBar.style.display == "none") {
            sideNavBar.style.display = "flex";
            toggleButton.style.backgroundColor = "var(--registrationPageColor2)";
            toggleButton.style.color = "var(--registrationPageColor1)";
        } else {
            sideNavBar.style.display = "none";
            toggleButton.style.backgroundColor = "var(--registrationPageColor1)";
            toggleButton.style.color = "var(--registrationPageColor2)";
        }
    });

    </script>

    <script src="https://kit.fontawesome.com/1967035ddc.js" crossorigin="anonymous"></script>
</html>