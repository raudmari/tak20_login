<?php
# Nice URL and all over index.php
$ProjectFolder = "/tak20_login_edit/"; # ÄRA UNUSTA .htaccess FAILI!
# Eemaldame kausta osa URL reast
$request = str_replace($ProjectFolder, "/", $_SERVER['REQUEST_URI']);
# Eemaldame $request eest / ehk /default_seo/ => default_seo/
$request = substr($request, 1, strlen($request));
# Teeme selle slashist (/) osadeks
$req = explode('/', $request);

define('PROJECT_FULL_URL', 'https://' . $_SERVER['SERVER_NAME'] . $ProjectFolder);


function show($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
