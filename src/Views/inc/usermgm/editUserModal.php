<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm" method="POST" action="/updateUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Benutzer bearbeiten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="editUserId">
                    <div class="mb-3">
                        <label for="editUserName" class="form-label">Benutzername</label>
                        <input type="text" class="form-control" name="user_name" id="editUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editVorname" class="form-label">Vorname</label>
                        <input type="text" class="form-control" name="vorname" id="editVorname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNachname" class="form-label">Nachname</label>
                        <input type="text" class="form-control" name="nachname" id="editNachname" required>
                    </div>
                    <div class="mb-3">
                        <label for="isAdmin" class="form-label">Admin</label>
                        <select class="form-select" id="isAdmin" name="isAdmin">
                            <option value="0">Nein</option>
                            <option value="1">Ja</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="isDev" class="form-label">Dev</label>
                        <select class="form-select" id="isDev" name="isDev">
                            <option value="0">Nein</option>
                            <option value="1">Ja</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>
