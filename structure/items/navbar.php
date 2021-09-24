<nav id="navbar" class="flexbox">
    <div class="navbar-inner flexbox-right">
        <div class="navbar-right flexbox">
            <?php
            if (isset($currentUser)) { ?>
                <div class="navbar-profilepicture-wrapper">
                    <div class="navbar-profilepicturew-inner">
                        <img class="navbar-profilepicture" src="images/profile-pic.jpg" alt="">
                    </div>
                    <img class="navbar-profilepicture-glow" src="images/profile-pic.jpg" alt="">
                </div>
                <div class="navbar-dropdown">
                    <div class="npw-menu-items flexbox-col-left">
                        <div class="npw-menu-item flexbox-left">
                            <div class="npw-menu-item-inner flexbox-left">
                                <div class="npw-menu-profilepicture-wrapper flexbox-left">
                                    <div class="npw-menu-picture flexbox">
                                        <img class="npw-menu-picture-inner" src="images/profile-pic.jpg" alt="">
                                    </div>
                                </div>
                                <div class="nwp-menu-profile-info-items">
                                    <a class="npw-profile-link flexbox" href="<?php print $rootPath ?>user.php"><?php print $currentUser->username?></a>
                                    <!-- <a class="npw-editprofile-link">Edit&nbspProfile</a> -->
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