/*
Template: POSDash - Responsive Bootstrap 4 Admin Dashboard Template
Author: iqonicthemes.in
Design and Developed by: iqonicthemes.in
NOTE: This file contains the styling for responsive Template.
*/

/*----------------------------------------------
Index Of Script
------------------------------------------------

:: Tooltip
:: Fixed Nav
:: Magnific Popup
:: Ripple Effect
:: Sidebar Widget
:: FullScreen
:: Page Loader
:: Counter
:: Progress Bar
:: Page Menu
:: Close  navbar Toggle
:: Mailbox
:: chatuser
:: chatuser main
:: Chat start
:: todo Page
:: user toggle
:: Data tables
:: Form Validation
:: Active Class for Pricing Table
:: Flatpicker
:: Scrollbar
:: checkout
:: Datatables
:: image-upload
:: video
:: Button
:: Pricing tab

------------------------------------------------
Index Of Script
----------------------------------------------*/

(function (jQuery) {
  "use strict";

  /*---------------------------------------------------------------------
        Tooltip
        -----------------------------------------------------------------------*/
  jQuery('[data-bs-toggle="popover"]').popover();
  jQuery('[data-bs-toggle="tooltip"]').tooltip();

  /*---------------------------------------------------------------------
        Fixed Nav
        -----------------------------------------------------------------------*/

  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 0) {
      $(".iq-top-navbar").addClass("fixed");
    } else {
      $(".iq-top-navbar").removeClass("fixed");
    }
  });

  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 0) {
      $(".white-bg-menu").addClass("sticky-menu");
    } else {
      $(".white-bg-menu").removeClass("sticky-menu");
    }
  });

  /*---------------------------------------------------------------------
        Magnific Popup
        -----------------------------------------------------------------------*/
  if (typeof $.fn.magnificPopup !== typeof undefined) {
    jQuery(".popup-gallery").magnificPopup({
      delegate: "a.popup-img",
      type: "image",
      tLoading: "Loading image #%curr%...",
      mainClass: "mfp-img-mobile",
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1], // Will preload 0 - before current, and 1 after the current image
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
          return item.el.attr("title") + "<small>by Marsel Van Oosten</small>";
        },
      },
    });
    jQuery(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
      disableOn: 700,
      type: "iframe",
      mainClass: "mfp-fade",
      removalDelay: 160,
      preloader: false,
      fixedContentPos: false,
    });
  }

  /*---------------------------------------------------------------------
        Ripple Effect
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".iq-waves-effect", function (e) {
    // Remove any old one
    jQuery(".ripple").remove();
    // Setup
    let posX = jQuery(this).offset().left,
      posY = jQuery(this).offset().top,
      buttonWidth = jQuery(this).width(),
      buttonHeight = jQuery(this).height();

    // Add the element
    jQuery(this).prepend("<span class='ripple'></span>");

    // Make it round!
    if (buttonWidth >= buttonHeight) {
      buttonHeight = buttonWidth;
    } else {
      buttonWidth = buttonHeight;
    }

    // Get the center of the element
    let x = e.pageX - posX - buttonWidth / 2;
    let y = e.pageY - posY - buttonHeight / 2;

    // Add the ripples CSS and start the animation
    jQuery(".ripple")
      .css({
        width: buttonWidth,
        height: buttonHeight,
        top: y + "px",
        left: x + "px",
      })
      .addClass("rippleEffect");
  });

  /*---------------------------------------------------------------------
        Sidebar Widget
        -----------------------------------------------------------------------*/

  jQuery(document).on("click", ".iq-menu > li > a", function () {
    jQuery(".iq-menu > li > a").parent().removeClass("active");
    jQuery(this).parent().addClass("active");
  });

  // Active menu
  var parents = jQuery("li.active").parents(".iq-submenu.collapse");

  parents.addClass("show");

  parents.parents("li").addClass("active");
  jQuery('li.active > a[aria-expanded="false"]').attr("aria-expanded", "true");

  /*---------------------------------------------------------------------
        FullScreen
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".iq-full-screen", function () {
    let elem = jQuery(this);
    if (
      !document.fullscreenElement &&
      !document.mozFullScreenElement && // Mozilla
      !document.webkitFullscreenElement && // Webkit-Browser
      !document.msFullscreenElement
    ) {
      // MS IE ab version 11

      if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
      } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
      } else if (document.documentElement.webkitRequestFullscreen) {
        document.documentElement.webkitRequestFullscreen(
          Element.ALLOW_KEYBOARD_INPUT
        );
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen(
          Element.ALLOW_KEYBOARD_INPUT
        );
      }
    } else {
      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
    elem
      .find("i")
      .toggleClass("ri-fullscreen-line")
      .toggleClass("ri-fullscreen-exit-line");
  });

  /*---------------------------------------------------------------------
        Page Loader
        -----------------------------------------------------------------------*/
  jQuery("#load").fadeOut();
  jQuery("#loading").delay().fadeOut("");

  /*---------------------------------------------------------------------
        Counter
        -----------------------------------------------------------------------*/
  if (window.counterUp !== undefined) {
    const counterUp = window.counterUp["default"];
    const $counters = $(".counter");
    $counters.each(function (ignore, counter) {
      var waypoint = new Waypoint({
        element: $(this),
        handler: function () {
          counterUp(counter, {
            duration: 1000,
            delay: 10,
          });
          this.destroy();
        },
        offset: "bottom-in-view",
      });
    });
  }

  /*---------------------------------------------------------------------
        Progress Bar
        -----------------------------------------------------------------------*/
  jQuery(".iq-progress-bar > span").each(function () {
    let progressBar = jQuery(this);
    let width = jQuery(this).data("percent");
    progressBar.css({
      transition: "width 2s",
    });

    setTimeout(function () {
      progressBar.appear(function () {
        progressBar.css("width", width + "%");
      });
    }, 100);
  });

  jQuery(".progress-bar-vertical > span").each(function () {
    let progressBar = jQuery(this);
    let height = jQuery(this).data("percent");
    progressBar.css({
      transition: "height 2s",
    });
    setTimeout(function () {
      progressBar.appear(function () {
        progressBar.css("height", height + "%");
      });
    }, 100);
  });

  /*---------------------------------------------------------------------
        Page Menu
        -----------------------------------------------------------------------*/
  jQuery(document).ready(function () {
    // Ketika tombol untuk membuka sidebar diklik
    jQuery("#sidebar_open").on("click", function () {
      jQuery(".sidebar").addClass("open");
    });
  
    // Ketika tombol untuk menutup sidebar diklik
    jQuery("#sidebar_close").on("click", function () {
      jQuery(".sidebar").removeClass("open");
    });
  });
  
  /*---------------------------------------------------------------------
       Close  navbar Toggle
       -----------------------------------------------------------------------*/

  jQuery(".close-toggle").on("click", function () {
    jQuery(".h-collapse.navbar-collapse").collapse("hide");
  });

  /*---------------------------------------------------------------------
        Mailbox
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", "ul.iq-email-sender-list li", function () {
    jQuery(this).next().addClass("show");
    // jQuery('.mail-box-detail').css('filter','blur(4px)');
  });

  jQuery(document).on("click", ".email-app-details li h4", function () {
    jQuery(".email-app-details").removeClass("show");
  });

  /*---------------------------------------------------------------------
        chatuser
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".chat-head .chat-user-profile", function () {
    jQuery(this).parent().next().toggleClass("show");
  });
  jQuery(document).on("click", ".user-profile .close-popup", function () {
    jQuery(this).parent().parent().removeClass("show");
  });

  /*---------------------------------------------------------------------
        chatuser main
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".chat-search .chat-profile", function () {
    jQuery(this).parent().next().toggleClass("show");
  });
  jQuery(document).on("click", ".user-profile .close-popup", function () {
    jQuery(this).parent().parent().removeClass("show");
  });

  /*---------------------------------------------------------------------
        Chat start
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", "#chat-start", function () {
    jQuery(".chat-data-left").toggleClass("show");
  });
  jQuery(document).on("click", ".close-btn-res", function () {
    jQuery(".chat-data-left").removeClass("show");
  });
  jQuery(document).on("click", ".iq-chat-ui li", function () {
    jQuery(".chat-data-left").removeClass("show");
  });
  jQuery(document).on("click", ".sidebar-toggle", function () {
    jQuery(".chat-data-left").addClass("show");
  });

  /*---------------------------------------------------------------------
        todo Page
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".todo-task-list > li > a", function () {
    jQuery(".todo-task-list li").removeClass("active");
    jQuery(".todo-task-list .sub-task").removeClass("show");
    jQuery(this).parent().toggleClass("active");
    jQuery(this).next().toggleClass("show");
  });
  jQuery(document).on("click", ".todo-task-list > li li > a", function () {
    jQuery(".todo-task-list li li").removeClass("active");
    jQuery(this).parent().toggleClass("active");
  });

  /*---------------------------------------------------------------------
        user toggle
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".iq-user-toggle", function () {
    jQuery(this).parent().addClass("show-data");
  });

  jQuery(document).on("click", ".close-data", function () {
    jQuery(".iq-user-toggle").parent().removeClass("show-data");
  });
  jQuery(document).on("click", function (event) {
    var $trigger = jQuery(".iq-user-toggle");
    if ($trigger !== event.target && !$trigger.has(event.target).length) {
      jQuery(".iq-user-toggle").parent().removeClass("show-data");
    }
  });
  /*-------hide profile when scrolling--------*/
  jQuery(window).scroll(function () {
    let scroll = jQuery(window).scrollTop();
    if (
      scroll >= 10 &&
      jQuery(".iq-user-toggle").parent().hasClass("show-data")
    ) {
      jQuery(".iq-user-toggle").parent().removeClass("show-data");
    }
  });
  let Scrollbar = window.Scrollbar;
  if (jQuery(".data-scrollbar").length) {
    Scrollbar.init(document.querySelector(".data-scrollbar"), {
      continuousScrolling: false,
    });
  }

    /*---------------------------------------------------------------------
        Datatables
    -----------------------------------------------------------------------*/
    if(jQuery('.data-tables').length)
    {
      $('.data-tables').DataTable();
    }

  /*---------------------------------------------------------------------
        Form Validation
        -----------------------------------------------------------------------*/

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );

  /*---------------------------------------------------------------------
       Active Class for Pricing Table
       -----------------------------------------------------------------------*/
  jQuery("#my-table tr th").click(function () {
    jQuery("#my-table tr th").children().removeClass("active");
    jQuery(this).children().addClass("active");
    jQuery("#my-table td").each(function () {
      if (jQuery(this).hasClass("active")) {
        jQuery(this).removeClass("active");
      }
    });
    var col = jQuery(this).index();
    jQuery("#my-table tr td:nth-child(" + parseInt(col + 1) + ")").addClass(
      "active"
    );
  });

  /*------------------------------------------------------------------
        Select 2 Selectpicker
        * -----------------------------------------------------------------*/

  if ($.fn.select2 !== undefined) {
    $("#single").select2({
      placeholder: "Select a Option",
      allowClear: true,
    });
    $("#multiple").select2({
      placeholder: "Select a Multiple Option",
      allowClear: true,
    });
    $("#multiple2").select2({
      placeholder: "Select a Multiple Option",
      allowClear: true,
    });
    $("#customer_id").select2({
      placeholder: "--Pilih Customer--",
      allowClear: true,
    });
    $("#order_id").select2({
      placeholder: "--Pilih Sales Order--",
      allowClear: true,
    });
    $(".order_id").select2({
      placeholder: "--Pilih Sales Order--",
      allowClear: true,
    });
    $("#delivery_id").select2({
      placeholder: "--Pilih Sales Order--",
      allowClear: true,
    });
    $(".delivery_id").select2({
      placeholder: "--Pilih Sales Order--",
      allowClear: true,
    });
    // $("#mapel").select2({
    //   placeholder: "--Mapel--",
    //   allowClear: true,
    // });
    
  }

  function formatOption(option) {
    if (!option.id) {
        return option.text; // Jika tidak ada ID, kembalikan teks default
    }

    // Mengambil data dari data-attribute
    var name = $(option.element).data('name');
    var dept = $(option.element).data('dept');

    // Membuat tampilan custom seperti tabel
    var $table = $(
        '<div style="display: flex; justify-content: space-between; width: 100%;">' +
        '<div>' + name + '</div>' +
        '<div>' + dept + '</div>' +
        '</div>'
    );

    return $table;
}

