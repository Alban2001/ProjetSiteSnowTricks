// Permet de récupérer le nom du trick pour le convertir en slug afin de gérer le message d'erreur (unicité nom du trick)
document.getElementById("trick_nom").oninput = () => {
  document.getElementById("trick_slug").value = document
    .getElementById("trick_nom")
    .value.toLowerCase()
    .replace(" ", "-")
    .trim();
};
