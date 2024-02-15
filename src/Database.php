<?php

declare(strict_types=1);

namespace App;

require_once("Exception/StorageException.php");

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;
use Throwable;

class Database
{
  private PDO $conn;

  public function __construct(array $config)
  {
    try {
      $this->validateConfig($config);
      $this->createConnection($config);
    } catch (PDOException $e) {
      throw new StorageException('Connection error');
    }
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
      throw new StorageException('Failed to create a new note', 400, $e);
    }
  }

  private function createConnection(array $config): void
  {
    $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
    $this->conn = new PDO(
      $dsn,
      $config['user'],
      $config['password'],
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]
    );
  }

  private function validateConfig(array $config): void
  {
    if (
      empty($config['database'])
      || empty($config['host'])
      || empty($config['user'])
      || empty($config['password'])
    ) {
      throw new ConfigurationException('Storage configuration error');
    }
  }
}
