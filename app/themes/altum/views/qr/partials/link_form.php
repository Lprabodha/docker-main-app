<?php defined('ALTUMCODE') || die() ?>
<?php
if (isset($data->qr_code[0]['data'])) {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $QrName =  $data->qr_code[0]['name'];
} else {
    $filledInput = array();
    $QrName = null;
}
?>

<div id="step2_form">
    <div class="row">
        <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['uId'] : uniqid();  ?>" data-reload-qr-code />
        <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
        <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />
        <div class="col-12">
            <div class="form-group" data-type="app">
                <label for="name"> <?= l('qr_codes.input.qrname') ?></label>
                <input id="name" name="name" class="form-control" value="<?php echo (!empty($QrName)) ? $QrName : '';  ?>" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required="required" data-reload-qr-code />
            </div>
        </div>

    </div>

    <h4>Basic information</h4>
    <label for="primaryColor"> <?= l('qr_codes.input.primaryColor') ?></label>
    <input type="color" id="primaryColor" name="primaryColor" onchange="LoadPreview()" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#0099ff'; ?>" data-reload-qr-code />

    <label for="images"><i class="fa fa-fw fa-link fa-sm mr-1"></i>App Logo</label>
    <input type="file" id="images" name="images[]" onchange="LoadPreview()" class="form-control" value="" accept="image/png, image/gif, image/jpeg" required="required" data-reload-qr-code />
    <div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="<div class=" screen-upload mb-3">
        <label for="app_logo">
            <input type="file" id="app_logo" name="app_logo" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" data-reload-qr-code />
            <div class="input-image">
                <svg class="MuiSvgIcon-root" id="tmp-mage" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                    <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                    <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                </svg>
            </div>
            <div class="add-icon">
                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                </svg>
            </div>
        </label>
        <button type="button" class="upload-btn" onclick="LoadPreview(true)">Preview</button>
    </div>
</div>

<label for="title"> Title </label>
<input id="title" onchange="LoadPreview()" name="title" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['title'] : ''; ?>" required="required" data-reload-qr-code />

<label for="description"> Description</label>
<input id="description" onchange="LoadPreview()" name="description" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['description'] : ''; ?>" required="required" data-reload-qr-code />

<label for="developer"> Developer/Company</label>
<input id="developer" onchange="LoadPreview()" name="developer" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['developer'] : ''; ?>" required="required" data-reload-qr-code />


<h4>Links</h4>
<label for="primaryColor"> <?= l('qr_codes.input.primaryColor') ?></label>
<input type="color" id="primaryColor" name="primaryColor" onchange="LoadPreview()" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#0099ff'; ?>" data-reload-qr-code />

<label for="images"><i class="fa fa-fw fa-link fa-sm mr-1"></i>App Logo</label>
<input type="file" id="images" name="images[]" onchange="LoadPreview()" class="form-control" value="" accept="image/png, image/gif, image/jpeg" required="required" data-reload-qr-code />
<div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="<div class=" screen-upload mb-3">
    <label for="screen">
        <input type="file" id="screen" name="screen" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" data-reload-qr-code />
        <div class="input-image" id="input-image">
            <svg class="MuiSvgIcon-root" id="tmp-mage" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
            </svg>
        </div>
        <div class="add-icon" id="add-icon">
            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
            </svg>
        </div>
    </label>
    <button type="button" class="upload-btn" onclick="LoadPreview(true)">Preview</button>
</div>
</div>

<label for="title"> Title </label>
<input id="title" onchange="LoadPreview()" name="title" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['title'] : ''; ?>" required="required" data-reload-qr-code />

<label for="description"> Description</label>
<input id="description" onchange="LoadPreview()" name="description" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['description'] : ''; ?>" required="required" data-reload-qr-code />




<label for="website"> Website</label>
<input id="website" type="url" name="website" onchange="LoadPreview()" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['website'] : ''; ?>" placeholder="E.g. https://mywebsite.com/" data-reload-qr-code />

<h4>Links to different platforms</h4>

<label for="google"> Google</label>
<input id="google" type="url" name="google" onchange="LoadPreview()" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['google'] : ''; ?>" placeholder="E.g. https://mywebsite.com/" data-reload-qr-code />

