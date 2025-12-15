(function (jQuery) {
  "use strict";
if (document.querySelectorAll('#myChart').length) {
  const options = {
    series: [55, 75],
    chart: {
    height: 230,
    type: 'radialBar',
  },
  colors: ["#4bc7d2", "#3a57e8"],
  plotOptions: {
    radialBar: {
      hollow: {
          margin: 10,
          size: "50%",
      },
      track: {
          margin: 10,
          strokeWidth: '50%',
      },
      dataLabels: {
          show: false,
      }
    }
  },
  labels: ['Apples', 'Oranges'],
  };
  if(ApexCharts !== undefined) {
    const chart = new ApexCharts(document.querySelector("#myChart"), options);
    chart.render();
    document.addEventListener('ColorChange', (e) => {
        const newOpt = {colors: [e.detail.detail2, e.detail.detail1],}
        chart.updateOptions(newOpt)

    })
  }
}
if (document.querySelectorAll('#d-activity').length) {
  const options = {
    series: [
      {
        name: 'Anggaran',
        data: [30, 50, 35, 60, 40, 60, 60, 30, 50, 35] // dalam juta rupiah
      },
      {
        name: 'Realisasi',
        data: [40, 50, 55, 50, 30, 80, 30, 40, 50, 55] // dalam juta rupiah
      }
    ],
    chart: {
      type: 'bar',
      height: 230,
      stacked: true,
      toolbar: { show: false }
    },
    colors: ['#3a57e8', '#4bc7d2'],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '28%',
        endingShape: 'rounded',
        borderRadius: 5
      }
    },
    legend: { show: false },
    dataLabels: { enabled: false },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: ['S', 'M', 'T', 'W', 'T', 'F', 'S', 'M', 'T', 'W'],
      labels: {
        minHeight: 20,
        maxHeight: 20,
        style: {
          colors: '#8A92A6'
        }
      }
    },
    yaxis: {
      title: { text: 'Rupiah (Juta)' },
      labels: {
        minWidth: 19,
        maxWidth: 19,
        style: {
          colors: '#8A92A6'
        },
        formatter: function (val) {
          return val + ' jt';
        }
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return 'Rp ' + val.toLocaleString('id-ID') + '.000.000';
        }
      }
    }
  };

  const chart = new ApexCharts(document.querySelector('#d-activity'), options);
  chart.render();

  // 🔄 Update warna jika tema berubah
  document.addEventListener('ColorChange', (e) => {
    const newOpt = { colors: [e.detail.detail1, e.detail.detail2] };
    chart.updateOptions(newOpt);
  });
}

if (document.querySelectorAll('#d-main').length) {
  const options = {
    series: [
      {
        name: 'Pemasukan',
        data: [400, 420, 460, 470, 490, 500, 560] // dalam juta
      },
      {
        name: 'Pengeluaran',
        data: [100, 110, 120, 120, 140, 160, 185] // dalam juta
      }
    ],
    chart: {
      fontFamily:
        '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
      height: 245,
      type: 'area',
      toolbar: {
        show: false
      },
      sparkline: {
        enabled: false
      }
    },
    colors: ['#3a57e8', '#4bc7d2'], // Biru untuk pemasukan, hijau muda untuk pengeluaran
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 3
    },
    yaxis: {
      title: {
        text: 'Rupiah (Juta)'
      },
      min: 0,
      max: 600,
      labels: {
        show: true,
        style: {
          colors: '#8A92A6'
        },
        formatter: function (val) {
          return val + ' jt';
        }
      }
    },
    legend: {
      show: true,
      position: 'top',
      horizontalAlign: 'left',
      markers: {
        radius: 12
      }
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
      labels: {
        show: true,
        style: {
          colors: '#8A92A6'
        }
      },
      axisTicks: {
        show: false
      },
      axisBorder: {
        show: false
      }
    },
    grid: {
      show: true,
      borderColor: '#f1f1f1'
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        type: 'vertical',
        opacityFrom: 0.4,
        opacityTo: 0.1,
        stops: [0, 50, 80]
      }
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return 'Rp ' + val.toLocaleString('id-ID') + '.000';
        }
      }
    }
  };

  const chart = new ApexCharts(document.querySelector('#d-main'), options);
  chart.render();

  // 🔄 Auto-update warna jika ada event tema
  document.addEventListener('ColorChange', (e) => {
    const newOpt = {
      colors: [e.detail.detail1, e.detail.detail2],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'vertical',
          gradientToColors: [e.detail.detail1, e.detail.detail2],
          opacityFrom: 0.4,
          opacityTo: 0.1,
          stops: [0, 50, 60]
        }
      }
    };
    chart.updateOptions(newOpt);
  });
}

if (document.querySelectorAll('#d-main2').length) {
  const options = {
    series: [
      {
        name: 'Distribusi',
        data: [552, 552, 552, 552, 3134, 3134, 3134, 3134, 3134, 3134, 3134, 3134, 3134, 3134]
      }
    ],
    chart: {
      fontFamily:
        '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
      height: 245,
      type: 'line',
      toolbar: {
        show: false
      },
      sparkline: {
        enabled: false
      }
    },
    colors: ['#ff4d4f'], // merah
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 3
    },
    yaxis: {
      title: {
        text: 'Porsi'
      },
      min: 0,
      labels: {
        show: true,
        style: {
          colors: '#8A92A6'
        },
        formatter: function (val) {
          return val + ' porsi';
        }
      }
    },
    legend: {
      show: true,
      position: 'top',
      horizontalAlign: 'left',
      markers: {
        radius: 12
      }
    },
    xaxis: {
      categories: [
        '17 Mar', '18 Mar', '19 Mar', '20 Mar',
        '14 Apr', '15 Apr', '16 Apr', '17 Apr', '18 Apr',
        '21 Apr', '22 Apr', '23 Apr', '24 Apr', '25 Apr'
      ],
      labels: {
        show: true,
        style: {
          colors: '#8A92A6'
        }
      },
      axisTicks: {
        show: false
      },
      axisBorder: {
        show: false
      }
    },
    grid: {
      show: true,
      borderColor: '#f1f1f1'
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val + ' porsi';
        }
      }
    }
  };

  const chart = new ApexCharts(document.querySelector('#d-main2'), options);
  chart.render();

  // 🔄 Auto-update warna jika tema berubah
  document.addEventListener('ColorChange', (e) => {
    const newOpt = {
      colors: [e.detail.detail1],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'vertical',
          gradientToColors: [e.detail.detail1],
          opacityFrom: 0.4,
          opacityTo: 0.1,
          stops: [0, 50, 60]
        }
      }
    };
    chart.updateOptions(newOpt);
  });
}


if ($('.d-slider1').length > 0) {
    const options = {
        centeredSlides: false,
        loop: false,
        slidesPerView: 4,
        autoplay:false,
        spaceBetween: 32,
        breakpoints: {
            320: { slidesPerView: 1 },
            550: { slidesPerView: 2 },
            991: { slidesPerView: 3 },
            1400: { slidesPerView: 3 },
            1500: { slidesPerView: 4 },
            1920: { slidesPerView: 6 },
            2040: { slidesPerView: 7 },
            2440: { slidesPerView: 8 }
        },
        pagination: {
            el: '.swiper-pagination'
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar'
        }
    }
    let swiper = new Swiper('.d-slider1',options);

    document.addEventListener('ChangeMode', (e) => {
      if (e.detail.rtl === 'rtl' || e.detail.rtl === 'ltr') {
        swiper.destroy(true, true)
        setTimeout(() => {
            swiper = new Swiper('.d-slider1',options);
        }, 500);
      }
    })
}

})(jQuery)
