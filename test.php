<?php
try {
    $db = new PDO('mysql:host=bq5jiqemsif59sfmccah-mysql.services.clever-cloud.com;port=3306', 'uijkwku3pucpqv64', 'SMlSRuKvzebcOihHQXMr');
    echo 'Success!';
} catch (Exception $e) {
    echo $e->getMessage();
}
