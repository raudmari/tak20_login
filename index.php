<?php
include_once 'header.php'
?>
<div class="container">
    <div class="columns is-centered">
        <div class="is-full">
            <h1 class="title is-1 mt-5 has-text-weight-bold">Welcome,
                <?php if (isset($_SESSION['usersId'])) {
                    echo explode(" ", $_SESSION['usersName'])[0];
                } else {
                    echo 'Guest';
                }
                ?>
            </h1>
        </div>
    </div>
</div>

<?php
include_once 'footer.php'
?>