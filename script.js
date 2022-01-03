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
    function startTimer(secs) {
        var seconds = secs, date;
        setInterval(function () {
            date = new Date(seconds*1000);
            timeHours.textContent = ("0" + date.getUTCHours()).slice(-2);
            timeMinutes.textContent = ("0" + date.getMinutes()).slice(-2);
            timeSeconds.textContent = ("0" + date.getSeconds()).slice(-2);

            if (timeMinutes.textContent % 10 == "1" && timeMinutes.textContent != "11") 
            {
              timeMinutesText.textContent = "минута";
            }          
            else if (timeMinutes.textContent != "12" 
            && timeMinutes.textContent != "13" && timeMinutes.textContent != "14" &&
            timeMinutes.textContent % 10 == "2" || timeMinutes.textContent % 10 == "3" 
            ||timeMinutes.textContent % 10 == "4") 
            {
              timeMinutesText.textContent = "минуты";
            }
            else
            {
              timeMinutesText.textContent = "минут";
            }



            if (timeSeconds.textContent % 10 == "1" && timeSeconds.textContent != "11") 
            {
              timeSecondsText.textContent = "секунда";
            }          
            else if (timeSeconds.textContent != "12" 
            && timeSeconds.textContent != "13" && timeSeconds.textContent != "14" &&
            timeSeconds.textContent % 10 == "2" || timeSeconds.textContent % 10 == "3" 
            ||timeSeconds.textContent % 10 == "4")
            {
              timeSecondsText.textContent = "секунды";
            }
            else
            {
              timeSecondsText.textContent = "секунд";
            }



            if (timeHours.textContent == "0") {
              timeHoursText.textContent = "часов";
            }
            else if (timeHours.textContent == "1") 
            {
              timeHoursText.textContent = "час";
            } 
            else if (timeHours.textContent > 1)
            {
              timeHoursText.textContent = "часа";
            }
            
            if (--seconds < 0) {
                seconds = secs;
            }
        }, 1000);
    }
    
    window.onload = function () {
        var fiveMinutes = 236 * 57;
        startTimer(fiveMinutes);
    };
    
    for (let variable of document.querySelectorAll('.figure')) {
      variable.onclick = function(){
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
          }, 400, function(){
            window.location.hash = hash;
          });
        } 
      });
    });


