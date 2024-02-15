<?php

declare(strict_types=1);

namespace App;

require_once("src/Exception/ConfigurationException.php");

use App\Request;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

require_once("Database.php");
require_once("View.php");

class Controller
{
  private const DEFAULT_ACTION = 'list';

  private static array $configuration = [];

  private Database $database;
  private Request $request;
  private View $view;

  public static function initConfiguration(array $configuration): void
  {
    self::$configuration = $configuration;
  }

  public function __construct(Request $request)
  {
    if (empty(self::$configuration['db'])) {
      throw new ConfigurationException('Configuration error');
    }
    $this->database = new Database(self::$configuration['db']);

    $this->request = $request;
    $this->view = new View();
  }

  public function run(): void
  {
    switch ($this->action()) {
      case 'create':
        $page = 'create';



        if ($this->request->checkIfPost()) {
          $templateData = [
            'title' => $this->request->postParam('title'),
            'message' => $this->request->postParam('message')
          ];
          $this->database->createTemplate($templateData);
          header('Location: /?before=created');
          exit;
        }

        break;
      case 'show':
        $page = 'show';


        $templateId = (int) $this->request->getParam(('id'));

        if (!$templateId) {
          header('Location: /?error=missingTemplateId');
          exit;
        }

        try {
          $template = $this->database->getTemplate($templateId);
        } catch (NotFoundException $e) {
          header('Location: /?error=templateNotFound');
          exit;
        }

        $viewParams = [
          'template' => $template
        ];
        break;
      default:
        $page = 'list';

        $viewParams = [
          'templates' => $this->database->getTemplates(),
          'before' => $this->request->getParam('before'),
          'error' => $this->request->getParam('error'),
        ];

        break;
    } 

    $this->view->render($page, $viewParams ?? []);
  }

  private function action(): string
  { 
    return $this->request->getParam('action', self::DEFAULT_ACTION);
  }
}
