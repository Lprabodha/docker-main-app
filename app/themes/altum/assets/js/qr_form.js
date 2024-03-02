var currentScreen;
var currentCompanyLogo;
var currentOI;

// get the script element
var scriptElem = document.querySelector('script[src$="qr_form.js"]');
// get the value of the "link" attribute
var siteUrl = scriptElem.getAttribute('site-url');
var langVariablesJson = scriptElem.getAttribute('lang-variables');
var langVariablesArr = JSON.parse(langVariablesJson);


if (document.getElementById("screen")) {
    var screen = document.getElementById("screen");
    screen.onchange = (evt) => {

        $("#screensizeErrorMesg").remove();
        $("label[for='screen']").css("border", "2px solid #96949C");
        const [file] = screen.files;
        if (file) {
            if ($("#upl-img")) {
                $("#upl-img").remove();
            }

            // Removed from here

            if (currentScreen) {
                // Deleting from Server 
                deleteCurrentFile(currentScreen);
            }

            // Note that to count exact value like operating system use 1000 instead of 1024 below functions 
            sizeinMB = file.size / Math.pow(1024, 2);
            if (sizeinMB > 10) {
                const dts = new DataTransfer();
                screen.files = dts.files;
                document.getElementById("screen_delete").style.display = "none";
                document.getElementById('custom_preview').disabled = true;
                $("label[for='screen']").css({
                    "border": "2px solid red"
                });

                $(screen).parent().parent().parent().after("<span id='screensizeErrorMesg' style='color:red;margin-top:15px;'>" + langVariablesArr[0] + " </span>");
                document.getElementById("tmp-mage").style.display = "flex";
                $("#editscreen").val('');
            } else {
                // Added Here
                document.getElementById("tmp-mage").style.display = "none";
                document.getElementById("add-icon").style.display = "none";
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "upl-img");
                document.getElementById("input-image").appendChild(elem);
                // Added Here
                $(".preview-qr-btn").attr("disabled", true);
                $("#temp_next").attr("disabled", true);
                $(screen).parent().append('<div id="welcome-screens-loader" class="spinner-border text-secondary" role="status"><span class="sr-only">' + langVariablesArr[2] + '</span></div>');
                $("#upl-img").css({ 'filter': 'blur(1px)', });
                let form = document.querySelector('form#myform');
                let form_data = new FormData(form);
                let newFormData = onlyFileTypes(form_data, "screen");
                $.ajax({
                    type: 'POST',
                    method: 'post',
                    url: qrFormPostUrl, // declared at themes/altum/views/qr/index.php
                    data: newFormData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                        $("#welcome-screens-loader").remove();
                        $("#upl-img").css({ 'filter': 'none', });

                        document.getElementById("edit-icon").style.display = "block";
                        document.getElementById("screen_delete").style.display = "block";
                        document.getElementById('custom_preview').disabled = false;
                        document.querySelector('#qr_code').src = response.details.data;
                        document.querySelector('#download_svg').href = response.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            document.querySelector('input[name="qr_code"]').value = response.details.data;
                        }

                        // We are here doing this step to store the path of the current Welcome Screens and then delete it from the server if required 
                        let uId = document.getElementById('uId').value;
                        var filesscreen = document.getElementById("screen").files;
                        var screenExtension = filesscreen[0].name.substr(filesscreen[0].name.lastIndexOf('.') + 1);
                        var uploadUniqueId = document.getElementById("uploadUniqueId").value;
                        currentScreen = filesscreen.length ? "screen/" + uId + "_welcome_" + uploadUniqueId + "." + screenExtension + "" : "";

                        if (filesscreen.length) {
                            $('input[name="welcomescreen"]').val(siteUrl + currentScreen);
                        }

                    },
                    error: function (response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                    }
                });
            }

            // document.getElementById('custom_preview_one').disabled = false;
        }
    };
}

