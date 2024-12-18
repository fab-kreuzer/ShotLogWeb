<?php ob_start(); ?>
<div class="container mt-5">
    <h1>Willkommen bei ShotLog!</h1>
    <p>Wähle eine Kategorie, um zu beginnen.</p>
</div>

<?php 
    $content = ob_get_clean();
    include 'inc/layout.php';
?>