function formatOptionSelection(option) {
    return option.text; // Kembalikan teks untuk opsi yang dipilih
}

  /*------------------------------------------------------------------
        Flatpicker
        * -----------------------------------------------------------------*/
  if (jQuery.fn.flatpickr !== undefined) {
    if (jQuery(".basicFlatpickr").length > 0) {
      jQuery(".basicFlatpickr").flatpickr();
    }

    if (jQuery("#inputTime").length > 0) {
      jQuery("#inputTime").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
      });
    }
    if (jQuery("#inputDatetime").length > 0) {
      jQuery("#inputDatetime").flatpickr({
        enableTime: true,
      });
    }
    if (jQuery("#inputWeek").length > 0) {
      jQuery("#inputWeek").flatpickr({
        weekNumbers: true,
      });
    }
    if (jQuery("#inline-date").length > 0) {
      jQuery("#inline-date").flatpickr({
        inline: true,
      });
    }
    if (jQuery("#inline-date1").length > 0) {
      jQuery("#inline-date1").flatpickr({
        inline: true,
      });
    }
  }

  /*---------------------------------------------------------------------
        Scrollbar
        -----------------------------------------------------------------------*/

  jQuery(window)
    .on("resize", function () {
      if (jQuery(this).width() <= 1299) {
        jQuery("#salon-scrollbar").addClass("data-scrollbar");
      } else {
        jQuery("#salon-scrollbar").removeClass("data-scrollbar");
      }
    })
    .trigger("resize");

  jQuery(".data-scrollbar").each(function () {
    var attr = $(this).attr("data-scroll");
    if (typeof attr !== typeof undefined && attr !== false) {
      let Scrollbar = window.Scrollbar;
      var a = jQuery(this).data("scroll");
      Scrollbar.init(document.querySelector('div[data-scroll= "' + a + '"]'));
    }
  });

  /*---------------------------------------------------------------------
        Pricing tab
        -----------------------------------------------------------------------*/
  jQuery(window).on("scroll", function (e) {
    // Pricing Pill Tab
    var nav = jQuery("#pricing-pills-tab");
    if (nav.length) {
      var contentNav = nav.offset().top - window.outerHeight;
      if (jQuery(window).scrollTop() >= contentNav) {
        e.preventDefault();
        jQuery("#pricing-pills-tab li a").removeClass("active");
        jQuery("#pricing-pills-tab li a[aria-selected=true]").addClass(
          "active"
        );
      }
    }
  });

  /*---------------------------------------------------------------------
        Sweet alt Delete
        -----------------------------------------------------------------------*/
  $('[data-extra-toggle="delete"]').on("click", function (e) {
    const closestElem = $(this).attr("data-closest-elem");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-outline-primary ml-2",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        showClass: {
          popup: "animate__animated animate__zoomIn",
        },
        hideClass: {
          popup: "animate__animated animate__zoomOut",
        },
      })
      .then((willDelete) => {
        if (willDelete.isConfirmed) {
          swalWithBootstrapButtons
            .fire({
              title: "Deleted!",
              text: "Your note has been deleted.",
              icon: "success",
              showClass: {
                popup: "animate__animated animate__zoomIn",
              },
              hideClass: {
                popup: "animate__animated animate__zoomOut",
              },
            })
            .then(() => {
              if (closestElem == ".card") {
                $(this).closest(closestElem).parent().remove();
              } else {
                $(this).closest(closestElem).remove();
              }
            });
        } else {
          swalWithBootstrapButtons.fire({
            title: "Your note is safe!",
            showClass: {
              popup: "animate__animated animate__zoomIn",
            },
            hideClass: {
              popup: "animate__animated animate__zoomOut",
            },
          });
        }
      });
  });

  if ($.fn.slick !== undefined && $(".top-product").length > 0) {
    jQuery(".top-product").slick({
      slidesToShow: 3,
      speed: 300,
      slidesToScroll: 1,
      focusOnSelect: true,
      autoplay: true,
      arrows: false,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            autoplay: true,
            slidesToShow: 1,
          },
        },
      ],
    });
  }
})(jQuery);

