<header>
    <div class="logo">
        <img src="../image/logo.png" width="200">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile">
        <?php
            $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id=?"); 
            $select_profile->execute([$seller_id]);

           if ($select_profile->rowCount() > 0) {
               $select_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
       ?>

        <div class="profile">
        <img src="../uploaded_files/<?= $select_profile['image'];?>" class="logo-img" width="100" >
        <p><?= $select_profile['name'];?></p>
        <div class="flex-btn">
            <a href="profile.php" class="btn">profile</a>
            <a href="../componen/admin_logout.php" onclick="return confirm('logout from this website?');" class="btn">logout</a>
        </div>
    </div>
    <?php }?>
</div>