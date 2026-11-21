<dialog class="sn-signup" id="sn-signup" aria-labelledby="sn-signup-title" aria-describedby="sn-signup-description" data-lenis-prevent>
  <div class="sn-signup-panel">
    <button class="sn-signup-close" type="button" aria-label="Close sign up"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    <div class="sn-signup-intro">
      <!--<span class="sn-signup-emblem" aria-hidden="true"><i class="fa-solid fa-book-open"></i></span>
      <span class="sn-signup-eyebrow">SMART NOTES PUBLICATION</span>-->
      <h2 id="sn-signup-title">Sign up</h2>
      <p id="sn-signup-description">A little step towards a world of learning.</p>
    </div>
    <form class="sn-signup-form">
      <div class="sn-signup-field">
        <label for="sn-signup-contact">Mobile number or email</label>
        <div class="sn-signup-input">
          <i class="fa-solid fa-user" aria-hidden="true"></i>
          <input id="sn-signup-contact" name="contact" type="text" autocomplete="username" placeholder="Enter mobile number or email" required maxlength="254">
        </div>
      </div>
      <div class="sn-signup-field">
        <label for="sn-signup-password">Password</label>
        <div class="sn-signup-input">
          <i class="fa-solid fa-lock" aria-hidden="true"></i>
          <input id="sn-signup-password" name="password" type="password" autocomplete="new-password" placeholder="Create a password" minlength="8" required aria-describedby="sn-signup-password-hint">
          <button type="button" class="sn-signup-toggle" aria-label="Show password" aria-controls="sn-signup-password" aria-pressed="false"><i class="fa-solid fa-eye-slash" aria-hidden="true"></i></button>
        </div>
        <small id="sn-signup-password-hint">Use at least 8 characters.</small>
      </div>
      <div class="sn-signup-field">
        <label for="sn-signup-confirm">Confirm password</label>
        <div class="sn-signup-input">
          <i class="fa-solid fa-lock" aria-hidden="true"></i>
          <input id="sn-signup-confirm" name="confirm_password" type="password" autocomplete="new-password" placeholder="Re-enter your password" minlength="8" required>
          <button type="button" class="sn-signup-toggle" aria-label="Show confirm password" aria-controls="sn-signup-confirm" aria-pressed="false"><i class="fa-solid fa-eye-slash" aria-hidden="true"></i></button>
        </div>
      </div>
      <button class="vs-btn sn-signup-submit" type="submit">Create account <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
      <p class="sn-signup-status" role="status" hidden></p>
    </form>
    <p class="sn-signup-footnote"><i class="fa-solid fa-book" aria-hidden="true"></i> Great learning starts here.</p>
    <p class="sn-signup-signin">Already have an account? <a href="#sn-signin" data-sn-signin-open aria-haspopup="dialog" aria-controls="sn-signin">Sign In</a></p>
  </div>
</dialog>


<dialog class="sn-signup sn-signin" id="sn-signin" aria-labelledby="sn-signin-title" aria-describedby="sn-signin-description" data-lenis-prevent>
  <div class="sn-signup-panel">
    <button class="sn-signup-close" type="button" aria-label="Close sign in"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    <div class="sn-signup-intro">
      <!--<span class="sn-signup-emblem" aria-hidden="true"><i class="fa-solid fa-book-open"></i></span>
      <span class="sn-signup-eyebrow">WELCOME BACK</span>-->
      <h2 id="sn-signin-title">Sign in</h2>
      <p id="sn-signin-description">Continue your learning journey with Smart Notes.</p>
    </div>
    <form class="sn-signin-form">
      <div class="sn-signup-field">
        <label for="sn-signin-contact">Email or phone</label>
        <div class="sn-signup-input">
          <i class="fa-solid fa-user" aria-hidden="true"></i>
          <input id="sn-signin-contact" name="contact" type="text" autocomplete="username" placeholder="Enter email or phone number" required maxlength="254">
        </div>
      </div>
      <div class="sn-signup-field">
        <label for="sn-signin-password">Password</label>
        <div class="sn-signup-input">
          <i class="fa-solid fa-lock" aria-hidden="true"></i>
          <input id="sn-signin-password" name="password" type="password" autocomplete="current-password" placeholder="Enter your password" required>
          <button type="button" class="sn-signup-toggle" aria-label="Show password" aria-controls="sn-signin-password" aria-pressed="false"><i class="fa-solid fa-eye-slash" aria-hidden="true"></i></button>
        </div>
      </div>
      <div class="sn-signin-help"><button type="button" class="sn-signin-forgot">Forgot Password?</button></div>
      <button class="vs-btn sn-signup-submit" type="submit">Login <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
      <p class="sn-signup-status" role="status" hidden></p>
    </form>
    <p class="sn-signup-footnote"><i class="fa-solid fa-book" aria-hidden="true"></i> Your next chapter starts here.</p>
    <p class="sn-signup-signin">Not a member? <a href="#sn-signup" data-sn-signup-return>Signup now</a></p>
  </div>
</dialog>
