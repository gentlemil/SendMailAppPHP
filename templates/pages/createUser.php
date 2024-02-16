<div>
  <h3>Add new user</h3>
  
  <div>
    <form class="note-form" action="/?action=createUser" method="post">
      <ul>
        <li>
          <label>First name <span class="required">*</span></label>
          <input type="text" name="firstName" class="field-long" />
        </li>

        <li>
          <label>Last name <span class="required">*</span></label>
          <input type="text" name="lastName" class="field-long" />
        </li>

        <li>
          <label>Email address <span class="required">*</span></label>
          <input type="text" name="email" class="field-long" />
        </li>

        <li>
          <label>Position<span class="required">*</span></label>
          <input type="text" name="position" class="field-long" />
        </li>

        <li>
          <input type="submit" value="Submit" />
        </li>
      </ul>
    </form>
  </div>
</div>