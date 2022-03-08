<?php
include 'templates/header.php';
include 'templates/navbar.php';
if (empty($_GET['selector']) || empty($_GET['validator'])) {
    echo 'Kahjuks ei õnnestu päringut valideerida!';
} else {
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];

    if (ctype_xdigit($selector) && ctype_xdigit($validator)) { ?>
<?php
        include_once './helpers/session_helper.php';
        ?>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-full">
            <h1 class="is-size-6 mb-2 has-text-centered">Parooli uuendamine</h1>
            <?php flash('newReset') ?>
            <div class="control">
                <form method="post" action="./controllers/ResetPasswords.php">
                    <input type="hidden" name="type" value="reset" />
                    <input type="hidden" name="selector" value="<?php echo $selector ?>" />
                    <input type="hidden" name="validator" value="<?php echo $validator ?>" />
                    <input class="input mb-2" type="password" name="pwd" placeholder="Sisesta uus parool...">
                    <input class="input mb-2" type="password" name="pwd-repeat"
                        placeholder="Sisesta uus parool uuesti...">
                    <button class="button is-light" type="submit" name="submit">Uuenda parool</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        echo 'Antud päringut ei õnnestu valideerida!';
    }
}
include 'templates/footer.php'
?>