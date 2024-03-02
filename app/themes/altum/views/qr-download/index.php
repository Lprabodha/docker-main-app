<?php defined('ALTUMCODE') || die() ?>


<style>
  .qrCodeImg {
    /* border: 3px solid #F5F8FB; */
    display: grid;
    place-items: center;
    border-radius: 16px;
    padding: 20px;
    max-width: 100%;
    width: 320px;
    padding: 0px;
    margin: auto;
    padding-bottom: 20px;
  }

  .qrCodeImg .embed {
    display: block;
    max-width: 100%;
    height: auto;
    width: 320px;
  }

  .qr-container {
    max-width: 360px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .btn {
    outline: 0;
    text-align: center;
    font-size: 20px;
    border-radius: 32px;
    text-decoration: none;
    min-width: unset !important;

  }

  .qr-fill-btn {
    background-image: linear-gradient(133deg, #28c254, #25b567);
    border: 0;
    color: white;
    padding: 12px 9px;
  }

  .qr-outlined-btn {
    border: 1px solid #25b533;
    background-color: white;
    color: #25b533;
    padding: 12px 9px;
  }

  .qr-code-download-btn {
    width: calc(100% - 100px);
    margin-top: 30px;
    /* font-size: 23px; */
    display: block;
    /* margin: 16px auto 0; */

  }
  .qr-code-detail-btn:not(:lang(en)),
  .qr-code-download-btn:not(:lang(en)) {
    width: max-content;
    padding:9px 12px;
    
  }
  .qr-code-detail-btn {
    width: calc(100% - 100px);
    margin-top: 30px;
    /* font-size: 23px; */
    display: block;
    /* margin: 16px auto 0; */
  }

  .qr-download-row {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .qr-download-wrp {
    height: calc(100vh - 74px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    background-color: white;
  }

  .download-qr-btn,
  .track-qr-btn {
    padding-left: 24px;
    padding-right: 24px;
    font-size: 18px;
    width: 230px;
  }

  @media only screen and (min-width: 375px) {
    .qr-code-detail-btn:not(:lang(en)),
    .qr-code-download-btn:not(:lang(en)) {
      min-width:300px !important;
    }
  }
  @media only screen and (max-width: 375px) {
    .qr-code-detail-btn:not(:lang(en)),
    .qr-code-download-btn:not(:lang(en)) {
      min-width:100% !important;
    }
    .qrCodeImg {
      width: 240px;
    }

    @media (max-height: 640px) {
      .qrCodeImg {
        width: 200px;
      }

    }
  }

  .ready-Use-Modal .modal-header .modal-title {
    font-size: 32px;
    width: 100%;
  }

  .ready-Use-Modal .modal-header {
    padding-top: 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding-left: 30px;
    padding-right: 30px;
  }

  .ready-Use-Modal .modal-header button {
    position: absolute;
    top: 14px;
    right: 14px;
    background-color: #DEDEDE;
    border-radius: 20px;
    font-size: 14px;
    padding: 12px;
  }

  .ready-Use-Modal .text-content-wrp .wrapper .title h2 {
    font-size: 24px;

  }

  .ready-Use-Modal .text-content-wrp .wrapper .bullet-list ul {
    line-height: 2;
  }

  .ready-Use-Modal .text-content-wrp .wrapper .bullet-list ul li {
    position: relative;
    display: flex;
    align-items: center;
    /* line-height: 1.25; */
  }

  .ready-Use-Modal .text-content-wrp .wrapper .bullet-list ul li span {
    margin-right: 10px;
    min-width: 20px;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #28C254;
    border-radius: 10px;
    font-size: 14px;
    color: white;
  }

  .ready-Use-Modal .text-content-wrp .wrapper .bullet-list {
    margin-top: 32px;
  }

  .ready-Use-Modal .text-content-wrp {
    display: flex;
    /* justify-content: center; */
  }

  .disable-share {
    border: 1px solid var(--input-focus-bg) !important;
    background-color: var(--input-focus-bg);
    width: 55px;
    height: 55px;
    padding: 4px;
    pointer-events: none;
  }

  .disable-share .icon-sign-out {
    color: #9DA0B3;
    display: block;
    margin: auto;
    transform: rotate(90deg);
    font-size: 27px !important;
  }

  @media only screen and (max-width: 1199px) {
    .qr-download-wrp {
      height: 100vh;
    }

    .qr-download-row {
      margin-top: 0;
    }
  }

  .-logo-wrapper {
    position: relative;
  }

  @media only screen and (max-width: 1199px) {

    .-logo-wrapper::before {
      bottom: 18px;
      height: 50px;
      width: 25px;
      left: -30px;
      background-repeat: no-repeat;
    }

    .qr-download-wrp {
      margin-top: 74px;
    }
  }

  .-logo-wrapper::before {
    content: "";
    position: absolute;
    background-image: url('<?= ASSETS_FULL_URL . 'images/corners.png' ?>');
    bottom: 37px;
    height: 50px;
    width: 32px;
    left: -42px;
  }

  @media (max-height: 842px) {
    .qr-download-wrp {
      justify-content: flex-start;
    }

    .qr-download-row {
      height: 100%;
    }

    @media only screen and (max-width: 575px) {
      .qr-code-embed {
        width: 240px;
        margin: 0 auto;
        height: auto;
      }
    }
  }

  @media (max-height: 768px) {
    .qr-download-wrp {
      height: calc(100vh + 74px);
    }

    .qr-download-row {
      margin-top: 50px;
      padding-top: 25px;
      padding-bottom: 25px;
      height: auto;
    }

    @media (max-width: 425px) {
      .qr-download-row {
        margin-top: 0;
      }

      .qr-code-download-btn {
        margin-top: 20px;
        width: 300px;
      }

      .qr-code-detail-btn {
        margin-top: 16px;
        width: 300px;
      }

      .qr-fill-btn,
      .qr-outlined-btn {
        padding: 8px 9px;
      }

    }

  }

  @media only screen and (max-width: 1024px) and (min-width: 767.5px) {
    .new-dl-modal>div {
      max-width: 740px;
    }
  }

  @media(max-width:575.98px) {
    .qr-download-wrp {
      height: 100vh !important;
    }
  }

  @media (max-width: 519.5px) {

    .qr-code-detail-btn,
    .qr-code-download-btn {
      width: 248px;
    }

    .qr-code-detail-btn {
      padding-top: 9px !important;
    }

    .ready-Use-Modal .text-content-wrp .wrapper .bullet-list ul li {
      line-height: 1.15;
      margin-bottom: 0.75rem;
      height: 38px;
      font-size: 14px;
    }

    #readyUseModal .modal-footer a {
      width: 300px;
    }
  }

  @media only screen and (max-width: 425px) {
    .ready-Use-Modal .modal-header .modal-title {
      /* width: 240px; */
      font-size: 26px;
      line-height: 1.25;
    }

    .ready-Use-Modal .text-content-wrp .wrapper .title h2 {
      font-size: 20px;
    }

    @media only screen and (max-width: 366px) {

      #readyUseModal .modal-body .text-content-wrp,
      #readyUseModal .modal-body {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
      }

      @media only screen and (max-width: 327px) {
        .ready-Use-Modal .text-content-wrp .wrapper .title h2 {
          font-size: 18px;
        }
      }
    }
  }

  #printFrame {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    max-height: 360px;
    z-index: -99999;
    opacity: 1;
  }

  @media print {
    .qrCodeImg {
      position: relative;
      z-index: 99999;
    }

    .qr-code-detail-btn,
    .qr-code-download-btn,
    .section-navbar {
      display: none;
    }

    body,
    .qrCodeWrap {
      display: block;
    }

    .new-download-modal {
      display: none;
    }
  }

  @media(max-width:576.98px) {
    .qr-container {
      margin-top: -160px;
    }

    #qrCode {
      height: 100%;
      margin-top: 0px;
    }

    #qrCode .qr-container .qrCodeWrap {
      height: 100%;
      display: flex;
      align-items: center;
    }

    .qr-code-embed {
      width: 200px;
      margin: 30px auto 0;
    }

    #readyUseModal .modal-body {
      padding: 8px;
    }
  }

  @media(max-width:367.98px) {
    .ready-Use-Modal .text-content-wrp .wrapper .bullet-list ul {
      padding: 0 8px;
    }
  }
