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
    <div class="row justify-content-center mt-3">
        <div class="col-sm-6">
            <form action="/probamunka/user/update" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail cím</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $user->getEmail(); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nev" class="form-label">Név:</label>
                    <input type="text" name="nev" id="nev" class="form-control" value="<?php echo $user->getNev(); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="csaladi_allapot" class="form-label">Családi állapot:</label>
                    <select name="csaladi_allapot" id="csaladi_allapot" class="form-control" required>
                        <?php if($user->getCsaladiAllapot() == 'egyedulallo'){ ?>
                            <option value="egyedulallo" selected>Egyedülálló</option>
                            <option value="hazas">Házas</option>
                            <option value="elvalt">Elvált</option>
                        <?php }else if($user->getCsaladiAllapot() == 'hazas'){ ?>
                            <option value="egyedulallo">Egyedülálló</option>
                            <option value="hazas" selected>Házas</option>
                            <option value="elvalt">Elvált</option>
                        <?php }else if($user->getCsaladiAllapot() == 'elvalt'){ ?>
                            <option value="egyedulallo">Egyedülálló</option>
                            <option value="hazas">Házas</option>
                            <option value="elvalt" selected>Elvált</option>
                        <?php } ?>

                    </select>
                </div>
                <div class="mb-3">
                    <label for="szuletesi_ido" class="form-label">Születési idő</label>
                    <input type="date" name="szuletesi_ido" id="szuletesi_ido" value="<?php echo $user->getSzuletesiIdo(); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="weboldal" class="form-label">Weboldal</label>
                    <input type="text" name="weboldal" id="weboldal" value="<?php echo $user->getWeboldal(); ?>" class="form-control">
                </div>
                <input type="submit" class="btn btn-success" value="Módosítás ->">
            </form>
        </div>
    </div>
</div>