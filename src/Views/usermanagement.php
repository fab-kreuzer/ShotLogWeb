<?php ob_start(); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Benutzerverwaltung</h1>
        <button class="btn bg-dark-green" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Benutzer hinzufügen
        </button>
    </div>
    <p>Hier kannst du Benutzer ansehen, hinzufügen oder löschen.</p>
</div>

<?php
include 'inc/usermgm/editUserModal.php';
include 'inc/usermgm/addUserModal.php';
include 'inc/usermgm/displayUsers.php';
?>

<script>
    document.querySelectorAll('.edit-user').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('editUserId').value = this.dataset.userId;
        document.getElementById('editUserName').value = this.dataset.userName;
        document.getElementById('editVorname').value = this.dataset.vorname;
        document.getElementById('editNachname').value = this.dataset.nachname;
        document.getElementById('isAdmin').value = this.dataset.isAdmin ? 1 : 0;
        document.getElementById('isDev').value = this.dataset.isDev ? 1 : 0;
    });
});

</script>

<?php 
    $content = ob_get_clean();
    include 'inc/layout.php';
?>