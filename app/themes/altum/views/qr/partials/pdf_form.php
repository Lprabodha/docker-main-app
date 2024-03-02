<?php defined('ALTUMCODE') || die() ?>
<?php

$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'pdf') {
  $filledInput = json_decode($data->qr_code[0]['data'], true);
  $qrName = $data->qr_code[0]['name'];
  $qrUid = $data->qr_code[0]['uId'];

  $previewLink = parse_url($filledInput['preview_link2'], PHP_URL_QUERY); // Get query string
  parse_str($previewLink, $params);
  $companyLogo = isset($params['companyLogo']);
  // $pdfFile = $params['pdf'];
  $pdfFile = $filledInput['pdfFile'];
} else {
  $filledInput = array();
  $pdfUrl = "<?php echo SITE_URL;?>uploads/pdf/" . isset($filledInput['uId']) . ".pdf";
  $qrName = null;
  $qrUid = null;
  $pdfFile = null;
}

?>

<style>
  @media (min-width: 481px) {

    .mt-sm-4,
    .my-sm-4 {
      margin-top: 0 !important;
    }
  }

  @media (max-width: 480px) {

    .mt-sm-4,
    .my-sm-4 {
      margin-top: 1.5rem !important;
    }
  }
</style>

<div id="step2_form">
  <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid(); ?>" data-reload-qr-code /> -->
  <input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : ''; ?>" data-reload-qr-code />
  <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : ''; ?>" class="form-control" data-reload-qr-code />
  <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">

  <div class="custom-accodian pdf-upload-main-wrp upload-main-wrp">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrPdf" aria-expanded="true" aria-controls="acc_nameOfQrPdf">
      <div class="qr-step-icon">
        <span class="icon-pdf-up grey steps-icon"></span>
      </div>

      <span class="custom-accodian-heading">
        <span class="accodianRequired"><?= l('qr_step_2_pdf.file') ?><sup>*</sup></span>
        <span class="fields-helper-heading"><?= l('qr_step_2_pdf.help_txt.file') ?></span>
      </span>

      <div class="toggle-icon-wrap ml-2">
        <span class="icon-arrow-h-right grey toggle-icon"></span>
      </div>
    </button>
    <div class="collapse show" id="acc_nameOfQrPdf">
      <hr class="accordian-hr">
      <div class="collapseInner">
        <input type="hidden" name="pdfFile" id="pdfFile" class="anchorLoc" data-anchor="pdf_file" value="<?php echo $pdfFile ? $pdfFile : ''; ?>">

        <div class="custom-upload">
          <div class="dropzone dropzone fileupload col-12 " id="pdf" style="display:<?php echo  $pdfFile ? 'none !important' : 'block '; ?>;">
          </div>
          <!-- <span class="col-lg-12 col-xl-12 error" id="logo-error" style="color:red;"></span> -->
          <div id="img_previews">
          </div>
          <div id="custom-dropzone-preview" class="pdf-dropzone dropzone-previews dropzone col-12 d-flex" style="display:<?php echo  $pdfFile ? 'block' : 'none !important'; ?>;">
            <!-- <span class="touch-detect "></span> -->
            <?php if ($pdfFile) { ?>
              <div class="dz-preview dz-file-preview dz-complete">
                <div class="dz-image"><img data-dz-thumbnail="" src="./themes/altum/assets/images/pdf.png"></div>
                <span class="hover-effect-icon"></span>
                <div class="upload-edit-wrap pdf-file-edit-upload">
                  <span class="image-edit-icon"></span>
                </div>
                <a class="dz-remove" data-dz-remove=""><?= l('qr_step_2_pdf.delete') ?><span class="dz-remove-icon"></span></a>
              </div>
            <?php } ?>
          </div>

        </div>

        <div class="checkbox-wrapper pdf-direct-show">
          <div class="roundCheckbox m-2 mr-3">
            <input type="checkbox" id="direct_pdf" name="direct_pdf" data-reload-qr-code <?php echo (!empty($filledInput)) ? ((isset($filledInput['direct_pdf'])) ? 'checked' : '') : ''; ?> />
            <label class="m-0" for="direct_pdf"></label>
          </div>
          <label class="passwordlabel mb-0"><?= l('qr_step_2_pdf.file_show') ?></label>
        </div>
      </div>
    </div>
  </div>

  <!-- add color palette -->
  <?php include_once('components/design-2-color.php'); ?>

  <div class="custom-accodian consider pdf-info-main-wrp">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_pdfInformation" aria-expanded="true" aria-controls="acc_pdfInformation">
      <div class="qr-step-icon">
        <span class="icon-info grey steps-icon"></span>
      </div>

      <span class="custom-accodian-heading">
        <span><?= l('qr_step_2_pdf.file_information') ?></span>
        <span class="fields-helper-heading"><?= l('qr_step_2_pdf.help_txt.file_information') ?></span>
      </span>

      <div class="toggle-icon-wrap ml-2">
        <span class="icon-arrow-h-right grey toggle-icon"></span>
      </div>
    </button>
    <div class="collapse show" id="acc_pdfInformation">
      <hr class="accordian-hr">
      <div class="collapseInner">

        <div class="form-group step-form-group mb-4">
          <label for="company" class="formLabel"> <?= l('qr_step_2_pdf.input.company') ?> </label>
          <input id="company" placeholder="<?= l('qr_step_2_pdf.input.company.placeholder') ?>" name="company" class="form-control anchorLoc" data-anchor="company" value="<?php echo (!empty($filledInput)) ? $filledInput['company'] : ''; ?>" data-reload-qr-code />
        </div>

        <div class="form-group step-form-group mb-4">
          <label for="pdftitle" class="formLabel"> <?= l('qr_step_2_pdf.input.pdf_title') ?></label>
          <input id="pdftitle" placeholder="<?= l('qr_step_2_pdf.input.pdftitle.placeholder') ?>" name="pdftitle" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['pdftitle'] : ''; ?>" data-reload-qr-code />
        </div>

        <div class="form-group step-form-group mb-4">
          <label for="description" class="formLabel"> <?= l('qr_step_2_pdf.input.description') ?></label>
          <input id="description" placeholder="<?= l('qr_step_2_pdf.input.description.placeholder') ?>" name="description" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['description'] : ''; ?>" data-reload-qr-code />
        </div>

        <div class="form-group step-form-group mb-4">
          <label for="website" class="formLabel"> <?= l('qr_step_2_pdf.input.website') ?></label>
          <input id="website" type="url" name="website" placeholder="<?= l('qr_step_2_pdf.input.website.placeholder') ?>" data-anchor="website" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['website'] : ''; ?>" data-reload-qr-code />
        </div>

        <div class="form-group step-form-group m-0">
          <label for="button" class="formLabel"> <?= l('qr_step_2_pdf.input.button') ?></label>
          <input id="button" name="button" placeholder="<?= l('qr_step_2_pdf.input.button.placeholder') ?>" data-anchor="website" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['button'] : ''; ?>" data-reload-qr-code />
        </div>
      </div>
    </div>
  </div>

  <!-- fonts  -->
  <?php include_once('components/fonts.php'); ?>


  <!-- Welcome Screen sections -->
  <?php include_once('components/welcome-screen.php'); ?>

  <!-- Name sections -->
  <?php include_once('components/qr-name.php'); ?>

  <!-- password sections -->
  <?php include_once('components/password.php'); ?>

  <!-- Folder sections -->
  <?php include_once('components/folder.php'); ?>

