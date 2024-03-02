<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<script type="text/javascript">
    var step = 1;
    var backbtn = false;
    window.onload = function steps() {
        // $("#submit").removeAttr("disabled")
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'none';
        document.getElementById('tabhead').style.display = 'none';
        var c_step = window.location.href.split('/');
        if (!isNaN(c_step[c_step.length - 1])) {
            if (c_step[c_step.length - 1] == 1 || c_step[c_step.length - 1] == 2 || c_step[c_step.length - 1] == 3) {
                step = c_step[c_step.length - 1];
            }
        }
        console.log("s", step);
        document.getElementsByClassName("app-footer")[0].style.display = "none";
        console.log("t", getBackButtonText());
        document.getElementById("cancel").innerHTML = getBackButtonText();
        if (step == '2' || step == 2) {
            // document.getElementById('tab1').classList.add = 'active';
            // document.getElementById('s1').style.fill = '#220E27';
            // document.getElementById('s2').style.fill = '#FE8E3E';
            // document.getElementById('s2').style.opacity = '1';
            // document.getElementById('s3').style.fill = '#220E27';
            document.getElementById('preview').style.display = 'none';
            document.getElementById('tabhead').style.display = 'flex';
            document.getElementById('tabhead_example').style.display = 'none';
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            document.getElementById('step3').style.display = 'none';
            document.getElementById('temp_next').style.display = 'none';
            document.getElementById('temp_next_tmp').style.display = 'block';
            document.getElementById('temp_submit').style.display = 'none';
            document.getElementById('tab1').setAttribute("onclick", function() {
                step = 1;
                change_step();
            });

        } else if (step == '3' || step == 3) {
            document.getElementById('s1').style.fill = '#220E27';
            // document.getElementById('s2').style.fill = '#220E27';
            // document.getElementById('s2').style.opacity = '1';
            // document.getElementById('s3').style.fill = '#FE8E3E';
            document.getElementById('tabs-2').classList.add('active');
            document.getElementById('2').classList.add('active');
            document.getElementById('step1').style.display = 'none';
            document.getElementById('tabhead').style.display = 'flex';
            document.getElementById('tabhead_example').style.display = 'none';
            document.getElementById('step3').style.display = 'block';

        } else {
            document.getElementById('s1').style.fill = '#FE8E3E';
            // document.getElementById('s2').style.fill = '#220E27';
            // document.getElementById('s2').style.opacity = '0.50';
            // document.getElementById('s3').style.fill = '#220E27';
            document.getElementById('step1').style.display = 'block';
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step3').style.display = 'none';
            document.getElementById('temp_next').style.display = 'block';
            document.getElementById('temp_next_tmp').style.display = 'none';
            document.getElementById('temp_submit').style.display = 'none';

        }

        // colorPicker
        document.querySelectorAll('.pickerField').forEach(function(picker) {
            var targetLabel = document.querySelector('label[for="' + picker.id + '"]'),
                codeArea = document.createElement('span');
            var clsid = document.querySelector('.pickerFieldes').id;
            var clsids = document.querySelector('.pickerFields').id;

            codeArea.innerHTML = picker.value;
            targetLabel.appendChild(codeArea);
            codeArea.setAttribute("id", clsid + "txt");
            codeArea.setAttribute("id", clsids + "txt");

            picker.addEventListener('change', function() {
                codeArea.innerHTML = picker.value;
                targetLabel.appendChild(codeArea);
                codeArea.setAttribute("id", clsid + "txt");
                codeArea.setAttribute("id", clsids + "txt");

            });
        });
    }



    async function submit() {
        // temp_submit_loader
        $("#temp_submit").hide();
        $("#temp_submit_loader").show();
        if (document.getElementById("preview_link")) {
            document.getElementById("preview_link").value = "<?php echo LANDING_PAGE_URL;?>" + document.getElementById('uId').value;
            $("#qr_frame_id_tmp").click();
            $("#qr_frame_path_tmp").click();
            await new Promise(resolve => setTimeout(resolve, 5000));
            document.getElementById("submit").click();
        } else {
            document.getElementById("submit").click();
        }

    }

    function backButton() {
        if (step == 2 && !backbtn) {
            // document.getElementById('s2').style.fill = '#FE8E3E';
            // document.getElementById('s3').style.fill = '#220E27';
            document.getElementById('step2_form').style.display = 'block';
            document.getElementById('step3').style.display = 'none';
            document.getElementById('temp_next').style.display = 'block';
            document.getElementById('temp_next_tmp').style.display = 'none';
            document.getElementById('temp_submit').style.display = 'none';
            document.getElementById('tabs-1').classList.remove('active');
            document.getElementById('1').classList.remove('active');
            document.getElementById('tabs-2').classList.add('active');
            document.getElementById('2').classList.add('active');
            backbtn = true;
        } else {
            history.back()
        }

    }

    function change_step() {
        console.log("here")
        document.getElementById('temp_next').style.display = 'block';
        document.getElementById('temp_next_tmp').style.display = 'none';
        if (step == 2) {
            // document.getElementById('s1').style.fill = '#220E27';
            // document.getElementById('s2').style.fill = '#220E27';
            // document.getElementById('s2').style.opacity = '1';
            // document.getElementById('s3').style.fill = '#FE8E3E';
            document.getElementById('tabs-1').classList.remove('active');
            document.getElementById('1').classList.remove('active');
            document.getElementById('tabs-2').classList.add('active');
            document.getElementById('2').classList.add('active');
            document.getElementById('step1').style.display = 'none';
            // document.getElementById('step2').style.display = 'none';
            document.getElementById('step3').style.display = 'block';
            document.getElementById('temp_next').style.display = 'none';

            // document.getElementById('preview').style.display = 'none';
            document.getElementById('temp_submit').style.display = 'block';
            document.getElementById('step2_form').style.display = 'none';
        } else {
            document.getElementById('temp_next').style.display = 'block';
            document.getElementById('temp_submit').style.display = 'none';
            console.log("change_step", step);
            let curr_step = parseInt(step);
            let next_url = window.location.href + '/' + (curr_step + 1);
            console.log("next_url", next_url);
            window.location = next_url;
        }

    }

    var __QRTYPES = <?php echo json_encode($data->qr_code_settings['type']); ?>;

    function changeUrl(newUrl, thisObj) {
        var newQrTypeText = $(thisObj).data('qr_type') || 'pdf';
        $('#QrType').text(newQrTypeText);
        $("#iframesrc").prop('src', __QRTYPES[newQrTypeText.toLowerCase()]['preview'])
        window.history.pushState('', 'Test', newUrl);
    }

    // function getBackButtonText() {
    //     if (step > 1) {
    //         return "Back";
    //     }
    //     return "Cancel";
    // }

    function swapValues() {       
        var tmp = document.getElementById("primaryColor").value;
        document.getElementById("primaryColor").value = document.getElementById("SecondaryColor").value;
        document.getElementById("SecondaryColor").value = tmp;
        // document.getElementById('primaryColortxt').innerHTML = document.getElementById("SecondaryColor").value;
        // document.getElementById('SecondaryColortxt').innerHTML = tmp;
        LoadPreview();
    }
 
