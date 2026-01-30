<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Assemblaggio Libero</title>
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<script>
document.addEventListener("DOMContentLoaded", () => {

  let qrScanner = null;

  function initScanner() {
    if (!qrScanner) {
      qrScanner = new Html5Qrcode("qr-reader");
    }
  }

  async function stopScanner() {
    if (qrScanner) {
      await qrScanner.stop();
      document.getElementById("scannerBox").style.display = "none";
    }
  }

  const openBtn = document.getElementById("openScanner");
  const closeBtn = document.getElementById("closeScanner");

  if (!openBtn || !closeBtn) {
    console.error("Pulsanti scanner non trovati nel DOM");
    return;
  }

  openBtn.addEventListener("click", async () => {
    document.getElementById("scannerBox").style.display = "block";
    initScanner();

    try {
      await qrScanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onQrSuccess,
        () => {}
      );
    } catch (err) {
      alert("Errore accesso alla fotocamera");
      console.error(err);
    }
  });

  closeBtn.addEventListener("click", stopScanner);

  function onQrSuccess(text) {
    console.log("QR letto:", text);
    stopScanner();
  }

});
</script>
<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <section class="assembly-card">
      <div class="assembly-actions">
        <button class="btn-primary" id="openScanner">Avvia Scanner QR</button>
      </div>

      <div class="camera-box" id="scannerBox" style="display:none">
        <div id="qr-reader"></div>

        <div class="scanner-actions">
          <button class="btn-secondary" id="closeScanner">Chiudi scanner</button>
        </div>
      </div>

      <h2 class="section-title">Componenti prelevati</h2>

      <table class="assembly-table">
        <thead>
          <tr>
            <th>Codice</th>
            <th>Descrizione</th>
            <th>Quantità</th>
            <th>Stato</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>COMP-001</td>
            <td>Centralina</td>
            <td>1</td>
            <td class="status-ok">OK</td>
          </tr>
          <tr>
            <td>COMP-014</td>
            <td>Cavo sensore</td>
            <td>2</td>
            <td class="status-pending">In attesa</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>

  <!-- FOOTER già esistente -->

</body>
</html>