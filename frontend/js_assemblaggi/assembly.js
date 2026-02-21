document.addEventListener("DOMContentLoaded", () => {

  const assemblyMap = {
    cambio: [
      { nome: "Pedalina", qty: 1 },
      { nome: "Interruttore", qty: 1 },
      { nome: "Cablaggio", qty: 1 },
      { nome: "Centralina", qty: 1 }
    ],
    pedalina: [
      { nome: "Scocca", qty: 1 },
      { nome: "Molla", qty: 1 },
      { nome: "Perno", qty: 1 },
      { nome: "Ampolla-reed", qty: 1 },
      { nome: "Pulsante", qty: 1 },
      { nome: "Magnete", qty: 1 }
    ],
    centralina: [
      { nome: "PCB", qty: 1 },
      { nome: "Case", qty: 1 }
    ]
  };

  const radios = document.querySelectorAll('input[name="assembly_type"]');
  const requiredBox = document.getElementById("requiredComponents");
  const list = document.getElementById("componentList");

  radios.forEach(radio => {
    radio.addEventListener("change", () => {

      const selected = radio.value;
      const components = assemblyMap[selected];

      list.innerHTML = "";

      components.forEach(comp => {
        const li = document.createElement("li");
        li.textContent = `${comp.nome} - x${comp.qty}`;
        list.appendChild(li);
      });

      requiredBox.classList.remove("hidden");
    });
  });

});