<?php 
session_start();

// connecter a la base de donné
$db = mysqli_connect('localhost', 'root', 'rootroot', 'multi_login');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// appeler la fonction register() si register_btn est cliqué
if (isset($_POST['register_btn'])) {
        register();
}

// REGISTER USER
function register(){
    global $db, $errors, $username, $email;

    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);

    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    }
    if (empty($email)) { 
        array_push($errors, "Email is required"); 
    }
    if (empty($password_1)) { 
        array_push($errors, "Password is required"); 
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    if (count($errors) == 0) {
        $password = md5($password_1);

        try {
            $user_type = isset($_POST['user_type']) ? e($_POST['user_type']) : 'user';
            
            $query = "INSERT INTO users (username, email, user_type, password) 
                                VALUES('$username', '$email', '$user_type', '$password')";
            $result = mysqli_query($db, $query);

            if (!$result) {
                array_push($errors, "Erreur de requête : " . mysqli_error($db));
            } else {
                if ($user_type == 'user') {
                    $logged_in_user_id = mysqli_insert_id($db);
                    $_SESSION['user'] = getUserById($logged_in_user_id);
                }

                $_SESSION['success']  = "User successfully created!!";
                header('location: ' . ($user_type == 'user' ? 'index1.php' : 'home.php'));
            }
        } catch (Exception $e) {
            array_push($errors, "Error: " . $e->getMessage());
        }
    }
}




// return user array from their id
function getUserById($id){
    global $db;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($db));
    }

    $user = mysqli_fetch_assoc($result);
    var_dump($user); 

    return $user;
}



// escape string
function e($val){
        global $db;
        return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
        global $errors;

        if (count($errors) > 0){
                echo '<div class="error">';
                        foreach ($errors as $error){
                                echo $error .'<br>';
                        }
                echo '</div>';
        }
}   
function isLoggedIn()
{
        if (isset($_SESSION['user'])) {
                return true;
        }else{
                return false;
        }
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}
// appeler la fonction login() si le register_btn est cliqué
if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN USER
function login(){
    global $db, $username, $errors;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // to make sure form is filled properly
    if (empty($username)) {
            array_push($errors, "Username is required");
    }
    if (empty($password)) {
            array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
            $password = md5($password);

            $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                    // check if user is admin ou user
                    $logged_in_user = mysqli_fetch_assoc($results);
                    if ($logged_in_user['user_type'] == 'admin') {

                            $_SESSION['user'] = $logged_in_user;
                            $_SESSION['success']  = "You are now logged in";
                            header('location: admin/home.php');               
                    }else{
                            $_SESSION['user'] = $logged_in_user;
                            $_SESSION['success']  = "You are now logged in";

                            header('location: index1.php');
                    }
            }else {
                    array_push($errors, "Wrong username/password combination");
            }
    }
}
function isAdmin()
{
        if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
                return true;
        }else{
                return false;
        }
}
