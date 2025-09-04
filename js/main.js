document.addEventListener("DOMContentLoaded", () => {

     if (window.location.pathname.includes("index.php")) {
       document.body.style.overflowY = "hidden";
     }

     
  const booster = document.querySelector(".booster");
  const etoile = document.querySelector(".etoile");

  booster.addEventListener("click", () => {
    openBooster();});

    function openBooster() {
      // Accélérer le shake
      booster.classList.add("shake-fast");

      // Préparer l'étoile
      let startWidth = booster.offsetWidth;
      let startHeight = booster.offsetHeight;
      let targetWidth = startWidth + 1000;
      let targetHeight = startHeight + 1000;
      let step = 20; // vitesse de l'agrandissement en px par frame
      let opacityStep = 0.03; // vitesse de disparition du booster

      etoile.style.width = startWidth + "px";
      etoile.style.height = startHeight + "px";
      etoile.style.opacity = 1;
      etoile.style.display = "block"; // s'assurer qu'elle est visible

      let currentWidth = startWidth;
      let currentHeight = startHeight;
      let currentOpacity = 1;

      const interval = setInterval(() => {
        if (currentWidth < targetWidth) {
          currentWidth += step;
          currentHeight += step;
          currentOpacity -= opacityStep;

          etoile.style.width = currentWidth + "px";
          etoile.style.height = currentHeight + "px";
          booster.style.opacity = currentOpacity;
        } else {
          // fin de l'animation
          booster.style.opacity = 0;
          etoile.style.opacity = 0;
          etoile.style.display = "none"; // on la cache complètement
          clearInterval(interval);
        }
      }, 16); // environ 60fps
    }
    
  
});
