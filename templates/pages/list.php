<div class="list">
  <section>
    <div class="message">
      <?php
      if (!empty($params['error'])) {
        switch ($params['error']) {
          case 'templateNotFound':
            echo 'Template not found.';
            break;
          case 'missingTemplateId':
            echo 'Incorrect template ID.';
            break;
          case 'sentMailError':
            echo 'Send mail failure. Try again.';
            break;
        }
      }
      ?>
    </div>

    <div class="message">
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']) {
          case 'created':
            echo 'Template has been created';
            break;
          case 'edited':
            echo 'Template has been updated';
            break;
          case 'sent':
            echo 'Mail template has been sent successfully';
            break;
        }
      }
      ?>
    </div>

    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th style="width: 15%;">Id</th>
            
            <th style="width: 20%;">Title</th>
            
            <th style="width: 40%;">Message</th>
            
            <th style="width: 25%;">Options</th>
          </tr>
        </thead>
      </table>
    </div>

    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php foreach ($params['templates'] ?? [] as $template): ?>
            <tr>
              <td style="width: 15%;"><?php echo (int) $template['id'] ?></td>
              
              <td style="width: 20%;"><?php echo htmlentities($template['title']) ?></td>
              
              <td style="width: 40%;"><?php echo htmlentities($template['message']) ?></td>
              
              <td style="width: 25%;">
                <a href="?action=show&id=<?php echo (int) $template['id'] ?>">
                <button>DETAILS</button>
              </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>