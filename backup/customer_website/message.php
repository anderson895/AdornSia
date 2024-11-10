<?php
include('components/header.php');
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/chat.css">
<link rel="stylesheet" href="../administrator/admin_view/assets/plugins/alertify/alertify.min.css">






<div class="container" >

<section class="gradient-custom" >
  <div class="container py-2">

    <div class="row">

     

      <div style="border-radius:10px;" class="col-md-6 col-lg-7 col-xl-12 shadow">

      <h2 class="mt-3"><i class="bi bi-chat-right-text"></i> Message</h2>


        <ul class="list-unstyled text-white" >
       
       
        <div class="container mt-4 " id="allMessagesContainer" style="height: 650px; overflow-y: auto;">
   
        </div>


         

          
        <!-- <li class="mb-3 mt-3">
  <div data-mdb-input-init class="form-outline form-white">
    <input hidden type="text" name="mess_sender_id" id="mess_sender_id" value="<?=$_SESSION['acc_id']?>">

    <div class="d-flex flex-column flex-md-row align-items-start">
      <textarea class="form-control me-2 mb-2 mb-md-0" id="sender_Messages" name="sender_Messages" rows="2" style="flex: 1;"></textarea>
      <button type="button" id="btnSentMessage" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-rounded">
        Send
      </button>
    </div>

    <label class="form-label mt-2" for="sender_Messages">Message</label>
    <div id="spinner" class="spinner-border text-primary" role="status" style="display: none;">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</li> -->

<!-- <div class="card-footer">
    <div class="input-group">
        <input hidden type="text" name="mess_sender_id" id="mess_sender_id" value="<?=$_SESSION['acc_id']?>">

        <input type="text" class="form-control type_msg mh-auto empty_check" id="sender_Messages" name="sender_Messages" placeholder="Type your message...">

     
        <button type="button" id="btnSentMessage" class="btn btn-primary btn_send">
        <span class="spinner-border spinner-border-sm" style="display: none;" id="spinner" role="status" aria-hidden="true"></span>
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
    </div>
</div> -->



<div class="card-footer">
    <div class="input-group">
        <div class="input-group-prepend">
            <label for="fileInput" class="btn btn-primary">
                <i class="fa fa-paperclip"></i> &nbsp;
            </label>
            <input type="file" id="fileInput" class="form-control-file" style="display: none;" accept="image/*">
        </div>

        <input hidden type="text" name="mess_sender_id" id="mess_sender_id" value="<?=$_SESSION['acc_id']?>">

        <input type="text" class="form-control type_msg mh-auto empty_check" id="sender_Messages" name="sender_Messages" placeholder="Type your message...">
        <div id="loadingSpinner"></div>
        <button type="button" id="btnSentMessage" class="btn btn-primary btn_send">
            <span class="spinner-border spinner-border-sm" style="display: none;" id="spinner" role="status" aria-hidden="true"></span>
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
    </div>
    
    <div id="fileDisplay" class="mt-2" style="display: none;">
        <span id="fileName">Selected File: </span>
        <div id="imagePreviewContainer" class="border rounded p-2" style="display: none;">
          <div class="d-flex justify-content-center align-items-center">
              <img id="imagePreview" class="img-fluid" style="max-height: 150px;" />
          </div>

        </div>
        <button id="removeFile" class="btn btn-danger mt-2">X</button>
    </div>
</div>




         
        </ul>

      </div>

    </div>

  </div>
</section>

</div>

<?php
include('components/footer.php');
?>
<script src="../administrator/admin_view/assets/plugins/alertify/alertify.min.js"></script>
