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