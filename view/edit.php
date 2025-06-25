<?php $this->layout('layout', ['title' => 'Пользователи']) ?>
<?php 
use controllers\QueryBuilder;
use function Tamtamchik\SimpleFlash\flash;
//use PDO;
session_start();
$db = new QueryBuilder();
echo flash()->display();
$id=$_GET['id'];
$user = $db->getOne('users', $id);
//require "functions.php";
//$authUser=login($_SESSION["login"],$_SESSION["password"]);
//$_SESSION['authUserId']=$authUser['id'];
// if(is_not_logged_in()){
//     redirect_to("page_login.php");
//     exit;
// }

// if(!is_admin($_SESSION['user']))
// {if(!is_author($_SESSION['authUserId'],$_GET['id'])){
//     set_flash_message("danger","Можно редактировать только свой профиль!");
//     redirect_to("users.php");
// }}

// $user = get_user_by_id($_GET['id']);
// $_SESSION['id']=$_GET['id'];

//var_dump($_POST['id']);
//var_dump($user);
?>

    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
            </h1>

        </div>
        <form action="/profile" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Общая информация</h2>
                            </div>
                            <div class="panel-content">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <!-- username -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Имя</label>
                                    <input type="text" name="username" class="form-control" value=<?= $user['username']; ?>>
                                </div>
                                <!-- title -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Место работы</label>
                                    <input type="text" id="simpleinput" name="job_title" class="form-control" value=<?= $user['job_title']; ?>>
                                </div>

                                <!-- tel -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Номер телефона</label>
                                    <input type="text" id="simpleinput" name="phone" class="form-control" value=<?= $user['phone']; ?> >
                                </div>

                                <!-- address -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Адрес</label>
                                    <input type="text" id="simpleinput" name="address" class="form-control" value=<?= $user['address']; ?> >
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Редактировать</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>