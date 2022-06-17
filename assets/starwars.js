const submitForm = document.querySelectorAll(".sw-import");
console.log(submitForm);

//form parameter
submitForm.forEach(function (form) {
  form.addEventListener("submit", submitAjaxForm); //cb function nedan
});
function submitAjaxForm(e) {
  const URL = e.currentTarget.getAttribute("action"); //name i inputs
  const dataFromForm = new FormData(e.target);
  console.log(submitForm);
  fetch(URL, {
    method: "POST",
    body: dataFromForm,
  })
    .then((response) => response.json)
    .then((body) => {
      console.log(body);
    })
    .catch();
}
