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

// (function (jQuery) {
//     "use strict";
  
//     /*---------------------------------------------------------------------
//           Tooltip
//           -----------------------------------------------------------------------*/
//     jQuery('[data-bs-toggle="popover"]').popover();
//     jQuery('[data-bs-toggle="tooltip"]').tooltip();
  
//     /*---------------------------------------------------------------------
//           Fixed Nav
//           -----------------------------------------------------------------------*/
  
//     $(window).on("scroll", function () {
//       if ($(window).scrollTop() > 0) {
//         $(".iq-top-navbar").addClass("fixed");
//       } else {
//         $(".iq-top-navbar").removeClass("fixed");
//       }
//     });
  
//     $(window).on("scroll", function () {
//       if ($(window).scrollTop() > 0) {
//         $(".white-bg-menu").addClass("sticky-menu");
//       } else {
//         $(".white-bg-menu").removeClass("sticky-menu");
//       }
//     });
  
//     /*---------------------------------------------------------------------
//           Magnific Popup
//           -----------------------------------------------------------------------*/
//     if (typeof $.fn.magnificPopup !== typeof undefined) {
//       jQuery(".popup-gallery").magnificPopup({
//         delegate: "a.popup-img",
//         type: "image",
//         tLoading: "Loading image #%curr%...",
//         mainClass: "mfp-img-mobile",
//         gallery: {
//           enabled: true,
//           navigateByImgClick: true,
//           preload: [0, 1], // Will preload 0 - before current, and 1 after the current image
//         },
//         image: {
//           tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
//           titleSrc: function (item) {
//             return item.el.attr("title") + "<small>by Marsel Van Oosten</small>";
//           },
//         },
//       });
//       jQuery(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
//         disableOn: 700,
//         type: "iframe",
//         mainClass: "mfp-fade",
//         removalDelay: 160,
//         preloader: false,
//         fixedContentPos: false,
//       });
//     }
  
