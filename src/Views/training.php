<?php ob_start(); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Training</h1>
        <button class="btn bg-dark-green" data-bs-toggle="modal" data-bs-target="#addTrainingModal">
            Training hinzufügen
        </button>
    </div>
    <p>Hier kannst du dein Training verwalten.</p>
</div>


<?php

//Include Sessions view
include 'inc/training/display_training_sessions.php';
include 'inc/session/editSession.php';
?>

<?php 
    $content = ob_get_clean();
    include 'inc/layout.php';
?>