/*---------------------------------------------------------------------
Sweet alt Confirmation
-----------------------------------------------------------------------*/
$('.confirm-button').on("click", function (e) {
  e.preventDefault(); // Mencegah form dari pengiriman otomatis
  const form = $(this).closest('.confirmation-form'); // Ambil form terkait

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton: "btn btn-danger me-3", // Tombol batal (cancel) berwarna merah
      confirmButton: "btn btn-success",    // Tombol konfirmasi (confirm) berwarna hijau
    },
    buttonsStyling: false,  // Menonaktifkan styling default tombol SweetAlert
  });

  swalWithBootstrapButtons
    .fire({
      title: "Konfirmasi",
      text: "Pastikan data yang Anda masukkan sudah benar!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Batalkan",
      confirmButtonText: "Simpan",
      reverseButtons: true, // Membalik posisi tombol, membuat confirm di kanan dan cancel di kiri
    })
    .then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Sukses!",
          text: "Pesanan berhasil dibuat!.",
          icon: "success"
        });
        // Jika pengguna mengkonfirmasi, kirim form
        form.submit();
      }
    });
});

/*---------------------------------------------------------------------
Sweet alt Update
-----------------------------------------------------------------------*/
$('.update-button').on("click", function (e) {
  e.preventDefault(); // Mencegah form dari pengiriman otomatis
  const form = $(this).closest('.confirmation-form'); // Ambil form terkait

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton: "btn btn-danger me-3", // Tombol batal (cancel) berwarna merah
      confirmButton: "btn btn-success",    // Tombol konfirmasi (confirm) berwarna hijau
    },
    buttonsStyling: false,  // Menonaktifkan styling default tombol SweetAlert
  });

  swalWithBootstrapButtons
    .fire({
      title: "Perbarui Data",
      text: "Apakah Anda yakin?!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Tidak, batalkan!",
      confirmButtonText: "Ya, simpan!",
      reverseButtons: true, // Membalik posisi tombol, membuat confirm di kanan dan cancel di kiri
    })
    .then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Berhasil!",
          text: "Data berhasil diperbarui!.",
          icon: "success"
        });
        form.submit();
      }
    });
});

