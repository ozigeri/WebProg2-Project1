<?php
require_once 'private/db.php';

$data = getAllSection();
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fórum</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
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
                    </ul>
                </div>
            </div>
        </nav>
        <div class="mb-5"></div>
        <div class="d-flex container gap-5">
            <main class="flex-grow-1 main-content">
                <?php foreach ($data as $x): ?>
                <div
                    class="section-header d-flex align-items-center justify-content-between mb-2">
                    <h2 class="mb-2 me-2 flex-grow-1"><?= $x['name'] ?></h2>
                    <div class="d-flex align-items-center">
                        <a href="new.php" class="btn btn-sm btn-success me-2">+</a>
                        <button
                            class="btn btn-sm btn-outline-secondary toggle-section"
                            onclick="toggleTable('tabla-<?= $x['id']?>', this)">
                            <i class="bi bi-chevron-up"></i>
                        </button>
                    </div>
                </div>
                <?php $thread = getThread(intval($x['id'])); 
        if(!empty($thread)): ?>
                <div class="table-responsive">
                    <table
                        class="table table-dark table-bordered table-hover"
                        id="tabla-<?= $x['id'] ?>">
                        <thead>
                            <tr>
                                <th class="col-3 text-center">Thread név</th>
                                <th class="col-3 text-center">Létrehozva</th>
                                <th class="col-3 text-center">Utolsó komment</th>
                                <th class="col-3 text-center">Db</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($thread as $y): ?>
                            <?php 
                    $lastcomment = getComment($y['id']);
                    $commentDb = countComment($y['id']);
                ?>
                            <tr>
                                <td>
                                    <a
                                        href="thread.php?id=<?= $y['id'] ?>"
                                        style="text-decoration: none; color:white;"><?= $y['name'] ?></a>
                                </td>
                                <td><?= $y['created'] . '<br>' . htmlspecialchars($y['author_name']) ?></td>
                                <td>
                                    <?php if (!empty($lastcomment)): ?>
                                    <?= $lastcomment['created'] . '<br>' . htmlspecialchars($lastcomment['author_name']) ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $commentDb ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </main>
            <main class="latest-sidebar ">
                <div class="sticky-top">
                    <div class="card bg-transparent border-0 shadow-none text-white">
                        <h2 class="section-title mt-1">Legújabbak</h2>
                        <?php 
                $last5thread = get5Thread();
                if (!empty($last5thread)): ?>
                        <?php foreach($last5thread as $l): ?>
                        <div class="latest-thread">
                            <div class="d-flex justify-content-between">
                                <span class="latest-thread-title"><?= htmlspecialchars($l['name']) ?></span>
                                <small><?= htmlspecialchars($l['author_name']) ?></small>
                            </div>
                            <div class="mt-2">
                                <?= nl2br(htmlspecialchars(mb_strimwidth($l['content'], 0, 120, '...'))) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
        <script src="table.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>