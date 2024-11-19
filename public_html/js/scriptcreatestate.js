let lastFocusedElement;
document.addEventListener("focusout", function (event) {
  lastFocusedElement = event.target;
});

//window.localStorage.setItem("imgcount", "0");
//window.localStorage.setItem("pcount", "0");
//const name = window.localStorage.getItem('name')

let textareas = document.querySelectorAll("textarea");
updateTextarea();

let inputElement = document.querySelector('input[type="file"]');
inputElement.addEventListener("change", (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = () => {
    let imgElement = document.getElementById("foto");
    imgElement.src = reader.result;
  };
});
document.querySelector(".downloadbut").addEventListener("click", () => {
  inputElement.click();
});

document.getElementById("insertpbefore").addEventListener("click", () => {
  const newDiv = document.createElement("div");
  newDiv.classList.add("statecreateblock");
  newDiv.innerHTML = `<textarea name="area[]" class="aaa"  placeholder="Введите данные"></textarea>`;
  if (lastFocusedElement != null && lastFocusedElement.classList.contains("aaa")) {
    lastFocusedElement.parentNode.parentNode.insertBefore(newDiv, lastFocusedElement.parentNode);
    updateTextarea();
  }
});

document.getElementById("insertpafter").addEventListener("click", () => {
  const newDiv = document.createElement("div");
  newDiv.classList.add("statecreateblock");
  newDiv.innerHTML = `<textarea name="area[]" class="aaa"  placeholder="Введите данные"></textarea>`;
  if (lastFocusedElement != null && lastFocusedElement.classList.contains("aaa")) {
    lastFocusedElement.parentNode.parentNode.insertBefore(newDiv, lastFocusedElement.parentNode.nextSibling);
    updateTextarea();
  }
});

document.getElementById("insertpstart").addEventListener("click", () => {
  const newDiv = document.createElement("div");
  newDiv.classList.add("statecreateblock");
  newDiv.innerHTML = `<textarea name="area[]" class="aaa"  placeholder="Введите данные"></textarea>`;
  const d = document.getElementById("startmark");
  d.parentNode.insertBefore(newDiv, d.nextSibling);
  updateTextarea();
});

document.getElementById("insertpend").addEventListener("click", () => {
  const newDiv = document.createElement("div");
  newDiv.classList.add("statecreateblock");
  newDiv.innerHTML = `<textarea name="area[]" class="aaa"   placeholder="Введите данные"></textarea>`;
  const d = document.getElementById("endmark");
  d.parentNode.insertBefore(newDiv, d);
  updateTextarea();
});
// document.getElementById("insertpend").addEventListener("click", () => {
//   const newDiv = document.createElement("div");
//   newDiv.classList.add("statecreateblock");
//   newDiv.innerHTML = `<textarea name="area" class="aaa"   placeholder="Введите данные"></textarea>`;
//   const d = document.getElementById("endmark");
//   d.parentNode.insertBefore(newDiv, d);
//   updateTextarea();
// });

document.getElementById("deletep").addEventListener("click", () => {
  if (lastFocusedElement != null && lastFocusedElement.classList.contains("aaa")) {
    lastFocusedElement.parentNode.parentNode.removeChild(lastFocusedElement.parentNode);
  }
});

let insertimgbefore = document.getElementById("insertimgbefore");
let insertimgafter = document.getElementById("insertimgafter");

function updateTextarea() {
  textareas = document.querySelectorAll("textarea");
  textareas.forEach((textarea) => {
    textarea.addEventListener("input", (event) => {
      event.target.style.height = "auto";
      event.target.style.height = event.target.scrollHeight + 6 + "px";
    });
    textarea.addEventListener("paste", (event) => {
      event.target.style.height = "auto";
      event.target.style.height = event.target.scrollHeight + 6 + "px";
    });
  });
}
textareas.forEach((elem) => {
  elem.style.height = "auto";
  elem.style.height = elem.scrollHeight + 6 + "px";
});

let tegs = document.querySelectorAll(".statecreate_tegitem label");
tegs.forEach((elem) => {
  elem.addEventListener("click", () => {
    elem.parentNode.classList.toggle("currenttteg");
  });
});
