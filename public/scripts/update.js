// Affichage des médias en version mobile
const btnVoirMedias = document.getElementById("btnVoirMedias");
const divImgVideoTrick = document.querySelector(".div-img-video-trick");
if (btnVoirMedias !== null) {
  btnVoirMedias.onclick = () => {
    divImgVideoTrick.classList.replace("d-none", "d-flex");
  };
}

// Affichage des form illustrations lors de l'edit
const edit_form_illustration = document.querySelectorAll(
  ".edit_form_illustration"
);

edit_form_illustration.forEach((element, index) => {
  element.onclick = () => {
    document.querySelectorAll(".div_form_illustrations_update")[
      index
    ].style.display = "block";
  };
});

// Affichage des form videos lors de l'edit
const edit_form_video = document.querySelectorAll(".edit_form_video");

edit_form_video.forEach((element, index) => {
  console.log(index);
  element.onclick = () => {
    document.querySelectorAll(".div_form_videos_update")[index].style.display =
      "block";
  };
});
