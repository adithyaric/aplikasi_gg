// Ambil tanggal awal tahun & hari ini
const today = new Date();
const startOfYear = new Date(today.getFullYear(), 0, 1);

// Inisialisasi Flatpickr
const datePicker = flatpickr("#dateRange", {
  mode: "range",
  dateFormat: "d/m/Y",
  locale: "id",
  altInput: true,
  altFormat: "j F Y",
  allowInput: true,
  defaultDate: [startOfYear, today], // default rentang
  onClose: function (selectedDates, dateStr, instance) {
    if (selectedDates.length === 2) {
      // Saat user selesai pilih 2 tanggal
      filterData(dateStr);
    }
  },
});

// Contoh fungsi filter
function filterData(rentang) {
  console.log("Rentang tanggal dipilih:", rentang);
  // TODO: ganti dengan aksi filter yang kamu mau
  // Contoh:
  // loadDataByDate(rentang);
}
