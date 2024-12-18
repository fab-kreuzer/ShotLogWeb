<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./Styles/login.css" rel="stylesheet">
</head>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 24rem;">
        <div class="card-header text-center text-white login-green">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            <form method="post" id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Passwort</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn login-green hover-color w-100">Einloggen</button>
            </form>
        </div>
    </div>
</div>

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