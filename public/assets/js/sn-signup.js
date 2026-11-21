(function () {
  'use strict';

  const dialog = document.getElementById('sn-signup');
  if (!dialog) return;
  const form = dialog.querySelector('form');
  const contact = form.elements.contact;
  const password = form.elements.password;
  const confirm = form.elements.confirm_password;
  const status = dialog.querySelector('.sn-signup-status');
  const signin = document.getElementById('sn-signin');
  let opener;

  document.querySelectorAll('[data-sn-signup-open]').forEach(function (trigger) {
    trigger.addEventListener('click', function (event) {
      event.preventDefault();
      opener = trigger;
      dialog.showModal();
      document.documentElement.classList.add('sn-signup-open');
      contact.focus();
    });
  });

  dialog.querySelector('.sn-signup-close').addEventListener('click', function () { dialog.close(); });
  dialog.addEventListener('click', function (event) {
    if (event.target !== dialog) return;
    const bounds = dialog.getBoundingClientRect();
    if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
  });
  dialog.addEventListener('close', function () {
    if (!signin || !signin.open) document.documentElement.classList.remove('sn-signup-open');
    form.reset();
    contact.setCustomValidity('');
    confirm.setCustomValidity('');
    status.hidden = true;
    dialog.querySelectorAll('.sn-signup-toggle').forEach(function (button) {
      document.getElementById(button.getAttribute('aria-controls')).type = 'password';
      button.setAttribute('aria-pressed', 'false');
      button.setAttribute('aria-label', button.getAttribute('aria-controls') === confirm.id ? 'Show confirm password' : 'Show password');
      button.querySelector('i').className = 'fa-solid fa-eye-slash';
    });
    if (opener && (!signin || !signin.open)) opener.focus();
  });
  dialog.querySelectorAll('.sn-signup-toggle').forEach(function (button) {
    button.addEventListener('click', function () {
      const input = document.getElementById(button.getAttribute('aria-controls'));
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      button.setAttribute('aria-pressed', String(show));
      button.setAttribute('aria-label', (show ? 'Hide ' : 'Show ') + (input === confirm ? 'confirm password' : 'password'));
      button.querySelector('i').className = show ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
    });
  });

  function validate() {
    const value = contact.value.trim();
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || /^\+?\d[\d\s()-]{6,18}\d$/.test(value);
    contact.setCustomValidity(value && !valid ? 'Enter a valid email address or mobile number.' : '');
    confirm.setCustomValidity(confirm.value && confirm.value !== password.value ? 'Passwords do not match.' : '');
  }
  form.addEventListener('input', function () { validate(); status.hidden = true; });
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    validate();
    if (!form.reportValidity()) return;
    status.textContent = 'Account registration is not available yet. Please contact Smart Notes Publication for assistance.';
    status.hidden = false;
  });

  if (!signin) return;
  const loginForm = signin.querySelector('form');
  const loginContact = loginForm.elements.contact;
  const loginPassword = loginForm.elements.password;
  const loginStatus = signin.querySelector('.sn-signup-status');
  const loginToggle = signin.querySelector('.sn-signup-toggle');

  dialog.querySelector('[data-sn-signin-open]').addEventListener('click', function (event) {
    event.preventDefault();
    dialog.close();
    signin.showModal();
    document.documentElement.classList.add('sn-signup-open');
    loginContact.focus();
  });
  signin.querySelector('[data-sn-signup-return]').addEventListener('click', function (event) {
    event.preventDefault();
    signin.close();
    dialog.showModal();
    document.documentElement.classList.add('sn-signup-open');
    contact.focus();
  });
  signin.querySelector('.sn-signup-close').addEventListener('click', function () { signin.close(); });
  signin.addEventListener('click', function (event) {
    if (event.target !== signin) return;
    const bounds = signin.getBoundingClientRect();
    if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) signin.close();
  });
  signin.addEventListener('close', function () {
    loginForm.reset();
    loginContact.setCustomValidity('');
    loginStatus.hidden = true;
    loginPassword.type = 'password';
    loginToggle.setAttribute('aria-pressed', 'false');
    loginToggle.setAttribute('aria-label', 'Show password');
    loginToggle.querySelector('i').className = 'fa-solid fa-eye-slash';
    if (!dialog.open) {
      document.documentElement.classList.remove('sn-signup-open');
      if (opener) opener.focus();
    }
  });
  loginToggle.addEventListener('click', function () {
    const show = loginPassword.type === 'password';
    loginPassword.type = show ? 'text' : 'password';
    loginToggle.setAttribute('aria-pressed', String(show));
    loginToggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    loginToggle.querySelector('i').className = show ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
  });
  function validateLogin() {
    const value = loginContact.value.trim();
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || /^\+?\d[\d\s()-]{6,18}\d$/.test(value);
    loginContact.setCustomValidity(value && !valid ? 'Enter a valid email address or phone number.' : '');
  }
  loginForm.addEventListener('input', function () { validateLogin(); loginStatus.hidden = true; });
  loginForm.addEventListener('submit', function (event) {
    event.preventDefault();
    validateLogin();
    if (!loginForm.reportValidity()) return;
    loginStatus.textContent = 'Online sign in is not available yet. Please contact Smart Notes Publication for assistance.';
    loginStatus.hidden = false;
  });
  signin.querySelector('.sn-signin-forgot').addEventListener('click', function () {
    loginStatus.textContent = 'For password assistance, call +91 99798-65666 or email smartnotespublication@gmail.com.';
    loginStatus.hidden = false;
  });
})();
