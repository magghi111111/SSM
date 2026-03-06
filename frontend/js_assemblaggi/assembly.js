const actionsBox = document.getElementById('assemblyActions');

document.querySelectorAll('input[name="assembly_type"]').forEach(radio => {
  radio.addEventListener('change', () => {

    const selectedId = radio.value;

    // mostra i controlli
    actionsBox.classList.remove('hidden');

    document.querySelectorAll('.required-components').forEach(block => {
      const isActive = block.dataset.assemblyId === selectedId;

      block.classList.toggle('hidden', !isActive);

      block.querySelectorAll('.component-qr').forEach(input => {
        input.disabled = !isActive;

        if (!isActive) {
          input.value = '';
          input.classList.remove('filled', 'success', 'error');
        }
      });
    });
  });
});