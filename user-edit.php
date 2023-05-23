<?php
require "func.php";
session_start();
$errors = new ErrorMessage();
$rootPath = "";

if (isset($_SESSION["user"])) {
    $currentUser = User::sessionGet();
}


if (isset($_POST["upload-profile-picture"])) {
    $getImage = addslashes(file_get_contents($_FILES["profile-picture"]["tmp_name"]));
    $image = $_FILES["profile-picture"]["name"];
    $extension = pathinfo($image, PATHINFO_EXTENSION);
    if ($extension == "jpg" or $extension == "png" or $extension == "PNG" or $extension == "gif") {
        dbQuery("UPDATE lanmine_noneon.user SET profile_picture = '$getImage' WHERE username = '$currentUser->username'");
        $result = dbQuery("SELECT profile_picture FROM lanmine_noneon.user WHERE username='$currentUser->username'");
        $currentUser->profilePicture = $result->fetch_assoc()["profile_picture"];
        $currentUser->sessionSet();
        header("Location: user.php");
    } else {
        $errors->add("invalidImage");
        header("Location: user-edit.php?error={$errors->encode()}");
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

    <form id="profile-section" class="view-width" method="post" action="" enctype="multipart/form-data">
        <?php
        if (isset($_GET["error"])) {
            print '<p class="error-msg flexbox-left"><span class="material-icons">warning</span>' . ErrorMessage::decode($_GET["error"]) . '</p>'; // Prints error messages
        }
        ?>
        <div class="profile-inner flexbox-col">
            <!-- Profile Header -->
            <div class="upload-header flexbox-col-left-start">
                <p class="upload-note">Trykk for å velge nytt profilbilde</p>
                <div class="profile-header-content">
                    <input type="file" id="profile-picture" name="profile-picture" accept="image/*" style="display:none;" value="" aria-label="" required>
                    <div id="pp-upload-wrapper" class="profile-picture-wrapper flexbox">
                        <div class="profile-picture-inner flexbox">
                            <div class="profile-picture-upload-overlay flexbox">
                                <p><span class="material-icons">add_photo_alternate</span></p>
                            </div>
                            <?php print '<img id="profile-picture-show" class="profile-picture" src="data:media_type;base64,' . base64_encode($currentUser->profilePicture) . '" alt="">'; ?>
                        </div>
                        <?php print '<img id="profile-picture-show2" class="profile-picture-glow" src="data:media_type;base64,' . base64_encode($currentUser->profilePicture) . '" alt="">'; ?>
                    </div>
                    <fieldset class="flexbox-right">
                        <input type="submit" name="upload-profile-picture" id="upload-profile-picture" value="Lagre">
                    </fieldset>
                </div>
            </div>

            <script type="text/javascript">

                let ppUploadBtn = document.getElementById("pp-upload-wrapper");

                ppUploadBtn.addEventListener("click", function(event) {
                    event.preventDefault();

                    document.getElementById("profile-picture").click();
                });

                document.getElementById("profile-picture").addEventListener("change", function(event) {
                    event.preventDefault();

                    let uploadedImageI = document.getElementById("profile-picture-show");
                    let uploadedImageI2 = document.getElementById("profile-picture-show2");
                    uploadedImageI.src = URL.createObjectURL(event.target.files[0]);
                    uploadedImageI2.src = URL.createObjectURL(event.target.files[0]);
                });



            </script>
        </div>
    </form>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>
