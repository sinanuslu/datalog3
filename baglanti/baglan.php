<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=datalog', username: "root", password: "");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("set names utf8mb4"); 
} catch (PDOException $e) {
    echo "Bağlantı Hatası: " . $e->getMessage();
    die();  // Stop execution if connection fails
// örneğin zaman aşımını bekledikten sonra yediden bağlanmaya çalış
}

?>
