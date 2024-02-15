<?php

declare(strict_types=1);

spl_autoload_register(function (string $classNamespace) {
  $path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
  $path = "src/$path.php";
  require_once($path);
});

require_once("src/Utils/debug.php");
$configuration = require_once("config/config.php");

use App\Controller\AbstactController;
use App\Controller\TemplateController;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;

$request = new Request($_GET, $_POST);

try {
  AbstactController::initConfiguration($configuration);
  // TODO: add logic when create another controller
  (new TemplateController($request))->run();
} catch (ConfigurationException $e) {
  echo "Error has occurred in the application. ";
  echo 'Problem with the app, please try again in a moment. ';
} catch (AppException $e) {
  echo "Error has occurred in the application. ";
  echo $e->getMessage();
} catch (\Throwable $e) {
  echo "Error has occurred in the application. ";
  dump($e);
}