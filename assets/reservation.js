// Filtrage intelligent des séances selon le film choisi

document.addEventListener('DOMContentLoaded', function() {
  const filmSelect = document.getElementById('film');
  const seanceSelect = document.getElementById('seance');
  if (!filmSelect || !seanceSelect) return;

  function filterSeances() {
    const filmId = filmSelect.value;
    if (!filmId) {
      seanceSelect.disabled = true;
      seanceSelect.value = '';
    } else {
      seanceSelect.disabled = false;
      seanceSelect.value = '';
    }
    Array.from(seanceSelect.options).forEach(option => {
      if (!option.value) {
        option.hidden = false;
        option.disabled = false;
        return;
      }
      if (!filmId || option.getAttribute('data-film') === filmId) {
        option.hidden = false;
        option.disabled = false;
      } else {
        option.hidden = true;
        option.disabled = true;
      }
    });
    // Si aucune séance visible, reset le select
    if (!Array.from(seanceSelect.options).some(opt => !opt.hidden && opt.value)) {
      seanceSelect.value = '';
    }
  }

  filmSelect.addEventListener('change', filterSeances);
  filterSeances();
});
