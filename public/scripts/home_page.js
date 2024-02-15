document.querySelectorAll(".btnDeleteTrick").forEach((element, index) => {
  element.onclick = () => {
    document.getElementById("pDeleteTrick").innerHTML =
      document.querySelectorAll(".nomTrick")[index].innerHTML;
    console.log(
      document
        .querySelectorAll(".nomTrick")
        [index].innerHTML.toLowerCase()
        .replace(" ", "-")
    );
  };
});
