<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

if (isset($_SESSION["user"])) {
    $currentUser = User::sessionGet();
}


if (isset($_POST["upload-profile-picture"])) {
    $getImage = addslashes(file_get_contents($_FILES["profile-picture"]["tmp_name"]));
    $image = $_FILES["profile-picture"]["name"];
    $extension = pathinfo($image, PATHINFO_EXTENSION);
    if ($extension == "jpg" or $extension == "png") {
        $result = dbQuery("UPDATE lanmine_noneon.user SET profile_picture = '$getImage' WHERE username = '$currentUser->username'");
        header("Location: user.php");
    } else {
        header("Location: user.php?error={$errors->encode()}");
    }
}


?>
<!DOCTYPE html>
<html lang="no">
<head>
    <!-- Meta Tags -->
    <?php require "{$rootPath}structure/head/meta.php" ?>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- ======= -->
    <!-- General -->
    <title>Rediger profil</title>
    <?php require "{$rootPath}structure/head/imports.php" ?>
</head>
<body>

<!-- Loading - Pace -->
<div class="pace">
    <div class="pace-progress"></div>
</div>

<!-- Navbar -->
<?php require "structure/items/navbar.php"; ?>

<!-- Main -->
<main id="main" class="flexbox-col-start-center">

    <section id="profile-section" class="view-width">
        <div class="profile-inner flexbox-col">
            <!-- Profile Header -->
            <div class="profile-header">

                <form class="profile-header-content flexbox-left" method="post" action="" enctype="multipart/form-data">
                    <input type="file" id="profile-picture" name="profile-picture" accept="image/*" style="display:none;" value="" aria-label="" required>
                    <div id="pp-upload-wrapper" class="profile-picture-wrapper flexbox">
                        <div class="profile-picture-inner flexbox">
                            <img class="profile-picture" src="images/profile-pic.jpg" alt="">
                        </div>
                        <img class="profile-picture-glow" src="images/profile-pic.jpg" alt="">
                    </div>
                    <div class="profile-username-wrapper flexbox-col-left">
                        <h3 class="profile-username"><?php print $currentUser->username?></h3>
                        <p class="profile-at-username">@<?php print strtolower($currentUser->username) ?></p>
                    </div>

                    <div id="profile-pic-uploader" class="flexbox">
                        <div class="profile-pic-uploader-inner flexbox">
                            <fieldset class="flexbox">
                                <div class="flexbox-col">
                                    <a class="profile-pic-small"><img id="profile-img-tag" src="" alt=""></a>
                                    <input type="submit" name="upload-profile-picture" id="upload-profile-picture" value="Last opp bilde">
                                </div>
                            </fieldset>
                        </div>
                        <div class="profile-pic-wrapper-overlay"></div>
                    </div>
                </form>

                <script type="text/javascript">

                    let ppUploadBtn = document.getElementById("pp-upload-wrapper");

                    ppUploadBtn.addEventListener("click", function(event) {
                        event.preventDefault();

                        document.getElementById("profile-picture").click();
                    });

                </script>

            </div>
        </div>
    </section>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>