</script>

<script type="text/javascript">
    function onModal() {
        document.getElementById('helpSkipbtn').style.display = 'block';
        document.getElementById('helpNextbtn').style.display = 'block';
        document.getElementById('helpPrevbtn').style.display = 'none';
        document.getElementById('helpAcceptbtn').style.display = 'none';
        $('#helpCarousel').carousel(0).index();

        var myCarousel = document.querySelector('#helpCarousel')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: false,
            wrap: false
        })
    }

    function onSlide(type) {
        var current = $('.carousel-item.active').index() + 1;
        if (type) {
            document.getElementById('helpPrevbtn').style.display = 'block';
            document.getElementById('helpSkipbtn').style.display = 'none';
            if (current === 4) {
                document.getElementById('helpNextbtn').style.display = 'none';
                document.getElementById('helpAcceptbtn').style.display = 'block';
            }
        } else {
            document.getElementById('helpNextbtn').style.display = 'block';
            document.getElementById('helpAcceptbtn').style.display = 'none';
            if (current === 2) {
                document.getElementById('helpPrevbtn').style.display = 'none';
                document.getElementById('helpSkipbtn').style.display = 'block';
            }
        }
    }
    $("#screen_delete").on("click", function() {
        // var control = $("#screen");
        // control.replaceWith(control = control.clone(true));
        $('#screen').val('');

        document.getElementById('edit-icon').style.display = 'none';
        document.getElementById('screen_delete').style.display = 'none';
        document.getElementById("tmp-mage").style.display = "flex";
        document.getElementById("upl-img").style.display = "none";
        document.getElementById('add-icon').style.display = "block";
        let upl_img = document.getElementById('upl-img');
        upl_img.remove();

    });

    // function deleteWelocomeImage() {
    //     reset($('#screen_delete'));
    //     var input = $("#screen_delete");
    //     input.replaceWith(input.val('').clone(true));
    //     document.getElementById("tmp-mage").style.display = "block";
    //     document.getElementById('add-icon').style.display = "block";
    //     let upl_img = document.getElementById('upl-img');
    //     upl_img.remove();
    //     document.getElementById("input-image").appendChild(elem);
    //     document.getElementById('edit-icon').style.display = 'none';
    //     document.getElementById('screen_delete').style.display = 'none';

    // }
    if (document.getElementById('screen')) {
        var screen = document.getElementById('screen')
        screen.onchange = evt => {
            console.log("file uploaded")
            const [file] = screen.files
            if (file) {
                if ($('#upl-img')) {
                    $('#upl-img').remove();
                }
                document.getElementById("tmp-mage").style.display = 'none';
                document.getElementById('add-icon').style.display = 'none';
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                elem.setAttribute("height", "60");
                elem.setAttribute("width", "60");
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "upl-img");
                document.getElementById("input-image").appendChild(elem);
                document.getElementById('edit-icon').style.display = "block";
                document.getElementById('screen_delete').style.display = "block";
                // par.innerHTML = `<img id="blah" src="${URL.createObjectURL(file)}" alt="your image" />`
                // blah.src = URL.createObjectURL(file)
            }
        }
    }


    var logoImg = document.getElementById('qr_code_logo')
    logoImg.onchange = evt => {
        console.log("file uploaded")
        const [file] = logoImg.files
        if (file) {
            if ($('#logo-upl-img')) {
                $('#logo-upl-img').remove();
            }
            document.getElementById("logo-tmp-mage").style.display = 'none';
            document.getElementById('add-logo-icon').style.display = 'none';
            var elem = document.createElement("img");
            elem.setAttribute("src", URL.createObjectURL(file));
            elem.setAttribute("height", "60");
            elem.setAttribute("width", "60");
            elem.setAttribute("alt", "Welcome screen image");
            elem.setAttribute("id", "logo-upl-img");
            document.getElementById("input-logo-image").appendChild(elem);
            document.getElementById('edit-logo-icon').style.display = "block";
            document.getElementById('logo_delete').style.display = "block";
            // document.getElementById('screen_delete').style.visibility = "visible";
            // par.innerHTML = `<img id="blah" src="${URL.createObjectURL(file)}" alt="your image" />`
            // blah.src = URL.createObjectURL(file)
        }
    }
    $("#logo_delete").on("click", function() {
        // var control = $("#screen");
        // control.replaceWith(control = control.clone(true));
        $('#qr_code_logo').val('');

        document.getElementById('edit-logo-icon').style.display = "none";
        document.getElementById('logo_delete').style.display = "none";
        document.getElementById("logo-tmp-mage").style.display = 'block';
        document.getElementById('add-logo-icon').style.display = 'block';
        // let upl_img = document.getElementById('logo-upl-img');
        $('#logo-upl-img').remove();

    });


    $("#cl_screen_delete").on("click", function() {
        // var control = $("#screen");
        // control.replaceWith(control = control.clone(true));
        $('#companyLogo').val('');

        document.getElementById('company_log_edit_icon').style.display = "none";
        document.getElementById('cl_screen_delete').style.display = "none";
        document.getElementById("cl-tmp-mage").style.display = 'block';
        document.getElementById('company_log_add_icon').style.display = 'block';
        // let upl_img = document.getElementById('logo-upl-img');
        $('#cl-upl-img').remove();

    });
    if (document.getElementById('companyLogo')) {
        var companyLogo = document.getElementById('companyLogo')
        companyLogo.onchange = evt => {
            console.log("file uploaded")
            const [file] = companyLogo.files
            if (file) {


                if ($('#cl-upl-img')) {
                    $('#cl-upl-img').remove();
                }
                document.getElementById("cl-tmp-mage").style.display = 'none';
                document.getElementById('company_log_add_icon').style.display = 'none';
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                // elem.setAttribute("height", "60");
                // elem.setAttribute("width", "60");
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "cl-upl-img");
                document.getElementById("company_logo_img").appendChild(elem);
                document.getElementById('company_log_edit_icon').style.display = "block";
                document.getElementById('cl_screen_delete').style.display = "block";
            }
        }
    }




    var imgUpload = document.getElementById('images'),
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
        totalFiles, previewTitle, previewTitleText, img;

    imgUpload.addEventListener('change', previewImgs, false);
    // imgUploadForm.addEventListener('submit', function (e) {
    //   e.preventDefault();
    //   alert('Images Uploaded! (not really, but it would if this was on your website)');
    // }, false);

    function previewImgs(event) {
        totalFiles = imgUpload.files.length;

        if (!!totalFiles) {
            imgPreview.classList.remove('quote-imgs-thumbs--hidden');
            // previewTitle = document.createElement('p');
            // previewTitle.style.fontWeight = 'bold';
            // previewTitleText = document.createTextNode(totalFiles + ' Total Images Selected');
            // previewTitle.appendChild(previewTitleText);
            // imgPreview.appendChild(previewTitle);
        }
        // console.log("sger" ,event.target.files);
        for (var i = 0; i < totalFiles; i++) {

            const fsize = event.target.files[i].size;
            const filesize = Math.round((fsize / 1024));
            upload = document.createElement('div');
            upload.className = "afterImage-upload";
            upload.id = "img_div";
            cent = document.createElement('div');
            cent.className = "d-flex align-items-center";
            prv = document.createElement('div');
            prv.className = "imagePreview";
            img = document.createElement('img');
            img.src = URL.createObjectURL(event.target.files[i]);
            prv2 = document.createElement('div');
            prv2.className = "previewDetail";
            lbl = document.createElement('label');
            lbl.innerHTML = event.target.files[i].name;
            flx = document.createElement('div');
            flx.className = "d-flex align-items-center";
            spn = document.createElement('span');
            spn.innerHTML = filesize + " kb";
            imgPreview.appendChild(upload);
            upload.appendChild(cent);
            cent.appendChild(prv);
            prv.appendChild(img);
            cent.appendChild(prv2);
            prv2.appendChild(lbl);
            prv2.appendChild(spn);
            upload.appendChild(flx);

            flx.innerHTML = '<button type="button" onclick="remove_me(this)">' +
                ' <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false"  viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">' +
                '<path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path  d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>' +
                '</button>';

        }
    }
    // delete image
    function remove_div(id) {
        console.log("remove", id)
        const img_div = document.getElementById('img_div');
        img_div.addEventListener('click', () => {
            img_div.remove();
        });
    }

    // QR code frame URL PATH and ID
    // function getQRFromUrl(d) {
    //     console.log("here---frame")
    //     $("#qr_frame_path").val(d.getAttribute("data-qrframeurl"));
    //     $("#qr_frame_id").val(d.getAttribute("data-qrframeid"));
    //     document.getElementById("qr_frame_id").value = d.getAttribute("data-qrframeid");
    //     document.getElementById("qr_frame_path").value = d.getAttribute("data-qrframeurl");
    //     $("#qr_frame_id_tmp").click();
    //     $("#qr_frame_path_tmp").click();

    // }
