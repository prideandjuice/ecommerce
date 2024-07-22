<?php 
    $db_name = 'mysql:host=localhost;dbname=shop';
    $user_name = 'root';
    $user_password = '';

    try {
        $conn = new PDO($db_name, $user_name, $user_password);
        // Mengatur mode error PDO ke exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    function unique_id(){
        $chars = 'Rara';
        $charLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < 20; $i++){
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }
        return $randomString;
    }
?>
