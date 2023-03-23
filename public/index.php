<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Core\Applications\Application;
use Dotenv\Dotenv;
use App\Data\Sources\Users\MysqlUserSource;
use App\Data\Repositories\UserRepository;
use App\Data\UseCases\Users\StoreUserUseCase;
use App\Presentation\Controllers\Users\StoreUserController;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$dsn = $_ENV["DB_DSN"];
$user = $_ENV["DB_USER"];
$password = $_ENV["DB_PASSWORD"];

$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mysqlUserSource = new MysqlUserSource($pdo);
$userRepository = new UserRepository($mysqlUserSource);
$storeUserUseCase = new StoreUserUseCase($userRepository);
$storeUserController = new StoreUserController($storeUserUseCase);

$app = new Application();

$app->router->post("/users", [$storeUserController, "execute"]);

$app->run();