<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BGN Makan Sehat Bergizi</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="{{ asset('homepage/assets/images/logo-polres.png') }}" />
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/style.css') }}" />
    <!-- Base CSS Flatpickr -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />

    <!-- Tema Flatpickr -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css"
    />
  </head>

  <body class="font-sans bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <header
      id="navbar"
      class="fixed top-0 left-0 w-full bg-white shadow-md z-50 transition-all duration-500"
    >
      <div
        class="container mx-auto flex justify-between items-center py-4 px-6"
      >
        <div class="flex items-center space-x-3">
          <img
            src="{{ asset('homepage/assets/images/Polresgesit.png') }}"
            alt="Logo Polres"
            class="h-10"
          />
          <h1 class="text-xl font-bold text-red-700">BGN Makan Sehat Bergizi</h1>
        </div>
        <nav
          class="hidden md:flex space-x-6 font-medium text-gray-700"
          id="text"
        >
          <a href="#beranda" class="hover:text-red-600">Beranda</a>
          <a href="#profil" class="hover:text-red-600">Profil BGN</a>
          <a href="#pelayanan" class="hover:text-red-600">Pelayanan Publik</a>
          <a href="#galeri" class="hover:text-red-600">Galeri</a>
          <a href="#pengaduan" class="hover:text-red-600">Pengaduan</a>
          <a href="#survey" class="hover:text-red-600">Survey SKM</a>
          <a href="#kontak" class="hover:text-red-600">Kontak</a>
        </nav>
        <button class="md:hidden text-gray-700 focus:outline-none">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </div>
    </header>

    <!-- Hero Section -->
    <section
      id="beranda"
      class="gradient-red text-white relative overflow-hidden pt-28 pb-16"
    >
      <div class="shape-bg"></div>

      <div
        class="container mx-auto grid md:grid-cols-2 gap-12 justify-center px-6 relative z-10"
      >
        <!-- Teks -->
        <div class="flex flex-col text-center md:text-left">
          <img
            src="{{ asset('homepage/assets/images/logopolres.png') }}"
            alt=""
            class="logo-polres mb-6"
          />
          <h2 class="text-3xl md:text-5xl font-extrabold mb-3">
            Makan Sehat Bergizi
          </h2>
          <h1 class="text-4xl md:text-6xl font-bold mb-6">
            BGN Makan Sehat Bergizi
          </h1>
          <p class="text-lg md:text-xl mb-6 font-light italic">
            “Pelayanan Cepat, Transparan, dan Humanis”
          </p>
          <div
            class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start"
          >
            <a
              href="{{ route('login') }}"
              class="bg-white text-red-700 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 shadow transition"
            >
              BGN
            </a>
            <a
              href="{{ route('survey.index') }}"
              class="bg-red-800 text-white font-semibold px-6 py-3 rounded-lg hover:bg-red-700 shadow transition"
            >
              Survey Kepuasan Masyarakat (SKM)
            </a>
          </div>
        </div>

        <div class="relative flex flex-col items-center md:items-end">
          <!-- SPIN CONTAINER 1 (lebih kecil, lebih lambat lagi) -->
          <div
            class="absolute right-3 w-56 h-56 bg-white/10 rounded-3xl spin-slower"
          ></div>
          <!-- SPIN CONTAINER 2 (besar, lambat) -->
          <div
            class="absolute rounded-3xl top-0 right-0 w-56 h-56 spin-slow"
          ></div>

          <!-- Gambar Hero -->
          <div class="relative flex flex-col items-center z-10">
            <img
              src="{{ asset('homepage/assets/images/kapolrespacitan.png') }}"
              alt="KaMakan Sehat Bergizi"
              class="hero-img z-10 drop-shadow-2xl"
            />

            <!-- Identitas (sekarang posisinya natural, di atas timer) -->
            <div class="hero-identity mt-6">
              <h3 class="text-gray-900 font-semibold text-lg text-center">
                AKBP Ayub Diponegoro Azhar, S.H., S.I.K., M.I.K.
              </h3>
              <p class="text-gray-700 text-sm italic text-center">
                KaMakan Sehat Bergizi
              </p>
            </div>

            <!-- Timer Countdown -->
            <!-- <div class="timer-box bg-white text-pink-900 rounded-2xl shadow-lg px-6 py-4 flex gap-4 mt-4">
      <div class="text-center">
        <div id="days" class="text-3xl font-bold">74</div>
        <div class="text-xs font-semibold">DAYS</div>
      </div>
      <div class="text-center">
        <div id="hours" class="text-3xl font-bold">12</div>
        <div class="text-xs font-semibold">HOURS</div>
      </div>
      <div class="text-center">
        <div id="minutes" class="text-3xl font-bold">43</div>
        <div class="text-xs font-semibold">MINUTES</div>
      </div>
      <div class="text-center">
        <div id="seconds" class="text-3xl font-bold">14</div>
        <div class="text-xs font-semibold">SECONDS</div>
      </div>
    </div> -->
          </div>
        </div>
      </div>

      <!-- Background logo transparan -->
      <div
        class="absolute inset-0 flex items-center justify-center pointer-events-none"
      >
        <img
          src="{{ asset('homepage/assets/images/Polresgesit.png') }}"
          alt="Logo Polisi"
          class="w-30 opacity-40 select-none filter grayscale"
        />
      </div>

      <!-- Wave -->
      <div
        class="absolute bottom-0 z-20 left-0 w-full overflow-hidden leading-[0] rotate-180"
      >
        <svg
          class="relative block w-[calc(100%+1.3px)] h-[80px]"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 1200 120"
          preserveAspectRatio="none"
        >
          <path
            fill="white"
            d="M321.39,56.44C208.55,82.56,99.26,92.79,0,84.81V120H1200V16.48c-90.79,22.19-191.74,35.44-303.39,39.6C691.75,63.35,511.25,32.11,321.39,56.44Z"
            class="fill-white"
          ></path>
        </svg>
      </div>
    </section>

    <!-- Profil Singkat -->
    <section id="profil" class="py-16 bg-white">
      <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-red-700 mb-6">
          Profil BGN Makan Sehat Bergizi
        </h2>
        <p class="max-w-2xl mx-auto text-gray-600 leading-relaxed">
          Sentra Pelayanan Kepolisian Terpadu (BGN) Makan Sehat Bergizi berkomitmen
          memberikan pelayanan prima kepada masyarakat dengan mengutamakan
          kecepatan, keterbukaan informasi, dan kenyamanan bagi seluruh warga.
        </p>
      </div>
    </section>

    <!-- Profil BGN -->
    <section id="profil" class="py-16 bg-gray-50">
      <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-red-900 mb-10">
          Profil BGN
        </h2>
        <div class="grid md:grid-cols-2 gap-10">
          <div>
            <h3 class="text-2xl font-semibold mb-3 text-red-700">Visi</h3>
            <ul class="list-disc list-inside">
              <li>Menjadi pusat pelayanan kepolisian terpadu yang prima.</li>
              <li>
                Menyelenggarakan pelayanan cepat, mudah, transparan, bersih, dan
                tanpa diskriminatif.
              </li>
            </ul>
            <h3 class="text-2xl font-semibold mt-6 mb-3 text-red-700">Misi</h3>
            <ul class="list-disc list-inside">
              <li>Melayani secara profesional dan humanis.</li>
              <li>Meningkatkan efisiensi penanganan laporan.</li>
              <li>Menyajikan informasi akuntabel dan cepat.</li>
              <li>Memberikan bantuan dan pertolongan di TKP.</li>
              <li>Melaksanakan nilai senyum, sapa, salam, dan tanggap.</li>
            </ul>
          </div>
          <div>
            <h3 class="text-2xl font-semibold mb-3 text-red-700">
              Tugas dan Fungsi
            </h3>
            <ul class="list-disc list-inside">
              <li>
                Memberikan pelayanan kepolisian terpadu kepada masyarakat.
              </li>
              <li>Menerima laporan dan pengaduan.</li>
              <li>Memberikan bantuan dan pertolongan.</li>
              <li>Menyajikan informasi kepolisian.</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Pelayanan Publik -->
    <section id="pelayanan" class="py-16">
      <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-red-900 mb-10">
          Pelayanan Publik
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div
            class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition"
          >
            <h4 class="font-bold text-red-800 mb-2">Pelayanan SIM</h4>
            <p>
              Informasi lengkap seputar pembuatan, perpanjangan, dan persyaratan
              SIM.
            </p>
          </div>
          <div
            class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition"
          >
            <h4 class="font-bold text-red-800 mb-2">Pelayanan STNK</h4>
            <p>
              Panduan dan persyaratan administrasi untuk pengurusan STNK
              kendaraan bermotor.
            </p>
          </div>
          <div
            class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition"
          >
            <h4 class="font-bold text-red-800 mb-2">Pelayanan BPKB</h4>
            <p>
              Prosedur penerbitan dan penggantian Buku Kepemilikan Kendaraan
              Bermotor (BPKB).
            </p>
          </div>
          <div
            class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition"
          >
            <h4 class="font-bold text-red-800 mb-2">Pelayanan SKCK</h4>
            <p>
              Permohonan SKCK online melalui
              <a
                href="https://skck.polri.go.id/"
                target="_blank"
                class="text-red-500 underline"
                >skck.polri.go.id</a
              >
            </p>
          </div>
          <div
            class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition"
          >
            <h4 class="font-bold text-red-800 mb-2">Ilmu Semeru</h4>
            <p>
              <a
                href="https://ilmusemeru.id/beranda"
                target="_blank"
                class="text-red-500 underline"
                >Aplikasi Ilmu Semeru</a
              >
              untuk pelaporan kendaraan.
            </p>
          </div>
          <div
            class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition"
          >
            <h4 class="font-bold text-red-800 mb-2">Konfirmasi ETLE</h4>
            <p>
              Konfirmasi pelanggaran lalu lintas di
              <a
                href="https://konfirmasi-etle.polri.go.id/"
                target="_blank"
                class="text-red-500 underline"
                >ETLE Polri</a
              >.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Galeri -->
    <section id="galeri" class="py-16 bg-gray-50">
      <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-red-900 mb-10">
          Galeri Kegiatan
        </h2>
        <div class="grid md:grid-cols-3 gap-6">
          <img
            src="{{ asset('homepage/assets/images/kegiatan1.jpeg') }}"
            alt="Kegiatan 1"
            class="rounded-lg shadow"
          />
          <img
            src="{{ asset('homepage/assets/images/kegiatan3.jpg') }}"
            alt="Kegiatan 3"
            class="rounded-lg shadow"
          />
          <img
            src="{{ asset('homepage/assets/images/kegiatan2.jpeg') }}"
            alt="Kegiatan 2"
            class="rounded-lg shadow"
          />
          <img
            src="{{ asset('homepage/assets/images/kegiatan2.jpeg') }}"
            alt="Kegiatan 2"
            class="rounded-lg shadow"
          />
          <img
            src="{{ asset('homepage/assets/images/kegiatan3.jpg') }}"
            alt="Kegiatan 3"
            class="rounded-lg shadow"
          />
          <img
            src="{{ asset('homepage/assets/images/kegiatan1.jpeg') }}"
            alt="Kegiatan 1"
            class="rounded-lg shadow"
          />
        </div>
      </div>
    </section>

    <!-- Pengaduan -->
    <section id="pengaduan" class="py-16">
      <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-red-900 mb-6">
          Pengaduan Masyarakat
        </h2>

        <!-- Grid 3 Kolom -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
          <!-- Kartu 1 -->
          <div
            class="border border-gray-200 bg-white p-5 rounded-2xl shadow-sm relative hover:shadow-xl transition-all duration-300"
          >
            <div class="text-xs absolute top-2 right-3 text-gray-400">
              3 bulan yang lalu
            </div>
            <div class="flex items-start">
              <div
                class="flex-none bg-red-800 text-white w-10 h-10 flex items-center justify-center rounded-full font-semibold shadow-md"
              >
                W
              </div>
              <div class="pl-4 text-left w-full">
                <div class="text-sm font-semibold text-red-900">
                  Winda Oktaviani
                </div>
                <div class="text-xs text-gray-600 mt-1 leading-snug">
                  Apakah bisa cek status tilang online?
                </div>
                <div class="text-xs text-primary text-right pt-2 font-semibold">
                  <button
                    class="toggle-reply text-red-800 hover:text-red-900 transition-colors"
                  >
                    Lihat Balasan
                  </button>
                </div>

                <!-- Bubble Balasan -->
                <div
                  class="reply mt-4 overflow-hidden transition-all duration-500 ease-in-out"
                >
                  <div
                    class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-xs text-gray-700"
                  >
                    <div class="flex items-start">
                      <div
                        class="flex-none bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full font-semibold shadow-sm text-[10px]"
                      >
                        P
                      </div>
                      <div class="ml-2 text-left">
                        <span class="font-semibold text-blue-700 text-xs"
                          >Petugas Lantas</span
                        >
                        <p class="mt-1 text-gray-600">
                          Halo Kak Winda, pengecekan status tilang dapat
                          dilakukan melalui website resmi
                          <a href="#" class="text-blue-700 hover:text-blue-900"
                            >https://etilang.info</a
                          >.
                        </p>
                        <div class="text-[10px] text-gray-400 mt-1 text-right">
                          3 bulan yang lalu
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Kartu 2 -->
          <div
            class="border border-gray-200 bg-white p-5 rounded-2xl shadow-sm relative hover:shadow-xl transition-all duration-300"
          >
            <div class="text-xs absolute top-2 right-3 text-gray-400">
              2 bulan yang lalu
            </div>
            <div class="flex items-start">
              <div
                class="flex-none bg-red-800 text-white w-10 h-10 flex items-center justify-center rounded-full font-semibold shadow-md"
              >
                A
              </div>
              <div class="pl-4 text-left w-full">
                <div class="text-sm font-semibold text-red-900">
                  Ahmad Rizqi
                </div>
                <div class="text-xs text-gray-600 mt-1 leading-snug">
                  Apakah SIM yang telat sehari masih bisa diperpanjang?
                </div>
                <div class="text-xs text-primary text-right pt-2 font-semibold">
                  <button
                    class="toggle-reply text-red-800 hover:text-red-900 transition-colors"
                  >
                    Lihat Balasan
                  </button>
                </div>

                <div
                  class="reply mt-4 overflow-hidden transition-all duration-500 ease-in-out"
                >
                  <div
                    class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-xs text-gray-700"
                  >
                    <div class="flex items-start">
                      <div
                        class="flex-none bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full font-semibold shadow-sm text-[10px]"
                      >
                        P
                      </div>
                      <div class="ml-2 text-left">
                        <span class="font-semibold text-blue-700 text-xs"
                          >Petugas Lantas</span
                        >
                        <p class="mt-1 text-gray-600">
                          Halo Kak Ahmad, jika telat hanya 1 hari tetap bisa
                          diperpanjang di Satpas terdekat tanpa harus membuat
                          baru.
                        </p>
                        <div class="text-[10px] text-gray-400 mt-1 text-right">
                          2 bulan yang lalu
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Kartu 3 -->
          <div
            class="border border-gray-200 bg-white p-5 rounded-2xl shadow-sm relative hover:shadow-xl transition-all duration-300"
          >
            <div class="text-xs absolute top-2 right-3 text-gray-400">
              1 bulan yang lalu
            </div>
            <div class="flex items-start">
              <div
                class="flex-none bg-red-800 text-white w-10 h-10 flex items-center justify-center rounded-full font-semibold shadow-md"
              >
                A
              </div>
              <div class="pl-4 text-left w-full">
                <div class="text-sm font-semibold text-red-900">
                  Adi Subagja
                </div>
                <div class="text-xs text-gray-600 mt-1 leading-snug">
                  Salut untuk upaya Ditlantas Polda Jatim dalam menjaga
                  ketertiban dan keamanan lalu lintas!
                </div>
                <div class="text-xs text-primary text-right pt-2 font-semibold">
                  <button
                    class="toggle-reply text-red-800 hover:text-red-900 transition-colors"
                  >
                    Lihat Balasan
                  </button>
                </div>

                <div
                  class="reply mt-4 overflow-hidden transition-all duration-500 ease-in-out"
                >
                  <div
                    class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-xs text-gray-700"
                  >
                    <div class="flex items-start">
                      <div
                        class="flex-none bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full font-semibold shadow-sm text-[10px]"
                      >
                        P
                      </div>
                      <div class="ml-2 text-left">
                        <span class="font-semibold text-blue-700 text-xs"
                          >Petugas Lantas</span
                        >
                        <p class="mt-1 text-gray-600">
                          Terima kasih atas apresiasinya, Kak Adi 🙏 Kami akan
                          terus berusaha memberikan pelayanan terbaik untuk
                          masyarakat.
                        </p>
                        <div class="text-[10px] text-gray-400 mt-1 text-right">
                          1 bulan yang lalu
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <p class="max-w-2xl mx-auto mb-6">
          Sampaikan pertanyaan, keluhan, atau pengaduan Anda terkait pelayanan
          kepolisian melalui formulir berikut.
        </p>

        <!-- Tombol untuk membuka modal -->
        <button
          id="openModal"
          class="bg-red-900 text-white px-6 py-3 rounded-lg hover:bg-red-800 transition-all shadow-md"
        >
          Kirim Pengaduan
        </button>
      </div>
    </section>

    <!-- Modal Pengaduan -->
    <div
      id="pengaduanModal"
      class="fixed inset-0 flex items-center justify-center z-50 hidden transition-all duration-300"
      style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px)"
    >
      <!-- Animasi modal -->
      <div
        class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto p-6 relative transform scale-95 opacity-0 transition-all duration-300"
        id="modalContent"
      >
        <!-- Tombol Close -->
        <button
          id="closeModal"
          class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold transition"
        >
          &times;
        </button>

        <h3 class="text-xl font-bold text-red-900 mb-4 text-center">
          Form Pengaduan
        </h3>

        <form>
          <input
            type="text"
            placeholder="Nama"
            class="w-full border rounded p-2 mb-3"
            required
          />
          <input
            type="email"
            placeholder="Email"
            class="w-full border rounded p-2 mb-3"
            required
          />
          <textarea
            placeholder="Pesan atau Pengaduan"
            rows="4"
            class="w-full border rounded p-2 mb-4"
          ></textarea>
          <!-- Google reCAPTCHA -->
          <div class="g-recaptcha mb-4" data-sitekey="ISI_SITE_KEY_KAMU"></div>
          <button
            type="submit"
            class="bg-red-900 text-white px-6 py-2 rounded-lg w-full hover:bg-red-800 transition-all"
          >
            Kirim Sekarang
          </button>
        </form>
      </div>
    </div>

    <!-- Survey SKM -->
    <section id="survey" class="py-16 bg-gray-50 text-center">
      <div class="w-full px-6 md:px-12">
        <h2 class="text-3xl font-bold text-red-900 mb-6">
          Survey Kepuasan Masyarakat
        </h2>
        <!-- ====== CARD SURVEI ====== -->
        <div
          class="bg-white shadow-xl rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-12 w-full mb-6"
        >
          <!-- === Kolom Kiri: Progress Bar === -->
          <div class="flex flex-col items-center border-r border-gray-200">
            <img
              src="{{ asset('homepage/assets/images/logopolres.png') }}"
              alt="Logo"
              class="logo-SKM mb-4"
            />
            <h3 class="font-semibold text-gray-700 mb-2 text-center">
              Indeks Kepuasan Masyarakat
            </h3>
            <p class="text-red-900 font-bold mb-6 text-center">
              BGN Makan Sehat Bergizi
            </p>

            <div class="w-full max-w-sm space-y-4">
              <div>
                <p class="text-sm text-gray-600 mb-1 text-left">
                  BPKB BGN
                </p>
                <div class="w-full bg-gray-200 rounded-full h-3">
                  <div
                    class="bg-gradient-to-r from-sky-400 to-blue-500 h-3 rounded-full w-[85%]"
                  ></div>
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-600 mb-1 text-left">
                  STNK BGN
                </p>
                <div class="w-full bg-gray-200 rounded-full h-3">
                  <div
                    class="bg-gradient-to-r from-sky-400 to-blue-500 h-3 rounded-full w-[78%]"
                  ></div>
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-600 mb-1 text-left">
                  SKUKP SIM BGN
                </p>
                <div class="w-full bg-gray-200 rounded-full h-3">
                  <div
                    class="bg-gradient-to-r from-sky-400 to-blue-500 h-3 rounded-full w-[90%]"
                  ></div>
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-600 mb-1 text-left">
                  BGN
                </p>
                <div class="w-full bg-gray-200 rounded-full h-3">
                  <div
                    class="bg-gradient-to-r from-sky-400 to-blue-500 h-3 rounded-full w-[82%]"
                  ></div>
                </div>
              </div>
            </div>
          </div>

          <!-- === Kolom Kanan: Nilai & Komentar === -->
          <div>
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-gray-800">Makan Sehat Bergizi</h3>
              <div class="flex items-center gap-2">
                <!-- Filter Rentang Periode -->
                <div
                  class="col d-flex flex-wrap align-items-end gap-2 border rounded-3xl"
                >
                  <div class="col-auto">
                    <input
                      type="text"
                      id="dateRange"
                      class="form-control form-control-sm w-52 md:w-64 lg:w-60 text-sm text-center"
                      placeholder="Pilih rentang tanggal"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- Nilai IKM -->
            <div class="grid grid-cols-3 gap-3 mb-6 text-center">
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm">Kategori Nilai</p>
                <p class="text-2xl font-bold text-red-600">A</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm">Nilai IKM</p>
                <p class="text-2xl font-bold text-gray-800">95.56</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm">Responden</p>
                <p class="text-2xl font-bold text-gray-800">2384</p>
              </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="flex justify-around items-center mb-6 border-b pb-4">
              <div class="text-center">
                <p class="text-sm text-gray-500">LAKI-LAKI</p>
                <p class="text-xl font-bold text-orange-500">1255</p>
              </div>
              <div class="h-8 w-[1px] bg-gray-300"></div>
              <div class="text-center">
                <p class="text-sm text-gray-500">PEREMPUAN</p>
                <p class="text-xl font-bold text-orange-500">1129</p>
              </div>
            </div>

            <!-- Komentar -->
            <div class="space-y-3 max-h-56 overflow-y-auto pr-1">
              <div class="flex items-start gap-3 bg-orange-50 p-3 rounded-lg">
                <div
                  class="bg-blue-600 text-white font-bold w-8 h-8 flex items-center justify-center rounded-full"
                >
                  A
                </div>
                <p class="text-sm text-gray-700 text-left">
                  <span class="font-semibold">Annisa</span> — Sudah bagus
                  pelayanannya, cepat tanpa ribet, jika ada pertanyaan langsung
                  bertanya kepada petugas.
                </p>
              </div>
              <div class="flex items-start gap-3 bg-orange-50 p-3 rounded-lg">
                <div
                  class="bg-blue-600 text-white font-bold w-8 h-8 flex items-center justify-center rounded-full"
                >
                  T
                </div>
                <p class="text-sm text-gray-700 text-left">
                  <span class="font-semibold">Tri</span> — Pelayanan sangat
                  membantu, ada arahan dan bisa mudah dipahami.
                </p>
              </div>
              <div class="flex items-start gap-3 bg-orange-50 p-3 rounded-lg">
                <div
                  class="bg-blue-600 text-white font-bold w-8 h-8 flex items-center justify-center rounded-full"
                >
                  M
                </div>
                <p class="text-sm text-gray-700 text-left">
                  <span class="font-semibold">Moh Rosyid</span> — Pelayanan
                  sangat ramah, Samsat paling cepat untuk mutasi keluar top
                  markotop.
                </p>
              </div>
            </div>
          </div>
        </div>
        <p class="max-w-2xl mx-auto mb-8">
          Kami berkomitmen memberikan pelayanan terbaik. Mohon isi survei untuk
          peningkatan kualitas pelayanan kami.
        </p>
        <a
          href="{{ route('survey.index') }}"
          class="bg-yellow-400 text-red-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300"
          >Isi Survey SKM</a
        >
      </div>
    </section>

    <!-- Kontak -->
    <footer id="kontak" class="gradient-red text-white py-10">
      <div class="container mx-auto text-center">
        <h3 class="text-2xl font-bold mb-3">Hubungi Kami</h3>
        <p>Call Center: <strong>110</strong></p>
        <p>Alamat: Jl. Jend. A. Yani No.60, Krajan, Pacitan, Jawa Timur</p>
        <p class="mt-4 text-sm">
          © 2025 BGN Makan Sehat Bergizi. All Rights Reserved.
        </p>
      </div>
    </footer>

    <!-- Tombol WhatsApp -->
    <a
      href="https://wa.me/6281234567890"
      class="floating-wa"
      target="_blank"
      aria-label="Hubungi via WhatsApp"
    >
      <img
        src="https://cdn-icons-png.flaticon.com/512/733/733585.png"
        alt="WhatsApp"
        class="w-10 h-10"
      />
    </a>

    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Load Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- timer -->
    <script src="{{ asset('homepage/assets/js/timer.js') }}"></script>
    <!-- header sticky -->
    <script src="{{ asset('homepage/assets/js/header.js') }}"></script>
    <!-- tanggal -->
    <script src="{{ asset('homepage/assets/js/date.js') }}"></script>
    <!-- modal pengaduan -->
    <script src="{{ asset('homepage/assets/js/modalpengaduan.js') }}"></script>
    <!-- form pengaduan -->
    <script src="{{ asset('homepage/assets/js/formpengaduan.js') }}"></script>
    <!-- balas pengaduan -->
    <script src="{{ asset('homepage/assets/js/balaspengaduan.js') }}"></script>

  </body>
</html>
