// JS pour le formulaire récapitulatif de réservation

document.addEventListener('DOMContentLoaded', function() {
  attachRecapListeners();
});

function attachRecapListeners() {
  document.querySelectorAll('.seance-form').forEach(function(form) {
    form.addEventListener('submit', function recapHandler(e) {
      e.preventDefault();
      const seanceId = form.action.split('/').pop();
      const filmTitle = form.closest('.movie').querySelector('h3').textContent;
      const seanceTime = form.closest('.seance-item').querySelector('.seance-time').textContent;
      const places = form.querySelector('input[name="nombre_places"]').value;
      showRecapModal({
        film: filmTitle,
        seance: seanceTime,
        places: places,
        form: form
      });
    }, { once: true });
  });
}

function showRecapModal({film, seance, places, form}) {
  // Supprime toute modal existante
  const oldModal = document.getElementById('recap-modal');
  if (oldModal) oldModal.remove();

  let modal = document.createElement('div');
  modal.id = 'recap-modal';
  modal.innerHTML = `
    <div class="recap-backdrop"></div>
    <div class="recap-content">
      <h2>Récapitulatif de réservation</h2>
      <div class="recap-details">
        <p><strong>Film :</strong> ${film}</p>
        <p><strong>Séance :</strong> ${seance}</p>
        <p><strong>Nombre de places :</strong> ${places}</p>
      </div>
      <div class="recap-actions">
        <button type="button" class="btn small" id="recap-cancel">Retour</button>
        <button type="button" class="btn small primary" id="recap-confirm">Confirmer</button>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
  modal.style.display = 'flex';
  // Bouton retour
  modal.querySelector('#recap-cancel').onclick = function() {
    modal.remove();
    attachRecapListeners();
  };
  // Bouton confirmer
  modal.querySelector('#recap-confirm').onclick = function() {
    modal.remove();
    form.submit();
  };
}

// Style rapide pour le modal
const style = document.createElement('style');
style.innerHTML = `
#recap-modal {
  position: fixed; inset: 0; z-index: 9999; display: none; align-items: center; justify-content: center;
}
.recap-backdrop {
  position: absolute; inset: 0; background: rgba(20,24,33,0.7); backdrop-filter: blur(2px); border-radius: 0;
}
.recap-content {
  position: relative; background: var(--panel); color: var(--text); padding: 32px 28px; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); min-width: 320px; max-width: 90vw;
  display: flex; flex-direction: column; gap: 18px; align-items: center;
}
.recap-actions { display: flex; gap: 16px; margin-top: 18px; }
`;
document.head.appendChild(style);
