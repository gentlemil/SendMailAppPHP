<?php

declare(strict_types=1);

namespace App\Controller;

class UserController extends AbstactController
{
  public function createAction()
  {
    if ($this->request->hasPost()) {
      $userData = [
        'firstName' => $this->request->postParam('firstName'),
        'lastName' => $this->request->postParam('lastName'),
        'email' => $this->request->postParam('email'),
        'position' => $this->request->postParam('position'),
      ];
      $this->userDatabase->createUser($userData);

      $this->redirect('/', ['before' => 'userCreated']);
    }

    $this->view->render('userCreate');
  }

  public function listAction()
  {
    $this->view->render(
      'list', 
      [
      'users' => $this->userDatabase->getUsers(),
      'before' => $this->request->getParam('before'),
      'error' => $this->request->getParam('error'),
      ]
    );
  }
}
