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
        }
      }
      ?>
    </div>

    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Message</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php foreach ($params['templates'] ?? [] as $template): ?>
            <tr>
              <td><?php echo (int) $template['id'] ?></td>
              <td><?php echo htmlentities($template['title']) ?></td>
              <td><?php echo htmlentities($template['message']) ?></td>
              <td>
                <a href="?action=show&id=<?php echo (int) $template['id'] ?>">
                <button>Show details</button>
              </a>
              </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>