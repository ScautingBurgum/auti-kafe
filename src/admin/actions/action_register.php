<form class="form-horizontal" action='?action=submit' method="POST" style="display: table;margin: 0 auto;margin-top: 25px;margin-bottom: 25px;">
  <fieldset>
    <div id="legend">
      <legend class="">Register</legend>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Username</label>
      <div class="controls">
      	<input type="hidden" name="registerform" value="register"/>
        <input type="text" id="username" name="username" placeholder="" class="input-xlarge" required>
        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="email" id="email" name="email" placeholder="" class="input-xlarge" required>
        <p class="help-block">Please provide your E-mail</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="input-xlarge" required>
        <p class="help-block">Password should be at least 4 characters</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Password (Confirm)</label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge" required>
        <p class="help-block">Please confirm password</p>
      </div>
    </div>

    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="scode">"Secret Code"</label>
      <div class="controls">
        <input type="password" id="scode" name="scode" placeholder="" class="input-xlarge" required>
        <p class="help-block">Input secret code to verify you're admin</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success">Register</button>
      </div>
    </div>
  </fieldset>
</form>


<?php

/*password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
if(password_verify($input,$hashed_password)){

}*/
?>
