//Affichage des médias en version mobile
const btnVoirMedias = document.getElementById("btnVoirMedias");
const divImgVideoTrick = document.querySelector(".div-img-video-trick");
if (btnVoirMedias !== null) {
  btnVoirMedias.onclick = () => {
    divImgVideoTrick.classList.replace("d-none", "d-flex");
  };
}
