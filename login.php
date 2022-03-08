<?php
include_once 'helpers/session_helper.php';
?>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-full">
            <h1 class="is-size-6 mb-2 has-text-centered">Palun logi sisse</h1>
            <?php flash('login') ?>
            <div class="control">
                <form method="post" action="./controllers/Users.php">
                    <input type="hidden" name="type" value="login">
                    <input class="input mb-2" type="text" name="name/email" placeholder="Kasutajanimi/Email...">
                    <input class="input mb-2" type="password" name="usersPwd" placeholder="Parool...">
                    <button class="button is-light mb-2" type="submit" name="submit">Logi sisse</button>
                </form>
                <div>
                    <a href="./reset-password">Unustasid parooli?</a>
                </div>
            </div>
        </div>
    </div>
</div>