<?php $this->layout('layout', ['title' => 'Пользователи']) ?>
<?php
use function Tamtamchik\SimpleFlash\flash;
use controllers\QueryBuilder;
session_start();
$db = new QueryBuilder();
echo flash()->display();
$_SESSION['id']=$_GET['id'];
$id=$_SESSION['id'];
$user = $db->getOne('users', $id);
?>
<?php



// require "functions.php";
// $authUser=login($_SESSION["login"],$_SESSION["password"]);
// $_SESSION['authUserId']=$authUser['id'];
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
//$_SESSION['id']=$_GET['id'];
?>


    <main id="js-page-content" role="main" class="page-content mt-3">
    <?php if(isset($_SESSION["success"])):?>
                                            <div class="alert alert-success text-dark" role="alert">
                                                <?php echo $_SESSION["success"]; 
                                            unset($_SESSION["success"]);
                                            
                                            endif; ?>
                                            <?php if(isset($_SESSION["danger"])):?>
                                            <div class="alert alert-danger text-dark" role="alert">
                                                <?php echo $_SESSION["danger"]; 
                                            unset($_SESSION["danger"]);
                                            
                                            endif; ?>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-lock'></i> Безопасность
            </h1>

        </div>
        <form action="/changePass" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление эл. адреса и пароля</h2>
                            </div>
                            <div class="panel-content">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Email</label>
                                    <input type="text" name="email" id="simpleinput" class="form-control" value=<?= $user['email']; ?>>
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Пароль</label>
                                    <input type="password" name="password" id="simpleinput" class="form-control">
                                </div>

                                <!-- password confirmation-->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                                    <input type="password" name="passwordConfir" id="simpleinput" class="form-control">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Изменить</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>
