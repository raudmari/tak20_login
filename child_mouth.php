<?php
require_once 'controllers/RateChildMouths.php';
require_once 'controllers/AllowRewriting.php';

if (isset($_SESSION['usersUid'])) {
    $username = $_SESSION['usersUid'];
} elseif (isset($_SESSION['usersEmail'])) {
    $username = $_SESSION['usersEmail'];
}
?>

<div class="columns m-1">
    <div class="column">
        <h1 class="is-size-2 has-text-centered mb-2">Lapsesuu ei valeta</h1>
        <?php if ($results) : ?>
        <table class="table is-fullwidth is-hoverable is-bordered">
            <thead class="has-text-centered">
                <tr>
                    <th>Tekst</th>
                    <th style="width: 150px;">Hinnang</th>
                </tr>
            </thead>
            <cmody>
                <?php foreach ($results as $key => $val) : ?>
                <tr>
                    <td class=""><?= $val->child_text; ?></td>
                    <td class="has-text-centered">
                        <div class="my-rating" id='<?= $val->id ?>'></div>
                        <script>
                        $('.my-rating').starRating({
                            starSize: 20,
                            //disableAfterRate: !settings_result,
                            //readOnly: found,
                            initialRating: <?= $val->rate; ?>,
                            callback: function(currentRating, $el) {
                                let id = $el[0].id;
                                let rate = currentRating;
                                let username = '<?= $username ?>';
                                console.log(rate, username, id); // Testiks
                                $.ajax({
                                    type: 'POST',
                                    url: 'controllers/RateChildMouths.php',
                                    data: {
                                        id: id,
                                        rating: rate,
                                        username: username

                                    },
                                    success: function(data) {
                                        console.log('Rating updated');
                                        location.reload(true);
                                    },
                                    error: function(data) {
                                        console.log('Rating error')
                                    }
                                });
                            }
                        })
                        </script>
                    </td>
                </tr>

                <?php endforeach; ?>
            </cmody>
        </table>
        <?php else : ?>
        <!-- EI saadud DB midagi-->
        <h4 class="is-size-4 has-text-centered has-text-danger">Ei leitud midagi</h4>
        <?php endif; ?>
    </div>
</div>