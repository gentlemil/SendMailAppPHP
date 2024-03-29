<section>
  <h3 class="sub-header">1. Preview template</h3>
  
  <div>
    <?php if (!empty($params['template'])) : ?>
    <?php $template = $params['template'] ?>
    
    <form class="note-form" action="/?action=edit" method="post">
      <input type="hidden" name="id"  value="<?php echo $template['id'] ?>" />

      <ul>
        <li>
          <label>Title <span class="required">*</span></label>
          <input type="text" name="title" class="field-long" value="<?php echo $template['title'] ?>"  />
        </li>

        <li>
          <label>Message</label>
          <textarea name="message" id="message" class="field-long field-textarea"><?php echo $template['message'] ?></textarea>
        </li>
        
        <li>
          <input type="submit" name="edit" value="Edit template" />
        </li>
      </ul>
    </form>

    <?php else : ?>
      <div>
        <i>No data to display</i>

        <a href="/">
          <button>Go back to main page</button>
        </a>
      </div>

    <?php endif; ?>
  </div>

  <h3 class="sub-header">2. Choose users</h3>

  <?php if (!empty($params['users'])) : ?>
    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th style="width: 10%;"></th>
            
            <th style="width: 20%;">First Name</th>
            
            <th style="width: 20%;">Last Name</th>
            
            <th style="width: 30%;">Email</th>
            
            <th style="width: 20%;">Position</th>
          </tr>
        </thead>
      </table>
    </div>

    <div class="tbl-content">
      <form method="post">
        <table cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <?php foreach ($params['users'] ?? [] as $user): ?>
              <tr>
                <td style="width: 10%;">
                  <input type="checkbox" name="selectedUsers[]" value="<?php echo $user['id'] ?>">
                </td>

                <td style="width: 20%;"><?php echo htmlentities($user['firstName']) ?></td>
                
                <td style="width: 20%;"><?php echo htmlentities($user['lastName']) ?></td>
                
                <td style="width: 30%;"><?php echo htmlentities($user['email']) ?></td>
                
                <td style="width: 20%;"><?php echo htmlentities($user['position']) ?></td>
                
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <input type="submit" name="send" value="Send mail" style="margin-top: 20px;" />
      </form>
    </div>

    <?php else : ?>
    <div>
      <i>No users</i>
    </div>
    
    <?php endif; ?>
</section>