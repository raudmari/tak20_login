<?php
require '../models/User.php';
require '../helpers/session_helper.php';

class Users
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function register()
    {
        //Process form

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST);

        //Init data
        $data = [
            'usersName' => htmlspecialchars(trim($_POST['usersName'])),
            'usersEmail' => htmlspecialchars(trim($_POST['usersEmail'])),
            'usersUid' => htmlspecialchars(trim($_POST['usersUid'])),
            'usersPwd' => htmlspecialchars(trim($_POST['usersPwd'])),
            'pwdRepeat' => htmlspecialchars(trim($_POST['pwdRepeat']))
        ];

        //Validate inputs
        if (
            empty($data['usersName']) || empty($data['usersEmail']) || empty($data['usersUid']) ||
            empty($data['usersPwd']) || empty($data['pwdRepeat'])
        ) {
            flash("register", "Täida palun kõik väljad");
            redirect("../signup");
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $data['usersUid'])) {
            flash("register", "kasutajanimi ei tohi sisaldada tähemärkidest ja numbritest erinevaid sümboleid!");
            redirect("../signup");
        }

        if (!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)) {
            flash("register", "e-posti aadress ei ole korrektne");
            redirect("../signup");
        }

        if (strlen($data['usersPwd']) < 6) {
            flash("register", "Parool liiga lühike");
            redirect("../signup.php");
        } else if ($data['usersPwd'] !== $data['pwdRepeat']) {
            flash("register", "Paroolid ei klapi");
            redirect("../signup");
        }

        //User with the same email or password already exists
        if ($this->userModel->findUserByEmailOrUsername($data['usersEmail'], $data['usersName'])) {
            flash("register", "Antud kasutajanimi või e-posti aadress on juba kasutuses");
            redirect("../signup");
        }

        //Passed all validation checks.
        //Now going to hash password
        $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

        //Register User
        if ($this->userModel->register($data)) {
            redirect("../login");
        } else {
            die("Tekkis viga");
        }
    }

    public function login()
    {
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST);

        //Init data
        $data = [
            'name/email' => htmlspecialchars(trim($_POST['name/email'])),
            'usersPwd' => htmlspecialchars(trim($_POST['usersPwd']))
        ];

        if (empty($data['name/email']) || empty($data['usersPwd'])) {
            flash("login", "Palun täida kõik väljad");
            header("location: ../login");
            exit();
        }

        //Check for user/email
        if ($this->userModel->findUserByEmailOrUsername($data['name/email'], $data['name/email'])) {
            //User Found
            $loggedInUser = $this->userModel->login($data['name/email'], $data['usersPwd']);
            if ($loggedInUser) {
                //Create session
                $this->createUserSession($loggedInUser);
            } else {
                flash("login", "Salasõna on vale");
                redirect("../login");
            }
        } else {
            flash("login", "Kasutajat ei leitud");
            redirect("../login");
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['usersId'] = $user->usersId;
        $_SESSION['usersName'] = $user->usersName;
        $_SESSION['usersEmail'] = $user->usersEmail;
        redirect("../avaleht");
    }

    public function logout()
    {
        unset($_SESSION['usersId']);
        unset($_SESSION['usersName']);
        unset($_SESSION['usersEmail']);
        session_destroy();
        redirect("../avaleht");
    }
}

$init = new Users;

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            redirect("../avaleht");
    }
} else {
    switch ($_GET['q']) {
        case 'logout':
            $init->logout();
            break;
        default:
            redirect("../avaleht");
    }
}