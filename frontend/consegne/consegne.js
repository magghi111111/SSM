  function toggleNuovoFornitore() {
    const select = document.getElementById('fornitore');
    const box = document.getElementById('nuovo-fornitore');

    if (select.value === 'new') {
      box.classList.remove('hidden');
    } else {
      box.classList.add('hidden');
    }
  }

  function addDeliveryRow() {
    const container = document.getElementById('componenti-consegna');
    const row = container.children[0].cloneNode(true);

    row.querySelector('select').value = '';
    row.querySelector('input').value = 1;

    container.appendChild(row);
  }

  function removeRow(btn) {
    const container = document.getElementById('componenti-consegna');
    if (container.children.length > 1) {
      btn.closest('.delivery-row').remove();
    }
  }

    document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll(".assembly_component").forEach(row => {

      row.addEventListener("click", function() {

        console.log("Row clicked");

        const details = this.nextElementSibling;

        if (!details || !details.classList.contains("assembly-details")) {
          return;
        }

        details.classList.toggle("hidden");
        this.classList.toggle("open");

      });

    });

  });