/*---------------------------------------------------------------------
Sweet alt Delete
-----------------------------------------------------------------------*/
$('.delete-button').on("click", function (e) {
  e.preventDefault(); // Mencegah form dari pengiriman otomatis
  const form = $(this).closest('.confirmation-form'); // Ambil form terkait

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton: "btn btn-primary me-3", // Tombol batal (cancel) berwarna merah
      confirmButton: "btn btn-danger",    // Tombol konfirmasi (confirm) berwarna hijau
    },
    buttonsStyling: false,  // Menonaktifkan styling default tombol SweetAlert
  });

  swalWithBootstrapButtons
    .fire({
      // title: "Hapus Data",
      title: "Apakah Anda yakin untuk menghapus data?",
      // text: "Apakah Anda yakin?!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Tidak, batalkan!",
      confirmButtonText: "Ya, hapus!",
      reverseButtons: true, // Membalik posisi tombol, membuat confirm di kanan dan cancel di kiri
    })
    .then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Berhasil!",
          text: "Data berhasil dihapus!.",
          icon: "success"
        });
        form.submit();
      }
    });
});

// Success Alert
function showSuccessAlert(message) {
  Swal.fire({
      position: "bottom-end",
      toast: true,
      text: message,
      showConfirmButton: false,
      timer: 2500,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });
}