</style>
<div class="container qr-download-wrp">
  <div class="row justify-content-center align-items-center qr-download-row" id="qrCode">
    <div class="col-md-6 qr-container justify-content-center align-items-center">
      <div class="qrCodeWrap">
        <div class="qrCodeImg">
          <embed src="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->qrCode->qr_code ?>?<?= time() ?>" class="qr-code-embed img-fluid" loading="lazy"></embed>
          <!-- <img src="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->qrCode->qr_code ?>?<?= time() ?>" class="qr-code-embed" loading="lazy"></img> -->
        </div>
      </div>
      <button type="button" class="btn qr-code-download-btn qr-fill-btn rounded-pill downloadBtn" data-bs-toggle="modal" data-bs-target="#DownloadModal">

        <!-- Launch static backdrop modal -->
        <span class="icon-download"></span>
        <span><?= l('global.download') ?></span>
      </button>

      <a type="button" class="btn qr-code-detail-btn qr-outlined-btn rounded-pill" href="<?php echo SITE_URL; ?>login?redirect=qr-code/qr-codes"><?= l('qr_download.qr_code') ?>

      </a>
    </div>
  </div>

</div>


<!-- Modal -->
<div class=" modal new-dl-modal fade ready-Use-Modal" id="readyUseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-export">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center " id="staticBackdropLabel"><?= l('qr_download.your_qr_code_modal.title') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 text-content-wrp">
            <div class="wrapper">
              <div class="title">
                <h2><?= l('qr_download.your_qr_code_modal.signin_feature') ?></h2>
              </div>
              <div class="bullet-list">
                <ul>
                  <li><span class="icon-checker"></span><?= l('qr_download.your_qr_code_modal.signin_feature_1') ?></li>
                  <li><span class="icon-checker"></span><?= l('qr_download.your_qr_code_modal.signin_feature_2') ?></li>
                  <li><span class="icon-checker"></span><?= l('qr_download.your_qr_code_modal.signin_feature_3') ?></li>
                  <li><span class="icon-checker"></span><?= l('qr_download.your_qr_code_modal.signin_feature_4') ?></li>
                  <li><span class="icon-checker"></span><?= l('qr_download.your_qr_code_modal.signin_feature_5') ?></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-4 img-content-wrp d-md-flex d-none justify-content-center align-items-center">
            <img src="<?= ASSETS_FULL_URL . 'images/qr-Code-rafiki-1.png' ?>" class="img-fluid" alt="" width="" height="">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center ">
        <a class="btn qr-fill-btn download-qr-btn rounded-pill" href="<?php echo SITE_URL; ?>login?redirect=qr-codes"><?= l('qr_download.your_qr_code_modal.qr_code') ?></a>
        <a class="btn qr-outlined-btn track-qr-btn rounded-pill" href="<?php echo SITE_URL; ?>login?redirect=analytics"><?= l('qr_download.your_qr_code_modal.track_qr') ?></a>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<!--  -->
