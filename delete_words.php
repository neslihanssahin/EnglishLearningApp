<?php
include 'baglanti.php'; // Veritabanı bağlantısı

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Silme sorgusu
    $sql = "DELETE FROM words WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);

    if ($stmt->execute()) {
        echo "Kelime başarıyla silindi.";
    } else {
        echo "Hata: " . $sql . "<br>" . $stmt->errorInfo()[2];
    }
    $stmt->closeCursor();

    // Silme işleminden sonra geri yönlendirme
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} else {
    echo "Geçersiz ID.";
}
?>