//     /*---------------------------------------------------------------------
//           Ripple Effect
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".iq-waves-effect", function (e) {
//       // Remove any old one
//       jQuery(".ripple").remove();
//       // Setup
//       let posX = jQuery(this).offset().left,
//         posY = jQuery(this).offset().top,
//         buttonWidth = jQuery(this).width(),
//         buttonHeight = jQuery(this).height();
  
//       // Add the element
//       jQuery(this).prepend("<span class='ripple'></span>");
  
//       // Make it round!
//       if (buttonWidth >= buttonHeight) {
//         buttonHeight = buttonWidth;
//       } else {
//         buttonWidth = buttonHeight;
//       }
  
//       // Get the center of the element
//       let x = e.pageX - posX - buttonWidth / 2;
//       let y = e.pageY - posY - buttonHeight / 2;
  
//       // Add the ripples CSS and start the animation
//       jQuery(".ripple")
//         .css({
//           width: buttonWidth,
//           height: buttonHeight,
//           top: y + "px",
//           left: x + "px",
//         })
//         .addClass("rippleEffect");
//     });
  
//     /*---------------------------------------------------------------------
//           Sidebar Widget
//           -----------------------------------------------------------------------*/
  
//     jQuery(document).on("click", ".iq-menu > li > a", function () {
//       jQuery(".iq-menu > li > a").parent().removeClass("active");
//       jQuery(this).parent().addClass("active");
//     });
  
//     // Active menu
//     var parents = jQuery("li.active").parents(".iq-submenu.collapse");
  
//     parents.addClass("show");
  
//     parents.parents("li").addClass("active");
//     jQuery('li.active > a[aria-expanded="false"]').attr("aria-expanded", "true");
  
//     /*---------------------------------------------------------------------
//           FullScreen
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".iq-full-screen", function () {
//       let elem = jQuery(this);
//       if (
//         !document.fullscreenElement &&
//         !document.mozFullScreenElement && // Mozilla
//         !document.webkitFullscreenElement && // Webkit-Browser
//         !document.msFullscreenElement
//       ) {
//         // MS IE ab version 11
  
//         if (document.documentElement.requestFullscreen) {
//           document.documentElement.requestFullscreen();
//         } else if (document.documentElement.mozRequestFullScreen) {
//           document.documentElement.mozRequestFullScreen();
//         } else if (document.documentElement.webkitRequestFullscreen) {
//           document.documentElement.webkitRequestFullscreen(
//             Element.ALLOW_KEYBOARD_INPUT
//           );
//         } else if (document.documentElement.msRequestFullscreen) {
//           document.documentElement.msRequestFullscreen(
//             Element.ALLOW_KEYBOARD_INPUT
//           );
//         }
//       } else {
//         if (document.cancelFullScreen) {
//           document.cancelFullScreen();
//         } else if (document.mozCancelFullScreen) {
//           document.mozCancelFullScreen();
//         } else if (document.webkitCancelFullScreen) {
//           document.webkitCancelFullScreen();
//         } else if (document.msExitFullscreen) {
//           document.msExitFullscreen();
//         }
//       }
//       elem
//         .find("i")
//         .toggleClass("ri-fullscreen-line")
//         .toggleClass("ri-fullscreen-exit-line");
//     });
  
//     /*---------------------------------------------------------------------
//           Page Loader
//           -----------------------------------------------------------------------*/
//     jQuery("#load").fadeOut();
//     jQuery("#loading").delay().fadeOut("");
  
//     /*---------------------------------------------------------------------
//           Counter
//           -----------------------------------------------------------------------*/
//     if (window.counterUp !== undefined) {
//       const counterUp = window.counterUp["default"];
//       const $counters = $(".counter");
//       $counters.each(function (ignore, counter) {
//         var waypoint = new Waypoint({
//           element: $(this),
//           handler: function () {
//             counterUp(counter, {
//               duration: 1000,
//               delay: 10,
//             });
//             this.destroy();
//           },
//           offset: "bottom-in-view",
//         });
//       });
//     }
  
//     /*---------------------------------------------------------------------
//           Progress Bar
//           -----------------------------------------------------------------------*/
//     jQuery(".iq-progress-bar > span").each(function () {
//       let progressBar = jQuery(this);
//       let width = jQuery(this).data("percent");
//       progressBar.css({
//         transition: "width 2s",
//       });
  
//       setTimeout(function () {
//         progressBar.appear(function () {
//           progressBar.css("width", width + "%");
//         });
//       }, 100);
//     });
  
//     jQuery(".progress-bar-vertical > span").each(function () {
//       let progressBar = jQuery(this);
//       let height = jQuery(this).data("percent");
//       progressBar.css({
//         transition: "height 2s",
//       });
//       setTimeout(function () {
//         progressBar.appear(function () {
//           progressBar.css("height", height + "%");
//         });
//       }, 100);
//     });
  
//     /*---------------------------------------------------------------------
//           Page Menu
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".wrapper-menu", function () {
//       jQuery(this).toggleClass("open");
//     });
  
//     jQuery(document).on("click", ".wrapper-menu", function () {
//       jQuery("body").toggleClass("sidebar-main");
//     });
  
//     /*---------------------------------------------------------------------
//          Close  navbar Toggle
//          -----------------------------------------------------------------------*/
  
//     jQuery(".close-toggle").on("click", function () {
//       jQuery(".h-collapse.navbar-collapse").collapse("hide");
//     });
  
//     /*---------------------------------------------------------------------
//           Mailbox
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", "ul.iq-email-sender-list li", function () {
//       jQuery(this).next().addClass("show");
//       // jQuery('.mail-box-detail').css('filter','blur(4px)');
//     });
  
//     jQuery(document).on("click", ".email-app-details li h4", function () {
//       jQuery(".email-app-details").removeClass("show");
//     });
  
//     /*---------------------------------------------------------------------
//           chatuser
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".chat-head .chat-user-profile", function () {
//       jQuery(this).parent().next().toggleClass("show");
//     });
//     jQuery(document).on("click", ".user-profile .close-popup", function () {
//       jQuery(this).parent().parent().removeClass("show");
//     });
  
//     /*---------------------------------------------------------------------
//           chatuser main
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".chat-search .chat-profile", function () {
//       jQuery(this).parent().next().toggleClass("show");
//     });
//     jQuery(document).on("click", ".user-profile .close-popup", function () {
//       jQuery(this).parent().parent().removeClass("show");
//     });
  
//     /*---------------------------------------------------------------------
//           Chat start
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", "#chat-start", function () {
//       jQuery(".chat-data-left").toggleClass("show");
//     });
//     jQuery(document).on("click", ".close-btn-res", function () {
//       jQuery(".chat-data-left").removeClass("show");
//     });
//     jQuery(document).on("click", ".iq-chat-ui li", function () {
//       jQuery(".chat-data-left").removeClass("show");
//     });
//     jQuery(document).on("click", ".sidebar-toggle", function () {
//       jQuery(".chat-data-left").addClass("show");
//     });
  
//     /*---------------------------------------------------------------------
//           todo Page
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".todo-task-list > li > a", function () {
//       jQuery(".todo-task-list li").removeClass("active");
//       jQuery(".todo-task-list .sub-task").removeClass("show");
//       jQuery(this).parent().toggleClass("active");
//       jQuery(this).next().toggleClass("show");
//     });
//     jQuery(document).on("click", ".todo-task-list > li li > a", function () {
//       jQuery(".todo-task-list li li").removeClass("active");
//       jQuery(this).parent().toggleClass("active");
//     });
  
//     /*---------------------------------------------------------------------
//           user toggle
//           -----------------------------------------------------------------------*/
//     jQuery(document).on("click", ".iq-user-toggle", function () {
//       jQuery(this).parent().addClass("show-data");
//     });
  
//     jQuery(document).on("click", ".close-data", function () {
//       jQuery(".iq-user-toggle").parent().removeClass("show-data");
//     });
//     jQuery(document).on("click", function (event) {
//       var $trigger = jQuery(".iq-user-toggle");
//       if ($trigger !== event.target && !$trigger.has(event.target).length) {
//         jQuery(".iq-user-toggle").parent().removeClass("show-data");
//       }
//     });
//     /*-------hide profile when scrolling--------*/
//     jQuery(window).scroll(function () {
//       let scroll = jQuery(window).scrollTop();
//       if (
//         scroll >= 10 &&
//         jQuery(".iq-user-toggle").parent().hasClass("show-data")
//       ) {
//         jQuery(".iq-user-toggle").parent().removeClass("show-data");
//       }
//     });
//     let Scrollbar = window.Scrollbar;
//     if (jQuery(".data-scrollbar").length) {
//       Scrollbar.init(document.querySelector(".data-scrollbar"), {
//         continuousScrolling: false,
//       });
//     }
  
//       /*---------------------------------------------------------------------
//           Datatables
//       -----------------------------------------------------------------------*/
//       if(jQuery('.data-tables').length)
//       {
//         $('.data-tables').DataTable();
//       }
  
//     /*---------------------------------------------------------------------
//           Form Validation
//           -----------------------------------------------------------------------*/
  
//     // Example starter JavaScript for disabling form submissions if there are invalid fields
//     window.addEventListener(
//       "load",
//       function () {
//         // Fetch all the forms we want to apply custom Bootstrap validation styles to
//         var forms = document.getElementsByClassName("needs-validation");
//         // Loop over them and prevent submission
//         var validation = Array.prototype.filter.call(forms, function (form) {
//           form.addEventListener(
//             "submit",
//             function (event) {
//               if (form.checkValidity() === false) {
//                 event.preventDefault();
//                 event.stopPropagation();
//               }
//               form.classList.add("was-validated");
//             },
//             false
//           );
//         });
//       },
//       false
//     );
  
//     /*---------------------------------------------------------------------
//          Active Class for Pricing Table
//          -----------------------------------------------------------------------*/
//     jQuery("#my-table tr th").click(function () {
//       jQuery("#my-table tr th").children().removeClass("active");
//       jQuery(this).children().addClass("active");
//       jQuery("#my-table td").each(function () {
//         if (jQuery(this).hasClass("active")) {
//           jQuery(this).removeClass("active");
//         }
//       });
//       var col = jQuery(this).index();
//       jQuery("#my-table tr td:nth-child(" + parseInt(col + 1) + ")").addClass(
//         "active"
//       );
//     });
  
//     /*------------------------------------------------------------------
//           Select 2 Selectpicker
//           * -----------------------------------------------------------------*/
  
//     if ($.fn.select2 !== undefined) {
//       $("#single").select2({
//         placeholder: "Select a Option",
//         allowClear: true,
//       });
//       $("#multiple").select2({
//         placeholder: "Select a Multiple Option",
//         allowClear: true,
//       });
//       $("#multiple2").select2({
//         placeholder: "Select a Multiple Option",
//         allowClear: true,
//       });
//       $("#customer_id").select2({
//         placeholder: "--Pilih Customer--",
//         allowClear: true,
//       });
//       $("#order_id").select2({
//         placeholder: "--Pilih Sales Order--",
//         allowClear: true,
//       });
//     }
  
//     /*------------------------------------------------------------------
//           Flatpicker
//           * -----------------------------------------------------------------*/
//     if (jQuery.fn.flatpickr !== undefined) {
//       if (jQuery(".basicFlatpickr").length > 0) {
//         jQuery(".basicFlatpickr").flatpickr();
//       }
  
//       if (jQuery("#inputTime").length > 0) {
//         jQuery("#inputTime").flatpickr({
//           enableTime: true,
//           noCalendar: true,
//           dateFormat: "H:i",
//         });
//       }
//       if (jQuery("#inputDatetime").length > 0) {
//         jQuery("#inputDatetime").flatpickr({
//           enableTime: true,
//         });
//       }
//       if (jQuery("#inputWeek").length > 0) {
//         jQuery("#inputWeek").flatpickr({
//           weekNumbers: true,
//         });
//       }
//       if (jQuery("#inline-date").length > 0) {
//         jQuery("#inline-date").flatpickr({
//           inline: true,
//         });
//       }
//       if (jQuery("#inline-date1").length > 0) {
//         jQuery("#inline-date1").flatpickr({
//           inline: true,
//         });
//       }
//     }
  
//     /*---------------------------------------------------------------------
//           Scrollbar
//           -----------------------------------------------------------------------*/
  
//     jQuery(window)
//       .on("resize", function () {
//         if (jQuery(this).width() <= 1299) {
//           jQuery("#salon-scrollbar").addClass("data-scrollbar");
//         } else {
//           jQuery("#salon-scrollbar").removeClass("data-scrollbar");
//         }
//       })
//       .trigger("resize");
  
//     jQuery(".data-scrollbar").each(function () {
//       var attr = $(this).attr("data-scroll");
//       if (typeof attr !== typeof undefined && attr !== false) {
//         let Scrollbar = window.Scrollbar;
//         var a = jQuery(this).data("scroll");
//         Scrollbar.init(document.querySelector('div[data-scroll= "' + a + '"]'));
//       }
//     });
  
//     /*---------------------------------------------------------------------
//           Pricing tab
//           -----------------------------------------------------------------------*/
//     jQuery(window).on("scroll", function (e) {
//       // Pricing Pill Tab
//       var nav = jQuery("#pricing-pills-tab");
//       if (nav.length) {
//         var contentNav = nav.offset().top - window.outerHeight;
//         if (jQuery(window).scrollTop() >= contentNav) {
//           e.preventDefault();
//           jQuery("#pricing-pills-tab li a").removeClass("active");
//           jQuery("#pricing-pills-tab li a[aria-selected=true]").addClass(
//             "active"
//           );
//         }
//       }
//     });
  
//     /*---------------------------------------------------------------------
//           Sweet alt Delete
//           -----------------------------------------------------------------------*/
//     $('[data-extra-toggle="delete"]').on("click", function (e) {
//       const closestElem = $(this).attr("data-closest-elem");
//       const swalWithBootstrapButtons = Swal.mixin({
//         customClass: {
//           confirmButton: "btn btn-primary",
//           cancelButton: "btn btn-outline-primary ml-2",
//         },
//         buttonsStyling: false,
//       });
  
//       swalWithBootstrapButtons
//         .fire({
//           title: "Are you sure?",
//           text: "You won't be able to revert this!",
//           icon: "warning",
//           showCancelButton: true,
//           confirmButtonText: "Yes, delete it!",
//           showClass: {
//             popup: "animate__animated animate__zoomIn",
//           },
//           hideClass: {
//             popup: "animate__animated animate__zoomOut",
//           },
//         })
//         .then((willDelete) => {
//           if (willDelete.isConfirmed) {
//             swalWithBootstrapButtons
//               .fire({
//                 title: "Deleted!",
//                 text: "Your note has been deleted.",
//                 icon: "success",
//                 showClass: {
//                   popup: "animate__animated animate__zoomIn",
//                 },
//                 hideClass: {
//                   popup: "animate__animated animate__zoomOut",
//                 },
//               })
//               .then(() => {
//                 if (closestElem == ".card") {
//                   $(this).closest(closestElem).parent().remove();
//                 } else {
//                   $(this).closest(closestElem).remove();
//                 }
//               });
//           } else {
//             swalWithBootstrapButtons.fire({
//               title: "Your note is safe!",
//               showClass: {
//                 popup: "animate__animated animate__zoomIn",
//               },
//               hideClass: {
//                 popup: "animate__animated animate__zoomOut",
//               },
//             });
//           }
//         });
//     });
  
//     if ($.fn.slick !== undefined && $(".top-product").length > 0) {
//       jQuery(".top-product").slick({
//         slidesToShow: 3,
//         speed: 300,
//         slidesToScroll: 1,
//         focusOnSelect: true,
//         autoplay: true,
//         arrows: false,
//         responsive: [
//           {
//             breakpoint: 768,
//             settings: {
//               arrows: false,
//               slidesToShow: 2,
//             },
//           },
//           {
//             breakpoint: 480,
//             settings: {
//               arrows: false,
//               autoplay: true,
//               slidesToShow: 1,
//             },
//           },
//         ],
//       });
//     }
//   })(jQuery);
  
// function calculateDiscount() {
//   // Mengambil nilai subtotal dan diskon persen
//   const subtotalElement = document.getElementById('subtotal');
//   const discountPercentElement = document.getElementById('discount_percent');
//   const discountRpElement = document.getElementById('discount_rp');
//   const grandTotalElement = document.getElementById('grandtotal');
  
//   const subtotal = parseFloat(subtotalElement.textContent.replace(',', ''));
//     //  const discountPercent = parseFloat(discountPercentElement.value);
//   const discountPercent = parseFloat(document.getElementById('discount_percent').value);

  
//   // Validasi input
//   if (isNaN(subtotal) || isNaN(discountPercent) || discountPercent < 0 || discountPercent > 100) {
//     discountPercentElement.value = 0;
//     discountRpElement.value = 0;
//     return;
//   }
  
//   // Menghitung jumlah diskon
//   const discountRp = (subtotal * discountPercent) / 100;
//   // Menghitung total akhir
//   const grandTotal = subtotal - discountRp;
  
//   // Menampilkan hasil perhitungan di input field
//   discountRpElement.value = discountRp
//   grandTotalElement.value = grandTotal
// }

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

  // Menampilkan konfirmasi manual
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
        // Jika pengguna mengkonfirmasi, kirim form
        form.submit();
      }
    });
});

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

// // Toast Check Out Reminder
// function showCheckOutToast(status, pulang) {
//     if (status === 'Hadir' && !pulang) {
//         Swal.fire({
//             toast: true,
//             position: 'bottom-end',
//             icon: 'info',
//             title: 'Waktunya Absen Pulang!',
//             // text: 'Silakan lengkapi jam pulang Anda.',
//             showConfirmButton: false,
//             timer: false,
//             timerProgressBar: true,
//             background: '#ffffff',
//             customClass: {
//                 popup: 'swal-toast-custom',
//             },
//         });
//     }
// }

// function checkAttendanceStatus() {
//     const Attendance = {
//         status: 'Hadir',
//         pulang: null,
//     };
//     showCheckOutToast(Attendance.status, Attendance.pulang);
// }

// checkAttendanceStatus();

// Chart
import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {
    fetch('/orders/chart-data')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(order => `Bulan ${order.month}`);
            const totals = data.map(order => order.total);

            const ctx = document.getElementById('orderChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Order',
                        data: totals,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
});
