<?php ob_start(); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Wettkampf</h1>
        <button class="btn bg-dark-green" data-bs-toggle="modal" data-bs-target="#addSessionModal">
            Wettkampf hinzufügen
        </button>
    </div>
    <p>Hier kannst du deine Wettkämpfe verwalten.</p>
</div>


<?php
    // Modal einbinden
    include 'inc/competition/add_comp_modal.php';

    //Include Sessions view
    include 'inc/competition/display_comp_sessions.php';
    include 'inc/session/editSession.php';

    $content = ob_get_clean();
    include 'inc/layout.php';
?>