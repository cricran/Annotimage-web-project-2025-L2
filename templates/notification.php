<?php

$notif = getNotifications();

if (!isset($notif)){
    return;
}
?>
<section id="notification" >
    <?php foreach ($notif as $notification): ?>
        
            <div class="<?= $notification['type'] ?>">
                <button><img src="../static/images/close.svg" alt="close"></button>
                <h2><?= $notification['title'] ?></h2>
                <p><?= $notification['message'] ?></p>
            </div>
        
    <?php endforeach; ?>
</section>