<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;
use App\Entity\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::get();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        $rows = $stmt->fetchAll();

        return array_map([$this, 'mapToUser'], $rows);
    }

    public function find(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? $this->mapToUser($row) : null;
    }

    public function findByCorreo(string $correo): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE correo = ?");
        $stmt->execute([$correo]);
        $row = $stmt->fetch();

        return $row ? $this->mapToUser($row) : null;
    }

    public function create(string $nombre, string $apellido, string $correo, string $contrasena): User
    {
        $hash = password_hash($contrasena, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            INSERT INTO users (nombre, apellido, correo, contrasena)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$nombre, $apellido, $correo, $hash]);

        $id = (int) $this->db->lastInsertId();

        return $this->find($id);
    }

    public function save(User $user): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET nombre = ?, apellido = ?, correo = ?, contrasena = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $user->getNombre(),
            $user->getApellido(),
            $user->getCorreo(),
            $user->getContrasena(),
            $user->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    private function mapToUser(array $row): User
    {
        $user = new User();
        $user->setId((int)$row['id']);
        $user->setNombre($row['nombre']);
        $user->setApellido($row['apellido']);
        $user->setCorreo($row['correo']);
        $user->setContrasena($row['contrasena']);

        return $user;
    }
}