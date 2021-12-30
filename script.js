$('.slider1').slick({
      arrows: false,
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: true,
    })
    
    $('.left1').click(function() {
      $('.slider1').slick("slickPrev");
    })
    
    $('.right1').click(function() {
      $('.slider1').slick("slickNext");
    })

    $('.slider0').slick({
      arrows: false,
    })
    
    $('.left').click(function() {
      $('.slider0').slick("slickPrev");
    })
    
    $('.right').click(function() {
      $('.slider0').slick("slickNext");
    })
    function startTimer(secs, display) {
        var seconds = secs, date;
        setInterval(function () {
            date = new Date(seconds*1000);
            time0.textContent = ("0" + date.getUTCHours()).slice(-2);
            time1.textContent = ("0" + date.getMinutes()).slice(-2);
            time2.textContent = ("0" + date.getSeconds()).slice(-2);
            if (--seconds < 0) {
                seconds = secs;
            }
        }, 1000);
    }
    
    window.onload = function () {
        var fiveMinutes = 236 * 57,
            display = document.querySelector('#time');
        startTimer(fiveMinutes, display);
    };
    
    for (let variable of document.querySelectorAll('.figure')) {
      variable.onclick = function(event){
        this.querySelector('.figure .figure__hover-content').style.opacity = '1';
        setTimeout(() => this.querySelector('.figure .figure__hover-content').style.opacity = '0', 1000);
      };
    }
    
    $(document).ready(function(){
      $("#cursorToBottom").on('click', function(event) {
        if (this.hash !== "") {
          event.preventDefault();
          var hash = this.hash;
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 1300, function(){
            window.location.hash = hash;
          });
        } 
      });
    });


