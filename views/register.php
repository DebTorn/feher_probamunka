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
    <div class="row justify-content-center mb-2">
        <h1 class="text-center mt-1">Regisztráció</h1>
        <div class="col-sm-6">
            <form action="/probamunka/register/register" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail cím</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_GET['datas']) ? json_decode($_GET['datas'])->email : ""; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jelszo" class="form-label">Jelszó</label>
                    <input type="password" name="jelszo" id="jelszo" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nev" class="form-label">Név:</label>
                    <input type="text" name="nev" id="nev" value="<?php echo isset($_GET['datas']) ? json_decode($_GET['datas'])->nev : ""; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="csaladi_allapot" class="form-label">Családi állapot:</label>
                    <?php if(isset($_GET['datas'])): ?>
                        <select name="csaladi_allapot" id="csaladi_allapot" class="form-control" required>
                                <?php $datas = json_decode($_GET['datas']); ?>
                                <?php if($datas->csaladi_allapot == 'egyedulallo'): ?>
                                    <option value="egyedulallo" selected>Egyedülálló</option>
                                    <option value="hazas">Házas</option>
                                    <option value="elvalt">Elvált</option>
                                <?php elseif($datas->csaladi_allapot == 'hazas'): ?>
                                    <option value="egyedulallo">Egyedülálló</option>
                                    <option value="hazas" selected>Házas</option>
                                    <option value="elvalt">Elvált</option>
                                <?php elseif($datas->csaladi_allapot == 'elvalt'): ?>
                                    <option value="egyedulallo">Egyedülálló</option>
                                    <option value="hazas">Házas</option>
                                    <option value="elvalt" selected>Elvált</option>
                                <?php endif ?>
                        </select>
                        <?php else: ?>
                            <select name="csaladi_allapot" id="csaladi_allapot" class="form-control" required>
                                <option value="egyedulallo">Egyedülálló</option>
                                <option value="hazas">Házas</option>
                                <option value="elvalt">Elvált</option>
                            </select>
                    <?php endif ?>
                </div>
                <div class="mb-3">
                    <label for="szuletesi_ido" class="form-label">Születési idő</label>
                    <input type="date" name="szuletesi_ido" id="szuletesi_ido" value="<?php echo isset($_GET['datas']) ? json_decode($_GET['datas'])->szuletesi_ido : ""; ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="weboldal" class="form-label">Weboldal</label>
                    <input type="text" name="weboldal" id="weboldal" value="<?php echo isset($_GET['datas']) ? json_decode($_GET['datas'])->weboldal : ""; ?>" class="form-control">
                </div>
                <input type="submit" class="btn btn-success" value="Létrehozás +">
            </form>
        </div>
    </div>
</div>