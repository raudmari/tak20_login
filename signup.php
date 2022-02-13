<?php
include_once 'header.php';
include_once './helpers/session_helper.php';
?>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-two-fifths">
            <h1 class="is-size-6 mb-2 has-text-centered">Please Signup</h1>
            <?php flash('register') ?>
            <div class="control">
                <form method="post" action="./controllers/Users.php">
                    <input class="input" type="hidden" name="type" value="register">
                    <!-- peidetud input, et saata kasutaja andmed edasi -->
                    <input class="input mb-2" type="text" name="usersName" placeholder="Full name...">
                    <input class="input mb-2" type="text" name="usersEmail" placeholder="Email...">
                    <input class="input mb-2" type="text" name="usersUid" placeholder="Username...">
                    <input class="input mb-2" type="password" name="usersPwd" placeholder="Password...">
                    <input class="input mb-2" type="password" name="pwdRepeat" placeholder="Repeat password">
                    <button class="button" type="submit" name="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'footer.php'
?>