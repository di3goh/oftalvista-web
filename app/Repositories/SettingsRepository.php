<?php
declare(strict_types=1);

namespace Oftalvista\Repositories;

use Oftalvista\Core\Cache;
use Oftalvista\Core\Database;
use PDO;
use Throwable;

final class SettingsRepository
{
    private static ?self $instance = null;
    private ?array $all = null;

    public static function instance(): self
    {
        return self::$instance ??= new self();
    }

    public function get(string $key, string $fallback = ''): string
    {
        return $this->all()[$key] ?? $fallback;
    }

    public function all(): array
    {
        if ($this->all !== null) return $this->all;
        $redis = Cache::redis();
        $cached = $redis?->get('settings:all');
        if (is_string($cached)) return $this->all = json_decode($cached, true) ?: [];
        try {
            $rows = Database::connection()->query('SELECT key, value FROM site_settings ORDER BY key')->fetchAll(PDO::FETCH_KEY_PAIR);
            $this->all = $rows;
            $redis?->setex('settings:all', 3600, json_encode($rows));
            return $rows;
        } catch (Throwable) {
            return $this->all = [];
        }
    }

    public function updateMany(array $values): void
    {
        $pdo = Database::connection();
        $statement = $pdo->prepare('INSERT INTO site_settings (key, value, updated_at) VALUES (:key, :value, NOW()) ON CONFLICT (key) DO UPDATE SET value = EXCLUDED.value, updated_at = NOW()');
        $pdo->beginTransaction();
        try {
            foreach ($values as $key => $value) {
                if (!preg_match('/^[a-z0-9_.-]{2,100}$/', (string) $key)) continue;
                $statement->execute(['key' => $key, 'value' => trim((string) $value)]);
            }
            $pdo->commit();
        } catch (Throwable $error) {
            $pdo->rollBack();
            throw $error;
        }
        $this->all = null;
        Cache::redis()?->del('settings:all');
    }
}
