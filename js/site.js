$(function() {
		$(".search-site").keyup(function(){
    	var siteString = $(this).val(); 
        $.ajax({
            url : siteURl+'/sites?site_search='+siteString
        }).done(function (data) {
            $('.pagination-response').html(data); 
        }).fail(function () {
            alert('Site could not be loaded.');
        }); 
    });
     $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        $('#load a').css('color', '#dfecf6');
        $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="'+siteURl+'/images/ajax-loader.gif" />');
        var url = $(this).attr('href');  
        var pageNo = $(this).attr('href').split('page=')[1]; 
        var SiteString = $('.search-site').val();
        getSites(url,SiteString);
    });
    function getSites(url,SiteString) {
        if(SiteString==''){
            url= url;
        } else {
            url = url+'&site_search='+SiteString ;
        }
        console.log(SiteString);
        $.ajax({
            url : url
        }).done(function (data) {
            $('.pagination-response').html(data); 
           
        }).fail(function () {
            alert('Site could not be loaded.');
        });
    }
});

$(document).on('click','.addservice',function(){
  var siteid =  $(this).attr('siteid');
   $('.subscription_id').val(siteid);
  $.ajax({
            url : siteURl+'/service-popup/'+siteid
        }).done(function (data) {
            $('.service-popup').html(data); 
            $('.suscrip').html('<input id="subscription_id" type="hidden" class="form-control subscription_id" name="subscription_id"  value="'+siteid+'">');
        }).fail(function () {
           alert('Service could not be loaded.');
        }); 

});
$(document).ready(function(){
 /*   $("#addservice").validate({
  submitHandler: function(form) {
    form.submit();
  },
  ignore: [],
  rules: {
    'services[]': {
      required: true
    }
  }
});*/
 $('#addserviceform').validate({ // initialize the plugin 
            rules: {
                "services[]": {
                    required: true
                }
              },
            messages:
                {
                "services[]": "<font color='red'>Please select service<font>"
                }
                
        });
});

$(document).ready(function () {
    $('#add-service').validate({ // initialize the plugin 
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true
                }
                ,
                price: {
                    required: true
                }
                
               
            },
            messages:
                {
                name: "<font color='red'>Please enter service name<font>",
                description: "<font color='red'>Please  enter description<font>",
                price: {required:"<font color='red'>Please Enter price<font>"}
                },
                submitHandler: function(form) {
                      var queryString = $('#add-service').formSerialize(); 
                        $.ajax({
                            url : siteURl+ "/addons", 
                            type: "POST",             
                            data: queryString,
                            cache: false,             
                            processData: false,      
                            success: function(data) {
                                 
                            if($.isEmptyObject(data.error)){
                                    $('.service').html(data.html)
                                    $('#myModal2').modal('hide');
                                }else{
                                    printErrorMsg(data.error);

                                }
                            }
                        });
                    return false;
                }
        });

     

    function printErrorMsg (msg) {

            $(".print-error-msg").find("ul").html('');

            $(".print-error-msg").css('display','block');

            $.each( msg, function( key, value ) {

                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

            });

        }
        /*$('.check-data').click(function(e){
              e.preventDefault();
              var serviceName = $('.service').val();
             if (typeof serviceName =='undefined' || serviceName =='') {
              alert("please select service");
              } else {
                
                $('.check-data').trigger('click');
              }
        });*/
    });
