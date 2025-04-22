<?php
namespace controllers;
use controllers\QueryBuilder;
use League\Plates\Engine;
use Exception;
use Tamtamchik\SimpleFlash\Flash;
use Delight\Auth\Auth;
use SimpleMail;
use PDO;

class controller{

    private $templates;
    private $auth;
    private $db;
    function __construct(QueryBuilder $db,Engine $templates, Auth $auth){
        $this->auth=$auth;
        $this->db=$db;
        $this->templates = $templates;
    
       // $db = new PDO('mysql:host=MySQL-8.0;dbname=OOP2',"root","");  
       // $this->auth=new \Delight\Auth\Auth($db); 
    }

public function index()
    {
        
        if ($this->auth->isLoggedIn()) {
            $_SESSION['id_user'] = $this->auth->getUserId();
            $_SESSION['username'] = $this->auth->getUsername();
        }
        echo $this->templates->render('register');
    }

    public function login()
    {
        echo $this->templates->render('login');
    }

public function about(){
    
    
    try {
        $userId = $this->auth->register('runia87@mail.ru', '123', 'Ainur', function ($selector, $token) {
            echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
            echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
            echo '  For SMS, consider using a third-party service and a compatible SDK';
        });
    
        echo 'We have signed up a new user with the ID ' . $userId;
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        die('Invalid email address');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        die('Invalid password');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('User already exists');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }

}

public function email_verification(){
    try {
        $this->auth->confirmEmail('KnVpLKISofgS7ch5', '1Dusv0K4WV3s8EzB');
    
        echo 'Email address has been verified';
    }
    catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
        die('Invalid token');
    }
    catch (\Delight\Auth\TokenExpiredException $e) {
        die('Token expired');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('Email address already exists');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
}



public function editUser(){
    $id=$_POST['id'];
$username=$_POST['username'];
$job_title=$_POST['job_title'];
$phone=$_POST['phone'];
$address=$_POST['address'];
    
        redirect_to("edit.php");
       // get_user_by_id($id);
        edit__info($id,$username,$job_title,$phone,$address);
        set_flash_message("success","Профиль успешно обновлен!");
        redirect_to("page_profile.php");
}



public function addUser(){
    $email = $_POST['email'];
$password = $_POST['password'];
$username=$_POST['username'];
$job_title=$_POST['job_title'];
$status=$_POST['status'];
$image=$_POST['image'];
$phone=$_POST['phone'];
$address=$_POST['address'];
$vk=$_POST['vk'];
$telegram=$_POST['tg'];
$instagram=$_POST['insta'];
$is_free = get_user_by_email($email);
if (!empty($is_free)) {
    set_flash_message("danger","Эл.адрес уже занят");
  //  display_flash_message("danger");
    redirect_to("create_user.php");
    
}
else{
    $id = add_user($email,$password);
    edit_Information($id,$username,$job_title,$phone,$address);
   set_status($id,$status);
    upload_avatar($id,$image);
    add_social_links($id,$telegram,$instagram,$vk);
    set_flash_message("success","Регистрация успешна");
    redirect_to("users.php");
  //  display_flash_message("success");
   
}
}

public function changeStatus(){
    $id=$_POST['id'];
$status=$_POST['status'];

set_status($id,$status);
set_flash_message("success","Профиль успешно обновлен!");
redirect_to("page_profile.php");
}

public function delete(){

$authUser=login($_SESSION["login"],$_SESSION["password"]);
$_SESSION['authUserId']=$authUser['id'];
if(is_not_logged_in()){
    redirect_to("page_login.php");
    exit;
}

if(!is_admin($_SESSION['user']))
{if(!is_author($_SESSION['authUserId'],$_GET['id'])){
    set_flash_message("danger","Можно редактировать только свой профиль!");
    redirect_to("users.php");
}}

$user = get_user_by_id($_GET['id']);
$id=$user['id'];
$_SESSION['id']=$_GET['id'];

delete($id);
set_flash_message("success","Пользователь удален!");
if($authUser['id']===$id){
    redirect_to("page_register.php");  
}
else{
    
    redirect_to("users.php");
}
}

public function avatar(){
    $id=$_POST['id'];
$image=$_POST['image'];
upload_avatar($id,$image);
set_flash_message("success","Профиль успешно обновлен!");
redirect_to("page_profile.php");
}

public function changePass(){
    $id=$_POST['id'];
$email=$_POST['email'];
$password=$_POST['password'];
$passwordConfir=$_POST['passwordConfir'];
if($password===$passwordConfir){
edit__credentials($id,$email,$password);
set_flash_message("success","Профиль успешно обновлен!");
redirect_to("page_profile.php");
}
else{
    set_flash_message("danger","Пароли не совпадают!");
redirect_to("security.php?id=$id");

}
}

public function register()
{
    try {
        $this->auth->register($_POST['email'], $_POST['password'], function ($selector, $token) {

            $verification = "<a href='".$_SERVER['HTTP_REFERER'] . '/verification/' . \urlencode($selector) . '/' . \urlencode($token)."'>Verificate your account</a>";

            SimpleMail::make()
                ->setTo($_POST['email_user'], $_POST['name_user'])
                ->setFrom('kupriyanov@awagas.group', 'sergei')
                ->setSubject('Вы успешно зарегистрировались')
                ->setMessage('Вы зарегистрировались на сайте Kup@develop, для подтверждения почты перейдите по '.$verification)
                ->setHtml()
                ->send();
        });

        Flash::message('Вы успешно зарегистрировались, на Kup@develop, на ' .$_POST['email_user'] . ' отправлено письмо для подтверждения', 'success');
        echo $this->templates->render('login');
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        Flash::message('Invalid Email', 'error');
        echo $this->templates->render('register');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        Flash::message('Invalid password', 'error');
        echo $this->templates->render('register');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        Flash::message('User already exists', 'error');
        echo $this->templates->render('register');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        Flash::message('Too many requests', 'error');
        echo $this->templates->render('register');
    }
}

public function loginUser()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            echo $this->templates->render('users');
            //header('Location: /');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            echo $this->templates->render('login');
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            echo $this->templates->render('login');
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            Flash::message('Невозможно войти Ваш Email не подтверждён', 'error');
            header('Location: /');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
   
    public function logout()
    {
        $this->auth->logOut();
        header('Location: /');
    }

    public function verificationUser($data)
    {
        try {
            $this->auth->confirmEmail($data['selector'], $data['token']);

            Flash::message('Почта успешно подтверждена', 'success');
            header('Location: /');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}

?>
