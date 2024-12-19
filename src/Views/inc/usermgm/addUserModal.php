<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addUserForm" method="POST" action="/addUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Benutzer hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="userId">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Benutzername</label>
                        <input type="text" class="form-control" id="userName" name="user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Passwort</label>
                        <div class="input-group mb-3">
                            <input class="form-control password" id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <span class="input-group-text togglePassword" id="">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>                    
                    </div>
                    <div class="mb-3">
                        <label for="vorname" class="form-label">Vorname</label>
                        <input type="text" class="form-control" id="vorname" name="vorname" required>
                    </div>
                    <div class="mb-3">
                        <label for="nachname" class="form-label">Nachname</label>
                        <input type="text" class="form-control" id="nachname" name="nachname" required>
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
                    <button type="submit" class="btn bg-dark-green">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('.togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle icon class
        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script>