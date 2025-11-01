// Script Form Pengaduan
const form = document.getElementById("formPengaduan");

form.addEventListener("submit", function (e) {
  e.preventDefault(); // cegah reload default

  // Cek reCAPTCHA (opsional)
  if (typeof grecaptcha !== "undefined") {
    const response = grecaptcha.getResponse();
    if (!response) {
      alert("⚠️ Mohon verifikasi reCAPTCHA terlebih dahulu.");
      return;
    }
  }

  // Simulasi kirim
  alert("✅ Terima kasih, pengaduan Anda telah dikirim!");

  // Reset form & reCAPTCHA
  this.reset();
  if (typeof grecaptcha !== "undefined") grecaptcha.reset();

  // Tutup modal (fungsi dari modal.js)
  if (typeof closeModalFn === "function") closeModalFn();

  // Redirect ke index.html
  setTimeout(() => {
    window.location.href = "index.html";
  }, 800);
});
