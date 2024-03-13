<?php 

    try {
        $GLOBALS['db'] = new PDO("mysql:host=localhost:3307;dbname=otelprojesidb", 'root', '');
    } catch (PDOException $e) {
        echo $e-> getMessage();
    }

?>