<div id="user-list" class="container mt-4">
    <h1 class="mb-4">Alle User</h1>
    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Benutzername</th>
                <th scope="col">Vorname</th>
                <th scope="col">Nachname</th>
                <th scope="col">Admin</th>
                <th scope="col">Dev</th>
                <th scope="col">Eingefügt am</th>
                <th scope="col">Aktion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr data-user-id="<?= htmlspecialchars($user->id) ?>">
                    <th scope="row"><?= htmlspecialchars($user->id) ?></th>
                    <td><?= htmlspecialchars($user->username) ?></td>
                    <td><?= htmlspecialchars($user->vorname) ?></td>
                    <td><?= htmlspecialchars($user->nachname) ?></td>
                    <td><?= $user->isAdmin ? 'Ja' : 'Nein' ?></td>
                    <td><?= $user->isDev ? 'Ja' : 'Nein' ?></td>
                    <td><?= htmlspecialchars($user->createdAt) ?></td>
                    <td>
                        <form method="POST" action="removeUser" class="d-inline">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->id) ?>">
                            <input type="hidden" name="current_user_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Löschen">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <!-- Edit button -->
                            <button class="btn btn-warning btn-sm edit-user" 
                                data-user-id="<?= htmlspecialchars($user->id) ?>" 
                                data-user-name="<?= htmlspecialchars($user->username) ?>" 
                                data-vorname="<?= htmlspecialchars($user->vorname) ?>" 
                                data-nachname="<?= htmlspecialchars($user->nachname) ?>" 
                                data-is-admin="<?= $user->isAdmin ?>" 
                                data-is-dev="<?= $user->isDev ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editUserModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
