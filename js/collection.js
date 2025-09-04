Fancybox.bind("[data-fancybox='gallery']", {
  dragToClose: true, // Permet de fermer en tirant ou en cliquant à l'extérieur
  closeButton: "top", // Ajoute une croix en haut à droite
  animated: true,
  showClass: "fancybox-fadeIn",
  hideClass: "fancybox-fadeOut",
  backdropClick: true, // Clique sur le fond pour fermer
  Thumbs: false, // Pas de miniatures
  Toolbar: {
    display: [
      "close", // Affiche uniquement la croix de fermeture
    ],
  },
});
