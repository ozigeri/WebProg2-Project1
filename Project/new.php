<?php
require_once 'private/db.php';

$isCommentMode = isset($_GET['thread_id']) && is_numeric($_GET['thread_id']);
$threadId = $isCommentMode ? intval($_GET['thread_id']) : null;
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title><?= $isCommentMode ? 'Új hozzászólás' : 'Új téma létrehozása' ?></title>
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
        <div class="container mt-5">
    <h1 class="mb-4"><?= $isCommentMode ? 'Hozzászólás írása' : 'Új téma indítása' ?></h1>

    <form action="save.php" method="post">
        <?php if ($isCommentMode): ?>
            <input type="hidden" name="thread_id" value="<?= $threadId ?>">
        <?php else: ?>
            <div class="mb-3">
                <label for="section_id" class="form-label">Szekció</label>
                <select class="form-select" name="section_id" id="section_id" required>
                    <option value="" disabled selected>Válassz szekciót</option>
                    <?php foreach (getAllSection() as $section): ?>
                        <option value="<?= $section['id'] ?>"><?= htmlspecialchars($section['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="thread_name" class="form-label">Thread neve</label>
                <input type="text" class="form-control" id="thread_name" name="thread_name" required>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="author_name" class="form-label">Név</label>
            <input type="text" class="form-control" id="author_name" name="author_name" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Tartalom</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <?= $isCommentMode ? 'Hozzászólás elküldése' : 'Téma létrehozása' ?>
        </button>
        <a href="index.php" class="btn btn-secondary">Vissza</a>
    </form>
</div>
        <div class="mb-5"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>