<div class="list">
  <section>
    <div class="message">
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']) {
          case 'created':
            echo 'Template has been created';
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
              <td>Options</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>