// Warning Alert
function warningAlert(message) {
  Swal.fire({
      position: "center",
      toast: true,
      icon: 'error',
      text: message,
      showConfirmButton: false,
      timer: 2500,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });
}

document.addEventListener("DOMContentLoaded", function() {
    console.log('App.js loaded successfully');
});

// Created Alert
function showCreatedAlert(message) {
  Swal.fire({
      position: "center",
      icon: "success",
      title: message,
      showConfirmButton: false,
      confirmButtonText: "OK",
      timer: 2000
  });
}

// Calculate Discount
function calculateDiscount() {
    // Mengambil nilai subtotal dan diskon persen
    const subtotalElement = document.getElementById('subtotal');
    // const subtotalElement = document.getElementById('subtotal');
    const discountPercentElement = document.getElementById('discount_percent');
    const discountRpElement = document.getElementById('discount_rp');
    const grandTotalElement = document.getElementById('grandtotal');
    
    const subtotal = parseFloat(subtotalElement.textContent.replace(',', ''));
    const discountPercent = parseFloat(document.getElementById('discount_percent').value);

      if (isNaN(subtotal) || isNaN(discountPercent) || discountPercent < 0 || discountPercent > 100) {
      discountPercentElement.value = 0;
      discountRpElement.value = 0;
      return;
    }
    
    // Menghitung jumlah diskon
    const discountRp = (subtotal * discountPercent) / 100;
    // Menghitung total akhir
    const grandTotal = subtotal - discountRp;
    
    // Menampilkan hasil perhitungan di input field
    discountRpElement.value = discountRp
    grandTotalElement.value = grandTotal
}

