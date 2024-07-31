<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'baglanti.php'; // Veritabanı bağlantı dosyanız

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM test WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$id])) {
        // İşlem tamamlandıktan sonra panel_test.php dosyasına yönlendirme yap
header("Location: panel_test.php");
exit();
    } else {
        // İşlem tamamlandıktan sonra panel_test.php dosyasına yönlendirme yap
header("Location: panel_test.php");
exit();
    }
    exit();
}


?>