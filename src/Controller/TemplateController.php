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

  public function sendMailAction($userIds, $templateId)
  {
    $templateData = $this->templateDatabase->getTemplate((int) $templateId);

    foreach ($userIds as $userId) {
      $user = $this->userDatabase->getUser((int) $userId);
      $message = "Dear " . $user['firstName'] . " " . $user['lastName'] . ",\n\n" . $templateData['message'] . "\n\nAll the best\nMilosz";

      $mailData = [
        'to' => $user['email'],
        'subject' => $templateData['title'],
        'message' => $message,
      ];

        $mail = new PHPMailer;
        $mail->SMTPDebug = 5;                                 

        $mail->isSMTP();                                      
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom(EMAIL, 'Milosz Bukala');
        $mail->addAddress($mailData['email'], $user['firstName'] . " " . $user['lastName']); 
        $mail->addReplyTo(EMAIL, 'Milosz Bukala');

        $mail->isHTML(true);

        $mail->Subject = $templateData['title'];
        $mail->Body    = $message;
        $mail->AltBody = $message;

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }

      try {
        mail($mailData['to'], $mailData['subject'], $mailData['message']);

      } catch (NotFoundException $e) {
        $this->redirect('/', ['error' => 'sentMailError']);
      }
    }
    $this->redirect('/', ['before' => 'sent']);
  }

  public function editAction()
  {
    if ($this->request->isPost()) {
      if (isset($_POST['edit'])) {
        $templateId = (int) $this->request->postParam('id');

        $templateData = [
          'title' => $this->request->postParam('title'),
          'message' => $this->request->postParam('message')
        ];

        $this->templateDatabase->editTemplate($templateId, $templateData);
        $this->redirect('/', ['before' => 'edited']);
      } elseif (isset($_POST['send'])) {
        $templateId = $_GET['id'];
        $selectedUserIds = $_POST['selectedUsers'];

        $this->sendMailAction($selectedUserIds, $templateId);
      }
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
