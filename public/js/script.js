const hamburger = document.getElementById('hamburger');
const body = document.body;
const sidebar = document.getElementById('logo-sidebar');

hamburger.addEventListener('click', () => {
    if (body.classList.contains('sidebar-open')) {
        body.classList.remove('sidebar-open');
        body.classList.add('sidebar-closed');
        sidebar.classList.add('-translate-x-full');
    } else {
        body.classList.remove('sidebar-closed');
        body.classList.add('sidebar-open');
        sidebar.classList.remove('-translate-x-full');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-accordion-target]').forEach(button => {
      button.addEventListener('click', function () {
        const target = document.querySelector(button.getAttribute('data-accordion-target'));
        target.classList.toggle('hidden');
        button.querySelector('[data-accordion-icon]').classList.toggle('rotate-180');
      });
    });
  });

  function togglePassword() {
    var passwordField = document.getElementById('password');
    var toggleIcon = document.getElementById('togglePassword');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}