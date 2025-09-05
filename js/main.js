document.addEventListener("DOMContentLoaded", () => {
  if (window.location.pathname.includes("index.php")) {
    document.body.style.overflowY = "hidden";
  }

  const booster = document.querySelector(".booster");
  const etoile = document.querySelector(".etoile");
  const cardsRow = document.querySelector(".cards-row");

  if (!booster || !etoile || !cardsRow) {
    console.warn("booster, etoile ou cardsRow introuvable dans le DOM.");
    return;
  }

  function revealCards() {
    const cards = cardsRow.querySelectorAll(".card");

    // Position initiale sur le booster
    const boosterRect = booster.getBoundingClientRect();
    const rowRect = cardsRow.getBoundingClientRect();

    cards.forEach((card) => {
      card.style.top =
        boosterRect.top + boosterRect.height / 1.2 - rowRect.top + "px";
      card.style.left =
        boosterRect.left + boosterRect.width / 1.2 - rowRect.left + "px";
      card.style.transform = "translate(-50%, -50%) scale(0.5)";
      card.style.opacity = 0;
      card.style.position = "absolute";
    });

    // Force le reflow
    void cardsRow.offsetWidth;

    // Animation vers la position finale
    cards.forEach((card, i) => {
      setTimeout(() => {
        card.style.transition = "all 0.6s ease";
        card.style.top = "";
        card.style.left = "";
        card.style.transform = "";
        card.style.opacity = "1";
        card.style.position = "relative";
      }, i * 200);
    });
  }

  booster.addEventListener("click", () => {
    openBooster();
    setTimeout(() => {
      revealCards();
    }, 1500); // après que le booster ait disparu
  });

  function openBooster() {
    booster.classList.add("shake-fast");

    let startWidth = booster.offsetWidth;
    let startHeight = booster.offsetHeight;
    let targetWidth = startWidth + 1000;
    let step = 20;
    let opacityStep = 0.03;

    etoile.style.width = startWidth + "px";
    etoile.style.height = startHeight + "px";
    etoile.style.opacity = 1;
    etoile.style.display = "block";

    let currentWidth = startWidth;
    let currentOpacity = 1;

    const interval = setInterval(() => {
      if (currentWidth < targetWidth) {
        currentWidth += step;
        currentOpacity -= opacityStep;

        etoile.style.width = currentWidth + "px";
        etoile.style.height = currentWidth + "px"; // carré pour l'étoile
        booster.style.opacity = currentOpacity;
      } else {
      document.querySelector(".container__index").style.display = "none";
        booster.style.opacity = 0;
        etoile.style.opacity = 0;
        etoile.style.display = "none";
        clearInterval(interval);
      }
    }, 16);
  }
});