<!-- Download to Modal -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/download-model.php') ?>

<!-- Custom share modal -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/custom-share-popup.php') ?>

<?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>

<?php ob_start() ?>


<?php foreach ([
  'libraries/jszip.min.js',
  'libraries/jspdf.umd.min.js',
  'libraries/FileSaver.js'
] as $file) : ?>
  <script src="<?= ASSETS_FULL_URL ?>js/<?= $file ?>?v=<?= PRODUCT_CODE ?>"></script>
<?php endforeach ?>

<script>
  $("#readyUseModal").on("hidden.bs.modal", function() {
    // window.location.href = "<?php url('qr-codes') ?>"; 
    $("#qrCode").show();
  });

  $(document).on('click', ".close-download-model-btn", function() {
    $('#DownloadModal').modal('hide');
  });
  $(document).on('click', ".downloadQrCode", function() {
    var modal = $(this).closest("#DownloadModal");
    var type = $('.dl-modal-options').attr('data-selected');
    var size = $('.dl-modal-size-picker-options').attr('data-selected').split('x');
    var link = modal.find("#dmQrcodeLink").val();
    var fileName = modal.find("#fileName").val();
    var qrId = modal.find("#qr_id").val();
    var qrType = modal.find("#qr_type").val();
    var qrUid = modal.find("#qr_uid").val();
    var user_id = modal.find("#user_id").val();

    $('#qrCode').hide();
    $('#readyUseModal').modal('toggle');

    const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50" class="new-spinner"><circle r="20" cy="50" cx="50"></circle></svg></div>
                            <span class="download-modal-text">Processing...</span>`;

    let dlButtonHTML = $(this).html();

    var data = {
      link: link,
      name: fileName,
      type: type,
      size: size[0],
      action: "get_image_ratio",
    }
    $.ajax({
      type: 'POST',
      url: '<?php echo url('api/ajax') ?>',
      data: data,
      dataType: 'json',
      beforeSend: function() {
        $(".downloadQrCode").html(spinnerHTML);
      },
      success: function(response) {
        $(".downloadQrCode").html(dlButtonHTML);
        width = response.data.width;
        height = response.data.height;
        var fileName = response.data.name;
        if (type == "svg") {
          downloadSvg(link, fileName, width, height, qrUid);
        } else if (type == "pdf") {
          makePDF(link, size[0], size[1], width, height, fileName);
          modal.find(".new-dl-close").trigger('click');
        } else if (type == "eps") {
          makeEPS(link, width, fileName, qrUid, qrId);
        } else {
          convert_svg_to_others(link, type, fileName, width, height);
          modal.find(".new-dl-close").trigger('click');
        }
      },
      error: () => {
        $(".downloadQrCode").html(dlButtonHTML);
      }
    });
    var data = {
      qr_code_id: qrId,
      user_id: user_id,
      uid: qrUid,
      action: "change_qr_download_status",
    }
    $.ajax({
      type: 'POST',
      url: '<?php echo url('api/ajax') ?>',
      data: data,
      dataType: 'json',
    });

    <?php if ($this->user->user_id) :  ?>

      // Data Layer Implementation (GTM)
      var eventDownload = "qr_download";
      var eventData = {
        "userId": "<?php echo $this->user->user_id ?>",
        'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
        'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
        "qr_type": qrType,
        "qr_id": qrId,
        'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
      }
      googleDataLayer(eventDownload, eventData);
    <?php endif ?>


  });

  function openReadyUseModel() {
    var modal = $(".toPrintBtn").closest("#DownloadModal");
    $('#qrCode').hide();
    $('#readyUseModal').modal('toggle');
  }
  function mobilePrint() {
    var qrUrl = $(".qr-code-embed").attr("src");
    var iframe = $('<iframe class="print-qr-window"></iframe>');
    iframe.appendTo("body");
    var printIframeDocument = $(".print-qr-window").contents().find('body');
    var qrDiv = $('<div class="print-qr"></div>');
    var qrElement = $("<img class='qr-img-element' src='" + qrUrl + "'>");
    qrElement.appendTo(qrDiv);
    qrDiv.appendTo(printIframeDocument);
    $(".print-qr-window").css({
      'width': '100%',
      'height': '100%',
      'display': 'flex',
      'align-items': 'center',
      'justify-content': 'center',
      'background-color': '#fff',
      'position': 'absolute',
      'top': '-74px',
    })
    $(".print-qr-window").contents().find('.print-qr').css({
      'height': '100%',
      'display': 'flex',
      'justify-content': 'center',
      'align-items': 'center'
    });
    $(".print-qr-window").contents().find('.qr-img-element').css({
      'width': '300px'
    });
    var iframeContentWindow = $('.print-qr-window')[0].contentWindow;
    setTimeout(function() {
      if (iframeContentWindow) {
        iframeContentWindow.print();
      } else {
        console.error('Unable to access iframe content window.');
      }
    }, 1000);
    iframeContentWindow.onafterprint = function() {
      setTimeout(function() {
        openReadyUseModel();
        $('.print-qr-window').remove();
      }, 1000);
    }
  }
  function toggleModelInIphoneChrome() {
    var mediaQueryList = window.matchMedia('print');
    mediaQueryList.addListener(function(mql) {
      if (!mql.matches) {
        $('#readyUseModal').show().addClass("show");
      }
    });
  }
  function defaultPrint() {
    window.print();
    printModalRemove();
    $('.qrFrameWindow').remove();
  }
  
  $(document).on('click', '.toPrintBtn', function(e) {
    const isIPhone = navigator.userAgent.match(/iPhone/i);
    let userAgent = navigator.userAgent;
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    downloadModalClose();
    var modal = $(this).closest("#DownloadModal");
    if ($(window).width() < 767) {
      if (userAgent.match(/chrome|chromium|crios/i) && isIPhone) {
        $('#readyUseModal').hide();
        defaultPrint();
        toggleModelInIphoneChrome();
      } else {
        mobilePrint();
      }
    } else {
      defaultPrint();
      openReadyUseModel();
    }
    var qrId = modal.find("#qr_id").val();
    var qrUid = modal.find("#qr_uid").val();
    var user_id = modal.find("#user_id").val();
    var data = {
      qr_code_id: qrId,
      user_id: user_id,
      uid: qrUid,
      action: "change_qr_download_status",
    }
    $.ajax({
      type: 'POST',
      url: '<?php echo url('api/ajax') ?>',
      data: data,
      dataType: 'json',
    });
    setTimeout(function() {
      // iframe.remove();
      $(".modal-backdrop").remove();
    }, 100);
    // Data Layer Implementation (GTM)
    var event = "all_click";
    var qrData = {
      "userId": user_id,
      "clicktext": "Print Qr Code",
    }
    googleDataLayer(event, qrData);
  });

  $(".ready-modal-close-btn").on("click", function() {
    $('#readyUseModal').hide().removeClass("show");
    $(".qr-code-download-btn").trigger("click");
  });

  function printModalRemove() {
    if ($('#print').is(':checked')) {
      // $(".modal-backdrop").remove();
      $("body").removeClass('modal-open');
      $("body").css({
        'padding-right': '0px',
        'overflow': 'auto'
      });

    }
  }

  function downloadModalClose() {
    $("#DownloadModal").removeClass('show');
    $('#DownloadModal').css({
      'display': 'none'
    });
    $(".modal-backdrop").remove();
  }
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>