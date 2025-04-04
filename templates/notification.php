<?php



if (!isset($_SESSION['notification'])){
    return;
}
?>
<section id="notification" >
    <?php foreach ($_SESSION['notification'] as $notification): ?>
        
            <div class="<?= $notification['type'] ?>">
                <button><img src="../static/images/close.svg" alt="close"></button>
                <h2><?= $notification['title'] ?></h2>
                <p><?= $notification['message'] ?></p>
            </div>
        
    <?php endforeach; ?>
</section>
<?php
unset($_SESSION['notification']);
?>