</div>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
  var base_url = '<?php echo UPLOADS_FULL_URL; ?>';
  var isPdf = false;

  $(document).on('change', '#website', function() {
    var website = $("input[name=\"website\"]").val();

    if (website) {
      if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(website)) {
        // $("#website").css("border", "2px solid #96949C");
        $("#website").css("border", "");
        $('#website').parent().find(".invalid_err").remove();
      } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(website)) {
        $("#website").css("border", "");
        $('#website').parent().find(".invalid_err").remove();
      } else {
        $('#website').parent().find(".invalid_err").remove();
        allAreFilled = false;
        $("#website").css("border", "2px solid red");
        $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#website"));
      }

    } else {
      $('#website').parent().find(".invalid_err").remove();
      $("#website").css("border", "");
    }

  });


  $(".dz-remove").on("click", function() {
    $("#pdfFile").val("");
    $("#custom-dropzone-preview").attr('style', 'display:none !important');
    $(".dz-preview").remove();
    $("#2").attr("disabled", false);
    $("#2").addClass("disable-btn");
    $("#pdf").show();
    $('.consider').show();
    $("#preview_qrcode").removeClass('direct-pdf-qr-preview');
    $("#direct_pdf").prop("checked", false);
    window.isPdf = false;
    LoadPreview(true);
    $(this).remove();
  });

  var currentPos;
  $(document).on("input", '.anchorLoc', function(e) {
    if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {

    } else {
    currentPos = e.target.getAttribute('data-anchor');
    }
  });

  $(document).on("click", '.anchorLocBtn', function(e) {
    if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {

    } else {
      currentPos = e.target.getAttribute('data-anchor');
      // console.log($(this).data('anchor'))
      console.log(currentPos);
    }
  });

  // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/pdf';

  document.getElementById('iframesrc').setAttribute('isDPDF', false);

  function LoadPreview(welcome_screen = false, showLoader = true, changeAnc = null) {

    if (showLoader){}
      // setFrame();

    let uId = document.getElementById('uId').value;
    let company = document.getElementById('company').value.replace(/&/g, '%26');
    let pdftitle = document.getElementById('pdftitle').value.replace(/&/g, '%26');
    let primaryColor = document.getElementById('primaryColor').value;
    let SecondaryColor = document.getElementById('SecondaryColor').value;
    let description = document.getElementById('description').value.replace(/&/g, '%26');

    var webValue = document.getElementById('website').value.replace(/&/g, '%26');
    var website = set_url(webValue);

    let button = document.getElementById('button').value.replace(/&/g, '%26');
    let font_title = document.getElementById('filters_title_by').value;
    let font_text = document.getElementById('filters_text_by').value;
    let direct_pdf = document.getElementById("direct_pdf").checked;
    var defImg = `<?php echo LANDING_PAGE_URL; ?>` + `/pdf.jpg`;
    var screen = document.getElementById("editscreen").value;

    // Only show QR code in less than 1200px
    if (window.innerWidth < 1200) {
      if (direct_pdf) {
        $("#1").removeClass("active");
        $("#1").addClass("d-none");
        $("#2").addClass("active");
        $('#qr-code-wrap').addClass('active');
        $("#tabs-1").removeClass('active');
        $("#tabs-2").addClass('active');
        $("#preview_qrcode").css({
          'width': '102px',
          'margin': '0 auto 0 auto !important',
        });
      } else {
        $("#1").addClass("active");
        $("#1").removeClass("d-none");
        $("#2").removeClass("active");
        $("#preview_qrcode").css({
          'width': '192px'
        });
      }
    }

    var files = myDropzone.getAcceptedFiles();

    var pdfUrl = document.getElementById('pdfFile').value;

    if (pdfUrl == "") {
      isPdf = false;
      $("#2").addClass('disable-btn');
      $("#2").attr('disabled', true);
      $("#tabs-1").addClass('active');
      $("#tabs-2").removeClass('active');
      $("#1").addClass('active');
      $("#2").addClass('no-files');
      $("#2").removeClass('active');
      $("#direct_pdf").attr('disabled', true);
      $("#direct_pdf").prop("checked", false);
      $(".checkbox-label").css("color", "#a3abad");
      $(".checkbox-label-direct").css("border", "1px solid #a3abad");
      $(".checkbox-label-direct").css("cursor", "auto");
    } else {
      isPdf = true;
      $('#qr-code-wrap').addClass('active');
      // $("#2").removeClass('disable-btn');
      $("#2").attr('onclick', 'save_qr_fn()');
      $("#2").removeClass('no-files');
      $("#2").attr('disabled', false);
      $("#2").removeClass("disable-btn");
      $("#direct_pdf").attr('disabled', false);
      $(".checkbox-label").css("color", "#767c83");
      $(".checkbox-label-direct").removeAttr('style');
    }

    // Only show QR code preview on mobile devices
    if (window.innerWidth < 1200) {
      if (direct_pdf) {
        $("#1").removeClass("active");
        $("#1").addClass("d-none");
        $("#2").addClass("active");
        $('#qr-code-wrap').addClass('active');
        $("#tabs-1").removeClass('active');
        $("#tabs-2").addClass('active');
        $("#preview_qrcode").css({
          'width': '102px',
          'margin': '0px auto',
        });
      } else {
        $("#1").addClass("active");
        $("#1").removeClass("d-none");
        $("#2").removeClass("active");
        $("#preview_qrcode").css({
          'width': '192px'
        });
      }
    }

    if (company == '' && pdftitle == '' && description == '' && pdfUrl == '' && website == '' && button == '') {
      company = '<?= l('qr_step_2_pdf.lp_def_company') ?>';
      pdftitle = '<?= l('qr_step_2_pdf.lp_def_pdftitle') ?>';
      description = '<?= l('qr_step_2_pdf.lp_def_description') ?>';
      button = '<?= l('qr_step_2_pdf.lp_def_button') ?>';
      website = '#'
    }
    
    const PreviewData = {
      live: true,
      company: company,
      pdftitle: pdftitle,
      directly_show_pdf: direct_pdf || "",
      primaryColor: primaryColor,
      SecondaryColor: SecondaryColor,
      description: description,
      font_title: font_title,
      font_text: font_text,
      screen: !welcome_screen ? false : screen,
      button: button,
      pdf: pdfUrl,
      website: website,
      defImg: defImg,
      change: changeAnc || currentPos,
      step:2,
      type:'pdf',
      static:false
    }

    if(PreviewData.directly_show_pdf && PreviewData.pdf){

      document.getElementById('iframesrc').setAttribute('isDPDF',true);
      document.getElementById('iframesrc').contentWindow.location.replace(PreviewData.pdf);

    }else{

      if(document.getElementById('iframesrc').getAttribute('isDPDF') == 'true'){

        document.getElementById('iframesrc').removeAttribute('isDPDF');
        document.getElementById('iframesrc').contentWindow.location.replace('<?=LANDING_PAGE_URL?>preview?preview=true&type=pdf');
        document.getElementById('iframesrc').onload = (e)=>{
          setTimeout(()=>{
            document.getElementById('iframesrc').contentWindow.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');
          },1000)
        }

      }else{
        document.getElementById('iframesrc').contentWindow.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');
      }
    }

    let im_url = $('#qr_code').attr('src');
    if ($(".qrCodeImg")) {
      $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
    }

  }
  
  if($('#qr_status').val()) {
    if(document.getElementById("direct_pdf").checked){
      document.getElementById('iframesrc').contentWindow.location.replace(document.getElementById('pdfFile').value);
      document.getElementById('iframesrc').setAttribute('isDPDF',true);
    }else{
      $('#iframesrc').ready(function(){
        setTimeout(()=>{
          LoadPreview()
        },1000)
      })
    }
  }

