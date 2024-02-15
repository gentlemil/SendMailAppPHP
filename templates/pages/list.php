<div>
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

  <h4>templates list</h4>
  <b><?php echo $params['resultList'] ?? "" ?></b>
</div>