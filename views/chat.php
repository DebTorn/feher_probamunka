<?php

    require_once('models/User.php');
    use models\User;

?>
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-sm-6">
            <div class="card" style="overflow:scroll; height: 300px;">
                <div class="card-body">
                    <div id="chatMessages">
                        <?php if(!is_null($messages)): ?>
                            <?php for($i = 0; $i < count($messages); $i++): ?>
                                    <?php 
                                        $user = new User();
                                        $user->findById($messages[$i]['userId']);
                                    ?>
                                    <div>
                                        <?php echo $user->getNev(); ?> (<?php echo $messages[$i]['sent']; ?>): <?php echo $messages[$i]['message']; ?>
                                    </div>
                            <?php endfor ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-sm-6">
            <form id="chatForm">
                <div class="row">
                    <input type="text" id="messageInput" placeholder="Írja be üzenetét..." class="form-control" required>
                    <button type="submit" class="btn btn-primary mt-2">Küldés</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/probamunka/resources/js/chat.js"></script>
<script>
    var name = '<?php echo $_SESSION['nev']; ?>';
    var chatApp = new ChatApp(name);
    chatApp.init();
</script>