<?php
require_once 'controllers/RateChildMouths.php';

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
                    <td class=""><?= $val['child_text']; ?></td>
                    <td class="has-text-centered">
                        <div class="my-rating" id='<?= $val['id'] ?>'></div>


                        <script>
                        $('.my-rating').starRating({
                            starSize: 25,
                            disableAfterRate: !settings_result,
                            readOnly: found,
                            initialRating: <?= $val['rate']; ?>,
                            callback: function(currentRating, $el) {
                                let rate = currentRating; // Mitu tärni valiti
                                let ip_add = '<?= $ip_add ?>';
                                let id = $el[0].id; // my-rating id=
                                console.log(rate, ip_add, id); // Testiks
                                $.ajax({
                                    type: 'POST',
                                    url: 'setMouthValue.php',
                                    data: {
                                        cm_id: id,
                                        rating_number: rate,
                                        ip_add: ip_add

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