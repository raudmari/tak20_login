<?php
include_once 'controllers/AllowRewriting.php';
?>

<nav class="navbar is-light is-size-4 p-2 mb-4" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <div class="navbar-item">
            <a class="button is-gray-lighter" href="avaleht">
                <i class="fas fa-l fa-home"></i>
            </a>
        </div>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="books" class="button is-dark">
                        <i class="fas fa-book"></i>
                    </a>
                    <a href="child_mouth" class="button is-dark">
                        <i class="fas fa-smile"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <?php if (!isset($_SESSION['usersId'])) : ?>

                    <a class="button is-dark" href="signup">
                        <i class="fas fa-user-plus"></i>
                    </a>
                    <a class="button is-grey " href="login">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                    <?php else : ?>

                    <a href="" class="button is-grey"> <label for="" class="checkbox">

                            <input type="checkbox" name="allow" id="user_settings" value="<?= $allow ?>" <?php if ($allow) {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                            Luba hinnangut muuta

                        </label></a>

                    <a class="button is-dark" href="controllers/Users.php?q=logout">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>

</nav>

<script>
$(document).ready(function() {

    // Check for click events on the navbar burger icon
    $(".navbar-burger").click(function() {

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");

    });

    $('#user_settings').change(function() {
        let allow = "<?= $allow; ?>"; // Tekstina
        if (allow) {
            allow = 0; // Numbrina
        } else {
            allow = 1;
        }
        $.ajax({
            type: 'POST',
            url: '<?= $rateSettings ?>',
            data: {
                allow: allow,
                id: 1
            },
            success: function(data) {
                console.log(data)
                console.log('Settings updated');
                location.reload(true);
            },
            error: function(data) {
                console.log('Settings error');
            }
        });
    });
});
</script>