$("#custom_preview").on("click", function () {
    currentPos = "";
});
$("#screen_delete").on("click", function () {
    $("#screen").val("");
    $('input[name="welcomescreen"]').val("");

    document.getElementById("edit-icon").style.display = "none";
    document.getElementById("screen_delete").style.display = "none";
    document.getElementById('custom_preview').disabled = true;

    document.getElementById("tmp-mage").style.display = "flex";
    document.getElementById("upl-img").style.display = "none";
    document.getElementById("add-icon").style.display = "flex";
    let upl_img = document.getElementById("upl-img");
    upl_img.remove();

    $("#screensizeErrorMesg").remove();
    $("label[for='screen']").css("border", "2px solid #96949C");

    // document.getElementById('custom_preview_one').disabled = true;

    // Deleting from Server 
    deleteCurrentFile(currentScreen);
    currentScreen = null;
});

const deleteCurrentFile = (files) => {
    formData = new FormData();
    formData.append('action', 'deleteFiles');
    formData.append('fileLinks', files);

    $.ajax({
        type: 'POST',
        method: 'post',
        url: 'api/ajax',
        // url: '<?php echo url('api/ajax') ?>',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
    });
};

const onlyFileTypes = (formData, keepField, companyId) => {
    // Loop through all fields in the FormData object
    var formData = formData;
    for (let pair of formData.entries()) {
        const fieldName = pair[0];
        const fieldValue = pair[1];

        // Check if the field is a file input and not named "screens"
        if (fieldValue instanceof File && fieldName !== keepField && fieldName !== "qr_code_logo") {
            // Remove the file input if it is not named "screens"
            formData.delete(fieldName);
        }
    }
    formData.append('companyId', companyId);
    return formData;
}

$("#cl_screen_delete").on("click", function () {

    $("#companyLogo").val("");
    $('#companyLogoImage').val('');

    document.getElementById("company_log_edit_icon").style.display = "none";
    document.getElementById("cl_screen_delete").style.display = "none";
    document.getElementById("cl-tmp-mage").style.display = "flex";
    document.getElementById("company_log_add_icon").style.display = "flex";
    // let upl_img = document.getElementById('logo-upl-img');
    $("#cl-upl-img").remove();

    $("#sizeErrorMesg").remove();
    $("label[for='companyLogo']").css("border", "2px solid #96949C");

    deleteCurrentFile(currentCompanyLogo);
    currentCompanyLogo = null;
    LoadPreview(false);
});

const clickedOnCancels = () => {
    $("#companyLogo").val("");

    document.getElementById("company_log_edit_icon").style.display = "none";
    document.getElementById("cl_screen_delete").style.display = "none";
    document.getElementById("cl-tmp-mage").style.display = "flex";
    document.getElementById("company_log_add_icon").style.display = "flex";
    // let upl_img = document.getElementById('logo-upl-img');
    $("#cl-upl-img").remove();

    $("#sizeErrorMesg").remove();
    $("label[for='companyLogo']").css("border", "2px solid #96949C");

    deleteCurrentFile(currentCompanyLogo);
    currentCompanyLogo = null;
    LoadPreview(true);
};

