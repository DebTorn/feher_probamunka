<div class="container">
    <?php if(isset($_GET['errors'])): ?>
        <div class="row justify-content-center mt-3">
            <div class="col-sm-6">
                <?php foreach(json_decode($_GET['errors']) as $error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>
    <div class="row justify-content-center">
        <h1 class="text-center mt-1">Bejelentkezés</h1>
        <div class="col-sm-6">
            <form action="/probamunka/login/login" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail cím</label>
                    <input type="email" id="email" name="email" value="<?php echo (isset($_GET['datas']) ? json_decode($_GET['datas'])->email : ""); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="jelszo" class="form-label">Jelszó</label>
                    <input type="password" name="jelszo" id="jelszo" class="form-control">
                </div>
                <input type="submit" class="btn btn-success" value="Belépés ->">
            </form>
        </div>
    </div>
</div>