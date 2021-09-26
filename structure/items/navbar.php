<nav id="navbar" class="flexbox">
    <div class="navbar-inner flexbox-right">
        <div class="navbar-right flexbox">
            <?php
            if (isset($currentUser)) { ?>
                <div class="navbar-profilepicture-wrapper">
                    <div class="navbar-profilepicturew-inner">
                        <?php print '<img class="navbar-profilepicture" src="data:media_type;base64,' . base64_encode($displayUser->profilePicture) . '" alt="">'; ?>
                    </div>
                    <?php print '<img class="navbar-profilepicture-glow" src="data:media_type;base64,' . base64_encode($displayUser->profilePicture) . '" alt="">'; ?>
                </div>
                <div class="navbar-dropdown">
                    <div class="npw-menu-items flexbox-col-left">
                        <div class="npw-menu-item flexbox-left">
                            <div class="npw-menu-item-inner flexbox-left">
                                <div class="npw-menu-profilepicture-wrapper flexbox-left">
                                    <div class="npw-menu-picture flexbox">
                                        <?php print '<img class="npw-menu-picture-inner" src="data:media_type;base64,' . base64_encode($displayUser->profilePicture) . '" alt="">'; ?>
                                    </div>
                                </div>
                                <div class="nwp-menu-profile-info-items">
                                    <a class="npw-profile-link flexbox" href="<?php print $rootPath ?>user.php"><?php print $currentUser->username?></a>
                                    <a class="npw-editprofile-link" href="<?php print $rootPath ?>user-edit.php">Rediger&nbspProfil</a>
                                </div>
                            </div>
                        </div>
                        <div class="npw-menu-item flexbox-left"><a class="npw-menu-item-inner flexbox-left" href="backend/logout.php"><span class="material-icons">logout</span>Logg ut</a></div>
                    </div>
                </div>
            <?php } else { ?>
                    <!-- Will be changed -->
                <a href="<?php print $rootPath ?>login.php"><button>Logg inn</button></a>
            <?php }
            ?>
        </div>
    </div>
</nav>