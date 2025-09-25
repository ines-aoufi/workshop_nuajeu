document.addEventListener("DOMContentLoaded", function () {
  Fancybox.bind("[data-fancybox='gallery']", {
    dragToClose: true,
    closeButton: "top",
    animated: true,
    showClass: "fancybox-fadeIn",
    hideClass: "fancybox-fadeOut",
    backdropClick: true,
    Thumbs: false,
    Toolbar: {
      display: [
        "close",
      ],
    },
  });
});
