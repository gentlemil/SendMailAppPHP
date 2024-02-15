<div>

<i>Here you can edit template, choose users and send message to your colleagues</i>
<br />

<h3>Edit template before send message</h3>
  
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
          <textarea name="message" id="field5" class="field-long field-textarea"><?php echo $template['message'] ?></textarea>
        </li>
        
        <li>
          <input type="submit" value="Submit" />
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
</div>

<h3>Choose users</h3>
    <!-- in progress -->
    <?php if (!empty($params['users'])) : ?>
    <?php $users = $params['users'] ?>
    
    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>x</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Select</th>
          </tr>
        </thead>
      </table>
    </div>

    <div class="tbl-content">
      <form method="post">
        <table cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <?php foreach ($params['templates'] ?? [] as $template): ?>
              <tr>
                <td>
                  <input type="checkbox" name="selectedUsers[]" value="<?php echo (int) $template['id'] ?>">
                </td>
                <td><?php echo htmlentities($template['firstName']) ?></td>
                <td><?php echo htmlentities($template['lastName']) ?></td>
                <td><?php echo htmlentities($template['email']) ?></td>
                <td><?php echo htmlentities($template['position']) ?></td>
                
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </form>
      <button type="submit">Submit</button>
    </div>

    <?php else : ?>
      <div>
        <i>No users</i>
      </div>
    
      <?php endif; ?>
