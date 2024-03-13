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
        "isim" => $_SESSION['kullanici']["isim"], 
        "soyisim" => $_SESSION['kullanici']["soyisim"],
        "email" => $_SESSION['kullanici']["email"],
        "telno" => $_SESSION['kullanici']["telno"]
    );

    $kiralananOdaId = $_POST['oda_id'];

    $musteriOdasiEkle = $db->prepare("INSERT INTO otel_musteriler (kullanici_id, musteri_isim, musteri_soyisim, musteri_telno, musteri_oda) VALUES (?,?,?,?,?)");
    $musteriOdasiEkle->execute(array($kullanici["id"], $kullanici["isim"], $kullanici["soyisim"], $kullanici["telno"], $kiralananOdaId));

    //admin panelindeki static degisken ile calisacak olan log kayit bolumundeki 
    //kaydin artmasi icin kullanici oda rezervasyon yapinca calisan kod

    header("Location: rooms.php");
    exit();

?>