<label for="apple"> Apple</label>
<input id="apple" type="url" name="apple" onchange="LoadPreview()" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['apple'] : ''; ?>" placeholder="E.g. https://mywebsite.com/" data-reload-qr-code />

<label for="amazon"> Amazon</label>
<input id="amazon" type="url" name="amazon" onchange="LoadPreview()" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['website'] : ''; ?>" placeholder="E.g. https://mywebsite.com/" data-reload-qr-code />


<label for="screen">Welcome Screen</label>
<input type="file" id="screen" name="screen" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control" value="" accept="image/png, image/gif, image/jpeg" input_size_validate data-reload-qr-code />

<label for="password"> Password</label>
<input id="password" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code />
</div>

<script>
    $(".custom-select-box input").click(function() {
        $(this).next(".dropdown").addClass('active')
    });


    $(".custom-select-box .dropdown .drp-btn").click(function() {
        $(this).parents(".dropdown").removeClass('active');
        let setFont = $(this).parents(".custom-select-box").children('input');
        setFont.attr("value", $(this).attr("value"));
        setFont.css("font-family", $(this).attr("value"));
        LoadPreview();
    });
    $(".custom-select-box .dropdown").mouseleave(function() {
        $(this).removeClass('active')
    });
    $(".custom-select-box .dropdown").mouseleave(function() {
        $(this).next(".dropdown").removeClass('active')
    });
    $(".custom-select-box input").mouseleave(function() {
        $(this).removeClass('active')
    });

    function LoadPreview(welcome_screen = false) {
        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let appname = document.getElementById('appname').value;
        let description = document.getElementById('description').value;

        var webValue = document.getElementById('website').value.replace(/&/g, '%26');
        if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(webValue)) {
            var website = document.getElementById('website').value.replace(/&/g, '%26');
        } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(webValue)) {
            var output = "https://" + webValue;
            var website = output;
        } else if (webValue == "") {
            var website = "";
        }

        let developer = document.getElementById('developer').value;
        let google = document.getElementById('google').value;
        let apple = document.getElementById('apple').value;
        let amazon = document.getElementById('amazon').value;

        // let tmp_screen = document.getElementById('screen').value;
        // var filesscreen = document.getElementById("screen").files;
        // console.log(filesscreen);
        // var screen = filesscreen.length ? "<?php echo SITE_URL; ?>uploads/app/" + uId + "_" + filesscreen[0].name + "" : "";
        var screen = document.getElementById("editscreen").value;

        let tmp_images = document.getElementById('images').value;
        // console.log("images", tmp_images)
        var files = document.getElementById("images").files;
        var all_images = [];
        for (var i = 0; i < files.length; i++) {
            var image = "<?php echo SITE_URL; ?>uploads/app/" + uId + "_" + i + "_" + files[i].name + "";
            console.log(image);
            all_images.push(image)
        }

        let link = `<?php echo LANDING_PAGE_URL; ?>apps?primaryColor=${primaryColor.replace("#","")}&appname=${appname}&description=${description}&website=${website}&developer=${developer}&screen=${screen}&google=${google}&app=${apple}&amazon=${amazon}&images=${JSON.stringify(all_images)}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL; ?>apps?primaryColor=${primaryColor.replace("#","")}&appname=${appname}&description=${description}&website=${website}&developer=${developer}&google=${google}&app=${apple}&amazon=${amazon}&images=${JSON.stringify(all_images)}`
        }

        var frame = $('#iframesrc')[0];
        var frame2 = $('#iframesrc2')[0];
        link = link.replace(/#/g, '%23'); //convert # symbol 
        frame.contentWindow.location.replace(link);
        if (document.getElementById('iframesrc2')) {
            frame2.contentWindow.location.replace(link);
        }
        document.getElementById("loader").style.display = "none";
        document.getElementById("iframesrc").style.visibility = "visible";
        document.getElementById("preview_link").value = link;
        document.getElementById("preview_link2").value = link;

        let im_url = $('#qr_code').attr('src');
        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }
    }
</script>
<script site-url="<?php echo SITE_URL ?>" src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>