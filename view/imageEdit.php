<?php $this->layout('layout', ['title' => 'Пользователи']) ?>
<?php
use controllers\QueryBuilder;
use controllers\controller;
use function Tamtamchik\SimpleFlash\flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
session_start();
$db = new QueryBuilder();
echo flash()->display();
$id=$_GET['id'];
$user = $db->getOne('users', $id);
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
// $_SESSION['id']=$_GET['id'];
?>

    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-image'></i> Загрузить аватар
            </h1>

        </div>
        <form action="/avatar" method="POST">
        
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Текущий аватар</h2>
                            </div>
                            <div class="panel-content">
                                <div class="form-group">
                                    <img src= "<?= $user['image']==""?'img/demo/avatars/avatar-m.png' : $user['image'] ?>" alt="" class="img-responsive" width="200">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                    <input type="file" name="image" id="example-fileinput" class="form-control-file">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Загрузить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    