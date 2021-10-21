<style>
  #gitstar-notification{
    position: fixed;
    top: 10px;
    z-index: 99999999999999;
    width: 306px;
    margin-left: -151px;
    left: 50%;
   display: none;
}
</style>

<center>  
  <div id="gitstar-notification"  class="alert alert-info alert-dismissible" >
    <a href="javascript:void;" class="close" onclick="document.getElementById('gitstar-notification').style.display='none'">&times;</a>
        <!-- <strong><i class='fa fa-bell fa-2x pull-left'> </i></strong>  -->
	
	<span id="error_note"></span>    
  </div>
</center>






	<script>
		notify = function () {
  $.ajax({
            type: "POST",
            url: "<?=$domain;?>/home/flash_notification/",
            cache: false,
            success: function(data) {

          let $type = '';
				let $error_note = '';
				for (var i = 0; i < data.length; i++) {
					$error_note += data[i]['message'] +'<br>';
          $type = data[i]['title'];
				}

				if ($error_note != '') {

		      show_notification($error_note, $type);
				}




            },
            error: function (data) {
                 //alert("fail"+data);
            }

            

        });

		}


show_notification = function ($notification, $type) {
$('#error_note').html($notification);
    $('#gitstar-notification').css('display', 'block');
    $('#gitstar-notification').attr('class', 'alert alert-'+$type+' alert-dismissible');
  }

notify();



    
	</script>