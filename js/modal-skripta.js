const deleteModal = document.getElementById("deleteModal");
deleteModal.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute("data-bs-id");
  const deleteLink = deleteModal.querySelector(".modal-footer a");

  deleteLink.setAttribute("href", `./obrisi.php?id=${id}`);
});
