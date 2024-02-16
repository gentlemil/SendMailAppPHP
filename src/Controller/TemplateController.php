<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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

      $mail = new PHPMailer(true);

      try {
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;
          $mail->isSMTP();
          
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;   
          $mail->Username = 'example@gmail.com';    // provide user/company account details
          $mail->Password = 'account_password'; 
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $mail->Port = 465;

          $mail->setFrom('milosz.bukala.mbit@gmail.com', 'company');
          $mail->addAddress($mailData['email'], $user['firstName'] . " " . $user['lastName']);
          $mail->addReplyTo('milosz.bukala.mbit@gmail.com', 'company');
          $mail->isHTML(true);
          
          $mail->Subject = $templateData['title'];
          $mail->Body    = $message;
          $mail->AltBody = $message;

          $mail->send();

      } catch (Exception $e) {
          dump($e);
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