</script>

<script type="text/javascript">
    // document.getElementById("loader").style.display = "block";
    // document.getElementById("iframesrc").style.visibility = "hidden";

    // function showIt2() {
    document.getElementById("iframesrc").style.visibility = "visible";
    document.getElementById("loader").style.display = "none";
    // }
    // setTimeout("showIt2()", 1000); // after 5 secs
</script>

<script>
    $("#dot").click(function() {
        $("#dot").addClass('active');
        $("#round").removeClass('active');
        $("#square").removeClass('active');
    });
    $("#round").click(function() {
        $("#dot").removeClass('active');
        $("#round").addClass('active');
        $("#square").removeClass('active');
    });
    $("#square").click(function() {
        $("#dot").removeClass('active');
        $("#round").removeClass('active');
        $("#square").addClass('active');
    });

    $("#RE").click(function() {
        $("#CE").removeClass('active');
        $("#RE").addClass('active');
    });

    $("#CE").click(function() {
        $("#RE").removeClass('active');
        $("#CE").addClass('active');
    });

    // $(document).on('change', '#isGradientSelected', function() {

    //     if ($(this).is(":checked")) {

    //         $('#gradient').show();
    //     } else {
    //         $('#gradient').hide();
    //     }
    // });

    // $(document).ready(function() {
    //     $("#isGradientSelected").change(function() {
    //         console.log("here gradient", $("#isGradientSelected").val())
    //         var selectedOption = $("#isGradientSelected").val()
    //         if (selectedOption == 'gradient') {

    //             $('#gradient').show();
    //         } else {
    //             $('#gradient').hide();
    //         }
    //     });
    // });

    // $(document).ready(function() {
    //     $("#isFrameGradientSelected").change(function() {
    //         console.log("here frame", $("#isFrameGradientSelected").val())
    //         var selectedOption = $("#isFrameGradientSelected").val()
    //         if (selectedOption == 'gradient') {

    //             $('#gradient').show();
    //         } else {
    //             $('#gradient').hide();
    //         }
    //     });
    // });

    // $(document).ready(function() {
    //     $("#isBackgroundGradientSelected").change(function() {
    //         console.log("here background", $("#isBackgroundGradientSelected").val())
    //         var selectedOption = $("#isBackgroundGradientSelected").val()
    //         if (selectedOption == 'gradient') {

    //             $('#gradient').show();
    //         } else {
    //             $('#gradient').hide();
    //         }
    //     });
    // });

    $(document).ready(function() {
    $("#isGradientSelected").change(function() {
        console.log("here gradient", $("#isGradientSelected").val())
        var selectedOption = $("#isGradientSelected").val()
        if (selectedOption == 'gradient') {

            $('#gradient').show();
        } else {
            $('#gradient').hide();
        }
    });
});

