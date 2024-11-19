const inputElement = document.querySelector('input[type="file"]');
inputElement.addEventListener("change", (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = () => {
    let imgElement = document.getElementById("img");
    imgElement.src = reader.result;
    // document.body.appendChild(imgElement);
  };
});
document.querySelector(".downloadbut").addEventListener("click", () => {
  inputElement.click();
});

const button = document.querySelector("#chpasstrue");
const blocks = document.querySelectorAll(".chpass");

blocks.forEach((block) => block.classList.add("inactive"));

let isActive = false;
button.addEventListener("click", function () {
  isActive = !isActive;
  blocks.forEach((block) => {
    if (isActive) {
      block.classList.remove("inactive");
    } else {
      block.classList.add("inactive");
    }
  });
});
