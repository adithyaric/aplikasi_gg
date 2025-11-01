// Script Modal
const openModal = document.getElementById("openModal");
  const closeModal = document.getElementById("closeModal");
  const pengaduanModal = document.getElementById("pengaduanModal");
  const modalContent = document.getElementById("modalContent");

  // Buka modal
  openModal.addEventListener("click", () => {
    pengaduanModal.classList.remove("hidden");
    setTimeout(() => {
      modalContent.classList.remove("scale-95", "opacity-0");
      modalContent.classList.add("scale-100", "opacity-100");
    }, 10);
  });

  // Tutup modal
  function closeModalFn() {
    modalContent.classList.remove("scale-100", "opacity-100");
    modalContent.classList.add("scale-95", "opacity-0");
    setTimeout(() => pengaduanModal.classList.add("hidden"), 200);
  }

  closeModal.addEventListener("click", closeModalFn);
  pengaduanModal.addEventListener("click", (e) => {
    if (e.target === pengaduanModal) closeModalFn();
  });
  
// Biar fungsi ini bisa dipakai di form.js
window.closeModalFn = closeModalFn;
  