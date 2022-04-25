<?php ?>
<header class="header">
    <div class="header__menu">
        <div class="container">
            <?php
                if($_SESSION['user'] == null){
            ?>
            <img src="icons/Logo.svg" alt="логотип" class="col-md-1 mt-2 header__logo">
            <button class="offset-md-7 col-md-2 button" onclick="window.location.href='#reg_popub'">
                Регистрация
            </button>
             <?php

            ?>

            <button class="col-md-2 button" onclick="window.location.href='#auth_popub'">
                Вход
            </button>
            <?php
                }
                else{
            ?>
             <button class="offset-md-7 col-md-3 button button_profile" onclick="window.location.href='profile.php'">
                <?php echo $_SESSION['user'] ;?>
            </button>
            <?php
                }
            ?>
        </div>
    </div>
</header>
