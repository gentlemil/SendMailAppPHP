<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");
require_once("./src/Exception/AppException.php");

$configuration = require_once("config/config.php");

$request = [
  'get' => $_GET,
  'post' => $_POST
];

try {
  Controller::initConfiguration($configuration);
  (new Controller($request))->run();
} catch (ConfigurationException $e) {
  echo 'Error has occurred in the application';
  echo 'Problem with the app, please try again in a moment.';
} catch (AppException $e) {
  echo 'Error has occurred in the application';
  echo $e->getMessage();
} catch (Throwable $e) {
  echo 'Error has occurred in the application';
  dump($e);
}