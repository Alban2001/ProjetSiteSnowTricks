// Permet quand le modal s'ouvre d'afficher le nom du trick dans le message de suppression
document.querySelectorAll(".btnDeleteTrick").forEach((element, index) => {
  element.onclick = () => {
    document.getElementById("pDeleteTrick").innerHTML =
      document.querySelectorAll(".nomTrick")[index].innerHTML;
  };
});
