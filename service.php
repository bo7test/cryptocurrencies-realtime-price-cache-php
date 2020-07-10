<?php
require 'vendor/autoload.php';

$api = new Binance\API();
$dbConnected = false;

$db = "dbname";
$dbUser = "root";
$dbPass = "";
$dbHost = "localhost";

try {
    $dbh = new PDO("mysql:host=$dbHost;dbname=$db", $dbUser, $dbPass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbConnected = true;
} catch (PDOException $e) {
    echo $e->getMessage();
}

$symbols = ['BTCUSDT', 'ADAUSDT'];
$api->ticker(false, function ($api, $symbol, $ticker) use ($dbConnected, $dbh, $symbols) {
    if (in_array($symbol, $symbols) && $dbConnected) {
        $addPrice = $dbh->prepare("INSERT INTO prices (symbol, price, updated_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE price = ".$ticker['close'].", updated_at = ".time());
        $addPrice->execute([$symbol, $ticker['close'], time()]);
    }
});

