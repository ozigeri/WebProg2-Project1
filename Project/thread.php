<?php
require 'private/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Hibás vagy hiányzó ID!');
}

$threadId = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT name, author_name, content, DATE_FORMAT(created_at, '%Y-%m-%d') as created FROM thread WHERE id = :id");
$stmt->execute(['id' => $threadId]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$thread) {
    die('A thread nem található.');
}

$stmt = $pdo->prepare("SELECT author_name, content, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as created FROM comment WHERE thread_id = :id ORDER BY created_at ASC");
$stmt->execute(['id' => $threadId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT t.name AS thread_name, t.author_name, t.content, t.section_id, DATE_FORMAT(t.created_at, '%Y-%m-%d') as created, s.name AS section_name
    FROM thread t
    INNER JOIN section s ON t.section_id = s.id
    WHERE t.id = :id");
$stmt->execute(['id' => $threadId]);
$thread2 = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($thread['name']) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Ozibiusz Gergő</h1>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h3 class="mb-0">IH7JUK</h3>
                    </div>
                </div>
            </div>
        </header>
        <div
            class="hero-section d-flex justify-content-center align-items-center overflow-hidden"
            style="height: 200px;">
            <img
                src="threads-statistics-cover.png"
                alt=""
                class="img-fluid w-100 h-100 object-fit-cover">
        </div>

        <nav class="navbar navbar-expand-lg" style="background-color: #0d1b2a;">
            <div class="container">
                <button
                    class="navbar-toggler text-light border-0"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="index.php" class="btn btn-outline-light">Főoldal</a>
                        </li>
                        <?php if (!empty($thread2['section_name'])): ?>
                        <li class="nav-item">
                            <span class="navbar-text text-white mx-2">/</span>
                            <a class="btn btn-outline-light disabled"><?= htmlspecialchars($thread2['section_name']) ?></a>
                        </li>
                        <li class="nav-item">
                            <span class="navbar-text text-white mx-2">/</span>
                            <a class="btn btn-outline-light disabled"><?= htmlspecialchars($thread2['thread_name']) ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="mb-5"></div>
        <div class="container my-4">
            <?php if (!empty($comments)): ?>
            <table class="table table-dark table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <td
                            class="fw-bold text-center align-top"
                            style="width: 120px; vertical-align: top;">
                            <?= htmlspecialchars($thread['author_name']) ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong><?= htmlspecialchars($thread['name']) ?></strong>
                                <div>
                                    <button class="btn btn-outline-light btn-sm">Megosztás</button>
                                    <button class="btn btn-outline-secondary btn-sm">Archíválás</button>
                                </div>
                            </div>
                            <div class="mb-2" style="white-space: pre-line;">
                                <?= nl2br(htmlspecialchars($thread['content'])) ?>
                            </div>
                            <small><?= $thread['created'] ?></small>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $c): ?>
                    <tr>
                        <td
                            class="fw-bold text-center align-top"
                            style="width: 120px; vertical-align: top;">
                            <?= htmlspecialchars($c['author_name']) ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong><?= htmlspecialchars($thread['name']) ?></strong>
                                <div>
                                    <button class="btn btn-outline-light btn-sm">Megosztás</button>
                                    <button class="btn btn-outline-danger btn-sm">Törlés</button>
                                </div>
                            </div>
                            <div class="mb-2" style="white-space: pre-line;">
                                <?= nl2br(htmlspecialchars($c['content'])) ?>
                            </div>
                            <small class="text-muted-white"><?= $c['created'] ?></small>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-light">Nincs még komment ehhez a threadhez.</p>
            <?php endif; ?>
        </div>
        <footer class="text-white py-3 fixed-bottom" style="background-color: #0d1b2a;">
            <div class="container d-flex justify-content-end">
                <a href="new.php" class="btn btn-primary">Hozzászólás</a>
            </div>
        </footer>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>