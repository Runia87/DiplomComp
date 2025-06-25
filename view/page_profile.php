<?php $this->layout('layout', ['title' => 'Пользователи']) ?>
<?php 
use controllers\QueryBuilder;
use function Tamtamchik\SimpleFlash\flash;
session_start();
$db = new QueryBuilder();
echo flash()->display();
$id=$_POST['id'];
$user = $db->getOne('users', $id);
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
                    <i class='subheader-icon fal fa-user'></i><?php echo $user['username']; ?>
                </h1>
            </div>
            <div class="row">
              <div class="col-lg-6 col-xl-6 m-auto">
                    <!-- profile summary -->
                    <div class="card mb-g rounded-top">
                        <div class="row no-gutters row-grid">
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                    <img src="<?php echo $user['image']; ?>" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                    <h5 class="mb-0 fw-700 text-center mt-3">
                                    <?php echo $user['username']; ?> 
                                        <small class="text-muted mb-0"><?php echo $user['address']; ?></small>
                                    </h5>
                                    <div class="mt-4 text-center demo">
                                        <a href="javascript:void(0);" class="fs-xl" style="color:#C13584">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="fs-xl" style="color:#4680C2">
                                            <i class="fab fa-vk"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="fs-xl" style="color:#0088cc">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 text-center">
                                    <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                        <i class="fas fa-mobile-alt text-muted mr-2"></i><?php echo $user['phone']; ?></a>
                                    <a href="mailto:oliver.kopyov@marlin.ru" class="mt-1 d-block fs-sm fw-400 text-dark">
                                        <i class="fas fa-mouse-pointer text-muted mr-2"></i><?php echo $user['email']; ?></a>
                                    <address class="fs-sm fw-400 mt-4 text-muted">
                                        <i class="fas fa-map-pin mr-2"></i><?php echo $user['address']; ?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </main>