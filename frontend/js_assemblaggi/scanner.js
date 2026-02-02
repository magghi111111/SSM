document.addEventListener("DOMContentLoaded", () => {

  const openBtn = document.getElementById("openScanner");
  const closeBtn = document.getElementById("closeScanner");
  const scannerBox = document.getElementById("scannerBox");

  if (!openBtn || !closeBtn || !scannerBox) {
    console.warn("Scanner: elementi DOM mancanti");
    return;
  }

  let qrScanner;
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

  openBtn.addEventListener("click", async () => {
    scannerBox.classList.remove("hidden");

    if (!initScanner()) return;   // 🔒 GARANZIA

    try {
      scanning = true;
      await qrScanner.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: (viewfinderWidth, viewfinderHeight) => {
                const size = Math.min(viewfinderWidth, viewfinderHeight) * 0.6;
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

  closeBtn.addEventListener("click", stopScanner);

  async function onQrSuccess(text) {
    console.log("QR letto:", text);

    await stopScanner();

    const msgBox = document.getElementById("scanMessage");
    if (msgBox) {
        msgBox.textContent = "Componente scannerizzato";
        msgBox.classList.remove("hidden", "error");

        // sparisce dopo 3 secondi (opzionale)
        setTimeout(() => {
        msgBox.classList.add("hidden");
        }, 3000);
    }

    handleQr(text);
    }

});