<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->


<script>
    /* Vcard Social Script */
    'use strict';

    /* add new */
    let vcard_social_add = event => {
        let clone = document.querySelector(`#template_vcard_social`).content.cloneNode(true);
        let count = document.querySelectorAll(`[id="vcard_socials"] .mb-4`).length;

        if (count >= 20) return;

        clone.querySelector(`input[name="vcard_social_label[]"`).setAttribute('name', `vcard_social_label[${count}]`);
        clone.querySelector(`input[name="vcard_social_value[]"`).setAttribute('name', `vcard_social_value[${count}]`);

        document.querySelector(`[id="vcard_socials"]`).appendChild(clone);

        vcard_social_remove_initiator();

        apply_reload_qr_code_event_listeners();
    };

    document.querySelectorAll('[data-add="vcard_social"]').forEach(element => {
        element.addEventListener('click', vcard_social_add);
    })

    /* remove */
    let vcard_social_remove = event => {
        event.currentTarget.closest('.mb-4').remove();
    };

    let vcard_social_remove_initiator = () => {
        document.querySelectorAll('[id^="vcard_socials_"] [data-remove]').forEach(element => {
            element.removeEventListener('click', vcard_social_remove);
            element.addEventListener('click', vcard_social_remove)
        })
    };

    vcard_social_remove_initiator();
</script>

<script>
    /* Vcard Phone Numbers */
    'use strict';

    /* add new */
    let vcard_phone_number_add = event => {
        let clone = document.querySelector(`#template_vcard_phone_number`).content.cloneNode(true);
        let count = document.querySelectorAll(`[id="vcard_phone_numbers"] .mb-4`).length;

        if (count >= 20) return;

        clone.querySelector(`input[name="vcard_phone_number[]"`).setAttribute('name', `vcard_phone_number[${count}]`);

        document.querySelector(`[id="vcard_phone_numbers"]`).appendChild(clone);

        vcard_phone_number_remove_initiator();

        apply_reload_qr_code_event_listeners();
    };

    document.querySelectorAll('[data-add="vcard_phone_number"]').forEach(element => {
        element.addEventListener('click', vcard_phone_number_add);
    })

    /* remove */
    let vcard_phone_number_remove = event => {
        event.currentTarget.closest('.mb-4').remove();
    };

    let vcard_phone_number_remove_initiator = () => {
        document.querySelectorAll('[id^="vcard_phone_numbers_"] [data-remove]').forEach(element => {
            element.removeEventListener('click', vcard_phone_number_remove);
            element.addEventListener('click', vcard_phone_number_remove)
        })
    };

    vcard_phone_number_remove_initiator();
</script>

