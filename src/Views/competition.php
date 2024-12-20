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

<!-- Modal einbinden -->
<?php include 'inc/competition/add_comp_modal.php'; ?>

<!-- Include Sessions view -->
<?php include 'inc/competition/display_comp_sessions.php'; ?>

<?php 
    $content = ob_get_clean();
    include 'inc/layout.php';
?>