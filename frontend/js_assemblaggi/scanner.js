document.addEventListener("DOMContentLoaded", () => {

  const openBtn = document.getElementById("openScanner"); // solo un pulsante
  const closeBtn = document.getElementById("closeScanner");
  const scannerBox = document.getElementById("scannerBox");
  const qrReaderDiv = document.getElementById("qr-reader");

  if (!openBtn || !closeBtn || !scannerBox || !qrReaderDiv) {
    console.warn("Scanner: elementi DOM mancanti");
    return;
  }

  let qrScanner = null;
  let scanning = false;

  function initScanner() {
    if (!qrScanner) {
      if (typeof Html5Qrcode === "undefined") {
        console.error("Html5Qrcode non caricato");
        return false;
      }
      qrScanner = new Html5Qrcode("qr-reader");
    }
    return true;
  }

  async function stopScanner() {
    if (scanning && qrScanner) {
      await qrScanner.stop();
      scanning = false;
      scannerBox.classList.add("hidden");
    }
  }

  closeBtn.addEventListener("click", stopScanner);

  // APRI SCANNER (un solo pulsante)
  openBtn.addEventListener("click", async () => {
    scannerBox.classList.remove("hidden");

    if (!initScanner()) return;

    try {
      scanning = true;
      await qrScanner.start(
        { facingMode: "environment" },
        {
          fps: 10,
          qrbox: (vw, vh) => {
            const size = Math.min(vw, vh) * 0.6;
            return { width: size, height: size };
          }
        },
        onQrSuccess,
        () => {}
      );
    } catch (err) {
      console.error("Errore avvio scanner:", err);
      alert("Impossibile avviare la fotocamera");
    }
  });

  // QR SCANNED
  async function onQrSuccess(qrText) {
    await stopScanner();

    // invia al backend per sapere a quale componente appartiene
    fetch('backend/api/checkComponent.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ qr: qrText })
    })
    .then(res => res.json())
    .then(data => {

      document.getElementById("scannerError").classList.add("hidden");

      if (!data.success) {
        document.getElementById("scannerError").classList.remove("hidden");
        document.getElementById("scannerError").textContent = 'QR non valido';
        return;
      }

      const componentId = data.component_id;

      // seleziona l'input corretto tra quelli attivi (assembly selezionato)
      const input = document.querySelector(
        `.component-qr[data-componente-id="${componentId}"]:not(:disabled)`
      );

      if (!input) {
        document.getElementById("scannerError").classList.remove("hidden");
        document.getElementById("scannerError").textContent = 'Componente non richiesto per questo assembly';
        return;
      }

      input.value = qrText;
      input.classList.add('filled', 'success');

    })
    .catch(err => {
      console.error(err);
      document.getElementById("scannerError").classList.remove("hidden");
      document.getElementById("scannerError").textContent = 'Errore durante la validazione del QR';
    });
  }

});