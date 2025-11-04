// Tri interactif du tableau des réservations

document.addEventListener('DOMContentLoaded', function() {
  const table = document.querySelector('.table');
  if (!table) return;
  const headers = table.querySelectorAll('th.sortable');
  const tbody = table.querySelector('tbody');
  if (!headers.length || !tbody) return;

  headers.forEach(header => {
    header.style.cursor = 'pointer';
    header.onclick = function() {
      const sortKey = header.getAttribute('data-sort');
      const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelector('td'));
      let sorted;
      if (sortKey === 'film') {
        sorted = rows.sort((a, b) => a.cells[0].textContent.localeCompare(b.cells[0].textContent));
      } else if (sortKey === 'date') {
        sorted = rows.sort((a, b) => {
          const dA = a.cells[1].textContent.split('/').reverse().join('-');
          const dB = b.cells[1].textContent.split('/').reverse().join('-');
          return dA.localeCompare(dB);
        });
      } else if (sortKey === 'places') {
        sorted = rows.sort((a, b) => parseInt(a.cells[2].textContent) - parseInt(b.cells[2].textContent));
      } else if (sortKey === 'salle') {
        sorted = rows.sort((a, b) => a.cells[3].textContent.localeCompare(b.cells[3].textContent));
      } else if (sortKey === 'statut') {
        sorted = rows.sort((a, b) => a.cells[4].textContent.localeCompare(b.cells[4].textContent));
      }
      // Inverse le tri si déjà trié
      if (header.classList.contains('sorted-asc')) {
        sorted.reverse();
        header.classList.remove('sorted-asc');
        header.classList.add('sorted-desc');
      } else {
        headers.forEach(h => {
          h.classList.remove('sorted-asc', 'sorted-desc');
          const arrow = h.querySelector('.sort-arrow');
          if (arrow) arrow.textContent = '';
        });
        header.classList.add('sorted-asc');
      }
      // Ajoute la flèche sur la colonne active
      headers.forEach(h => {
        const arrow = h.querySelector('.sort-arrow');
        if (arrow) {
          if (h === header) {
            arrow.textContent = header.classList.contains('sorted-desc') ? '▼' : '▲';
            arrow.style.color = 'var(--primary)';
          } else {
            arrow.textContent = '';
            arrow.style.color = 'var(--muted)';
          }
        }
      });
      sorted.forEach(row => tbody.appendChild(row));
    };
  });
});
