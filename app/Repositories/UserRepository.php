<?php
declare(strict_types=1);

namespace Oftalvista\Repositories;

use Oftalvista\Core\Database;

final class UserRepository
{
    public function findByEmail(string $email): ?array
    {
        $statement = Database::connection()->prepare('SELECT id, email, password_hash FROM admin_users WHERE lower(email) = lower(:email) AND active = TRUE LIMIT 1');
        $statement->execute(['email' => trim($email)]);
        return $statement->fetch() ?: null;
    }

    public function updatePassword(int $id, string $hash): void
    {
        $statement = Database::connection()->prepare('UPDATE admin_users SET password_hash = :hash, updated_at = NOW() WHERE id = :id');
        $statement->execute(['hash' => $hash, 'id' => $id]);
    }
}
