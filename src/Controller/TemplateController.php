<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class TemplateController extends AbstactController
{
  public function createAction()
  {
    if ($this->request->hasPost()) {
      $templateData = [
        'title' => $this->request->postParam('title'),
        'message' => $this->request->postParam('message')
      ];
      $this->templateDatabase->createTemplate($templateData);

      $this->redirect('/', ['before' => 'created']);
    }

    $this->view->render('create');
  }

  public function showAction()
  {
    $templateId = (int) $this->request->getParam(('id'));

    if (!$templateId) {
      $this->redirect('/', ['error' => 'missingTemplateId']);
    }

    try {
      $template = $this->templateDatabase->getTemplate($templateId);
    } catch (NotFoundException $e) {
      $this->redirect('/', ['error' => 'templateNotFound']);
    }

    $this->view->render('show', ['template' => $template]);
  }

  public function listAction()
  {
    $this->view->render(
      'list', 
      [
      'templates' => $this->templateDatabase->getTemplates(),
      'before' => $this->request->getParam('before'),
      'error' => $this->request->getParam('error'),
      ]
    );
  }

  public function editAction()
  {
    if ($this->request->isPost()) {
      $templateId = (int) $this->request->postParam('id');

      $templateData = [
        'title' => $this->request->postParam('title'),
        'message' => $this->request->postParam('message')
      ];

      $this->templateDatabase->editTemplate($templateId, $templateData);
      $this->redirect('/', ['before' => 'edited']);

    }

    $templateId = (int) $this->request->getParam('id');

    if (!$templateId) {
      $this->redirect('/', ['error' => 'missingTemplateId']);
      header('Location: /?error=missingTemplateId');
    };

    try {
      $template = $this->templateDatabase->getTemplate($templateId);
      $users = $this->userDatabase->getUsers();
    } catch (NotFoundException $e) {
      $this->redirect('/', ['error' => 'templateNotFound']);
    }

    $this->view->render(
      'edit',
      [
        'template' => $template,
        'users' => $users,
      ],
    );
  }
}
