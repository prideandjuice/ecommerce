<?php
include '../componen/connect.php';

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    // Memeriksa apakah email sudah ada
    $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
    $select_seller->execute([$email]);

    if ($select_seller->rowCount() > 0) {
        $warning_msg[] = 'Email already exists!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Confirm password does not match';
        } else {
            // Menggunakan backticks (`) atau tanpa tanda kutip untuk nama tabel
            $insert_seller = $conn->prepare("INSERT INTO sellers (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
            $insert_seller->execute([$id, $name, $email, $cpass, $rename]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'New seller registered! Please login now';
        }
    }
}
?>

<!-- Contoh Form HTML -->
<form method="post" action="" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Enter name" required>
    <input type="email" name="email" placeholder="Enter email" required>
    <input type="password" name="pass" placeholder="Enter password" required>
    <input type="password" name="cpass" placeholder="Confirm password" required>
    <input type="file" name="image" required>
    <input type="submit" name="submit" value="Register">
</form>

<!-- Menampilkan pesan kesalahan atau sukses -->
<?php
if (!empty($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo '<p style="color: red;">' . htmlspecialchars($msg) . '</p>';
    }
}
if (!empty($success_msg)) {
    foreach ($success_msg as $msg) {
        echo '<p style="color: green;">' . htmlspecialchars($msg) . '</p>';
    }
}
?>

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A Shopper - seller registeration page</title>
    <link rel= "stylesheet" type= "text/css" href="../css/admin_style.css">
    <!-- font awesome cdn link -->
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>

    <div class= "form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>REGISTER NOW</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                         <p>Your Name <span>*</span> </p>
                         <input type="text" name="name" placeholder="enter your name" maxlength="50"
                         required class= "box">
                    </div>
                    <div class="input-field">
                         <p>your email  <span>*</span> </p>
                         <input type="email" name="email" placeholder="enter your email" maxlength="50"
                         required class= "box">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                         <p>your password <span>*</span></p>
                         <input type="password" name="password" placeholder="enter your password" maxlength="50"
                         required class= "box">
                    </div>
                    <div class="input-field">
                         <p>confirm password <span>*</span></p>
                         <input type="password" name="cpass" placeholder="confirm your password" maxlength="50"
                         required class= "box">
                    </div>
            </div>
            
        </div>
        <div class="input-field">
            <p>your profile <span>*</span></p>
                 <input type="file" name="image" accept= "image/*" required class="box">
        </div>
        <p> already have an account? <a href= "login.php">login now</a> </p>
        <input type= "submit" name="submit" value= "register now" class="btn">
            

    </form>
    </div>


    
    <!-- sweetalert cdn link -->
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src= "../js/script.js"></script>

    <?php include '../componen/alert.php'; ?>
</html>
    