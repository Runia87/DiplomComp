<?php $this->layout('layout', ['title' => 'Авторизация']) ?>
<?php
echo flash()->display();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <form action="loginUser" method="post">
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input type="email" name="email" id="username" class="form-control" placeholder="Эл. адрес"
                           value="">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Пароль"
                           value="">
                </div>
                <button type="submit" class="btn btn-success float-right">Войти</button>
            </form>
            <a href="register"><button type="submit" class="btn btn-warning float-left">Регистрация</button></a>
</div>
    
