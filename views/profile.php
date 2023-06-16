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
    <div class="row justify-content-center mt-4">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2>Adatok:</h2>
                    <b>Név: </b>    <?php echo $user->getNev(); ?> <br>
                    <b>E-mail cím: </b>    <?php echo $user->getEmail(); ?> <br>
                    <b>Családi állapot: </b>    <?php echo $user->getCsaladiAllapot(); ?>   <br>
                    
                    <?php if(!empty($user->getSzuletesiIdo())): ?>  
                        <b>Kor: </b> <?php echo $user->getKor(); ?> <br>
                    <?php endif ?>

                    <?php if(!empty($user->getWeboldal())): ?>
                        <b>Weboldal: </b> <?php echo $user->getWeboldal(); ?>   <br>    
                    <?php endif ?>
                    <a href="/probamunka/user/update" class="btn btn-primary">Módosítás</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2>Jelszó módosítása:</h2>
                    <form action="/probamunka/user/changepw" method="POST">
                        <div class="mb-3">
                            <label for="password" class="form-label">Régi jelszó</label>
                            <input type="password" id="regi_jelszo" name="regi_jelszo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Új jelszó</label>
                            <input type="password" id="uj_jelszo" name="uj_jelszo" class="form-control" required>
                        </div>
                        <input type="submit" class="btn btn-success" value="Jelszó módosítása ->">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>