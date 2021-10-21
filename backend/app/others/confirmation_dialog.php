
    <script>
      function ConfirmationDialog($request) {
        this.$request = $request;

        this.open_dialog = function() {
          $('#confirmation_dialog').modal('show');
        }

		this.open_dialog();

        this.confirm = function(){
          window.location.href = this.$request;
        } 

      }
    </script>

<!-- Modal -->
<div id="confirmation_dialog" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog" style="display: block;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation </h4>
      </div>
      <center class="modal-body">
        <h2>Are you sure You want to continue? </h2>
      </center>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
         No
        </button>
         <button type="button" class="btn btn-default" onclick="$confirm_dialog.confirm();">
          Yes
        </button>
      </div>
    </div>

  </div>
</div>