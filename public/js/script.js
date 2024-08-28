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

  function toggleModal(modalID, formAction = null) {
    const modal = document.getElementById(modalID);
    if (formAction) {
        document.getElementById('deleteForm').action = formAction;
    }
    modal.classList.toggle('hidden');
}

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    document.getElementById('deleteForm').submit();
});

document.addEventListener('DOMContentLoaded', function() {
  setupLiveSearch('search-survey', 'survey-table', '/surveys/search');
  setupLiveSearch('search-mitra', 'mitra-table', '/mitra/search');
  setupLiveSearch('search-mitra', 'mitra-table', '/mitra/search');
  setupLiveSearch('search-user', 'user-table', '/user/search');
});

function setupLiveSearch(searchInputId, resultContainerId, searchUrl) {
  document.getElementById(searchInputId).addEventListener('input', function () {
      let query = this.value;

      fetch(`${searchUrl}?query=${encodeURIComponent(query)}`, {
          headers: {
              'X-Requested-With': 'XMLHttpRequest'
          }
      })
      .then(response => response.text())
      .then(data => {
          document.getElementById(resultContainerId).innerHTML = data;
      })
      .catch(error => console.error('Error:', error));
  });
}

