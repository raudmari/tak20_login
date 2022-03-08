<?php
include_once 'controllers/RateBooks.php';
include_once 'controllers/AllowRewriting.php';

if (isset($_SESSION['usersUid'])) {
    $username = $_SESSION['usersUid'];
} elseif (isset($_SESSION['usersEmail'])) {
    $username = $_SESSION['usersEmail'];
}


?>
<div class="columns m-1">
    <div class="column">

        <h1 class="is-size-2 has-text-centered mb-2">TOP 100 Rahva Raamatut 2021 aastal<sup
                title="Link lehe lõpus">*</sup></h1>
        <table class="table is-fullwidth is-hoverable is-bordered">
            <thead class="has-text-centered">
                <tr>
                    <th>Jkn</th>
                    <th>Raamatu nimi</th>
                    <th>Raamatu autor</th>
                    <th>Hinnang</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $key => $val) : ?>
                <tr>
                    <td class="has-text-right"><?= ($key + 1); ?>.</td>
                    <td><?= $val->book_name; ?></td>
                    <td><?= $val->book_author; ?></td>
                    <td class="has-text-centered">
                        <div class="my-rating" id='<?= $val->id ?>'></div>
                        <?php if (!isset($_SESSION['usersId'])) : ?>
                        <!-- kui sessiooni pole, kui kasutaja pole sisse loginud, siis näeb hinnanguid, hinnata ei saa-->
                        <?php
                                $found = false;
                                ?>
                        <?php else : ?>
                        <!-- kui sessiooni on, kasutaja on sisse loginud, siis näeb hinnanguid ja saab ka hinnata-->
                        <?php
                                $found = false;
                                foreach ($usresRB as $k => $v) {
                                    if ($val->id == $v->book_id) { // kui found on tõene siis raamatut on sisselogitud kasutaja poolt juba kord hinnatud.
                                        $found = true;
                                    }
                                }
                                ?>
                        <?php endif; ?>

                        <script>
                        settings_result =
                            <?= json_encode($allow); ?>; // settings_result javascripti jaoks loetavaks muudetud
                        found = <?= json_encode($found); ?>;
                        if (settings_result) {
                            found = false;
                        }
                        $('.my-rating').starRating({
                            starSize: 20,
                            disableAfterRate: !settings_result,
                            readOnly: found,
                            initialRating: <?= $val->rate; ?>, // näitab esialgset väärtust, mis hinnanguna antud
                            callback: function(currentRating, $el) {
                                let id = $el[0].id;
                                let rate = currentRating;
                                let username = '<?= $username ?>';
                                console.log(id, rate, username);
                                $.ajax({
                                    type: 'POST',
                                    url: 'controllers/RateBooks.php',
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
                                        console.log('Rating error');
                                    }
                                })
                            }
                        })
                        </script>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
        * - <a href="https://raamatud.postimees.ee/7419531/selgusid-rahva-raamatu-2021-aasta-populaarseimad-raamatud"
            target="_blank">https://raamatud.postimees.ee/7419531/selgusid-rahva-raamatu-2021-aasta-populaarseimad-raamatud</a>
    </div>
</div>