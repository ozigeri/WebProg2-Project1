<?php
require_once 'config.php';

$pdo = null;
try {
  $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  die("Nem lehet csatlakozni az adatbázishoz.");
}

function getAllSection(): array {
  global $pdo;

  $query = "SELECT * FROM section";
  $result = $pdo->query($query);
  return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getThread(int $sectionId) : array{
  global $pdo;

  $stmt = $pdo->prepare("SELECT id, name, DATE_FORMAT(created_at, '%Y-%m-%d') as created, author_name, is_archived 
    FROM thread 
    WHERE section_id = :section_id 
    ORDER BY is_archived ASC, created_at DESC");
  $stmt->execute(['section_id' => $sectionId]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$result) {
      return [];
  }

  return $result;
}

function getComment(int $threadId): array {
  global $pdo;

  $stmt = $pdo->prepare("SELECT author_name, DATE_FORMAT(created_at, '%Y-%m-%d') AS created FROM comment WHERE thread_id = :thread_id ORDER BY created_at DESC LIMIT 1");
  $stmt->execute(['thread_id' => $threadId]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$result) {
    return [
      'created' => '',
      'author_name' => 'Nincs komment'
    ];
  } 

  return $result;
}

function countComment(int $threadId): int {
  global $pdo;
  $stmt = $pdo->prepare("SELECT COUNT(id) as count FROM comment WHERE thread_id = :thread_id");
  $stmt->execute(['thread_id' => $threadId]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return (int) $result['count'];
}

function get5Thread(): array{
  global $pdo;

  $stmt = $pdo->prepare("SELECT name,author_name,content FROM thread ORDER BY created_at DESC LIMIT 5");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$result) {
    return [];
  }
  return $result;
}
