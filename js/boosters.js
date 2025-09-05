document.addEventListener("DOMContentLoaded", () => {
  if (
    window.location.pathname.includes("boosters.php") &&
    window.matchMedia("(min-width: 768px)").matches
  ) {
    document.body.style.overflowY = "hidden";
  }

  const booster = document.querySelector(".booster");
  const etoile = document.querySelector(".etoile");
  const form = document.getElementById("boosterForm");
  const btnOuvrir = document.getElementById("btnouvrir");
  const cardsDiv = document.getElementById("cards");

  function lancerOuverture(e) {
    e.preventDefault();

    btnOuvrir.style.display = "none"; // cacher le bouton

    openBooster(() => {
      fetch("", { method: "POST", body: new FormData(form) })
        .then(response => response.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");
          const newContent = doc.querySelector("#cards").innerHTML;
          cardsDiv.innerHTML = newContent;
          cardsDiv.style.display = "block";

          // Animation apparition des cartes
          const lis = cardsDiv.querySelectorAll("li");
          lis.forEach((li, index) => {
            li.style.opacity = "0";
            li.style.transition = "opacity 0.5s ease";
            setTimeout(() => { li.style.opacity = "1"; }, index*500);
          });

          // Listener bouton Fermer
          const btnFermer = cardsDiv.querySelector(".btnfermer");
          if (btnFermer) {
            btnFermer.addEventListener("click", () => {
              cardsDiv.style.display = "none";
              btnOuvrir.style.display = "block";
              booster.style.opacity = "1";
              booster.classList.remove("shake-fast"); // reset animation
              form.style.display = "block";
            });
          }
        });
    });
  }

  booster.addEventListener("click", lancerOuverture);
  btnOuvrir.addEventListener("click", lancerOuverture);

  function openBooster(callback) {
    booster.classList.add("shake-fast");
    let startWidth = booster.offsetWidth;
    let startHeight = booster.offsetHeight;
    let targetWidth = startWidth + 1000;
    let targetHeight = startHeight + 1000;
    let step = 20;
    let opacityStep = 0.03;

    etoile.style.width = startWidth+"px";
    etoile.style.height = startHeight+"px";
    etoile.style.opacity = 1;
    etoile.style.display = "block";

    let currentWidth = startWidth;
    let currentHeight = startHeight;
    let currentOpacity = 1;

    const interval = setInterval(() => {
      if (currentWidth < targetWidth) {
        currentWidth += step;
        currentHeight += step;
        currentOpacity -= opacityStep;
        etoile.style.width = currentWidth+"px";
        etoile.style.height = currentHeight+"px";
        booster.style.opacity = currentOpacity;
      } else {
        booster.style.opacity = 0;
        etoile.style.opacity = 0;
        etoile.style.display = "none";
        form.style.display = "none";
        clearInterval(interval);
        if (callback) callback();
      }
    }, 16);
  }

});

