<?php $this->layout('layout', ['title' => 'Пользователи']) ?>
<?php
use controllers\QueryBuilder;
use function Tamtamchik\SimpleFlash\flash;
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
$status = [
    'Онлайн',
    'Отошел',
    'Не беспокоить',
];

?>

    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить статус
            </h1>

        </div>
        <form action="/changeStatus" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка текущего статуса</h2>
                            </div>
                            <div class="panel-content">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <select class="form-control" id="example-select" name="status">
                                            <?php foreach ($status as $item): ?>
                                                    <option <?= $user['status'] == $item ? 'selected' : '' ?>><?= $item; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Set Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>