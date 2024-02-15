<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use Throwable;
use PDO;

class UserDatabase extends AbstractDatabase
{
  public function getUsers(): array
  {
    try {
    $query = "SELECT id, firstName, lastName, email, position FROM users";
    $result = $this->conn->query($query);
    
    return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
      throw new StorageException('Failed to fetch users', 400, $e);
    }
  }

  public function createUser(array $data): void
  {
    try {
      $firstName = $this->conn->quote($data['firstName']);
      $lastName = $this->conn->quote($data['lastName']);
      $email = $this->conn->quote($data['email']);
      $position = $this->conn->quote($data['position']);
      $created = $this->conn->quote(date('Y-m-d H:i:s'));

      $query = "
        INSERT INTO users(firstName, lastName, email, position, created)
        VALUES($firstName, $lastName, $email, $position, $created)
      ";

      $this->conn->exec($query);
    } catch (Throwable $e) {
      throw new StorageException('Failed to create a new user', 400, $e);
    }
  }
}
