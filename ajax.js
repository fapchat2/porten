


function orderWithNumber(event) {
  event.preventDefault();
  Swal.fire({
    title: 'Enter phone number',
    input: 'text',
    confirmButtonColor: '#e31e35',
  preConfirm: (phone) => {    
      if (phone.search(/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/) == -1) 
      {
          Swal.showValidationMessage(
              '<i class="fa fa-info-circle"></i> Your phone number is required'
          )
      }

  }
  }).then((result) => {
  if (result.isConfirmed) {
      
    $.ajax({
        url: 'post.php', //url страницы (action_ajax_form.php)
        type: "POST", //метод отправки
        dataType: "html", //формат данных
        data: "phone=" + encodeURIComponent(result.value),//result,
        success: function(response) { //Данные отправлены успешно
            res = $.parseJSON(response);
            if (res.numberIsInDatabase) {
                Swal.fire({text: 'Вы уже оставили свой номер',
                confirmButtonColor: '#e31e35'})
            } 
            else
            {
                Swal.fire({
                    icon: 'success',
                    title: 'We will call you',
                    showConfirmButton: false,
                    timer: 1250
                  })      
            }
        },
        error: function(response) { // Данные не отправлены
        alert("error");
        }
    });       
  }
  })
}

document.querySelector('main .div1 a').addEventListener("click", orderWithNumber);
document.querySelector('.sec9 .div1 a').addEventListener("click", orderWithNumber);