<?php

declare(strict_types=1);

namespace App;

require_once("AbstactController.php");

use App\Exception\NotFoundException;

class TemplateController extends AbstactController
{
  public function createAction()
  {
    if ($this->request->checkIfPost()) {
      $templateData = [
        'title' => $this->request->postParam('title'),
        'message' => $this->request->postParam('message')
      ];
      $this->database->createTemplate($templateData);
      header('Location: /?before=created');
      exit;
    }

    $this->view->render('create');
  }

  public function showAction()
  {
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

    $this->view->render('show', ['template' => $template]);
  }

  public function listAction()
  {
    $this->view->render(
      'list', 
      [
      'templates' => $this->database->getTemplates(),
      'before' => $this->request->getParam('before'),
      'error' => $this->request->getParam('error'),
      ]
    );
  }
}
