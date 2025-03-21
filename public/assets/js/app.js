// Success Alert
function showSuccessAlert(message) {
    Swal.fire({
        position: "top-end",
        toast: true,
        text: message,
        icon: "success", // Tambahkan icon success
        showConfirmButton: false,
        timer: 5000,
        customClass: {
          popup: "swal-custom-success" // Tambahkan kelas CSS
        },
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}
  
// Warning Alert
function showWarningAlert(message) {
    Swal.fire({
        position: "top-end",
        toast: true,
        text: message,
        icon: "warning", // Tambahkan icon warning
        showConfirmButton: false,
        timer: 5000,
        customClass: {
          popup: "swal-custom-warning" // Tambahkan kelas CSS
        },
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
  }
  
// Danger Alert
function showDangerAlert(message) {
    Swal.fire({
        position: "top-end",
        toast: true,
        text: message,
        icon: "warning",
        showConfirmButton: false,
        timer: 5000,
        customClass: {
          popup: "swal-custom-danger"
        },
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}
  
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

// // Function untuk menampilkan greetings
// function showGreeting() {
//     var greetingElement = document.getElementById('greetings');
//     if (!greetingElement) return;

//     var now = new Date();
//     var currentHour = now.getHours();
//     var greetingMessage = '';

//     if (currentHour >= 0 && currentHour <= 10) {
//         greetingMessage = 'Pagi';
//     } else if (currentHour >= 11 && currentHour <= 14) {
//         greetingMessage = 'Siang';
//     } else if (currentHour >= 14 && currentHour <= 18) {
//         greetingMessage = 'Sore';
//     } else {
//         greetingMessage = 'Malam';
//     }

//     greetingElement.textContent = `Selamat ${greetingMessage}, ${greetingElement.textContent}`;
// }

// // Function untuk menampilkan popup absensi
// function showAttendanceModal() {
//     var attendanceModalElement = document.getElementById('attendanceModal');
//     var currentDate = new Date();
//     var currentDay = currentDate.getDay(); // 0 = Minggu

//     if (attendanceModalElement && currentDay !== 0) {
//         var attendanceModal = new bootstrap.Modal(attendanceModalElement, {
//             keyboard: false,
//             backdrop: 'static',
//         });
//         attendanceModal.show();
//     }
// }

// // Function untuk menangani perubahan status absensi
// function handleAttendanceChange() {
//     var hadirRadio = document.getElementById('hadir');
//     var tidakHadirRadio = document.getElementById('tidak_hadir');
//     var timepickerDiv = document.getElementById('timepickerDiv');
//     var keteranganDiv = document.getElementById('keteranganDiv');

//     if (!hadirRadio || !tidakHadirRadio) return;

//     hadirRadio.addEventListener('change', function () {
//         if (this.checked) {
//             timepickerDiv.style.display = 'block';
//             document.getElementById('datangTime').setAttribute('required', 'required');
//             keteranganDiv.style.display = 'none';
//             document.getElementById('keterangan').removeAttribute('required');
//         }
//     });

//     tidakHadirRadio.addEventListener('change', function () {
//         if (this.checked) {
//             timepickerDiv.style.display = 'none';
//             document.getElementById('datangTime').removeAttribute('required');
//             keteranganDiv.style.display = 'block';
//             document.getElementById('keterangan').setAttribute('required', 'required');
//         }
//     });
// }

// // Menjalankan semua fungsi saat halaman selesai dimuat
// document.addEventListener("DOMContentLoaded", function () {
//     showGreeting();
//     showAttendanceModal();
//     handleAttendanceChange();
// });

document.addEventListener("DOMContentLoaded", function () {
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
});

