document.addEventListener("DOMContentLoaded", () => {
  const booster = document.querySelector(".booster");
  const etoile = document.querySelector(".etoile");
  const form = document.getElementById("boosterForm");
  const btnOuvrir = document.getElementById("btnouvrir");
  const cardsDiv = document.getElementById("cards");

  // Vérification des éléments DOM
  if (!booster || !etoile || !form || !btnOuvrir || !cardsDiv) {
    console.error("Erreur: Éléments DOM manquants pour le booster.");
    return;
  }

  function lancerOuverture(e) {
    if (e) e.preventDefault();
    btnOuvrir.style.display = "none";
    document.body.style.pointerEvents = "none";

    setTimeout(() => {
      document.body.style.pointerEvents = "auto";
    }, 1500);

    openBooster(() => {
      console.log("Début fetch POST en prod/local..."); // Debug
      fetch("", {
        method: "POST",
        body: new FormData(form),
        credentials: "same-origin", // Pour sessions/cookies en prod
      })
        .then((response) => {
          console.log("Réponse status:", response.status); // Debug
          if (!response.ok) {
            throw new Error(
              `Erreur HTTP: ${response.status} ${response.statusText}`
            );
          }
          return response.text();
        })
        .then((html) => {
          console.log("HTML reçu du serveur:", html.substring(0, 200) + "..."); // Debug : Log premiers 200 chars
          // Vérification stricte (fix TypeError)
          if (!html || html.trim() === "" || html.includes("Erreur:")) {
            throw new Error(
              "Réponse invalide du serveur (vide ou erreur PHP). Vérifiez logs serveur."
            );
          }

          cardsDiv.innerHTML = html; // Assignation directe : PAS de querySelector/innerHTML read → Fix erreur
          cardsDiv.style.display = "block";

          // Animation cartes
          const lis = cardsDiv.querySelectorAll("li");
          console.log("Nombre de cartes:", lis.length); // Debug
          if (lis.length === 0) {
            console.warn("Aucune carte dans la réponse.");
            cardsDiv.innerHTML = "<p>Aucune carte tirée. Vérifiez la BDD.</p>";
          } else {
            lis.forEach((li, index) => {
              li.style.opacity = "0";
              li.style.transition = "opacity 0.5s ease";
              setTimeout(() => {
                li.style.opacity = "1";
              }, index * 500);
            });
          }

          // Bouton Fermer
          const btnFermer = cardsDiv.querySelector(".btnfermer");
          if (btnFermer) {
            btnFermer.addEventListener("click", () => {
              cardsDiv.style.display = "none";
              btnOuvrir.style.display = "block";
              booster.style.opacity = "1";
              booster.classList.remove("shake-fast");
              form.style.display = "block";
            });
          }
        })
        .catch((error) => {
          console.error("Erreur fetch/booster:", error.message);
          // Reset UI + message visible
          btnOuvrir.style.display = "block";
          booster.style.opacity = "1";
          booster.classList.remove("shake-fast");
          form.style.display = "block";
          cardsDiv.innerHTML = `<p>Erreur: ${error.message}. Vérifiez connexion/DB.</p>`;
          cardsDiv.style.display = "block";
          setTimeout(() => {
            cardsDiv.style.display = "none";
          }, 5000); // Auto-hide
        });
    });
  }

  // Écouteurs
  booster.addEventListener("click", (e) => lancerOuverture(e));
  btnOuvrir.addEventListener("click", (e) => lancerOuverture(e));
  form.addEventListener("submit", lancerOuverture);

  function openBooster(callback) {
    booster.classList.add("shake-fast");
    let startWidth = booster.offsetWidth;
    let startHeight = booster.offsetHeight;
    let targetWidth = startWidth + 1000;
    let targetHeight = startHeight + 1000;
    let step = 20;
    let opacityStep = 0.03;

    etoile.style.width = startWidth + "px";
    etoile.style.height = startHeight + "px";
    etoile.style.opacity = 1;
    etoile.style.display = "block";

    let currentWidth = startWidth;
    let currentHeight = startHeight;
    let currentOpacity = 1;

    function animate() {
      if (currentWidth < targetWidth) {
        currentWidth += step;
        currentHeight += step;
        currentOpacity -= opacityStep;
        etoile.style.width = currentWidth + "px";
        etoile.style.height = currentHeight + "px";
        booster.style.opacity = currentOpacity;
        requestAnimationFrame(animate);
      } else {
        booster.style.opacity = 0;
        etoile.style.opacity = 0;
        etoile.style.display = "none";
        form.style.display = "none";
        if (callback) callback();
      }
    }
    animate();
  }
});