function toggleElements() {
  const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');

  if (!paymentMethodInput) {
      return; // Jika tidak ada input yang terpilih, keluar dari fungsi
  }

  const paymentMethod = paymentMethodInput.value;

  const hideElement = (id) => {
      const element = document.getElementById(id);
      if (element) {
          element.style.display = 'none';
          element.removeAttribute('required'); // Hapus atribut required
      }
  };

  const showElement = (id) => {
      const element = document.getElementById(id);
      if (element) {
          element.style.display = 'block';
          element.setAttribute('required', 'required'); // Tambahkan atribut required
      }
  };

  if (paymentMethod === 'Transfer') {
      hideElement('penerima');
      showElement('bankPengirim');
      showElement('rekeningPengirim');
      showElement('rekeningPenerima');
  } else {
      showElement('penerima');
      hideElement('bankPengirim');
      hideElement('rekeningPengirim');
      hideElement('rekeningPenerima');
  }
}

// Tambahkan event listener untuk input metode pembayaran
document.querySelectorAll('input[name="payment_method"]').forEach(input => {
  input.addEventListener('change', toggleElements);
});

// Calculate Payment
function calculateCollection() {
    var select = document.getElementById('order_id');
    var selectedOption = select.options[select.selectedIndex];
    var due = selectedOption.getAttribute('data-due');
    var dataDue = selectedOption.getAttribute('data-due');
    
    var pay = parseFloat($('#pay').val()) || 0;
    
    if (pay < 0 || pay > due) {
        pay = 0;
        $('#pay').val(0);
        // alert("Pembayaran tidak boleh melebihi tagihan!");
    }

    function validatePercent(value, elementId, message) {
      if (value > pay || value < 0 || value > 100) {
        $(elementId).val(0);
            // alert(message);
            return 0;
        }
        return value;
      }
      
      function validateFee(value, elementId, message) {
      if (value < 0 || value > due ) {
          $(elementId).val(0);
              // alert(message);
              return 0;
          }
          return value;
      }
      
      var discount_percent = validatePercent(parseFloat($('#discount_percent').val()) || 0, '#discount_percent', 'Diskon tidak boleh lebih dari 100%!');
      var PPh22_percent = validatePercent(parseFloat($('#PPh22_percent').val()) || 0, '#PPh22_percent', 'PPh 22 tidak boleh lebih dari 100%!');
      var PPh23_percent = validatePercent(parseFloat($('#PPh23_percent').val()) || 0, '#PPh23_percent', 'PPh 23 tidak boleh lebih dari 100%!');
      var PPN_percent = validatePercent(parseFloat($('#PPN_percent').val()) || 0, '#PPN_percent', 'PPN tidak boleh lebih dari 100%!');
      
      var admin_fee = validateFee(parseFloat($('#admin_fee').val()) || 0, '#admin_fee', 'Biaya admin tidak boleh negatif!');
      var other_fee = validateFee(parseFloat($('#other_fee').val()) || 0, '#other_fee', 'Biaya lainnya tidak boleh negatif!');

    // Total Tagihan
    var dataDue = $('#data-due').val(dataDue);

    // Perhitungan diskon
    var discount_rp = due * discount_percent / 100;
        $('#discount_rp').val(discount_rp);

    // Perhitungan PPh22
        var PPh22_rp = due * PPh22_percent / 100;
        $('#PPh22_rp').val(PPh22_rp);

    // Perhitungan PPh23
        var PPh23_rp = due * PPh23_percent / 100;
        $('#PPh23_rp').val(PPh23_rp);

    // Perhitungan PPN
        var PPN_rp = due * PPN_percent / 100;
        $('#PPN_rp').val(PPN_rp);

    // Total akhir (grandtotal)
        // var grandtotal = due - discount_rp + PPh22_rp + PPh23_rp + PPN_rp + admin_fee + other_fee;
        // $('#grandtotal').val(grandtotal);

    // Perhitungan grand total
        var grandtotal = pay - discount_rp - PPh22_rp - PPh23_rp - PPN_rp - admin_fee - other_fee;
        $('#grandtotal').val(grandtotal);

    // Perhitungan due (total akhir - pembayaran)
        var due = due - pay;
        $('#due').val(due);

    
   // Menampilkan status pembayaran
    if (pay === 0) {
      $('#belum_dibayar').prop('checked', true); 
      $('#labelBelumDibayar').addClass('active');
      $('#labelBelumDibayar').show();
      $('#labelLunas').hide();
      $('#labelBelumLunas').hide();
    }
    else if (due > 0) {
      $('#belum_lunas').prop('checked', true); 
      $('#labelBelumLunas').addClass('active');
      $('#labelBelumLunas').show();
      $('#labelLunas').hide();
      $('#labelBelumDibayar').hide();
    } 
    else {
      $('#lunas').prop('checked', true);
      $('#labelLunas').addClass('active');
      $('#labelLunas').show();
      $('#labelBelumLunas').hide();
      $('#labelBelumDibayar').hide();
    }
}

