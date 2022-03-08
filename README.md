# tak20_login
   <?php if (!isset($_SESSION['usersId'])) : ?>
                        <!-- kui sessiooni pole, kui kasutaja pole sisse loginud, siis näeb hinnanguid, hinnata ei saa-->
                        <?php
                                $found = false;
                                ?>
                        <?php else : ?>
                        <!-- kui sessiooni on, kasutaja on sisse loginud, siis näeb hinnanguid ja saab ka hinnata-->
                        <?php
                                $found = false;
                                foreach ($usresRS as $k => $v) {
                                    if ($val->id == $v->book_id) { // kui found on tõene siis raamatut on sisselogitud kasutaja poolt juba kord hinnatud.
                                        $found = true;
                                    }
                                }
                                ?>
                        <?php endif; ?>

                        settings_result =
                            <?= json_encode($allow); ?>; // settings_result javascripti jaoks loetavaks muudetud
                        found = <?= json_encode($found); ?>;
                        if (settings_result) {
                            found = false;
                        }

                              $.ajax({
                                    type: 'POST',
                                    url: '<?= $setBookValue ?>',
                                    data: {
                                        rating: rate,
                                        username: username,
                                        id: id
                                    },
                                    success: function(data) {
                                        console.log('Rating updated');
                                        location.reload(true);
                                    },
                                    error: function(data) {
                                        console.log('Rating error');
                                    }

                                })