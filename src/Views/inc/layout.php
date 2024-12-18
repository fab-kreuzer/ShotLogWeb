<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ShotLog' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./Styles/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Include navbar -->

    <div class="container">
        <?php if (!empty($notifications)): ?>
            <div class="notifications">
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification notification-<?= htmlspecialchars($notification['level']) ?>">
                        <?= htmlspecialchars($notification['message']) ?>
                        <button class="close-btn" onclick="removeNotification(this)">×</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?= $content ?? '' ?> <!-- Render page-specific content -->

    <?php include "footer.php"; ?>

    <script>
        function removeNotification(button) {
            const notification = button.parentElement;
            notification.style.opacity = '0';
            notification.style.marginBottom = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    </script>
</body>
</html>