$(document).ready(function() {
    // Pastikan perhitungan dilakukan ketika ada perubahan
    $('#pay, #discount_percent, #PPh22_percent, #PPh23_percent, #PPN_percent, #admin_fee, #other_fee, #subtotal').on('input change', function() {
        calculateCollection();
    });

    // Inisialisasi perhitungan ketika halaman dimuat
    calculateCollection();
});

// Event listener untuk tombol Bayar Penuh
document.getElementById('fullPay').addEventListener('click', function() {
  // Ambil nilai due dari selected option
  var select = document.getElementById('order_id');
  var selectedOption = select.options[select.selectedIndex];
  var due = parseFloat(selectedOption.getAttribute('data-due')) || 0;
  
  // Set nilai input 'pay' menjadi nilai due
  $('#pay').val(due);
  
  // Recalculate the form after setting the payment to full
  calculateCollection();
});

// Event listener untuk tombol Bayar 75%
document.getElementById('pay75%').addEventListener('click', function() {
  // Ambil nilai due dari selected option
  var select = document.getElementById('order_id');
  var selectedOption = select.options[select.selectedIndex];
  var due = parseFloat(selectedOption.getAttribute('data-due')) || 0;
  
  var pay = due * 75 / 100;
  $('#pay').val(pay);
  
  // Recalculate the form after setting the payment to full
  calculateCollection();
});

// Event listener untuk tombol 50%
document.getElementById('pay50%').addEventListener('click', function() {
  // Ambil nilai due dari selected option
  var select = document.getElementById('order_id');
  var selectedOption = select.options[select.selectedIndex];
  var due = parseFloat(selectedOption.getAttribute('data-due')) || 0;
  
  var pay = due * 50 / 100;
  $('#pay').val(pay);
  
  // Recalculate the form after setting the payment to full
  calculateCollection();
});

// Event listener untuk tombol 25%
document.getElementById('pay25%').addEventListener('click', function() {
  // Ambil nilai due dari selected option
  var select = document.getElementById('order_id');
  var selectedOption = select.options[select.selectedIndex];
  var due = parseFloat(selectedOption.getAttribute('data-due')) || 0;
  
  var pay = due * 25 / 100;
  $('#pay').val(pay);
  
  // Recalculate the form after setting the payment to full
  calculateCollection();
});

// Event listener untuk tombol dibayar oleh Customer
document.getElementById('paidByCustomer').addEventListener('click', function() {
  var select = document.getElementById('order_id');
  var selectedOption = select.options[select.selectedIndex];
  var customer = selectedOption.getAttribute('data-customer');
  
  $('#paid_by').val(customer);
});

// Event listener untuk tombol diskon
document.getElementById('discount').addEventListener('click', function() {
  var select = document.getElementById('order_id');
  var selectedOption = select.options[select.selectedIndex];
  var discount = selectedOption.getAttribute('data-discount');
  
  $('#discount_percent').val(discount);
  calculateCollection();
});

// Event listener untuk tombol PPh22
document.getElementById('PPh22').addEventListener('click', function() {
  var pph22 = 0.5;
  $('#PPh22_percent').val(pph22);
  calculateCollection();
});

// Event listener untuk tombol PPN
document.getElementById('PPN').addEventListener('click', function() {
  var PPN = 11;
  $('#PPN_percent').val(PPN);
  calculateCollection();
});