if (document.getElementById("companyLogo")) {
    var companyLogo = document.getElementById("companyLogo");

    companyLogo.onchange = (evt) => {
        // if (!companyLogo.value) {
        //     clickedOnCancels();
        //     return;
        // }
        $("#sizeErrorMesg").remove();
        $("label[for='companyLogo']").css("border", "2px solid #96949C");

        const [file] = companyLogo.files;
        var companyId = Date.now();
        if (file) {
            if ($("#cl-upl-img")) {
                $("#cl-upl-img").remove();
            }

            // Removed From Here

            // elem.setAttribute("height", "60");
            // elem.setAttribute("width", "60");
            // document.getElementById("company_log_edit_icon").style.display = "block";
            // document.getElementById("cl_screen_delete").style.display = "block";


            if (currentCompanyLogo) {
                // Deleting from Server 
                deleteCurrentFile(currentCompanyLogo);
            }
            // Note that to count exact value like operating system use 1000 instead of 1024 below functions 

            sizeinMB = file.size / Math.pow(1024, 2);
            if (sizeinMB > 10) {
                const dts = new DataTransfer();
                companyLogo.files = dts.files;
                $("label[for='companyLogo']").css({
                    "border": "2px solid red"
                });
                $(companyLogo).parent().parent().after("<span id='sizeErrorMesg' style='color:red;margin-top:15px;'>" + langVariablesArr[1] + "</span>");

                document.getElementById("cl-tmp-mage").style.display = "flex";
                $('#companyLogoImage').val('');
            } else {
                // Added Here
                document.getElementById("cl-tmp-mage").style.display = "none";
                document.getElementById("company_log_add_icon").style.display = "none";
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "cl-upl-img");
                document.getElementById("company_logo_img").appendChild(elem);
                // Added Here
                $(".preview-qr-btn").attr("disabled", true);
                $("#temp_next").attr("disabled", true);
                $(companyLogo).parent().append('<div id="welcome-screens-loader" class="spinner-border text-secondary" role="status"><span class="sr-only">' + langVariablesArr[2] + '</span></div>');
                $("#cl-upl-img").css({ 'filter': 'blur(1px)', });
                let form = document.querySelector('form#myform');
                let form_data = new FormData(form);
                newFormData = onlyFileTypes(form_data, "companyLogo", companyId);
                $.ajax({
                    type: 'POST',
                    method: 'post',
                    url: qrFormPostUrl,
                    data: newFormData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                        $("#welcome-screens-loader").remove();
                        $("#cl-upl-img").css({ 'filter': 'none', });

                        // document.getElementById("edit-icon").style.display = "block";
                        // document.getElementById("screen_delete").style.display = "block";
                        // document.getElementById('custom_preview').disabled = false;
                        document.getElementById("company_log_edit_icon").style.display = "block";
                        document.getElementById("cl_screen_delete").style.display = "block";
                        LoadPreview(false, false);
                        document.querySelector('#qr_code').src = response.details.data;
                        document.querySelector('#download_svg').href = response.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            document.querySelector('input[name="qr_code"]').value = response.details.data;
                        }

                        // We are here doing this step to store the path of the current Welcome Screens and then delete it from the server if required 
                        let uId = document.getElementById('uId').value;
                        var filesscreens = document.getElementById("companyLogo").files;
                        var screenExtension = filesscreens[0].name.substr(filesscreens[0].name.lastIndexOf('.') + 1);
                        var uploadUniqueId = document.getElementById("uploadUniqueId").value;
                        var types = document.querySelector('input[name="type"]').value;
                        currentCompanyLogo = filesscreens.length ? types + "/" + uId + "_companyLogo_" + companyId + "." + screenExtension + "" : "";

                        if (filesscreens.length) {
                            $('input[name="companyLogoImage"]').val(siteUrl + currentCompanyLogo);
                            LoadPreview(false);
                        }

                    },
                    error: function (response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                    }
                });
            }
        }
    };
}



