const deleteModal = document.getElementById("deleteModal");
const searchForm = document.getElementById("search-forma");
const clearSearchBtn = document.getElementById("clear-search-button");

deleteModal.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute("data-bs-id");
  const deleteLink = deleteModal.querySelector(".modal-footer a");

  deleteLink.setAttribute("href", `./obrisi.php?id=${id}`);
});

clearSearchBtn.addEventListener("click", () => {
  searchForm.reset();
  searchForm.submit();
});