// Product validation quantity
document.getElementById('product_store').addEventListener('input', function () {
  const value = parseInt(this.value, 10);
  if (value < 0 || isNaN(value)) {
    this.value = 0; // Setel nilai ke 0 jika input kurang dari 0 atau bukan angka
    alert("Product store tidak dapat kurang dari 0");
  }
});

function moveFocus(currentInput, nextInputId) {
  if (currentInput.value.length === currentInput.maxLength) {
      document.getElementById(nextInputId).focus();
  }
}

// Confirm Button
$('.confirm-button').on("click", function (e) {
  e.preventDefault(); // Mencegah form dari pengiriman otomatis
  const form = $(this).closest('.confirmation-form'); // Ambil form terkait

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton: "btn btn-danger me-3", // Tombol batal (cancel) berwarna merah
      confirmButton: "btn btn-success",    // Tombol konfirmasi (confirm) berwarna hijau
    },
    buttonsStyling: false,  // Menonaktifkan styling default tombol SweetAlert
  });

  swalWithBootstrapButtons
    .fire({
      title: "Konfirmasi",
      text: "Pastikan data yang Anda masukkan sudah benar!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Batalkan",
      confirmButtonText: "Simpan",
      reverseButtons: true, // Membalik posisi tombol, membuat confirm di kanan dan cancel di kiri
    })
    .then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Sukses!",
          text: "Pesanan berhasil dibuat!.",
          icon: "success"
        });
        // Jika pengguna mengkonfirmasi, kirim form
        form.submit();
      }
    });
});

function validateQuantity(input) {
  let maxQty = parseInt(input.getAttribute("data-max")); // Ambil batas maksimal dari atribut data-max
  let currentQty = parseInt(input.value);

  if (currentQty > maxQty) {
      alert(`Jumlah tidak boleh melebihi ${maxQty}`);
      input.value = maxQty; // Kembalikan ke nilai maksimal jika lebih dari batas
  } else if (currentQty < 1) {
      alert("Jumlah tidak boleh kurang dari 1");
      input.value = 1; // Minimal 1
  }

  input.form.submit(); // Submit form setelah validasi
}

// Greetings
const greetingElement = document.getElementById('greetings');
if (greetingElement) {
    const now = new Date();
    const currentHour = now.getHours();
    let greetingMessage = '';
    
    if (currentHour >= 0 && currentHour <= 10) {
        greetingMessage = 'Pagi';
    } else if (currentHour >= 11 && currentHour <= 14) {
        greetingMessage = 'Siang';
    } else if (currentHour >= 14 && currentHour <= 18) {
        greetingMessage = 'Sore';
    } else if (currentHour >= 18 && currentHour <= 23) {
        greetingMessage = 'Malam';
    }

    greetingElement.textContent = `Selamat ${greetingMessage}, ${greetingElement.textContent}`;
}

// Popup Absensi
const attendanceModalElement = document.getElementById('attendanceModal');
const currentDate = new Date();
// Mendapatkan hari saat ini (0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
const currentDay = currentDate.getDay(); // Mengambil hari dalam seminggu

if (attendanceModalElement && currentDay !== 0) { // 0 berarti hari Minggu
    const attendanceModal = new bootstrap.Modal(attendanceModalElement, {
        keyboard: false,
        backdrop: 'static',
    });
    attendanceModal.show();
}

const hadirRadio = document.getElementById('hadir');
const tidakHadirRadio = document.getElementById('tidak_hadir');
const timepickerDiv = document.getElementById('timepickerDiv');
const keteranganDiv = document.getElementById('keteranganDiv');

if (hadirRadio && tidakHadirRadio) {
    hadirRadio.addEventListener('change', function () {
        if (this.checked) {
            timepickerDiv.style.display = 'block';
            document.getElementById('datangTime').setAttribute('required', 'required');
            keteranganDiv.style.display = 'none';
            document.getElementById('keterangan').removeAttribute('required');
        }
    });

    tidakHadirRadio.addEventListener('change', function () {
        if (this.checked) {
            timepickerDiv.style.display = 'none';
            document.getElementById('datangTime').removeAttribute('required');
            keteranganDiv.style.display = 'block';
            document.getElementById('keterangan').setAttribute('required', 'required');
        }
    });
}