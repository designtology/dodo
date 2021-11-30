<script type="text/javascript" src="js/jquery_3.5.1.js"></script>
<script src="js/validator_0.11.9.js"></script>
<script src="js/contact.js"></script>

<script type="text/javascript">




$(window).on('load', function() {





const cookieContainer = document.querySelector(".cookie_message");
const cookieButton = document.querySelector("#cookie_btn");

cookieButton.addEventListener("click", () => {
  cookieContainer.classList.remove("active");
  localStorage.setItem("cookieBannerDisplayed", "true");
});

setTimeout(() => {
  if (!localStorage.getItem("cookieBannerDisplayed")) {
    cookieContainer.classList.add("active");
  }
}, 2000);






  document.getElementsByTagName("body")[0].setAttribute("ontouchstart", "");



  // *****************************

$(document).ready(function() {




  $(document).on('click', ".close", function(){
    $(".messages").hide();
  });

});



// ================= SCROLL TO TOP



      $("#top_btn").click(function() {
          return $(".scroll_wrapper").animate({
              scrollTop: 0
          }),
          !1
      })

// ================= SCROLL TO TOP



var margin_leistungen = $(".leistungen_dropdown").css("margin-top");
var margin_casestudies = $(".casestudies_dropdown").css("margin-top");





  $("#mobile_trigger").on('click', function(event) {

    if($(".mobile_menu").css("left") == "1200px"){
      setTimeout(mobile_display, 1);
      $(".mobile_menu").css("display","block");        
      $(".header").css("height","100%");
      $(".section_name").css("display","none");
    }
    else{
      $(".mobile_menu").css("left","1200px");
      $(".section_name").css("display","block");
      setTimeout(header_height, 500);

    }

    function header_height() {
      $(".header").css("height","0%");
      $(".mobile_menu").css("display","none");
    }

    function mobile_display(){
      $(".mobile_menu").css("left","0px");

    }

  });

});


/****** TABLE SORTING  ********/


 $(document).ready(function(){  
      $(document).on('click', '.sorting', function(){
           var column_name = $(this).attr("aria-label");  
           var order = $(this).data("order");  
           var arrow = '';  
           //glyphicon glyphicon-arrow-up  
           //glyphicon glyphicon-arrow-down  

           if(order == 'desc')  
           {  
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-down"></span>';  
           }  
           else  
           {  
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-up"></span>';  
           }  

           $.ajax({  
                url:"sort.php",  
                method:"POST",  
                data:{column_name:column_name, order:order},  
                success:function(data)  
                {  
                     $('#kundentabelle').html(data);  
                     //$('#'+column_name+'').append(arrow);  
                }  
           })  
      });  

      /*********  ADD POSITION FORM *********/
      var ajax_count = 1;

      $("#add_position_form").click(function(){
        //var count = <?php echo $count++; ?>,
        dataString = "count=" + ajax_count;
        $.ajax({
          type: "POST",
          url: "position_form.php",
          data:dataString,
          success: function(result){
            ajax_count++;
            $("#positions").append(result);
            if($('#project_positions')){
              $('#project_positions').attr('value', ajax_count);
            }
          }
        });
      });

      /************** START TIMER ***************/
      $("[id^=start_timer]").click(function(){
        
        dataString = $(this).attr("data-button") + $(this).attr("data-action");

        $("#stop_timer_"+$(this).attr("value")).css('display','block');    
        $(this).css('display','none');
            
        $.ajax({
          type: "POST",
          url: "set_timer.php",
          data: dataString,
          success: function(result){
            ajax_count++;
            $("#timer_container").append(result);        
          }
          
        });


      });

    if($('#db_start_time')){
      var timer_id = $("#db_start_time").attr("data-id");
      $("#start_timer_"+timer_id).attr("data-action", "&action=auto");
      $("#start_timer_"+timer_id).click();
    }

 });  


  function secondsToDhms(s) {
      var fm = [
                        Math.floor(Math.floor(Math.floor(s/60)/60)/24)%24,      //DAYS
                        Math.floor(Math.floor(s/60)/60)%60,                          //HOURS
                        Math.floor(s/60)%60,                                                //MINUTES
                        s%60                                                                      //SECONDS
                  ];
      return $.map(fm,function(v,i) { return ( (v < 10) ? '0' : '' ) + v; }).join( ':' );
  }


</script>