</script>
<!-- for passing language variables to qr_form.js -->
<?php
$langVariables = array(
  l('qr_step_2_com_welcome_screen.max_size_allowed_10mb'),
  l('qr_step_2.max_allow_10mb.error'),
  l('qr_step_2.loading')
);
$langVariablesJson = json_encode($langVariables);
?>
<script site-url="<?php echo UPLOADS_FULL_URL; ?>" lang-variables="<?= htmlspecialchars($langVariablesJson, ENT_QUOTES, 'UTF-8'); ?>" src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>
<script>
  <?php if (isset($filledInput['direct_pdf'])) { ?>
    <?php if ($filledInput['direct_pdf'] == 'on') { ?>
      $('.consider').hide();
    <?php } else { ?>
      $('.consider').show();
    <?php } ?>
  <?php } ?>

  $(document).on('change', '#direct_pdf', function() {
    if ($(this).is(":checked")) {
      $('.consider').hide();
      $("#preview_qrcode").addClass('direct-pdf-qr-preview');
    } else {
      $('.consider').show();
      $("#preview_qrcode").removeClass('direct-pdf-qr-preview');
    }

    LoadPreview();

  });

  <?php

  if (!empty($filledInput)) {
  ?>
    $(".before-upload").hide();
    $(".after-upload").show();
  <?php
  }
  ?>


  function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes'

    const k = 1024
    const dm = decimals < 0 ? 0 : decimals
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
  }


  $(document).on("change", "#pdf", function() {
    var files = document.getElementById("pdf").files;
    var fileName = (files[0].name).length > 65 ? (files[0].name).substring(0, 65) + "..." : (files[0].name);

    $("#file-size").text("Size: " + formatBytes(files[0]["size"]))
    $(".after-upload").show();
    $(".after-upload").find('span').html(fileName)
    $(".before-upload").hide();
  })


  // qr-code-preview by webethics



  var imageArray = [];
  var ImagesUploading = false;
  let uId = document.getElementById('uId').value;
  var isSuccess = false;
  var isNotError = true;

  var myDropzone = new Dropzone("div#pdf", {

    url: '<?= url('qr-code-generator') ?>',
    paramName: "pdf",
    previewsContainer: ".dropzone-previews",
    init: function() {
      this.on("complete", function(file) {
        if ($(window).width() < 567) {
          $(".dz-remove").appendTo(".pdf-dropzone");
        }
        $(".dz-remove").text("<?= l('qr_step_2_pdf.delete') ?>");
        $(".dz-remove").append('<span class="dz-remove-icon"></span>');
        $(".dz-image img").attr("src", "./themes/altum/assets/images/pdf-up.png")
      });

      this.on('addedfile', function(file) {
        while (this.files.length > this.options.maxFiles) this.removeFile(this.files[0]);
        $(".dz-remove").text("<?= l('qr_step_2_pdf.delete') ?>");
        $(".dz-remove").append('<span class="dz-remove-icon"></span>');
        $("#custom-dropzone-preview").removeAttr('style');
        $("#2").attr("disabled", false);
        $("#2").removeClass("disable-btn");
      });
    },
    renameFile: function(file) {
      let newName = new Date().getTime() + '_' + file.name.replaceAll(" ", "-");
      return newName;
    },
    sending: function(file, xhr, formData) {
      $('#loader.qr').fadeIn(); +
      $('#qr-code-wrap').fadeOut();

      if ($('#custom-dropzone-preview').children(".dz-preview").length > 1) {
        $('#custom-dropzone-preview').children(".dz-preview").last().remove();
      }
      myDropzone.removeAllFiles();

      let form = document.querySelector('form#myform');
      let form_data = new FormData(form);
      for (var pair of form_data.entries()) {
        formData.append(pair[0], pair[1]);
      }
      var imageId = Date.now();
      imageArray[file.upload.filename] = imageId;
      formData.append("imageID", imageId);
      formData.delete("screen");
    },
    acceptedFiles: ".pdf",
    maxFilesize: 100, //2 MB
    maxFiles: 1,
    processing: function() {
      $(".preview-qr-btn").attr("disabled", true);
      ImagesUploading = true;
      $("#temp_next").attr("disabled", true);
      if (isNotError) {
        $(".invalid_err").first().text("");
      }
      this.options.autoProcessQueue = true;
    },
    removedfile: function(file) {
      $('.consider').show();
      $("#preview_qrcode").removeClass('direct-pdf-qr-preview');
      $("#pdfFile").val("");
      var fileNames = file.upload.filename;

      fileLinks = "pdf/" + uId + ".pdf";

      formData = new FormData();
      formData.append('action', 'deleteFiles');
      formData.append('fileLinks', fileLinks);

      $.ajax({
        type: 'POST',
        method: 'post',
        url: '<?php echo url('api/ajax') ?>',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
      })
      delete imageArray.fileNames;
      file.previewElement.remove();
      removedfile = true;
      if (myDropzone.getAcceptedFiles().length <= 0) {
        $("#custom-dropzone-preview").attr('style', 'display:none !important');
        $('#qr-code-wrap').html("");
        $("#is_pdf").val(0);

      }
      $(".custom_error").remove();
      $(".invalid_err").remove();
      LoadPreview(undefined, false);
      $("#pdf").show();
    },
    queuecomplete: function(files) {
      $(".preview-qr-btn").attr("disabled", false);
      ImagesUploading = false
      $("#temp_next").attr("disabled", false);
      if (isSuccess || isNotError) {
        LoadPreview(undefined, false);
      }

      isSuccess = false;
      isNotError = true;

    },
    addRemoveLinks: true,
    success: function(file, responseText) {

      isSuccess = true;
      var responseText = JSON.parse(responseText); +
      $('#qr-code-wrap').html(responseText.details.image);

      document.querySelector('#download_svg').href = responseText.details.data;
      if (document.querySelector('input[name="qr_code"]')) {
        document.querySelector('input[name="qr_code"]').value = responseText.details.data;
      }

      var fileNames = file.upload.filename;

      fileLinks = "pdf/" + uId + ".pdf";

      if (fileLinks) {
        $('input[name="pdfFile"]').val(base_url + fileLinks);
        LoadPreview(true);
        $("#is_pdf").val(1);
      }


      $("#pdf .dz-message").append("<div class=\" custom_error text-danger\" style='margin-top:0px;'><?= l('qr_step_2_pdf.file_replace_error') ?></div>")
      $("#pdf").hide();
      $('#loader.qr').fadeOut(); +
      $('#qr-code-wrap').fadeIn();

      $(file.previewElement).append('<span class="hover-effect-icon"></span>');
      $(file.previewElement).append('<div class="upload-edit-wrap pdf-file-upload"></div>');
      $(file.previewElement).children(".upload-edit-wrap").append('<span class="image-edit-icon"></span>');
    },
    error: function(file, response) {
      isNotError = false;
      $(".preview-qr-btn").attr("disabled", false);
      file.previewElement.remove();
      var fileNames = file.upload.filename
      delete imageArray.fileNames;



      if (myDropzone.getAcceptedFiles().length <= 0) {
        $("#custom-dropzone-preview").attr('style', 'display:none !important');
      }


      var errorAreas = document.getElementsByClassName("invalid_err");
      if (errorAreas[0]) {
        if (response == "You can not upload any more files.") {
          $(errorAreas[0]).text("<?= l('qr_step_2_pdf.max_pdf') ?>");
        } else {
          $(errorAreas[0]).text("<?= l('qr_step_2_pdf.max_allowed') ?>");
        }
      } else {
        if (response == "You can not upload any more files.") {
          $("#pdf").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_pdf.max_pdf') ?></span>");
        } else {
          $("#pdf").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_pdf.max_allowed') ?></span>");
        }
      }
    },
  });

  $(document).on('click', '.pdf-file-upload, .pdf-file-edit-upload, .hover-effect-icon', function() {
    $("#pdf").trigger("click");
  });

  $(".dz-button").text("<?= l('qr_step_2_pdf.file_upload') ?>");
  $(".dz-button").after("<p style='color: #220E27;margin-top: 16px;font-size: 13px;line-height: 18px;  '><strong><?= l('qr_step_2_pdf.mx_file') ?></strong></p>");


  $(document).on('click', '.pdf-upload-main-wrp .dz-button', function() {
    setInterval(function() {
      checkPdf();
    }, 1000);
  });

  $(document).ready(function() {
    checkPdf();
  });

  function checkPdf() {
    var pdfFile = $("#pdfFile").val();
    if (pdfFile == "") {
      $(".pdf-direct-show").css({
        'opacity': '0.3'
      });
      $("#direct_pdf").attr("disabled", true);
    } else {
      $(".pdf-direct-show").css({
        'opacity': '1'
      });
      $("#direct_pdf").attr("disabled", false);
    }
  }
</script>