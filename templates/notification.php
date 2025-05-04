<?php

$notif = getNotifications();

if ($notif === []){
    return;
}
?>
<section id="notification" >
    <?php foreach ($notif as $notification): ?>
            <?php 
                switch ($notification['type']) {
                    case 'error':
                        $icon = 'error.svg';
                        break;
                    case 'success':
                        $icon = 'success.svg';
                        break;
                    case 'warning':
                        $icon = 'warning.svg';
                        break;
                    case 'info':
                        $icon = 'info.svg';
                        break;
                }
            ?>
        
            <div class="<?= $notification['type'] ?>">
                <button><img src="../static/images/close.svg" alt="close"></button>
                <h2>
                    <img src="../static/images/<?= $icon ?>" alt="<?= $notification['type'] ?>">
                    <?= $notification['title'] ?>
                </h2>
                <p><?= $notification['message'] ?></p>
            </div>
        
    <?php endforeach; ?>
</section>