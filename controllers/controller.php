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
        // if ($this->auth->isLoggedIn()) {
        //     $_SESSION['id_user'] = $this->auth->getUserId();
        //     $_SESSION['username'] = $this->auth->getUsername();
        // }
        echo $this->templates->render('register');
    }

    public function login()
    {
        Flash::message('Посетить нас могут только зарегистрированные пользователи', 'error');
        echo $this->templates->render('/login');
    }


    public function create_user()
    {
        echo $this->templates->render('/create_user');
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
//$db = new QueryBuilder();
$id=$_POST['id'];
$username=$_POST['username'];
$job_title=$_POST['job_title'];
$phone=$_POST['phone'];
$address=$_POST['address'];
    
echo $this->templates->render('edit'); 
       // get_user_by_id($id);
        $this->db->edit__info($id,$username,$job_title,$phone,$address);
        Flash::message('Профиль успешно обновлен!', 'success');
    echo $this->templates->render('page_profile'); 
}



public function addUser(){
//db = new QueryBuilder();
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
$is_free = $this->db->getEmail('users', $email);
if (!empty($is_free)) {
    Flash::message('Эл.адрес уже занят', 'danger');
    echo $this->templates->render('create_user'); 
}
else{
    $id = $this->db->add_user($email,$password);
    $this->db->edit_Information($id,$username,$job_title,$phone,$address);
   $this->db->set_status($id,$status);
    $this->db->upload_avatar($id,$image);
    $this->db->add_social_links($id,$telegram,$instagram,$vk);
    Flash::message('Пользователь успешно добавлен!', 'success');
    echo $this->templates->render('users'); 
}
}

public function changeStatus(){
//$db = new QueryBuilder();
$id=$_POST['id'];
$status=$_POST['status'];
$this->db->set_status($id,$status);
Flash::message('Профиль успешно обновлен!', 'success');
echo $this->templates->render('page_profile'); 
}

public function delete(){
$authUser=$this->db->login($_SESSION["login"],$_SESSION["password"]);
$_SESSION['authUserId']=$authUser['id'];
if(is_not_logged_in()){
    echo $this->templates->render('login'); 
    exit;
}

if(!is_admin($_SESSION['user']))
{if(!is_author($_SESSION['authUserId'],$_GET['id'])){
    Flash::message('Можно редактировать только свой профиль!', 'danger');
    echo $this->templates->render('users'); 
}}

$user = $this->db->getOne('users', $_GET['id']);
$id=$user['id'];
$_SESSION['id']=$_GET['id'];

$this->db->delete($id);
Flash::message('Пользователь удален!', 'success');
if($authUser['id']===$id){
    echo $this->templates->render('register'); 
}
else{
    
    echo $this->templates->render('users'); 
}
}

public function avatar(){
//$db = new QueryBuilder();
$id=$_POST['id'];
$image=$_POST['image'];
$this->db->upload_avatar($id,$image);
Flash::message('Профиль успешно обновлен!', 'success');
echo $this->templates->render('page_profile'); 
}

public function changePass(){
$id=$_POST['id'];
$email=$_POST['email'];
$password=$_POST['password'];
$passwordConfir=$_POST['passwordConfir'];
if($password===$passwordConfir){
$this->db->edit__credentials($id,$email,$password);
Flash::message('Профиль успешно обновлен!', 'success');
echo $this->templates->render('page_profile'); 
}
else{
    Flash::message('Пароли не совпадают!', 'danger');
    echo $this->templates->render('security?id=$id'); 

}
}

public function register()
{
    try {
        $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'],function ($selector, $token) {

            $verification = "<a href='".$_SERVER['HTTP_REFERER'] . '/verification/' . \urlencode($selector) . '/' . \urlencode($token)."'>Verificate your account</a>";

            SimpleMail::make()
                ->setTo($_POST['email'], $_POST['username'])
                ->setFrom('runia87@mail.ru', 'runia87')
                ->setSubject('Вы успешно зарегистрировались')
                ->setMessage('Вы зарегистрировались на сайте Учебный проект, для подтверждения почты перейдите по '.$verification)
                ->setHtml()
                ->send();
        });

        Flash::message('Вы успешно зарегистрировались, на Учебном проекте, на ' .$_POST['email'] . ' отправлено письмо для подтверждения', 'success');
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

public function users()
    {
        //echo $this->templates->render('/users');
        //echo $this->db->getAll('users');
       $db = new QueryBuilder();
       //$db = new PDO('mysql:host=MySQL-8.0;dbname=OOP2',"root",""); 
       // $auth = new Auth(\Delight\Auth\Auth($db));
       // d($this->auth->getRoles()); die;
$users=$db->getAll('users');
// if ($auth->hasRole(\Delight\Auth\Role::admin)) {
//     echo 'The user is admin';
// }
echo $this->templates->render('users', ['users' => $users]);
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