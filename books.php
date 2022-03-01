<?php
require_once 'controllers/RateBooks.php';

if (isset($_SESSION['usersName'])) {
    $username = $_SESSION['usersName'];
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
                    <td><?= $val['book_name']; ?></td>
                    <td><?= $val['book_author']; ?></td>
                    <td class="has-text-centered">
                        <div class="my-rating" id='<?= $val['id'] ?>'></div>

                        <script>
                        $('.my-rating').starRating({
                            starSize: 25,
                            //disableAfterRate: !settings_result,
                            //readOnly: found,
                            initialRating: <?= $val['rate']; ?>, // näitab esialgset väärtust, mis hinnanguna antud
                            callback: function(currentRating, $el) {
                                let rate = currentRating; // Mitu tärni valiti
                                let username = '<?= $username ?>';
                                let id = $el[0].id; // my-rating id=
                                console.log(rate, username, id); // Testiks
                                $.ajax({
                                    type: 'POST',
                                    url: '<?= $setBooksValues; ?>',
                                    data: {
                                        book_id: id,
                                        rating_number: rate,
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

            </tbody>
        </table>
        * - <a href="https://raamatud.postimees.ee/7419531/selgusid-rahva-raamatu-2021-aasta-populaarseimad-raamatud"
            target="_blank">https://raamatud.postimees.ee/7419531/selgusid-rahva-raamatu-2021-aasta-populaarseimad-raamatud</a>
    </div>
</div>