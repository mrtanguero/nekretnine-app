const deleteModal = document.getElementById("deleteModal");
const editModal = document.getElementById("editModal");

deleteModal.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute("data-bs-id");
  const deleteLink = deleteModal.querySelector(".modal-footer a");

  deleteLink.setAttribute("href", `./gradovi.php?obrisi=${id}`);
});

editModal.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute("data-bs-id");
  const ime = button.getAttribute("data-bs-ime");
  const modalInput = editModal.querySelector("#naziv-grada");
  const hiddenInput = editModal.querySelector("#id-grada");

  modalInput.value = ime;
  hiddenInput.value = id;
});