if (document.getElementById("offerImage")) {
    var offerImage = document.getElementById("offerImage");
    offerImage.onchange = (evt) => {
        $("#sizeErrorMesg").remove();
        $("label[for='offerImage']").css("border", "1px solid #96949C");




        console.log("file uploaded");
        const [file] = offerImage.files;
        if (file) {
            if ($("#oi-upl-img")) {
                $("#oi-upl-img").remove();
            }


            if (currentOI) {
                // Deleting from Server 
                deleteCurrentFile(currentOI);
            }
            // Note that to count exact value like operating system use 1000 instead of 1024 below functions 
            sizeinMB = file.size / Math.pow(1024, 2);
            if (sizeinMB > 10) {

                const dts = new DataTransfer();
                offerImage.files = dts.files;

                $("label[for='offerImage']").css({
                    "border": "2px solid red"
                });
                $(offerImage).parent().parent().after("<span id='sizeErrorMesg' style='color:red;margin-top:15px;'>" + langVariablesArr[1] + "</span>");
                document.getElementById("oi-tmp-mage").style.display = "flex";
                $("#offerImg").val('');

            } else {

                document.getElementById("oi-tmp-mage").style.display = "none";
                document.getElementById("oi-add-icon").style.display = "none";
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                // elem.setAttribute("height", "60");
                // elem.setAttribute("width", "60");
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "oi-upl-img");
                document.getElementById("oi-input-image").appendChild(elem);

                $(".preview-qr-btn").attr("disabled", true);
                $("#temp_next").attr("disabled", true);
                $(offerImage).parent().append('<div id="welcome-screens-loader" class="spinner-border text-secondary" role="status"><span class="sr-only">' + langVariablesArr[2] + '</span></div>');
                $("#oi-upl-img").css({ 'filter': 'blur(1px)', });
                let form = document.querySelector('form#myform');
                let form_data = new FormData(form);
                newFormData = onlyFileTypes(form_data, "offerImage");
                $.ajax({
                    type: 'POST',
                    method: 'post',
                    url: qrFormPostUrl,
                    data: newFormData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                        $("#welcome-screens-loader").remove();
                        $("#oi-upl-img").css({ 'filter': 'none', });

                        // document.getElementById("edit-icon").style.display = "block";
                        // document.getElementById("screen_delete").style.display = "block";
                        // document.getElementById('custom_preview').disabled = false;
                        document.getElementById("oi-edit-icon").style.display = "flex";
                        document.getElementById("oi-screen_delete").style.display = "block";

                        LoadPreview(false, false);
                        document.querySelector('#qr_code').src = response.details.data;
                        document.querySelector('#download_svg').href = response.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            document.querySelector('input[name="qr_code"]').value = response.details.data;
                        }

                        // We are here doing this step to store the path of the current Welcome Screens and then delete it from the server if required 
                        let uId = document.getElementById('uId').value;
                        var filesscreenss = document.getElementById("offerImage").files;
                        var offerImageExtension = filesscreenss[0].name.substr(filesscreenss[0].name.lastIndexOf('.') + 1);
                        var uploadUniqueId = document.getElementById("uploadUniqueId").value;
                        currentOI = filesscreenss.length ? "coupon/" + uId + "_offerImage_" + uploadUniqueId + "." + offerImageExtension + "" : "";


                        if (filesscreenss.length) {
                            $('input[name="offerImg"]').val(siteUrl + currentOI);
                            $('#qr-code-wrap').addClass('active');
                            $("#2").attr('disabled', false)
                            $("#2").removeClass("disable-btn")
                            LoadPreview(false);
                        }
                    },
                    error: function (response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                        $("label[for='offerImage']").css("border", "2px solid red");
                    }
                });
            }
        }
    };
}




$("#oi-screen_delete").on("click", function () {

    $("#offerImage").val("");
    $("#offerImg").val("");
    $('.coupon-barcode-image').hide();
    $('.coupon-barcode-code').show();
    $('#couponCode').val("");

    document.getElementById("oi-edit-icon").style.display = "none";
    document.getElementById("oi-screen_delete").style.display = "none";
    document.getElementById("oi-tmp-mage").style.display = "flex";
    document.getElementById("oi-add-icon").style.display = "block";
    $("#couponTgl").prop("checked", false);
    let upl_img = document.getElementById("oi-upl-img");
    upl_img.remove();


    $("#sizeErrorMesg").remove();
    $("label[for='offerImage']").css("border", "2px solid #96949C");

    deleteCurrentFile(currentOI);
    currentOI = null;
});

var imgUpload = document.getElementById("images"),
    imgPreview = document.getElementById(`<div class="screen-upload mb-3"> <
        label
        for = "screen" >
        <
        input type = "file"
        id = "screen"
        name = "screen"
        onchange = "setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);"
        class = "form-control py-2"
        value = ""
        accept = "image/png, image/gif, image/jpeg"
        data - reload - qr - code / >
        <
        div class = "input-image"
        id = "input-image" >
        <
        svg class = "MuiSvgIcon-root"
        id = "tmp-mage"
        focusable = "false"
        viewBox = "0 0 60 60"
        aria - hidden = "true"
        style = "font-size: 60px;" >
        <
        path d = "M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z" > < /path> <
        path d = "M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z" > < /path> < /
        svg > <
        /div> <
        div class = "add-icon"
        id = "add-icon" >
        <
        svg class = "MuiSvgIcon-root"
        focusable = "false"
        viewBox = "0 0 24 24"
        aria - hidden = "true" >
        <
        path d = "M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" > < /path> < /
        svg > <
        /div> < /
        label > <
        button type = "button"
        class = "upload-btn"
        onclick = "LoadPreview()" > Preview < /button> < /
        div > `),
    totalFiles,
    previewTitle,
    previewTitleText,
    img;

