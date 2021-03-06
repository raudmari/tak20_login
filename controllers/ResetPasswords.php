<?php

use PHPMailer\PHPMailer\PHPMailer;

require '../models/ResetPassword.php';
require '../helpers/session_helper.php';
require '../models/User.php';
//Require PHP Mailer
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';

class ResetPasswords
{
    private $resetModel;
    private $userModel;
    private $mail;

    public function __construct()
    {
        $this->resetModel = new ResetPassword;
        $this->userModel = new User;
        //Setup PHPMailer
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 1;
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Host = ';
        $this->mail->Port = 587;
        $this->mail->Username = '';
        $this->mail->Password = '';
    }

    public function sendEmail()
    {
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST);
        $usersEmail = htmlspecialchars(trim($_POST['usersEmail']));

        if (empty($usersEmail)) {
            flash("reset", "Palun lisa e-posti aadress");
            redirect("../reset-password");
        }

        if (!filter_var($usersEmail, FILTER_VALIDATE_EMAIL)) {
            flash("reset", "Vale e-posti aadress");
            redirect("../reset-password");
        }
        //Will be used to query the user from the database
        $selector = bin2hex(random_bytes(8));
        //Will be used for confirmation once the database entry has been matched
        $token = random_bytes(32);
        //URL will vary depending on where the website is being hosted from
        $url = 'https://marion.kehtnakhk.ee/tak20_login_edit/create-new-password.php?selector=' . $selector . '&validator=' . bin2hex($token);
        //Expiration date will last for half an hour
        $expires = date("U") + 1800;
        if (!$this->resetModel->deleteEmail($usersEmail)) {
            die("Ilmnes viga");
        }
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        if (!$this->resetModel->insertToken($usersEmail, $selector, $hashedToken, $expires)) {
            die("Ilmnes viga");
        }
        //Can Send Email Now
        $subject = "Reset your password";
        $message = "<p>We recieved a password reset request.</p>";
        $message .= "<p>Here is your password reset link: </p>";
        $message .= "<a href='" . $url . "'>" . $url . "</a>";

        $this->mail->setFrom('raudmari@gamil.com', 'Login_Edit_Admin');
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->addAddress($usersEmail);

        $this->mail->send();

        flash("reset", "Vaata oma e-posti", 'box has-background-success-light has-text-success');
        redirect("../reset-password");
    }

    public function resetPassword()
    {
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST);
        $data = [
            'selector' => htmlspecialchars(trim($_POST['selector'])),
            'validator' => htmlspecialchars(trim($_POST['validator'])),
            'pwd' => htmlspecialchars(trim($_POST['pwd'])),
            'pwd-repeat' => htmlspecialchars(trim($_POST['pwd-repeat']))
        ];
        $url = '../create-new-password.php?selector=' . $data['selector'] . '&validator=' . $data['validator'];

        if (empty($_POST['pwd'] || $_POST['pwd-repeat'])) {
            flash("newReset", "Palun t??ida k??ik v??ljad");
            redirect($url);
        } else if ($data['pwd'] != $data['pwd-repeat']) {
            flash("newReset", "Paroolid on erinevad");
            redirect($url);
        } else if (strlen($data['pwd']) < 6) {
            flash("newReset", "Vale parool");
            redirect($url);
        }

        $currentDate = date("U");
        if (!$row = $this->resetModel->resetPassword($data['selector'], $currentDate)) {
            flash("newReset", "Kahjuks pole antud link enam aktiivne!");
            redirect($url);
        }

        $tokenBin = hex2bin($data['validator']);
        $tokenCheck = password_verify($tokenBin, $row->pwdResetToken);
        if (!$tokenCheck) {
            flash("newReset", "Palun saada oma p??ring uuesti!");
            redirect($url);
        }

        $tokenEmail = $row->pwdResetEmail;
        if (!$this->userModel->findUserByEmailOrUsername($tokenEmail, $tokenEmail)) {
            flash("newReset", "Tekkis viga");
            redirect($url);
        }

        $newPwdHash = password_hash($data['pwd'], PASSWORD_DEFAULT);
        if (!$this->userModel->resetPassword($newPwdHash, $tokenEmail)) {
            flash("newReset", "Tekkis viga");
            redirect($url);
        }

        if (!$this->resetModel->deleteEmail($tokenEmail)) {
            flash("newReset", "Tekkis viga");
            redirect($url);
        }

        flash("newReset", "Parool uuendatud", 'box has-background-success-light has-text-success');
        redirect($url);
    }
}

$init = new ResetPasswords;

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'send':
            $init->sendEmail();
            break;
        case 'reset':
            $init->resetPassword();
            break;
        default:
            header("location: ../avaleht");
    }
} else {
    header("location: ../avaleht");
}