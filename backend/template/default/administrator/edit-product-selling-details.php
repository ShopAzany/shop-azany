<?php
    $page_title = "Edit Products";
    $active_page = "pro_manager";
    include("includes/header.php");
    $proNav = 'pro-price';
?>
<link rel="stylesheet" type="text/css" href="<?=$this_folder?>assets/css/simplemde.min.css">


    <div class="page-content">

      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
        </ol>
      </nav>

      <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          Admin deleted successfully
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-md-12 grid-margin">
          
          <div class="tabSide mb-4">
            <div class="card card-body p-0" style="border: 2px solid #E51924; border-radius: 0px">
                <?php
                  include('includes/edit-product-nav.php');
                ?>
            </div>
          </div>


          

          <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/update_edited_pro_pricing" id="formPrice">
            <input type="hidden" name="pid" value="<?=$product->pid?>">
            <input type="hidden" name="sellerID" value="<?=$product->seller_id?>">
            
            <div class="table-respinsive">
              <table class="table table-bordered" style="border: 1px solid red">
                <thead style="background: red">
                  <tr style="padding: 0px">
                      <th style="min-width: 200px" class="text-white">Variation*</th>
                      <th class="text-white">Quantity*</th>
                      <th class="text-white">Regular Price</th>
                      <th class="text-white">Sale Price</th>
                      <!-- <th class="text-white">Sale Start Date</th>
                      <th class="text-white">Sale End Date</th> -->
                      <th class="text-white">opt</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($proVariations as $varia): ?>
                  <tr>
                    <td>
                      <select class="form-control custom-select" name="" style="background: #fff" id="selectID">   

                        <option selected value="<?=$varia->name?>,<?=$varia->value?>"><?=$varia->value?></option>

                        <?php foreach ($getVariation as $variation): ?>
                        <optgroup label="<?=$variation->name?>" style="background: red; color: #fff"></optgroup>
                          <?php foreach ($variation->values as $value): ?>
                            <option value="<?=$variation->name?>,<?=$value?>"><?=$value?></option>
                          <?php endforeach ?>
                        <?php endforeach ?>
                      </select>
                    </td>
                    
                    <td>
                      <input type="hidden" name="" class="form-control" id="pVarID" value="<?=$varia->id?>">
                      <input type="number" name="" class="form-control" id="qty" value="<?=$varia->quantity?>">
                    </td>
                    <td>
                      <input type="number" name="" class="form-control" id="reg_price" 
                        onchange="check(this, 'reg')" value="<?=$varia->regular_price?>">
                    </td>
                    <td>
                      <input type="number" name="" class="form-control" id="salePrice" 
                        onchange="check(this, 'sale')" value="<?=$varia->sales_price?>">
                    </td>
                    <td>
                        <button type="button" onclick="deleteProd(<?=$varia->id?>)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </tbody>

                <tbody id="first_bank" class="firstBankDel"></tbody>
              </table>
            </div>
            
            <div class="d-flex justify-content-between mt-5">
              <div>
                <button type="button" class="btn btn-success waves-effect waves-light" id="moreFirst_bank">
                  <span class="btn-label"><i class="fa fa-plus"></i></span>Add More
                </button>
              </div>
            </div>


            <div class="mt-5">
              <p class="text-danger"><b><i class="fa fa-exclamation-circle"></i> Azany charges a tax of 10% on price of products</b></p>

              <h5 class="text-muted mt-2 mb-2">Return Policy</h5>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" <?php if($product->domestic_policy) { ?> checked <?php } ?> id="domestic_policy" name="domestic_policy" value="1">
                  <label class="custom-control-label mb-0" for="domestic_policy">Domestic Return Accepted</label>
                </div>
              </div>


              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" <?php if($product->inter_policy) { ?> checked <?php } ?> id="inter_policy" name="inter_policy" value="1">
                  <label class="custom-control-label" for="inter_policy">International Return Accepted</label>
                </div>
              </div>

              <p class="text-muted"><i class="fa fa-exclamation-circle"></i> No payment will be received until a return option is specified</p>
            </div>

            <div class="mt-4 text-center">
                <button class="btn btn-primary rounded-0 pt-3 pb-3" type="submit">SAVE AND CONTINUE</button>
            </div>  
          </form>

        </div>
      </div>

    </div>

    <?php
      include("includes/footer.php");
    ?>
  
  </div>
</div>



<!-- The Modal -->
<div class="modal" id="deleVariationModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="text-center">
            <p class="mb-3">Are you sure you want to delete this variation</p>

            <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/delete_variation">
                <input type="hidden" name="proVarID" id="inputID">
                <input type="hidden" name="proID" value="<?=$product->pid?>">
                <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
                <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
            </form>
        </div>
      </div>

    </div>
  </div>
</div>


<script src="<?=$this_folder?>/assets/js/core.js"></script>
<!-- <script src="<?=$this_folder?>/assets/js/tinymce.min.js"></script> -->
<script src="https://www.nobleui.com/html/template/assets/vendors/tinymce/tinymce.min.js"></script>

<script src="<?=$this_folder?>/assets/js/simplemde.min.js"></script>
<script src="<?=$this_folder?>/assets/js/ace.js"></script>
<script src="<?=$this_folder?>/assets/js/theme-chaos.js"></script>


<script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
<script src="<?=$this_folder?>/assets/js/template.js"></script>

<script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
<script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
<script src="<?=$this_folder?>/assets/js/ace.js"></script>

<script>
    $(document).ready(function(){

      var clickCounts = 0;
      var countFirst = 0;
      var countGt = 0;
      var countUBA = 0;
      var countZenith = 0;  
      var countUse = 0;

      document.querySelector('#selectID').name = `theVariation[${countUse}][variation]`;
      document.querySelector('#qty').name = `theVariation[${countUse}][quantity]`;
      document.querySelector('#reg_price').name = `theVariation[${countUse}][regular_price]`;
      document.querySelector('#salePrice').name = `theVariation[${countUse}][sales_price]`;
      document.querySelector('#pVarID').name = `theVariation[${countUse}][pVarID]`;

      
      $('#moreFirst_bank').click(function(){
        countFirst++;
        countUse = countFirst;
          
        $('#first_bank').append('<tr class="removeFirstBank"><td><select class="form-control custom-select"  name="theVariation['+countUse+'][variation]" style="background: #fff">   <option hidden>--- Select ---</option><?php foreach ($getVariation as $variation): ?><optgroup label="<?=$variation->name?>" style="background: red; color: #fff"></optgroup><?php foreach ($variation->values as $value): ?><option value="<?=$variation->name?>,<?=$value?>"><?=$value?></option><?php endforeach ?><?php endforeach ?></select></td> <td>    <input type="number" name="theVariation['+countUse+'][quantity]" class="form-control"></td><td>    <input type="number" name="theVariation['+countUse+'][regular_price]" class="form-control"></td><td>    <input type="number" name="theVariation['+countUse+'][sales_price]" class="form-control"></td><td>    <button type="button" class="btn btn-warning btn-sm deleteFirstbank">        <i class="fa fa-trash"></i>    </button></td></tr>'); 
      }); 

      $('.firstBankDel').on("click", ".deleteFirstbank", function(e) {
          e.preventDefault();
          $(this).parents('.removeFirstBank').remove();
          countFirst--;
      });

      


    });
    function deleteProd(getID) {
        $("#deleVariationModal").modal();
        document.getElementById("inputID").value = getID;
    }
</script> 

</body>
</html>