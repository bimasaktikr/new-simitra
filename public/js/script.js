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
  setupLiveSearch('search-mitra', 'mitra-table', '/mitras/search');
  setupLiveSearch('search-employee', 'employee-table', '/employee/search');
  setupLiveSearch('search-user', 'user-table', '/users/search');
});

function setupLiveSearch(searchInputId, resultContainerId, searchUrl) {
  if($('#'+searchInputId).length <= 0){
    return;
  }

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

document.getElementById('fungsi').addEventListener('change', function() {
  var peranContainer = document.getElementById('peran-container');
  if (this.value && this.value !== "") {
      peranContainer.style.display = 'block';
  } else {
      peranContainer.style.display = 'none';
  }
});


document.addEventListener('DOMContentLoaded', function() {
    const syncForm = document.getElementById('sync-form');
    const syncButton = document.getElementById('sync-button');

    syncForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default

        syncButton.disabled = true; // Nonaktifkan tombol
        syncButton.textContent = 'Sedang Proses...'; // Ubah teks tombol

        fetch(syncForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(new FormData(syncForm)),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Jika berhasil, sembunyikan tombol
            syncButton.style.display = 'none';
            alert('Sinkronisasi berhasil!');
        })
        .catch(error => {
            console.error('Ada masalah dengan permintaan:', error);
            syncButton.disabled = false; // Aktifkan kembali tombol jika gagal
            syncButton.textContent = 'Sinkronisasi Data Mitra'; // Kembalikan teks tombol
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const tabs = document.querySelectorAll('.tab-link');
    let selectedPeriod = document.getElementById('selected-period').value;

    tabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();
            selectedPeriod = this.getAttribute('data-period');
            document.getElementById('selected-period').value = selectedPeriod;
            loadLeaderboard(selectedPeriod);
        });
    });

    searchInput.addEventListener('input', function () {
        performLiveSearch(this.value, selectedPeriod);
    });

    function performLiveSearch(query, period) {
        fetch(`/mitrateladan/live-search?search=${query}&period=${period}`)
            .then(response => response.json())
            .then(data => updateTable(data))
            .catch(error => console.error('Error:', error));
    }

    function updateTable(data) {
        const tbody = document.querySelector('#leaderboard-table tbody');
        tbody.innerHTML = ''; // Clear existing rows
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.classList.add('bg-white', 'border-b', 'dark:bg-gray-800', 'dark:border-gray-700');
            row.innerHTML = `
                <td class="px-6 py-4">${index + 1}</td>
                <td class="px-6 py-4">${item.name}</td>
                <td class="px-6 py-4">${item.id_sobat}</td>
                <td class="px-6 py-4">${item.rating}</td>
                <td class="px-6 py-4">${item.banyak_survey}</td>
            `;
            tbody.appendChild(row);
        });
    }

    function loadLeaderboard(period) {
        // Fetch data according to the selected tab and update the table
        performLiveSearch(searchInput.value, period);
    }
});
