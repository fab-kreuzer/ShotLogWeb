<div id="training-session-list" class="container mt-4">
    <h1 class="mb-4">Alle Sessions</h1>
    <div class="training-session-grid">
        <?php foreach ($sessions as $session): ?>
            <div class="training-session-card">
                <h3 class="training-session-title"><?= htmlspecialchars($session->getDesc()) ?></h3>
                <p><strong>Ort:</strong> <?= htmlspecialchars(string: $session->getOrt()) ?></p>
                <p><strong>Start:</strong> <?= htmlspecialchars(string: $session->getStartAt()) ?></p>
                <p><small>Eingefügt am: <?= htmlspecialchars($session->getInsertedAt()) ?></small></p>
                <div class="d-md-block session-btn-group">
                    <!-- Delete Button -->                    
                    <form method="POST" action="/removeSession" class="d-inline">
                        <input type="hidden" name="origin" value="training">
                        <input type="hidden" name="sessionId" value="<?= htmlspecialchars($session->getId()) ?>">
                        <button type="submit" class="btn btn-danger btn-sm" title="Löschen" type="button">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    <!-- Edit button -->
                    <button class="btn btn-warning btn-sm" id="edit-session"  type="button"
                            data-session-id="<?= htmlspecialchars($session->getId()) ?>" 
                            data-desc="<?= htmlspecialchars($session->getDesc()) ?>" 
                            data-ort="<?= htmlspecialchars($session->getOrt()) ?>" 
                            data-isWettkampf="<?= htmlspecialchars($session->getIsWettkampf()) ?>"
                            data-startAt="<?= htmlspecialchars($session->getStartAt()) ?>"
                            data-bs-toggle="modal" 
                            data-bs-target="#editSessionModal">
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Select all edit buttons
        const editButtons = document.querySelectorAll('#edit-session');

        // Attach a click event listener to each button
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Retrieve data attributes from the clicked button
                const sessionId = button.getAttribute('data-session-id');
                const desc = button.getAttribute('data-desc');
                const ort = button.getAttribute('data-ort');
                const isWettkampf = button.getAttribute('data-isWettkampf');
                const startAt = button.getAttribute('data-startAt');

                // Populate the modal form fields
                document.querySelector('#editSessionModal #sessionId').value = sessionId;
                document.querySelector('#editSessionModal #desc').value = desc;
                document.querySelector('#editSessionModal #location').value = ort;
                document.querySelector('#editSessionModal #datetime').value = startAt;
                if (isWettkampf === '1') {
                    document.querySelector('#editSessionModal #wettkampf').checked = true;
                } else {
                    document.querySelector('#editSessionModal #training').checked = true;
                }  
            });
        });
    });
</script>