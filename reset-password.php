<?php
include_once 'helpers/session_helper.php';
?>

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="is-size-6 mb-2 has-text-centered">Parooli uuendamine</h1>
            <?php flash('reset') ?>
            <div class="control">
                <form method="post" action="controllers/ResetPasswords.php">
                    <input type="hidden" name="type" value="send" />
                    <input class="input mb-2" type="text" name="usersEmail" placeholder="E-posti aadress...">
                    <button class="button" type="submit" name="submit">Saada link</button>
                </form>
            </div>
        </div>
    </div>
</div>