<script>
    // 'use strict';

    /* Type handler */
    let type_handler = (selector, data_key) => {
        if (!document.querySelector(selector)) {
            return;
        }

        let type = null;
        if (document.querySelector(selector).type == 'radio') {
            type = document.querySelector(`${selector}:checked`) ? document.querySelector(`${selector}:checked`).value : null;
        } else {
            type = document.querySelector(selector).value;
        }

        document.querySelectorAll(`[${data_key}]:not([${data_key}="${type}"])`).forEach(element => {
            element.classList.add('d-none');
            let input = element.querySelector('input,select,textarea');

            if (input) {
                if (input.getAttribute('required')) {
                    input.setAttribute('data-is-required', 'true');
                }
                // if(input.getAttribute('disabled')) {
                //     input.setAttribute('data-is-disabled', 'true');
                // }
                input.setAttribute('disabled', 'disabled');
                input.removeAttribute('required');
            }
        });

        document.querySelectorAll(`[${data_key}="${type}"]`).forEach(element => {
            element.classList.remove('d-none');
            let input = element.querySelector('input,select,textarea');

            if (input) {
                input.removeAttribute('disabled');
                if (input.getAttribute('data-is-required')) {
                    input.setAttribute('required', 'required')
                }
                // if(input.getAttribute('data-is-disabled')) {
                //     input.setAttribute('disabled', 'required')
                // }
            }
        });
    }

    type_handler('select[name="type"]', 'data-type');
    document.querySelector('select[name="type"]') && document.querySelector('select[name="type"]').addEventListener('change', () => {
        type_handler('select[name="type"]', 'data-type');
        url_dynamic_handler()
    });

    type_handler('[name="foreground_type"]', 'data-foreground-type');
    document.querySelector('[name="foreground_type"]') && document.querySelectorAll('[name="foreground_type"]').forEach(element => {
        element.addEventListener('change', () => {
            type_handler('[name="foreground_type"]', 'data-foreground-type')
        });
    })

    type_handler('select[name="custom_eyes_color"]', 'data-custom-eyes-color');
    document.querySelector('select[name="custom_eyes_color"]') && document.querySelector('select[name="custom_eyes_color"]').addEventListener('change', () => {
        type_handler('select[name="custom_eyes_color"]', 'data-custom-eyes-color')
    });

    /* Url Dynamic handler */
    let url_dynamic_handler = () => {
        // console.log("test function load");
        if (document.querySelector('select[name="type"]')) {
            let type = document.querySelector('select[name="type"]').value;

            if (type != 'url') {
                return;
            }
        }

        if (!document.querySelector('#url')) {
            return;
        }

        let url_dynamic = document.querySelector('#url_dynamic').checked;

        console.log(url_dynamic);

        if (url_dynamic) {
            document.querySelector('#url').removeAttribute('required');
            document.querySelector('[data-url]').classList.add('d-none');
            document.querySelector('#link_id').setAttribute('required', 'required');
            document.querySelector('[data-link-id]').classList.remove('d-none');

            let link_id_element = document.querySelector('#link_id');
            if (link_id_element.options.length) {
                document.querySelector('#url').value = link_id_element.options[link_id_element.selectedIndex].text;
            }
        } else {
            document.querySelector('#link_id').removeAttribute('required');
            document.querySelector('[data-link-id]').classList.add('d-none');
            document.querySelector('#url').setAttribute('required', 'required');
            document.querySelector('[data-url]').classList.remove('d-none');
        }
    }

    if (document.querySelector('#url_dynamic')) {
        url_dynamic_handler();
        document.querySelector('#url_dynamic').addEventListener('change', url_dynamic_handler);
    }

    /* URL Dynamic Link_id handler */
    let link_id_handler = () => {
        let link_id_element = document.querySelector('#link_id');

        if (link_id_element && document.querySelector('#url_dynamic') && document.querySelector('#url_dynamic').checked) {
            document.querySelector('#url').value = link_id_element.options[link_id_element.selectedIndex].text;
        }
    }
    document.querySelector('#link_id') && document.querySelector('#link_id').addEventListener('change', link_id_handler);

    /* On change regenerated qr */
    let delay_timer = null;

    let apply_reload_qr_code_event_listeners = () => {

        document.querySelectorAll('[data-reload-qr-code]').forEach(element => {
            ['change', 'paste', 'keyup'].forEach(event_type => {
                element.removeEventListener(event_type, reload_qr_code_event_listener);
                element.addEventListener(event_type, reload_qr_code_event_listener);

            })
        });
    }
    

    let reload_qr_code_event_listener = () => {

        /* Add the preloader, hide the QR */
        document.querySelector('#qr_code')?.classList.add('qr-code-loading');
        $("#temp_submit").prop("disabled", true);
        // $("#2").attr('disabled', false);
        // $("#2").removeClass("disable-btn");

        /* Disable the submit button */
        if (document.querySelector('button[type="submit"]')) {
            document.querySelector('button[type="submit"]').classList.add('disabled');
            document.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled');
        }

        clearTimeout(delay_timer);

        delay_timer = setTimeout(() => {

            /* Send the request to the server */
            let form = document.querySelector('form#myform');
            let form_data = new FormData(form);

            let notification_container = form.querySelector('.notification-container');
            notification_container.innerHTML = '';

            fetch(`${url}qr-code-generator`, {
                    method: 'POST',
                    body: form_data,
                })
                .then(response => response.ok ? response.json() : Promise.reject(response))
                .then(data => {
                    if (data.status == 'error') {
                        display_notifications(data.message, 'error', notification_container);
                    } else if (data.status == 'success') {
                        display_notifications(data.message, 'success', notification_container);

                        // $("#2").attr('disabled', false);
                        // $("#2").removeClass("disable-btn");

                        $('#qr-code-wrap').html(data.details.image);
                        document.querySelector('#download_svg').href = data.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            // console.log('yes qr_code input');
                            document.querySelector('input[name="qr_code"]').value = data.details.data;
                        }

                        /* Enable the submit button */
                        if (document.querySelector('button[type="submit"]')) {
                            document.querySelector('button[type="submit"]').classList.remove('disabled');
                            document.querySelector('button[type="submit"]').removeAttribute('disabled');
                        }
                    }

                    /* Hide the preloader, display the QR */
                    $("#temp_submit").prop("disabled", false);
                    document.querySelector('#qr_code').classList.remove('qr-code-loading');

                })
                .catch(error => {});

        }, 750);
    }

    function makePDF(link, pWidth, pHeight, width, height, fileName) {
        width = width * 60 / 100;
        height = height * 60 / 100;

        const {
            jsPDF
        } = window.jspdf;
        let image = new Image;
        image.crossOrigin = 'anonymous';
        /* Convert SVG data to others */
        image.onload = function() {
            let canvas = document.createElement('canvas');
            canvas.width = 1000;
            canvas.height = 1200;
            const marginX = (pWidth - width) / 2;
            const marginY = (pHeight - height) / 2;
            let context = canvas.getContext('2d');
            context.drawImage(image, 0, 0, 1000, 1200);
            let data = canvas.toDataURL(`image/png`, 1);
            // const pdf = new jsPDF(); 
            var pdf = new jsPDF('p', 'mm', [pWidth, pHeight], true);
            pdf.addImage(data, 'PNG', marginX, marginY, width, height, '', 'FAST')
            pdf.setProperties({
                title: fileName,
                author: "<?= isset($this->user->id) ? $this->user->name : 'Online QR Generator' ?>",
                subject: fileName,
                keywords: 'qr,generator',
                creator: 'Online QR Generator'
            })
            // pdf.save(fileName);
            var blob = pdf.output('blob');
            var formData = new FormData();
            formData.append('file', blob);
            formData.append('name', fileName);
            formData.append('action', 'download_pdf');

            $.ajax({
                type: 'POST',
                url: '<?= url('api/ajax') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    window.location = "download.php?file=" + response.data.path;
                },
                error: (response) => {
                    console.log(response);
                }
            });
        }
        reCorrectSvg(link).then((res)=>{
            image.src = URL.createObjectURL(new Blob([res],{type:"image/svg+xml"}))
        })
    }



    function savePdf(ImageData, fileName, jobid = null, reqBlob = false) {
        const {
            jsPDF
        } = window.jspdf;

        var pdf = new jsPDF('p', 'mm', 'a4', true);
        ImageData.forEach((image, i) => {
            const marginX = (pdf.internal.pageSize.getWidth() - (image.size ? image.size : image.width)) / 2;
            const marginY = (pdf.internal.pageSize.getHeight() - (image.size ? image.size : image.height)) / 2;

            pdf.addImage(
                image.imgLink,
                'png',
                marginX,
                marginY,
                image.size ? image.size : image.width,
                image.size ? image.size : image.height,
                '', 'FAST'
            );
            if (ImageData.length !== i + 1) {
                pdf.addPage("a4", "p");
            }
        })

        pdf.setProperties({
            title: fileName,
            author: "<?= isset($this->user->user_id) ? $this->user->name : 'Online QR Generator' ?>",
            subject: `${ImageData.length}`,
            keywords: 'qr,generator',
            creator: 'Online QR Generator'
        })

        if (!reqBlob) {
            pdf.save(fileName);
            $("#DownloadModal").find(".new-dl-close").trigger('click');
            clearTmpSvg('pdf', jobid);
        } else {
            return pdf.output('blob');
        }

    }


    apply_reload_qr_code_event_listeners();

    /* SVG to PNG, WEBP, JPG download handler */
    let convert_svg_to_others = (svg_data, type, name, width, height) => {
        svg_data = !svg_data && document.querySelector('#download_svg') ? document.querySelector('#download_svg').href : svg_data;

        let image = new Image;
        image.crossOrigin = 'anonymous';
        if(type == 'svg'){
            image.src = svg_data;
        }else{
            reCorrectSvg(svg_data).then((res)=>{
                image.src = URL.createObjectURL(new Blob([res],{type:"image/svg+xml"}))
            })
        }
        /* Convert SVG data to others */
        image.onload = function() {
            let canvas = document.createElement('canvas');

            canvas.width = width;
            canvas.height = height;

            let context = canvas.getContext('2d');
            // context.drawImage(image);
            // context.fillStyle = "white";
            if (type == "jpeg" | type == "jpg") {
                context.beginPath();
                context.rect(0, 0, width, height);
                context.fillStyle = "white";
                context.fill();
            }

            context.drawImage(image,
                0, 0, width, height
            );

            let data = canvas.toDataURL(`image/${type}`, 1);

            /* Download */
            let link = document.createElement('a');
            link.download = name;
            link.style.opacity = '0';
            document.body.appendChild(link);
            link.href = data;
            link.click();
            link.remove();
        }

        /* Add SVG data */


    }

    function makeEPS(link, width, fileName, tmpName, qrId) {
        var data = {
            action: 'convert_image_eps',
            svgPath: link,
            width: width,
            tmpName: tmpName,
            qrId: qrId
        }

        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax') ?>',
            data: data,
            success: function(response) {
                ForceDownload(response.data.path, fileName, `${tmpName}.eps`);
            },
            error: () => {

            }
        });
    }

    function downloadSvg(uri, name, width, height, tmpName) {
        var data = {
            action: 'resizeSvg',
            svgPath: uri,
            width: width,
            height: height,
            tmpName: tmpName
        }

        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax') ?>',
            data: data,
            success: function(response) {

                ForceDownload(response.data.path, name, `${tmpName}.svg`);
            },
            error: () => {

            }
        });
    }

    // All JS For Download Modal

    $(document).on('click', ".dl-modal-option-card", function() {
        const checkbox = this.querySelector(".qrCode-check .roundCheckbox input");
        const sizePicker = this.parentNode.parentNode.querySelector('.dl-modal-size-picker-section .dl-modal-size-picker');
        const downloadBtn = this.parentNode.parentNode.querySelector('.primary-btn');
        const PickerData = this.parentNode.parentNode.querySelector('.dl-modal-size-picker-section .dl-modal-size-picker-options');
        if (!checkbox.checked) {
            checkbox.checked = true
            this.classList.add('dl-modal-option-card-active');
            this.querySelector(".dl-modal-option-card-body .card-body-image-section img").classList.add('card-body-image-active');
            this.querySelector(".dl-modal-option-card-body div .m-show").classList.add('m-show-active');
            this.parentNode.setAttribute('data-selected', checkbox.id);
            this.parentNode.parentNode.querySelector('.dl-modal-size-picker-section .dl-modal-size-picker span').innerHTML = 'Default';
        }

        if (checkbox.id === "pdf") {
            changeFileSizes(this.parentNode.parentNode, 'pdf');
            sizePicker.removeAttribute('disabled');
            sizePicker.classList.remove('dl-modal-size-picker-disabled');
            downloadBtn.classList.remove('toPrintBtn');
            downloadBtn.classList.add('downloadQrCode');
            PickerData.setAttribute('data-selected', '210x297');
            $(".download-modal-text").html('<?= l('qr_download.download_model.download_text') ?>');
            $("#icon-dl-btn").addClass('icon-downloadBtn');
            $("#icon-dl-btn").removeClass('icon-print-run');
        } else if (checkbox.id === "print") {
            sizePicker.setAttribute('disabled', true);
            sizePicker.classList.add('dl-modal-size-picker-disabled');
            $(".download-modal-text").html('<?= l('qr_download.download_model.print_text') ?>');
            $("#icon-dl-btn").removeClass('icon-downloadBtn');
            $("#icon-dl-btn").addClass('icon-print-run');

            downloadBtn.classList.add('toPrintBtn');
            downloadBtn.classList.remove('downloadQrCode');

        } else {
            changeFileSizes(this.parentNode.parentNode, 'all');
            sizePicker.removeAttribute('disabled');
            sizePicker.classList.remove('dl-modal-size-picker-disabled');
            downloadBtn.classList.remove('toPrintBtn');
            downloadBtn.classList.add('downloadQrCode');
            PickerData.setAttribute('data-selected', '1024x1024');
            $(".download-modal-text").html('<?= l('qr_download.download_model.download_text') ?>');
            $("#icon-dl-btn").addClass('icon-downloadBtn');
            $("#icon-dl-btn").removeClass('icon-print-run');
        }

        const alertM = this.parentNode.parentNode.querySelector('.dl-modal-alert');
        if (checkbox.id === "eps") {
            alertM.style.display = 'flex';
            $(".share-btn").addClass('disable-share');
            $(".share-btn").removeClass('outline-btn');
            $(".new-download-modal > .modal-dialog > .modal-content").addClass('laptop-modal-content');
            $(".new-download-modal > .modal-dialog").addClass('laptop-modal-dialog');
        } else if (checkbox.id === "print") {
            alertM.style.display = 'none';
            $(".share-btn").addClass('disable-share');
            $(".share-btn").removeClass('outline-btn');
            $(".new-download-modal > .modal-dialog > .modal-content").removeClass('laptop-modal-content');
            $(".new-download-modal > .modal-dialog").removeClass('laptop-modal-dialog');
        } else {
            alertM.style.display = 'none';
            $(".share-btn").removeClass('disable-share');
            $(".share-btn").addClass('outline-btn');
            $(".new-download-modal > .modal-dialog > .modal-content").removeClass('laptop-modal-content');
            $(".new-download-modal > .modal-dialog").removeClass('laptop-modal-dialog');
        }

        const checkBoxes = document.querySelectorAll('.chk input');
        checkBoxes.forEach(e => {
            if (checkbox.id !== e.id) {
                e.checked = false;
            }
        });
        const optionCards = document.querySelectorAll('.dl-modal-option-card');
        optionCards.forEach(e => {
            if (e !== this) {
                e.classList.remove('dl-modal-option-card-active')
                e.querySelector(".dl-modal-option-card-body .card-body-image-section img").classList.remove('card-body-image-active');
                e.querySelector(".dl-modal-option-card-body div .m-show").classList.remove('m-show-active');
            }
        });
    });

    $(document).on('click', ".size-picker-option", function() {
        const PDF_SIZES = {
            'Default': 'Default',
            'A4': '210x297',
            'A3': '297x420',
            'A2': '420x594',
            'A1': '594x841',
            'A0': '841x1189'
        };
        const currType = this.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector('.dl-modal-options').getAttribute('data-selected');
        const thisCheckbox = this.querySelector(".picker-option-s input");
        thisCheckbox.checked = true;
        if (thisCheckbox.id === "Default") {
            if (currType === "pdf") {
                this.parentNode.setAttribute('data-selected', '210x297');
            } else {
                this.parentNode.setAttribute('data-selected', '1024x1024');
            }
        } else {
            if (currType === "pdf") {
                this.parentNode.setAttribute('data-selected', PDF_SIZES[thisCheckbox.id]);
            } else {
                this.parentNode.setAttribute('data-selected', thisCheckbox.id);
            }
        }
        this.parentNode.parentNode.querySelector('.dl-modal-size-picker span').innerText = thisCheckbox.id;

        const thisLabel = this.querySelector('.picker-option-l');
        const Labels = document.querySelectorAll('.dl-modal-size-picker-options .size-picker-option .picker-option-l');
        Labels.forEach((e) => {
            if (e === thisLabel) {
                e.classList.add('active');
            } else {
                e.classList.remove('active');
            }
        });
    });

    function expandSizePicker(elm) {
        if (!elm.getAttribute('disabled')) {
            const dropDown = document.querySelector('.dl-modal-size-picker-options');
            if (dropDown.hidden) {
                dropDown.hidden = false;
                elm.classList.add('dl-modal-size-picker-active');
                const fullHeight = window.visualViewport.height;
                const offset = dropDown.getBoundingClientRect().bottom;
                if (fullHeight < offset) {
                    dropDown.style.top = `${(getComputedStyle(dropDown).top.split('p')[0] - (offset - fullHeight))-5}px`;
                } else {
                    // dropDown.style.top = getComputedStyle(dropDown).top;
                }
            } else {
                dropDown.hidden = true;
                elm.classList.remove('dl-modal-size-picker-active');
            }

            window.onclick = (e) => {
                if (e.target !== dropDown && e.target !== elm && e.target !== elm.querySelector('span')) {
                    dropDown.hidden = true;
                    elm.classList.remove('dl-modal-size-picker-active');
                }
            }
        }
    }

    function changeFileSizes(cElm, type) {
        const FILE_SIZES = {
            all: ['Default', '512x512', '1024x1024', '2048x2048', '4096x4096'],
            pdf: ['Default', 'A4', 'A3', 'A2', 'A1', 'A0'],
        }
        const optionSection = cElm.querySelector('.dl-modal-size-picker-section .dl-modal-size-picker-options');
        let options = '';
        FILE_SIZES[type].forEach(e => {
            options += ` <div class="size-picker-option">
                            <div class="picker-option-s"><input type="radio" name="sizes" id="${e}" ${ e === "Default" ? 'checked' : '' }></div>
                            <div class="picker-option-l ${ e === "Default" ? 'active' : '' }"><label for="${e}">${e}</label></div>
                        </div>`
        })
        optionSection.innerHTML = options;
    }

    function setQrCodeData(elm) {
        var qrCodeCard = $(elm).closest('.qrCode-card');
        var fileName = qrCodeCard.find('.qrCodeName').text();
        var link = qrCodeCard.find('.qrCode-image img').attr('src');
        var qrId = qrCodeCard.find('.qrCodeId').val();
        var qrUid = qrCodeCard.find('.qrCodeUid').val();
        var qrType = qrCodeCard.find('.qrCodeType').val();

        if (!qrUid) {
            var fileName = $('#popFileName').val();
            var link = $('#popDmQrcodeLink').val();
            var qrId = $('#popQrId').val();
            var qrUid = $('#popQrUid').val();
            var qrType = $('#popQrType').val();
        }

        $("#DownloadModal").find("#fileName").val(fileName);
        $("#DownloadModal").find("#dmQrcodeLink").val(link);
        $("#DownloadModal").find("#qr_id").val(qrId);
        $("#DownloadModal").find("#qr_uid").val(qrUid);
        $("#DownloadModal").find("#qr_type").val(qrType);
    }

    $(document).on('click', '.downloadBtn', function() {
        const dlBtn = $('.downloadQrCode').length > 0 ? $('.downloadQrCode') : $('.toPrintBtn').filter((i, e) => {
            return e.localName === 'button' ? true : false
        });
        const dlModalFooter = $('.dl-modal-footer-buttons');
        const sizePicker = $('.dl-modal-size-picker-section');
        dlBtn.attr('data-dismiss', '');
        if ($(this).hasClass('bulk')) {
            if ($("input.qrSelected:checked").length <= 1) {
                sizePicker.show();
                dlModalFooter.removeClass('bl-bulk-options');
                dlBtn.removeClass('bulk');
                dlBtn.addClass('single');
                setQrCodeData($('.qrCode-card.selected'));
            } else {
                sizePicker.hide();
                dlBtn.removeClass('single');
                dlModalFooter.addClass('bl-bulk-options');
                dlBtn.addClass('bulk');
            }
        } else {
            sizePicker.show();
            dlModalFooter.removeClass('bl-bulk-options');
            dlBtn.removeClass('bulk');
            dlBtn.addClass('single');
        }
    })


    function ForceDownload(link, filename, tmp = null) {

        const dlBtnHtml = $(".downloadQrCode").html();
        $(".downloadQrCode").html('<?= l('qr_download.download_model.starting') ?>');
        let blob;
        const xmlHTTP = new XMLHttpRequest();
        xmlHTTP.open('GET', link, true);
        xmlHTTP.responseType = 'arraybuffer';
        xmlHTTP.onload = function(e) {
            blob = new Blob([this.response]);
        };
        xmlHTTP.onprogress = function(pr) {
            const dlProg = ((pr.loaded / pr.total) * 100).toFixed(0);
            $(".downloadQrCode").html(`<?= l('qr_download.download_model.downloading') ?> ${dlProg}%`);
        };
        xmlHTTP.onloadend = function(e) {
            $(".downloadQrCode").html(dlBtnHtml);
            let url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
            $("#DownloadModal").find(".new-dl-close").trigger('click');
            clearTmpSvg(filename.split('.')[1], filename);
        }
        xmlHTTP.onerror = (e) => {
            console.log(e);
            show_alert('error','<?= str_replace("'", "\'", l('qr_download.download_model.download_fail_alert')) ?>');
            $(".downloadQrCode").html(dlBtnHtml);
            $("#DownloadModal").find(".new-dl-close").trigger('click');
        }
        xmlHTTP.send();
    }

    function clearTmpSvg(type, tmp) {
        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax') ?>',
            data: {
                action: "clearTemp",
                fileName: tmp,
                type: type === 'pdf' ? 'folder' : 'file'
            },
            success: function(data) {
                // modal.find("button.new-dl-close").trigger('click');
            }
        })
    }

    $(document).ready(function() {
        if ($('#DownloadModal').css('display') == 'block') {
            if (window.matchMedia('(min-width: 576px)').matches) {
                var modelContent = $(".modal-content ");
                $(document).on("click", function(e) {
                    if (!modelContent.is(e.target) && modelContent.has(e.target).length === 0) {
                        // $("#DownloadModal").removeClass('show');
                        // $('#DownloadModal').css({
                        //     'display': 'none'
                        // });
                        // $("body").css({
                        //     'overflow': 'auto'
                        // });
                        // firstDownloadModelClose();
                    }
                });
            }
        }

    });


    $(".qr-code-download-btn").on("click", function() {
        $(".qr-code-model").removeClass('show');
        $('.qr-code-model').css({
            'display': 'none'
        });

        $(".close-download-model-btn").on("click", function() {
            $('.modal-backdrop').fadeOut(300, function() {
                $(this).remove();
            });
        });
    });



    function firstDownloadModelClose() {
        var formData = new FormData();
        formData.append('action', 'hideDownloadModel');
        formData.append('user_id', '<?= $this->user->user_id ?>');
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                $('.first-modal-img-wrap').html('<h3 class="new-dl-modal-title mb-4 mt-5"><?= l('qr_download.download_model.title') ?></h3>');
            },
            error: (code) => {
                if (code.status == 500) {
                    console.log('failed');
                }
            },
        });
    }

    async function shareFile(blog, fileName, fileType, shareButtonHTML) {

        var shareBtn = $("#shareBtn");
        var modal = $("#shareBtn").closest("#DownloadModal");
        var qrId = modal.find("#qr_id").val();
        var qrUid = modal.find("#qr_uid").val();
        var user_id = modal.find("#user_id").val();

        const blob = await blog;

        const file = new File([blob], fileName, {
            type: fileType
        });

        const shareObject = {
            title: fileName,
            files: [file],
            qrCodeId: qrId,
            uId: qrUid
        };

        shareBtn.html(shareButtonHTML);

        try {

            if (navigator.share !== undefined) {
                try {
                    await navigator.share(shareObject)
                        .then(() => {

                            var data = {
                                action: 'change_qr_download_status',
                                qr_code_id: shareObject.qrCodeId,
                                uid: shareObject.uId,
                            }

                            $.ajax({
                                type: 'POST',
                                url: '<?= url('api/ajax') ?>',
                                data: data,
                                success: function(response) {
                                    console.log(response.data);
                                },
                                error: (e) => {
                                    show_alert('error', "Something went wrong : " + e);
                                }
                            });
                        })
                        .catch((error) => {

                        });
                } catch (error) {
                    console.error("Error sharing:", error);
                }
            } else {
                // show_alert('error', "Sharing is not available. You can manually share the QR code.");
            }

        } catch (error) {
            shareBtn.html(shareButtonHTML);
            console.error("Web Share API permission denied:", error);
        }




    }

    // Share Qr Code
    $("#shareBtn").click(async function() {
        // $('#sharePopup').modal('show');
        var modal = $("#shareBtn").closest("#DownloadModal");
        var link = modal.find("#dmQrcodeLink").val();
        var fileName = modal.find("#fileName").val();
        var type = $('.dl-modal-options').attr('data-selected');
        var size = $('.dl-modal-size-picker-options').attr('data-selected').split('x');
        var qrId = modal.find("#qr_id").val();
        var qrType = modal.find("#qr_type").val();
        var qrUid = modal.find("#qr_uid").val();
        var user_id = modal.find("#user_id").val();
        var shareBtn = $("#shareBtn");
        var downloadBtn = $('.downloadQrCode');
        let shareButtonHTML = $(this).html();
        const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50"  class="new-spinner-share"><circle r="20" cy="50" cx="50"></circle></svg></div>`;
        shareBtn.html(spinnerHTML);
        if (typeof navigator.share === "undefined") {
            $('#DownloadModal').css('z-index', 1039);

        }
        // Bulk share
        if (downloadBtn.hasClass('bulk')) {
            var selectedQrCodes = [];
            $("input.qrSelected:checked").each(function() {
                selectedQrCodes.push($(this).attr('id'));

            });

            if (selectedQrCodes.length > 10) {
                show_alert('error', '<?= l('qr_download.download_model.qr_share_limit_alert') ?>');
                shareBtn.html(shareButtonHTML);
                return
            }

            if (type == "eps") {
                show_alert('error', "<?= l('qr_download.download_model.eps_alert') ?>");
                shareBtn.html(shareButtonHTML);

            } else {
                getDataFromSvg(type, selectedQrCodes).then(data => {
                    share({
                        title: fileName,
                        files: data,
                        qrCodeId: qrId,
                        uId: qrUid,
                        user_id: user_id
                    })
                    shareBtn.html(shareButtonHTML);
                });
            }

        } else {

            if (type == 'eps') {
                show_alert('error', "<?= l('qr_download.download_model.eps_alert') ?>");
            } else {
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

                    success: function(response) {
                        let width = response.data.width;
                        let height = response.data.height;
                        let fileName = response.data.name;

                        if (type == "svg") {
                            var data = {
                                action: 'svg_resize_return',
                                svgPath: link,
                                width: width,
                                height: height,
                                tmpName: qrUid
                            }

                            $.ajax({
                                type: 'POST',
                                url: '<?= url('api/ajax') ?>',
                                data: data,
                                success: function(response) {
                                    getDataFromSvg(type, [response?.data?.svg]).then((data => {
                                        share({
                                            title: fileName,
                                            files: data,
                                            qrCodeId: qrId,
                                            uId: qrUid,
                                            user_id: user_id
                                        })
                                        shareBtn.html(shareButtonHTML);
                                    }))
                                },
                                error: () => {

                                }
                            });
                        } else if (type == "pdf") {
                            width = width * 60 / 100;
                            height = height * 60 / 100;
                            let pWidth = size[0];
                            let pHeight = size[1];

                            const {
                                jsPDF
                            } = window.jspdf;
                            let image = new Image;
                            image.crossOrigin = 'anonymous';
                            /* Convert SVG data to others */
                            image.onload = function() {
                                let canvas = document.createElement('canvas');
                                canvas.width = 1200;
                                canvas.height = 1200;
                                const marginX = (pWidth - width) / 2;
                                const marginY = (pHeight - height) / 2;
                                let context = canvas.getContext('2d');
                                context.drawImage(image, 0, 0, 1200, 1200);
                                let data = canvas.toDataURL(`image/png`, 1);
                                // const pdf = new jsPDF(); 
                                var pdf = new jsPDF('p', 'mm', [pWidth, pHeight], true);
                                pdf.addImage(data, 'PNG', marginX, marginY, width, height, '', 'FAST')
                                pdf.setProperties({
                                    title: fileName,
                                    author: "<?= isset($this->user->user_id) ? $this->user->name : 'Online QR Generator' ?>",
                                    subject: fileName,
                                    keywords: 'qr,generator',
                                    creator: 'Online QR Generator'
                                })

                                var blob = pdf.output('blob');

                                if (blob) {
                                    shareFile(blob, fileName, 'application/pdf', shareButtonHTML)
                                }
                            }
                            reCorrectSvg(link).then((res)=>{
                                image.src = URL.createObjectURL(new Blob([res],{type:"image/svg+xml"}))
                            })

                        } else {
                            getDataFromSvg(type, [link], size[0], size[1]).then(data => {
                                share({
                                    title: fileName,
                                    files: data,
                                    qrCodeId: qrId,
                                    uId: qrUid,
                                    user_id: user_id
                                })
                                shareBtn.html(shareButtonHTML);
                            });
                        }
                    },
                    error: () => {
                        show_alert('error', "<?= l('qr_download.download_model.file_share_alert') ?>");
                        shareBtn.html(shareButtonHTML);
                    }
                });
            }
        }
    });

    $('#sharePopup').on('hidden.bs.modal', function() {
        if (typeof navigator.share === "undefined") {
            $('#DownloadModal').css('z-index', 1060);
        }
    });

    function getMimeType(type) {
        let fileType;
        switch (type) {
            case 'png':
                fileType = 'image/png';
                break;
            case 'jpeg':
                fileType = 'image/jpeg';
                break;
            case 'print':
                fileType = 'image/png';
                break;
            case 'eps':
                fileType = 'application/eps';
                break;
            case 'pdf':
                fileType = 'application/pdf';
                break;
            case 'svg':
                fileType = 'image/svg+xml';
                break;
            default:
                fileType = 'image/png';
                break;
        }

        return fileType;
    }

    async function share(shareObject) {

        if (navigator.share !== undefined) {
            try {
                await navigator.share(shareObject)
                    .then(() => {
                        var data = {
                            action: 'change_qr_download_status',
                            qr_code_id: shareObject.qrCodeId,
                            uid: shareObject.uId,
                            user_id: shareObject.user_id
                        }

                        $.ajax({
                            type: 'POST',
                            url: '<?= url('api/ajax') ?>',
                            data: data,
                            success: function(response) {

                            },
                            error: () => {

                            }
                        });
                    })
                    .catch((error) => {

                    });
            } catch (error) {
                console.error("Error sharing:", error);
            }
        } else {

            // $('#sharePopup').modal('show');

        }

    }

    function isValidEmail(email) {
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(email);
    }

    function shareQrViaEmail() {
        var email = $('#recieverEmail').val();
        var downloadModal = $("#shareBtn").closest("#DownloadModal");
        var link = downloadModal.find("#dmQrcodeLink").val();
        var fileName = downloadModal.find("#fileName").val();
        var type = $('.dl-modal-options').attr('data-selected');
        var size = $('.dl-modal-size-picker-options').attr('data-selected').split('x');
        var qrId = downloadModal.find("#qr_id").val();
        var qrType = downloadModal.find("#qr_type").val();
        var qrUid = downloadModal.find("#qr_uid").val();
        var shareBtn = $("#shareBtn");
        var downloadBtn = $('.downloadQrCode');
        var userId = document.getElementById('uid').value;
        var isBulk = false;
        var qrArr = [];
        var selectedQrCodes = [];
        var sendBtn = $('#shareToEmailBtn');
        const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50"  class="new-spinner"><circle r="20" cy="50" cx="50"></circle></svg></div>`;
        sendBtn.html(spinnerHTML);

        if (downloadBtn.hasClass('bulk')) {
            isBulk = true;
            $("input.qrSelected:checked").each(function() {
                selectedQrCodes.push($(this).attr('id'));
            });
        }

        if (email === null || email === undefined || email == '' || !isValidEmail(email)) {
            $('#emailReq').show();
            sendBtn.html("Send");
        } else {
            $('#emailReq').hide();

            if (isBulk == true) {

                if (type == "svg") {
                    let width = 1024;
                    let height = 1024;

                    var data = {
                        action: 'svg_resize_return',
                        svgPath: selectedQrCodes,
                        width: width,
                        height: height,
                        tmpName: qrUid,
                        isBulk: isBulk
                    }

                    $.ajax({
                        type: 'POST',
                        url: '<?= url('api/ajax') ?>',
                        data: data,
                        success: function(response) {

                            var jsonData = JSON.stringify(response?.data);
                            const jsonObject = JSON.parse(jsonData);
                            const stringArray = [];

                            for (const item of jsonObject) {
                                stringArray.push(item['svg']);
                            }

                            getDataFromSvg(type, stringArray).then(res => {
                                var formData = new FormData();
                                res.forEach((qr) => {
                                    formData.append('file[]', qr);
                                });

                                formData.append('action', 'share_email_attachment');
                                formData.append('email', email);
                                formData.append('user_id', userId);
                                formData.append('type', type);
                                formData.append('uid', qrUid);
                                formData.append('is_bulk', isBulk);
                                // Make the AJAX request
                                $.ajax({
                                    type: 'POST',
                                    url: '<?= url('api/ajax') ?>',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        show_alert('success', "<?= l('qr_share.success') ?>" + ' ' + email);
                                        sendBtn.html("Send");
                                        $("#sharePopup").find("#closeBtn").trigger('click');
                                        modal.find("button.close").trigger('click');
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }).catch(error => {
                                console.error('Error getting SVG data:', error);
                            });

                        }
                    });
                } else {
                    getDataFromSvg(type, selectedQrCodes).then(res => {
                        var formData = new FormData();
                        // Append the file data
                        res.forEach((qr) => {
                            formData.append('file[]', qr);
                        });

                        formData.append('action', 'share_email_attachment');
                        formData.append('email', email);
                        formData.append('user_id', userId);
                        formData.append('type', type);
                        formData.append('uid', qrUid);
                        formData.append('is_bulk', isBulk);
                        // Make the AJAX request
                        $.ajax({
                            type: 'POST',
                            url: '<?= url('api/ajax') ?>',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                show_alert('success', "<?= l('qr_share.success') ?>" + ' ' + email);
                                sendBtn.html("Send");
                                $("#sharePopup").find("#closeBtn").trigger('click');
                                modal.find("button.close").trigger('click');
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    }).catch(error => {
                        console.error('Error getting SVG data:', error);
                    });
                }

            } else {
                // Single share
                if (type == "svg") {
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

                        success: function(response) {
                            let width = response.data.width;
                            let height = response.data.height;

                            var data = {
                                action: 'svg_resize_return',
                                svgPath: link,
                                width: width,
                                height: height,
                                tmpName: qrUid
                            }

                            $.ajax({
                                type: 'POST',
                                url: '<?= url('api/ajax') ?>',
                                data: data,
                                success: function(response) {

                                    getDataFromSvg(type, [response?.data?.svg], width, height).then(res => {

                                        var formData = new FormData();
                                        // Append the file data
                                        formData.append('file', res[0]);
                                        formData.append('action', 'share_email_attachment');
                                        formData.append('email', email);
                                        formData.append('user_id', userId);
                                        formData.append('type', type);
                                        formData.append('qrId', qrId);
                                        formData.append('qr_name', fileName);
                                        formData.append('uid', qrUid);
                                        formData.append('is_bulk', isBulk);

                                        // Make the AJAX request
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?= url('api/ajax') ?>',
                                            data: formData,
                                            contentType: false,
                                            processData: false,
                                            success: function(response) {
                                                show_alert('success', "<?= l('qr_share.success') ?>" + ' ' + email);
                                                sendBtn.html("Send");
                                                $("#sharePopup").find("#closeBtn").trigger('click');
                                                modal.find("button.close").trigger('click');
                                            },
                                            error: function(error) {
                                                console.error(error);
                                            }
                                        });
                                    }).catch(error => {
                                        console.error('Error getting SVG data:', error);
                                    });


                                },
                                error: () => {

                                }
                            });

                        }
                    });
                } else if (type == "pdf") {

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

                        success: function(response) {
                            let width = response.data.width;
                            let height = response.data.height;


                            width = width * 60 / 100;
                            height = height * 60 / 100;
                            let pWidth = size[0];
                            let pHeight = size[1];

                            const {
                                jsPDF
                            } = window.jspdf;
                            let image = new Image;
                            image.crossOrigin = 'anonymous';
                            /* Convert SVG data to others */
                            image.onload = function() {
                                let canvas = document.createElement('canvas');
                                canvas.width = 1200;
                                canvas.height = 1200;
                                const marginX = (pWidth - width) / 2;
                                const marginY = (pHeight - height) / 2;
                                let context = canvas.getContext('2d');
                                context.drawImage(image, 0, 0, 1200, 1200);
                                let data = canvas.toDataURL(`image/png`, 1);
                                // const pdf = new jsPDF(); 
                                var pdf = new jsPDF('p', 'mm', [pWidth, pHeight], true);
                                pdf.addImage(data, 'PNG', marginX, marginY, width, height, '', 'FAST')
                                pdf.setProperties({
                                    title: fileName,
                                    author: "<?= isset($this->user->user_id) ? $this->user->name : 'Online QR Generator' ?>",
                                    subject: fileName + '.pdf',
                                    keywords: 'qr,generator',
                                    creator: 'Online QR Generator'
                                })

                                var blob = pdf.output('blob');

                                const pdfFile = new File([blob], fileName, {
                                    type: 'application/pdf'
                                });


                                var formData = new FormData();
                                // Append the file data
                                formData.append('file', pdfFile);
                                formData.append('action', 'share_email_attachment');
                                formData.append('email', email);
                                formData.append('user_id', userId);
                                formData.append('type', type);
                                formData.append('qrId', qrId);
                                formData.append('qr_name', fileName);
                                formData.append('uid', qrUid);
                                formData.append('is_bulk', isBulk);

                                // Make the AJAX request
                                $.ajax({
                                    type: 'POST',
                                    url: '<?= url('api/ajax') ?>',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        show_alert('success', "<?= l('qr_share.success') ?>" + ' ' + email);
                                        sendBtn.html("Send");
                                        $("#sharePopup").find("#closeBtn").trigger('click');
                                        modal.find("button.close").trigger('click');
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }
                            reCorrectSvg(link).then((res)=>{
                                image.src = URL.createObjectURL(new Blob([res],{type:"image/svg+xml"}))
                            })
                        }
                    })
                } else {
                    getDataFromSvg(type, [link], size[0], size[1]).then(res => {

                        var formData = new FormData();
                        // Append the file data
                        formData.append('file', res[0]);
                        formData.append('action', 'share_email_attachment');
                        formData.append('email', email);
                        formData.append('user_id', userId);
                        formData.append('type', type);
                        formData.append('qrId', qrId);
                        formData.append('qr_name', fileName);
                        formData.append('uid', qrUid);
                        formData.append('is_bulk', isBulk);

                        // Make the AJAX request
                        $.ajax({
                            type: 'POST',
                            url: '<?= url('api/ajax') ?>',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                show_alert('success', "<?= l('qr_share.success') ?>" + ' ' + email);
                                sendBtn.html("Send");
                                $("#sharePopup").find("#closeBtn").trigger('click');
                                modal.find("button.close").trigger('click');
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    }).catch(error => {
                        console.error('Error getting SVG data:', error);
                    });
                }

            }
        }
    }

    async function getDataFromSvg(type, selectedQrCodes, width = 1024, height = 1024) {

        const data = [];

        function convert() {
            return new Promise(resolve => {
                let i = 0;
                selectedQrCodes.forEach((link) => {
                    const filename = `${link.split('.')[0]}.${type === 'print'? 'png' : type }`;

                    if (type === 'svg') {
                        fetchSvg(link).then(res => {
                            const file = new File([res], filename, {
                                type: 'image/svg+xml',
                            });
                            data.push(file);

                            if (selectedQrCodes.length === i + 1) {
                                resolve(data);
                            }
                            i++;
                        });
                    } else {
                        reCorrectSvg(link).then((res)=>{
                            const image = new Image();
                            image.crossOrigin = 'anonymous';

                            image.onload = function() {
                                const canvas = document.createElement('canvas');

                                const iWidth = width;
                                const iHeight = height * (image.naturalHeight / image.naturalWidth);

                                canvas.width = width;
                                canvas.height = iHeight;

                                const context = canvas.getContext('2d');

                                if (type == "jpeg" || type == "jpg") {
                                    context.beginPath();
                                    context.rect(0, 0, width, iHeight);
                                    context.fillStyle = "white";
                                    context.fill();
                                }

                                context.drawImage(image,
                                    10, 10, iWidth - 20, iHeight - 20
                                );

                                if (type === 'pdf') {
                                    data.push({
                                        imgLink: canvas.toDataURL(getMimeType(type), 1),
                                        size: null,
                                        width: Math.floor((iWidth * 25.4) / Math.round((image.naturalHeight / image.naturalWidth) * 130)), //px to mm
                                        height: Math.floor((iHeight * 25.4) / Math.round((image.naturalHeight / image.naturalWidth) * 130))
                                    });
                                } else {
                                    data.push(dataURLtoFile(canvas.toDataURL(getMimeType(type), 1), filename));
                                }

                                image.remove();
                                canvas.remove();

                                if (selectedQrCodes.length === i + 1) {
                                    resolve(data);
                                }

                                i++;
                            }
                            image.style.backgroundColor = "red";
                            image.src = URL.createObjectURL(new Blob([res],{type:"image/svg+xml"}));
                        });
                    }

                })
            })
        }

        await convert().catch((e) => {
            console.error(e)
        })

        if (type === 'pdf') {
            const pdfBlob = await savePdf(data, 'share.pdf', null, true);
            return [new File([pdfBlob], 'share-pdf.pdf', {
                type: pdfBlob.type
            })];
        } else {
            return data
        }

    }

    const reCorrectSvg = (svgPath)=>{
        return new Promise(resolve=>{
            const fr = new FileReader();
            fetchSvg(svgPath).then((res)=>{
                fr.readAsText(res);
                fr.onload = ()=>{
                    const svgRes =  String(fr.result);
                    const doc = new DOMParser().parseFromString(svgRes,"image/svg+xml");
                    const svgElm = doc.documentElement
                    if(!svgElm.hasAttribute('width') && !svgElm.hasAttribute('height')){
                        const dimensions = svgElm.getAttribute('viewBox').split(' ');
                        svgElm.setAttribute('width',dimensions[2])
                        svgElm.setAttribute('height',dimensions[3])
                        resolve(svgElm.outerHTML)
                    }else{
                        resolve(svgRes);
                    }
                }
            })
        })
    }

    function dataURLtoFile(dataUrl, filename) {
        var arr = dataUrl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[arr.length - 1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {
            type: mime
        });
    }

    async function fetchSvg(path) {
        const response = await fetch(path);
        const blob = await response.blob();
        return blob;
    }

    async function ArchiveToZip(type, imagesPath, width, height) {
        const jsZip = new JSZip();
        await getDataFromSvg(type, imagesPath[0]).then(data => {
            data.forEach((file, i) => {
                jsZip.file(`${imagesPath[1][i]}.${type}`, file);
            })
        })
        await jsZip.generateAsync({
            type: "blob"
        }).then((content) => {
            saveAs(content, `${new Date().getTime()}.zip`);
        });
    }

    $("#saveUrl").click(function() {
        const Modal = $(this).closest('#editURL');
        const userID = Modal.find('#user_id').val();
        const qrID = Modal.find('#qr_id').val();
        const errorTag = Modal.find('#urlErr');
        const newUrlField = Modal.find('#newUrl');
        const saveBtnHTML = $(this).html();
        const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50"  class="new-spinner-share"><circle r="20" cy="50" cx="50"></circle></svg></div>`;

        if (validateURL(newUrlField.val())) {
            errorTag.hide();
            newUrlField.css("border", "2px solid #96949C");

            // $('#editURL').hide();
            $('#editURL').fadeOut(100);
            $('#editURL').removeClass('show');
            $('body').removeClass('set-scroll-none');
            $('#overlayPre').css({
                'opacity': '0',
                'display': 'none'
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: {
                    action: 'updateURL',
                    user_id: userID,
                    qr_id: qrID,
                    url: newUrlField.val()
                },
                dataType: 'json',
                beforeSend: () => {
                    $(this).html(spinnerHTML);
                },
                success: (resp) => {
                    $(this).html(saveBtnHTML);
                    show_alert(resp.status ? 'success' : 'error', resp.message);
                    Modal.find('#closeBtn').click();
                    qrCodeListing();
                },
                error: (xhr, ert) => {
                    $(this).html(saveBtnHTML);
                    show_alert('error',`${xhr.status === 0 ? '<?=str_replace("'", "\'", l('qr_codes.edit_url_modal.error_msg.disconnected'))?>' : xhr.status === 500 ? '<?= str_replace("'", "\'", l('qr_codes.edit_url_modal.error_msg.server')) ?>' : '<?= str_replace("'", "\'", l('qr_codes.edit_url_modal.error_msg.wrong')) ?>'}`);
                }
            });

        } else {
            errorTag.show();
            newUrlField.css("border", "2px solid red");
        }
    });

    function validateURL(url) {
        var urlValue = (url).trim()
        var expression = /^(http|https|ftp):\/\/[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}(?:[a-z]{2,})?\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        var regex = new RegExp(expression);

        if (urlValue == "") {
            return false;
        } else if (!urlValue.match(regex)) {
            if (!(/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlValue))) {
                return false;
            }
            return true
        } else {
            return true;
        }
    }

    <?php if (isset($_GET['name'])) : ?> document.querySelector('select[name="type"]').dispatchEvent(new Event('change'));
        document.querySelector('input[name="reload"]').dispatchEvent(new Event('change'));
    <?php endif ?>

    function downloadModalClose() {
        $("#DownloadModal").removeClass('show');
        $('#DownloadModal').css({
            'display': 'none'
        });
        $(".modal-backdrop").remove();
    }


</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>