if (imgUpload) imgUpload.addEventListener("change", previewImgs, false);

function previewImgs(event) {
    totalFiles = imgUpload.files.length;

    if (!!totalFiles) {
        imgPreview.classList.remove("quote-imgs-thumbs--hidden");
        // previewTitle = document.createElement('p');
        // previewTitle.style.fontWeight = 'bold';
        // previewTitleText = document.createTextNode(totalFiles + ' Total Images Selected');
        // previewTitle.appendChild(previewTitleText);
        // imgPreview.appendChild(previewTitle);
    }
    // console.log("sger" ,event.target.files);
    for (var i = 0; i < totalFiles; i++) {
        const fsize = event.target.files[i].size;
        const filesize = Math.round(fsize / 1024);
        upload = document.createElement("div");
        upload.className = "afterImage-upload";
        upload.id = "img_div";
        cent = document.createElement("div");
        cent.className = "d-flex align-items-center";
        prv = document.createElement("div");
        prv.className = "imagePreview";
        img = document.createElement("img");
        img.src = URL.createObjectURL(event.target.files[i]);
        prv2 = document.createElement("div");
        prv2.className = "previewDetail";
        lbl = document.createElement("label");
        lbl.innerHTML = event.target.files[i].name;
        flx = document.createElement("div");
        flx.className = "d-flex align-items-center";
        spn = document.createElement("span");
        spn.innerHTML = filesize + " kb";
        imgPreview.appendChild(upload);
        upload.appendChild(cent);
        cent.appendChild(prv);
        prv.appendChild(img);
        cent.appendChild(prv2);
        prv2.appendChild(lbl);
        prv2.appendChild(spn);
        upload.appendChild(flx);

        flx.innerHTML =
            '<button type="button" onclick="remove_me(this)">' +
            ' <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false"  viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">' +
            '<path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path  d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>' +
            "</button>";
    }
}
// delete image
function remove_div(id) {
    console.log("remove", id);
    const img_div = document.getElementById("img_div");
    img_div.addEventListener("click", () => {
        img_div.remove();
    });
}

