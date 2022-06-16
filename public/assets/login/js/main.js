const eyeButton = document.querySelector('#icon-eye')

eyeButton.addEventListener('click', () => {
  let inputPassword = document.querySelector('#pwd')

  if (inputPassword.getAttribute('type') == 'password') {
    inputPassword.setAttribute('type', 'text')
    eyeButton.classList = 'fas fa-eye'
    eyeButton.classList = 'fas fa-eye-slash'
    eyeButton.style.color = '#8257e6'
  } else {
    inputPassword.setAttribute('type', 'password')
    eyeButton.classList = 'fas fa-eye-slash'
    eyeButton.classList = 'fas fa-eye'
    eyeButton.style.color = '#aaa'
  }
})

$('.validate-form').on('submit',function(e){

    e.preventDefault();

    var formData = $(this).serialize();
    console.log(formData);
    $.ajax({
      type: 'POST',
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: $('.validate-form').attr("action"),
      data: formData,
      dataType: "json",
      timeout: function () {
        swal({
          title: "ERROR!",
          icon: "error",
          text: 'Please Tra Again !',
          value: true,
          visible: true,
          className: "",
          closeModal: true,
        });
    },
      success: function (res)
      {

        if(res.error) {
          swal({
            title: "ERROR!",
            icon: "error",
            text: res.error.message,
            value: true,
            visible: true,
            className: "",
            closeModal: true,
          });
          return false;
        }
        swal({
          title: "SUCCESS",
          icon: "success",
          text: res.success.message,
          value: true,
          visible: true,
          className: "",
          closeModal: true,
        });

        window.location.href = $('.validate-form').attr("redirect");

        return false;

      },
      error: function(res) {

        var object = JSON.parse(res.responseText);
        swal({
          title: "ERROR!",
          icon: "error",
          text: object.error.message,
          value: true,
          visible: true,
          className: "",
          closeModal: true,
        });

        return false;

      }
    });

});
