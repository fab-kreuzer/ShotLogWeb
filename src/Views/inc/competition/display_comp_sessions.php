<div id="training-session-list" class="container mt-4">
    <h1 class="mb-4">Alle Sessions</h1>
    <div class="training-session-grid">
        <?php foreach ($sessions as $session): ?>
            <div class="training-session-card">
                <h3 class="training-session-title"><?= htmlspecialchars($session->desc) ?></h3>
                <p><strong>Ort:</strong> <?= htmlspecialchars(string: $session->ort) ?></p>
                <p><strong>Start:</strong> <?= htmlspecialchars(string: $session->startAt) ?></p>
                <p><small>Eingefügt am: <?= htmlspecialchars($session->insertedAt) ?></small></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>