$(document).ready(function () {
    $("#passwordField").hide();
    $("#changeForgroundColor").click(function () {
        var one = $("#ForgroundColorFirst").val();
        var second = $("#ForgroundColorSecond").val();
        $("#ForgroundColorFirst").val(second);
        $("#ForgroundColorSecond").val(one);
    });

    // qr_frame_id_1
    for (let index = 0; index < 33; index++) {
        $("#qr_frame_id_" + index).click(function () {
            $("#qr_frame_id_" + index).addClass("active");
            for (let i = 0; i < 33; i++) {
                if (i != index) {
                    $("#qr_frame_id_" + i).removeClass("active");
                }
            }
        });
        // $("#qr_frame_enabled").click();
    }
    $("#changeForgroundColor").click(function () {
        var one = $("#ForgroundColorFirst").val();
        var second = $("#ForgroundColorSecond").val();
        $("#ForgroundColorFirst").val(second);
        $("#ForgroundColorSecond").val(one);
    });

    $("#ForgroundColor").change(function () {
        let selectedOption = $("#ForgroundColor").val();
        $("#ForgroundColorSpan").html(selectedOption);
    });
    $("#BackgroundColor").change(function () {
        let selectedOption = $("#BackgroundColor").val();
        $("#BackgroundColorSpan").html(selectedOption);
    });

    $("#ForgroundColorFirst").change(function () {
        var selectedOption = $("#ForgroundColorFirst").val();
        $("#ForgroundColorFirstSpan").html(selectedOption);
    });
    $("#ForgroundColorSecond").change(function () {
        var selectedOption = $("#ForgroundColorSecond").val();
        $("#ForgroundColorSecondSpan").html(selectedOption);
    });

    // EIColorSpan

    $("#EIColor").change(function () {
        let selectedOption = $("#EIColor").val();
        $("#EIColorSpan").html(selectedOption);
    });
    $("#EOColor").change(function () {
        let selectedOption = $("#EOColor").val();
        $("#EOColorSpan").html(selectedOption);
    });

    for (let index = 1; index < 6; index++) {
        $("#formcolorPalette" + index).click(function () {
            $("#formcolorPalette" + index).addClass("active");
            for (let i = 1; i < 33; i++) {
                if (i != index) {
                    $("#formcolorPalette" + i).removeClass("active");
                }
            }
        });
    }
    $("#formcolorPalette1").click(function () {
        $("#primaryColor").val("#2F6BFD");
        $("#SecondaryColor").val("#0E379A");
        LoadPreview(false,false,'color_palette');
    });

    $("#formcolorPalette2").click(function () {
        $("#primaryColor").val("#28EDC9");
        $("#SecondaryColor").val("#03A183");
        LoadPreview(false,false,'color_palette');
    });

    $("#formcolorPalette3").click(function () {
        $("#primaryColor").val("#28ED28");
        $("#SecondaryColor").val("#00A301");
        LoadPreview(false,false,'color_palette');
    });

    $("#formcolorPalette4").click(function () {
        $("#primaryColor").val("#EDE728");
        $("#SecondaryColor").val("#A39E0A");
        LoadPreview(false,false,'color_palette');
    });

    $("#formcolorPalette5").click(function () {
        $("#primaryColor").val("#ED4C28");
        $("#SecondaryColor").val("#A31F01");
        LoadPreview(false,false,'color_palette');
    });
});

$("#social").hide();

function remove_me(elm) {
    $(elm).parent().parent().remove();
    LoadPreview();
}

function remove_me_up(elm) {
    $(elm).parent().parent().parent().remove();
    LoadPreview();
}

// $(function () {
//     $("#passcheckbox").on("change", function () {
//         console.log("checked", $(this).prop("checked"));
//         // var checked = $(this).prop('checked');
//         $("#passwordField").prop("disabled", !$(this).prop("checked"));
//         $("#passwordField").val("");
//         if ($(this).prop("checked")) {
//             $("#passwordBlock").append(
//                 `<input autocomplete="new-password" id="passwordField" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code />`
//             );
//         } else {
//             $("#passwordField").remove();
//         }
//     });
// });

$("#dot").click(function () {
    $("#dot").addClass("active");
    $("#round").removeClass("active");
    $("#square").removeClass("active");
});
$("#round").click(function () {
    $("#dot").removeClass("active");
    $("#round").addClass("active");
    $("#square").removeClass("active");
});
$("#square").click(function () {
    $("#dot").removeClass("active");
    $("#round").removeClass("active");
    $("#square").addClass("active");
});

$("#RE").click(function () {
    $("#CE").removeClass("active");
    $("#RE").addClass("active");
});

$("#CE").click(function () {
    $("#RE").removeClass("active");
    $("#CE").addClass("active");
});


$(document).ready(function () {
    $("#isGradientSelected").change(function () {
        console.log("here gradient", $("#isGradientSelected").val())
        var selectedOption = $("#isGradientSelected").val()
        if (selectedOption == 'gradient') {

            $('#gradient').show();
        } else {
            $('#gradient').hide();
        }
    });
});

$(document).ready(function () {
    $("#isFrameGradientSelected").change(function () {
        var selectedOption = $("#isFrameGradientSelected").val()
        if (selectedOption == 'gradient') {

            $('#frame_gradient').show();
        } else {
            $('#frame_gradient').hide();
        }
    });
});

$(document).ready(function () {
    $("#isBackgroundGradientSelected").change(function () {
        console.log("here background", $("#isBackgroundGradientSelected").val())
        var selectedOption = $("#isBackgroundGradientSelected").val()
        if (selectedOption == 'gradient') {

            $('#background_gradient').show();
        } else {
            $('#background_gradient').hide();
        }
    });
});