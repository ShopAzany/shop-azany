<?php
    $page_title = "FAQ";
    $active_page = "con_manager";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropzone.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropify.min.css">
<link rel="stylesheet" type="text/css" href="<?=$this_folder?>assets/css/simplemde.min.css">

<style>
  .file-icon p{
    font-size: 17px !important
  }
  .hwBox{
    background: #f2f2f2; 
    border: 1px solid #ccc
  }
  #isSubmitting{
    display: none;
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">FAQs</li>
    </ol>
  </nav>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Frequently ask quetion <strong>successful</strong> added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Frequently ask quetion  <strong>successfully</strong> deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Frequently ask quetion <strong>successfully</strong> updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>




  <section id="HowItWork">
    <div class="card">
      <div class="card-body p-2">
        <div class="d-flex justify-content-between">
          <div>
            <h6 class="card-title mb-0 mt-2">Frequently Ask Question</h6></div>
          <div>
          <button class="float-right btn btn-primary" data-toggle="modal" data-target="#addHowWork">Add More</button>
          </div>
        </div>
      </div>
    </div>


    <div id="accordion">

      <?php foreach ($faqs as $faq): $count += 1; ?>
      <div class="card mt-3">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>
              <a class="card-link" data-toggle="collapse" href="#collapseOne_<?=$faq->id?>">
                <div><?=ucwords($faq->question)?></div>
              </a>
            </div>

            <div class="pull-right">
              <?php if($faq->status == 1) { ?>
                <button class="btn btn-success btn-sm">Active</button>
              <?php } else { ?>
                <button class="btn btn-info btn-sm">Pending</button>
              <?php } ?>

              <button id="notSubmitting" class="btn btn-primary btn-sm" onclick="editFaqButton(<?=$faq->id?>)"><i class="fa fa-edit"></i></button>
              <button id="isSubmitting" class="btn btn-primary btn-sm"><i class="fa fa-spinner fa-spin"></i></button>

              <button class="btn btn-danger btn-sm" onclick="deleteFaq(<?=$faq->id?>)"><i class="fa fa-trash"></i></button>
            </div>
          </div>
              
        </div>
        <div id="collapseOne_<?=$faq->id?>" class="collapse <?php if($count == 1) { ?> show <?php } ?>" data-parent="#accordion">
          <div class="card-body">
            <?=$faq->answer?>
          </div>
        </div>
      </div>
      <?php endforeach ?>

    </div>

  </section>

</div>


<!-- Add How It work Modal -->
<div class="modal" id="addHowWork">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Add FAQ</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/add_faq" enctype="multipart/form-data">
          
          <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" class="form-control">
          </div>

          <div class="form-group">
            <label>Answer</label>
            <textarea rows="12" class="form-control" name="answer"></textarea>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-primary pt-2 pb-2">ADD FAQ</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>







<!-- Edit How It work Modal -->
<div class="modal" id="editFaq">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Edit FAQ</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/update_faq" enctype="multipart/form-data">
          
          <input type="hidden" name="id" id="faqID">

          <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" class="form-control" id="questionID">
          </div>

          <div class="form-group">
            <p>Status</p>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="active" name="status" value="1">
              <label class="custom-control-label" for="active">Active</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="pending" name="status" value="0">
              <label class="custom-control-label" for="pending">Pending</label>
            </div>
          </div>

          <div class="form-group">
            <label>Answer</label>
            <textarea rows="12" class="form-control" name="answer" id="answerID"></textarea>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-primary pt-2 pb-2">Update</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="delModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="text-center">Are you sure you want to delete this FAQ?</p>
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/delete_faq" enctype="multipart/form-data">
          <input type="hidden" name="id" id="inputID">
          <div class="text-center mt-4">
            <button class="btn btn-success mr-3 btn-sm" type="submit">YES</button>
            <button class="btn btn-danger ml-3 btn-sm" type="button" data-dismiss="modal">NO</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>



<?php
    include("includes/footer.php");
?>
  
    </div>
  </div>

  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropzone.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropify.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>

  <script src="<?=$this_folder?>/assets/js/dropzone.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropify.js"></script>

  <script src="https://www.nobleui.com/html/template/assets/vendors/tinymce/tinymce.min.js"></script>

  <script src="<?=$this_folder?>/assets/js/simplemde.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>
  <script src="<?=$this_folder?>/assets/js/theme-chaos.js"></script>

  <script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
  <script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>

<script>

function deleteFaq(arg) {
  document.getElementById('inputID').value = arg;
  $("#delModal").modal();
  console.log(arg);
}


function editFaqButton(faqID) {
  document.getElementById("isSubmitting").style.display = "inline";
  document.getElementById("notSubmitting").style.display = "none";
  console.log('ghjkl');

  $.ajax({
    url: "<?=Config::ADMIN_BASE_URL()?>content_manager/get_faq/" + faqID,
    type: "Get",
    success: function(data){
      data = data.split('|');
      if(data && Number(data[0]) == 1) {
        document.getElementById("faqID").value = data[1];
        document.getElementById("questionID").value = data[2];
        document.getElementById("answerID").value = data[3];
        if (data[4] == 1) {
          document.getElementById("active").checked = true;
        } else if(data[4] == 0){
          document.getElementById("pending").checked = true
        }
        

        $("#editFaq").modal();
      } else {
        window.alert('Oops, Error in getting your how it works content. Please try again');
      }
    }         
  });

  document.getElementById("isSubmitting").style.display = "none";
  document.getElementById("notSubmitting").style.display = "inline";
}
</script>
</body>
</html>