$(document).ready(function() {
    $("#isFrameGradientSelected").change(function() {
        console.log("here frame", $("#isFrameGradientSelected").val())
        var selectedOption = $("#isFrameGradientSelected").val()
        if (selectedOption == 'gradient') {

            $('#frame_gradient').show();
        } else {
            $('#frame_gradient').hide();
        }
    });
});

$(document).ready(function() {
    $("#isBackgroundGradientSelected").change(function() {
        console.log("here background", $("#isBackgroundGradientSelected").val())
        var selectedOption = $("#isBackgroundGradientSelected").val()
        if (selectedOption == 'gradient') {

            $('#background_gradient').show();
        } else {
            $('#background_gradient').hide();
        }
    });
});

    // ForgroundColorFirst - changeForgroundColor - ForgroundColorSecond

    $(document).ready(function() {
        $("#passwordField").hide();
        $("#changeForgroundColor").click(
            function() {
                var one = $("#ForgroundColorFirst").val()
                var second = $("#ForgroundColorSecond").val()
                $("#ForgroundColorFirst").val(second)
                $("#ForgroundColorSecond").val(one)
            });

        $("#changeFrameColor").click(
        function() {
            var one = $("#FrameColorFirst").val()
            var second = $("#FrameColorSecond").val()
            $("#FrameColorFirst").val(second)
            $("#FrameColorSecond").val(one)
        });

        // qr_frame_id_1
        for (let index = 0; index < 33; index++) {
            $("#qr_frame_id_" + index).click(
                function() {
                    $("#qr_frame_id_" + index).addClass("active");
                    for (let i = 0; i < 33; i++) {
                        if (i != index) {
                            $("#qr_frame_id_" + i).removeClass("active");
                        }

                    }
                });
            // $("#qr_frame_enabled").click();
        }
        $("#changeForgroundColor").click(
            function() {
                var one = $("#ForgroundColorFirst").val()
                var second = $("#ForgroundColorSecond").val()
                $("#ForgroundColorFirst").val(second)
                $("#ForgroundColorSecond").val(one)
            });

        $("#ForgroundColor").change(function() {
            let selectedOption = $("#ForgroundColor").val()
            $("#ForgroundColorSpan").html(selectedOption)
        });
        $("#BackgroundColor").change(function() {
            let selectedOption = $("#BackgroundColor").val()
            $("#BackgroundColorSpan").html(selectedOption)
        });



        $("#ForgroundColorFirst").change(function() {
            var selectedOption = $("#ForgroundColorFirst").val()
            $("#ForgroundColorFirstSpan").html(selectedOption)
        });
        $("#ForgroundColorSecond").change(function() {
            var selectedOption = $("#ForgroundColorSecond").val()
            $("#ForgroundColorSecondSpan").html(selectedOption)
        });


        $("#changeFrameColor").click(
            function() {
                var one = $("#FrameColorFirst").val()
                var second = $("#FrameColorSecond").val()
                $("#FrameColorFirst").val(second)
                $("#FrameColorSecond").val(one)
            });

        $("#FrameColor").change(function() {
            let selectedOption = $("#FrameColor").val()
            $("#FrameColorSpan").html(selectedOption)
        });
       
        $("#FrameColorFirst").change(function() {
            var selectedOption = $("#FrameColorFirst").val()
            $("#FrameColorFirstSpan").html(selectedOption)
        });
        $("#FrameColorSecond").change(function() {
            var selectedOption = $("#FrameColorSecond").val()
            $("#FrameColorSecondSpan").html(selectedOption)
        });

        $("#changeFrameBackgroundColor").click(
            function() {
                var one = $("#FrameBackgroundColorFirst").val()
                var second = $("#FrameBackgroundColorSecond").val()
                $("#FrameBackgroundColorFirst").val(second)
                $("#FrameBackgroundColorSecond").val(one)
            });

        $("#FrameBackgroundColor").change(function() {
            let selectedOption = $("#FrameBackgroundColor").val()
            $("#FrameBackgroundColorSpan").html(selectedOption)
        });

        $("#FrameBackgroundColorFirst").change(function() {
            var selectedOption = $("#FrameBackgroundColorFirst").val()
            $("#FrameBackgroundColorFirstSpan").html(selectedOption)
        });

        $("#FrameBackgroundColorSecond").change(function() {
            var selectedOption = $("#FrameBackgroundColorSecond").val()
            $("#FrameBackgroundColorSecondSpan").html(selectedOption)
        });


        // EIColorSpan

        $("#EIColor").change(function() {
            let selectedOption = $("#EIColor").val()
            $("#EIColorSpan").html(selectedOption)
        });
        $("#EOColor").change(function() {
            let selectedOption = $("#EOColor").val()
            $("#EOColorSpan").html(selectedOption)
        });

        $("input, textarea").on("keyup", function() {
            console.log("valid");
            if (step == 2) {
                let allAreFilled = true;
                document.getElementById("myform").querySelectorAll("[required]").forEach(function(i) {
                    // console.log("iiii", i);
                    if (!allAreFilled) return;
                    if (i.type === "radio") {
                        let radioValueCheck = false;
                        document.getElementById("myform").querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
                            if (r.checked) radioValueCheck = true;
                        })
                        allAreFilled = radioValueCheck;
                        return;
                    }
                    if (!i.value) {
                        allAreFilled = false;
                        return;
                    }
                })
                console.log("valid", allAreFilled);
                if (!allAreFilled) {
                    $('#temp_next').hide();
                    $('#temp_next_tmp').show();
                } else {
                    $('#temp_next_tmp').hide();
                    $('#temp_next').show();
                }
            }

            // let valid = true;
            // $('[required]').each(function() {
            //     if ($(this).is(':invalid') || !$(this).val()) valid = false;
            // })
            // console.log("valid", valid);
            // if (!valid) {
            //     $('#temp_next').attr('disabled', 'disabled');
            // } else {
            //     $('#temp_next').removeAttr('disabled');
            // }
        });

        for (let index = 1; index < 6; index++) {
            $("#formcolorPalette" + index).click(
                function() {
                    $("#formcolorPalette" + index).addClass("active");
                    for (let i = 1; i < 33; i++) {
                        if (i != index) {
                            $("#formcolorPalette" + i).removeClass("active");
                        }

                    }
                });
        }
        $("#formcolorPalette1").click(
            function() {
                $("#primaryColor").val("#2F6BFD");
                $("#SecondaryColor").val("#0E379A");
                console.log("sdfsdfsdfsdf");
                LoadPreview();
            });

        $("#formcolorPalette2").click(
            function() {
                $("#primaryColor").val("#28EDC9")
                $("#SecondaryColor").val("#03A183")
                LoadPreview()
            });

        $("#formcolorPalette3").click(
            function() {
                $("#primaryColor").val("#28ED28")
                $("#SecondaryColor").val("#00A301")
                LoadPreview()
            });

        $("#formcolorPalette4").click(
            function() {
                $("#primaryColor").val("#EDE728")
                $("#SecondaryColor").val("#A39E0A")
                LoadPreview()
            });

        $("#formcolorPalette5").click(
            function() {
                $("#primaryColor").val("#ED4C28")
                $("#SecondaryColor").val("#A31F01")
                LoadPreview()
            });

    });
</script>

<script>
    $("#social").hide();

    function remove_me(elm) {
        $(elm).parent().parent().remove();
    }

    function remove_me_up(elm) {
        $(elm).parent().parent().parent().remove();
        LoadPreview();
    }

    $(function() {
        $('#passcheckbox').on('change', function() {
            console.log("checked", $(this).prop('checked'))
            // var checked = $(this).prop('checked');
            $('#passwordField').prop('disabled', !$(this).prop('checked'));
            $("#passwordField").val('');
            if ($(this).prop('checked')) {

                $("#passwordBlock").append(`<input autocomplete="new-password" id="passwordField" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code />`);
            } else {
                $("#passwordField").remove();
            }
        });
    });
</script>

<style>
    body {
        overflow: hidden;
    }
</style>