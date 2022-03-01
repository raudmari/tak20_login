<?php
include_once 'helpers/session_helper.php';
?>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-two-fifths">
            <h1 class="is-size-6 mb-2 has-text-centered">Registreeri end kasutajaks</h1>
            <?php flash('register') ?>
            <div class="control">
                <form method="post" action="./controllers/Users.php">
                    <input class="input" type="hidden" name="type" value="register">
                    <!-- peidetud input, et saata kasutaja andmed edasi -->
                    <input class="input mb-2" type="text" name="usersName" placeholder="Ees- ja perenimi...">
                    <input class="input mb-2" type="text" name="usersEmail" placeholder="E-posti aadress...">
                    <input class="input mb-2" type="text" name="usersUid" placeholder="Kasutajanimi...">
                    <input class="input mb-2" type="password" name="usersPwd" placeholder="Parool...">
                    <input class="input mb-2" type="password" name="pwdRepeat" placeholder="Parool uuesti">
                    <button class="button" type="submit" name="submit">Registreeri</button>
                </form>
            </div>
        </div>
    </div>
</div>