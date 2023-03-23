<?php

require_once __DIR__ . "/vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dsn = $_ENV["DB_DSN"];
$user = $_ENV["DB_USER"];
$password = $_ENV["DB_PASSWORD"];

class Migration
{
    const MIGRATION_TABLE_NAME = "migrations";
    private PDO $pdo;
    private string $migrationsDir;

    public function __construct(PDO $pdo, $migrationsDir)
    {
        $this->pdo = $pdo;
        $this->migrationsDir = $migrationsDir;
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = scandir($this->migrationsDir);
        $migrationsToApply = array_diff($files, $appliedMigrations);
        $newMigrations = [];
        foreach ($migrationsToApply as $migration) {
            if ($migration === "." || $migration === "..") {
                continue;
            }

            require_once $this->migrationsDir . "/" . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Applying migration " . $migration);
            $instance->up($this->pdo);
            $this->log("Applied migration " . $migration);
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied.");
        }

    }

    public function createMigrationsTable()
    {
        $statement = $this->pdo->prepare(
            "CREATE TABLE IF NOT EXISTS " . self::MIGRATION_TABLE_NAME . " 
                (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL,
                    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
                );"
        );
        $statement->execute();
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM " . self::MIGRATION_TABLE_NAME . ";");
        $statement->execute();
        return $statement->fetchALL(PDO::FETCH_COLUMN);
    }

    public function saveMigrations($migrations)
    {
        $formattedMigrations = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO " . self::MIGRATION_TABLE_NAME . " (migration) VALUES $formattedMigrations");
        $statement->execute();
    }

    protected function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}

$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$migration = new Migration($pdo, __DIR__ . "/migrations");

$migration->applyMigrations();