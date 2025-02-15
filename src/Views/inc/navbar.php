<?php
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShotLog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Styles/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-green">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">ShotLog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) ?? 'home') === 'training' ? 'active' : '' ?>" href="/training">Training</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) ?? 'home') === 'competition' ? 'active' : '' ?>" href="/competition">Meine Wettkämpfe</a>
                    </li>
                    <?php if (!isMobile()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) ?? 'home') === 'calender' ? 'active' : '' ?>" href="/calender">Kalender</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if ($_SESSION['isAdmin']): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= (basename($_SERVER['REQUEST_URI'])?? 'home') === 'usermanagement' ? 'active' : '' ?>" href="/usermanagement">Benutzerverwaltung</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link active btn-logout rounded-2" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>