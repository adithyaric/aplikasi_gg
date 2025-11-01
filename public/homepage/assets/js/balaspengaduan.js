document.querySelectorAll(".toggle-reply").forEach((button) => {
  button.addEventListener("click", () => {
    const card = button.closest(".border");
    const reply = card.querySelector(".reply");

    // Jika sedang tertutup, hitung tinggi kontennya dulu
    if (!reply.classList.contains("open")) {
      reply.classList.add("open");
      reply.style.maxHeight = reply.scrollHeight + "px";
      button.textContent = "Tutup Balasan";
    } else {
      // Tutup balasan
      reply.style.maxHeight = reply.scrollHeight + "px"; // fix transisi ke 0
      setTimeout(() => {
        reply.style.maxHeight = "0px";
        reply.classList.remove("open");
      }, 10);
      button.textContent = "Lihat Balasan";
    }
  });
});
