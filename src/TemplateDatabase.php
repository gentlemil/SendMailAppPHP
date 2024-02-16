<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use App\Exception\NotFoundException;
use Throwable;
use PDO;

class TemplateDatabase extends AbstractDatabase
{
  public function getTemplate(int $id): array
  {
    try {
      $query = "SELECT * FROM templates WHERE id = $id";
      $result = $this->conn->query($query);
      $template = $result->fetch(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
      throw new StorageException("Failed to fetch template with id equal $id", 400, $e);
    }

    if (!$template) {
      throw new NotFoundException("Template with id equal to $id does not exist.");
    }

    return $template;
  }

  public function getTemplates(): array
  {
    try {
    $query = "SELECT id, title, message FROM templates";
    $result = $this->conn->query($query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
      throw new StorageException('Failed to fetch templates', 400, $e);
    }
  }

  public function createTemplate(array $data): void
  {
    try {
      $title = $this->conn->quote($data['title']);
      $message = $this->conn->quote($data['message']);
      $created = $this->conn->quote(date('Y-m-d H:i:s'));

      $query = "
        INSERT INTO templates(title, message, created)
        VALUES($title, $message, $created)
      ";

      $this->conn->exec($query);
    } catch (Throwable $e) {
      throw new StorageException('Failed to create a new template', 400, $e);
    }
  }

  public function editTemplate(int $id, array $data): void
  {
    try {
      $title = $this->conn->quote(($data['title']));
      $message = $this->conn->quote(($data['message']));

      $query = "
        UPDATE templates
        SET title = $title, message = $message
        WHERE id = $id
      ";

      $this->conn->exec($query);

    } catch (Throwable $e) {
      throw new StorageException('Edit template failure', 400, $e);
    }
  }
}
