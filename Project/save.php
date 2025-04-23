<?php
require_once 'private/db.php';

$isCommentMode = isset($_POST['thread_id']) && is_numeric($_POST['thread_id']);
$sectionId = $_POST['section_id'] ?? null;
$threadName = $_POST['thread_name'] ?? null;
$authorName = $_POST['author_name'] ?? null;
$content = $_POST['content'] ?? null;
$threadId = $isCommentMode ? $_POST['thread_id'] : ($_GET['id'] ?? null);  // Ha hozzászólás módban vagyunk, a thread_id POST adatból, ha nem, akkor az URL-ből.

if ($isCommentMode) {
    // Hozzászólás hozzáadása
    if ($threadId && $authorName && $content) {
        $stmt = $pdo->prepare("INSERT INTO comment (thread_id, author_name, content, created_at) VALUES (:thread_id, :author_name, :content, NOW())");
        $stmt->execute([
            'thread_id' => $threadId,
            'author_name' => $authorName,
            'content' => $content
        ]);

        header("Location: thread.php?id=$threadId");
        exit();
    } else {
        // Hiba: hiányzó adatok
        echo "Minden mezőt ki kell tölteni!";
        exit();
    }
} else {
    // Új thread létrehozása
    if ($sectionId && $threadName && $authorName && $content) {
        $stmt = $pdo->prepare("INSERT INTO thread (section_id, name, author_name, content, created_at) VALUES (:section_id, :name, :author_name, :content, NOW())");
        $stmt->execute([
            'section_id' => $sectionId,
            'name' => $threadName,
            'author_name' => $authorName,
            'content' => $content
        ]);

        $newThreadId = $pdo->lastInsertId();
        header("Location: thread.php?id=$newThreadId");
        exit();
    } else {
        // Hiba: hiányzó adatok
        echo "Minden mezőt ki kell tölteni!";
        exit();
    }
}
?>
