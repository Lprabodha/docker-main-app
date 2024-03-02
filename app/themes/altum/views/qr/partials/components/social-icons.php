<div class="custom-accodian" id="social1" style="display: block;">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_social" aria-expanded="true" aria-controls="acc_social">
        <div class="qr-step-icon">
            <span class="icon-global grey steps-icon"></span>
        </div>

        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_social_icon.social') ?></span>
            <span class="fields-helper-heading"><?= l('qr_step_2_com_social_icon.help_txt.social') ?></span>
        </span>

        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse show" id="acc_social">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <!-- repeter form -->
            <div class="socialFormContainer">

                <?php if (isset($filledInput['social_icon_name'])) { ?>
                    <?php $i = 0; ?>
                    <?php foreach ($filledInput['social_icon_name'] as $key => $socialIconName) { ?>
                        <?php
                        $data_social = $filledInput['social_icon'][$key];
                        $text = "";
                        $type = "";
                        $class_url = "";
                        $attr_url = "";
                        if ($data_social == "dribbble" || $data_social == "line" || $data_social == "snapchat") {
                            $text = l('qr_step_2_com_social_icon.user_id');
                            $class_url = "noturl";
                            $type = 'text';
                            $urlPlaceHolder = l('qr_step_2_com_social_icon.input.user_id.placeholder');


                            if ($data_social == "line") {
                                $attr_url = "https://line.me/R/ti/p/";
                            }
                            if ($data_social == "dribbble") {
                                $attr_url = "https://dribbble.com/";
                            }
                            if ($data_social == "snapchat") {
                                $attr_url = "https://www.snapchat.com/add/";
                            }
                        } else {
                            $type = 'url';
                            $text = l('qr_step_2_com_social_icon.url');
                            $class_url = "url";
                            $urlPlaceHolder = "l('qr_step_2_com_social_icon.input.url.placeholder')";
                        }
                        ?>
                        <div class="social-item-full-wrap">
                            <div class="socialItem row w-100">
                                <div class="socialInner col">
                                    <button type="button" class="social-icon-btn d-block" data-socialiconurl="<?php echo $filledInput['social_icon_url'][$key] ?>" onclick="getQRFromUrl(this);" data-reload-qr-code>
                                        <img class="img-fluid" src="<?php echo $filledInput['social_icon_url'][$key] ?>">
                                        <input type="hidden" name="social_icon_url[]" value="<?php echo (!empty($filledInput)) ? $filledInput['social_icon_url'][$key] : ''; ?>">
                                    </button>
                                    <p class="social-icon-heading d-none"><?php echo $data_social ?></p>
                                </div>
                                <div class="socialBtn col-8">
                                    <button type="button" class="jss4776 social-option-btn up-btn prev-div anchorLoc" data-anchor="socialBlock_<?=$i?>">
                                        <!-- <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M17.71,13.29l-5-5a1,1,0,0,0-1.42,0l-5,5a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,10.41l4.29,4.3a1,1,0,0,0,1.42,0A1,1,0,0,0,17.71,13.29Z"></path>
                                    </svg> -->
                                        <span class="icon-arrow-h-right social-icon-up grey"></span>
                                    </button>
                                    <button type="button" class="jss4776 social-option-btn down-btn next-div anchorLoc" data-anchor="socialBlock_<?=$i+2?>">
                                        <!-- <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M17.71,9.29a1,1,0,0,0-1.42,0L12,13.59,7.71,9.29a1,1,0,0,0-1.42,1.42l5,5a1,1,0,0,0,1.42,0l5-5A1,1,0,0,0,17.71,9.29Z"></path>
                                    </svg> -->
                                        <span class="icon-arrow-h-right social-icon-down grey"></span>
                                    </button>
                                    <button class="close-div social-option-btn delete-btn" type="button">
                                        <!-- <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                    </svg> -->
                                        <span class="icon-trash d-flex social-icon-delete grey"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="row social-icon-field-wrap w-100 m-auto">
                                <hr class="social-hr">
                                <input class="' + data_val + '" onchange="LoadPreview()" value="<?php echo $data_social ?>" name="social_icon[]" type="hidden" class="form-control step-form-control ">
                                <div class="col-6 scoial-field  social-url-wrap">
                                    <div class="form-group mb-3 <?php echo $class_url ?>">
                                        <label class="filed-label"> <?php echo $text ?><span class="text-danger text-bold">*</span>
                                        </label>
                                        <input id="socialUrl" required data-attr="<?php echo $attr_url ?>" name="social_icon_name[]" type="<?php echo $type ?>" placeholder="<?php echo $urlPlaceHolder ?>"  value="<?php echo $socialIconName ?>" data-anchor="socialBlock_0" class="anchorLoc socialUrl step-form-control main-input <?php echo $data_social ?>" input_validate>
                                        <!-- <span class="invalid_err error-label"><?= l('qr_codes.error') ?></span> -->
                                    </div>
                                </div>
                                <div class="col-6 scoial-field">
                                    <div class="form-group m-0">
                                        <label class="filed-label"><?= l('qr_step_2_com_social_icon.text') ?></label>
                                        <input onchange="LoadPreview()" placeholder="<?php echo $qrType == 'vcard' ? l('qr_step_2_com_social_icon.input.text_1.placeholder')  : ('qr_step_2_com_social_icon.input.text_2.placeholder') ?>" value="<?php echo $filledInput['social_icon_text'][$key] ?>"  name="social_icon_text[]" type="text" data-anchor="socialBlock_0" class="anchorLoc form-control step-form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $i++; } ?>
                <?php } ?>

            </div>
            <?php
            $social_icon = array(
                "dribbble" => "icon1",
                "facebook" =>  "icon2",
                "flickr" =>  "icon3",
                "gitHub" =>  "icon4",
                "Google Review" =>  "icon5",
                "line" =>  "icon6",
                "linkedIn" =>  "icon7",
                "pinterest" =>  "icon8",
                "reddit" =>  "icon9",
                "skype" =>  "icon10",
                "snapchat" =>  "icon11",
                "tripAdvisor" =>  "icon12",
                "tumblr" =>  "icon13",
                "twitter" =>  "icon14",
                "vimeo" =>  "icon15",
                "vkontakte" =>  "icon16",
                "web" =>  "icon17",
                "xing" =>  "icon18",
                "youtube" =>  "icon19",
                "instagram" =>  "icon20",
                "tiktok" =>  "icon21",
                "whatsapp" =>  "icon22",
                "telegram" =>  "icon23",
                "Facebook Messenger" =>  "icon24",
                "yelp" =>  "icon25",
                "Uber Eats" =>  "icon26",
                "postmates" =>  "icon27",
                "opentable" =>  "icon28",
                "spotify" =>  "icon29",
                "soundcloud" =>  "icon30",
                "Apple Music" =>  "icon31"
            );

            ?>
            <div class="socialIconContainer">
                <!-- <label class="socialLabel"><?= l('qr_step_2_com_social_icon.add') ?></label> -->
                <div class="socialIconContain">
                    <?php foreach ($social_icon as $key => $value) { ?>
                        <button onchange="LoadPreview()" type="button" id="socialicon_id_<?= $key ?>" class="boxtagLabel anchorLocBtn" data-anchor="socialBlock" data-socialiconid="<?php echo $key; ?>" data-val="<?php echo $value; ?>" data-socialiconurl="<?= ASSETS_FULL_URL . 'images/socialicon/' . $value . '.svg'; ?>" onclick="getQRFromUrl(this);" data-reload-qr-code>
                            <img src="<?= ASSETS_FULL_URL . 'images/socialicon/' . $value . '.svg'; ?>" alt="<?= ucfirst($key) ?>" title="<?= ucfirst($key) ?>" style="width: 100%;">
                        </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /** Social Icons code start */
    function check_length() {
        if ($(".social-item-full-wrap").length == 1) {
            $(".social-item-full-wrap:nth-child(1) .prev-div").css({
                "pointer-events": "none",
                "opacity": "0.3"
            });
            $(".social-item-full-wrap:nth-child(1) .next-div").css({
                "pointer-events": "none",
                "opacity": "0.3"
            });
        } else if ($(".social-item-full-wrap").length == 2) {
            $(".social-item-full-wrap:nth-child(1) .prev-div").css({
                "pointer-events": "none",
                "opacity": "0.3"
            });
            $(".social-item-full-wrap:nth-child(1) .next-div").css({
                "pointer-events": "auto",
                "opacity": "1"
            });
            $(".social-item-full-wrap:last-child .next-div").css({
                "pointer-events": "none",
                "opacity": "0.3"
            });
            $(".social-item-full-wrap:last-child .prev-div").css({
                "pointer-events": "auto",
                "opacity": "1"
            });
        } else {

            $(".social-item-full-wrap .prev-div").css({
                "pointer-events": "auto",
                "opacity": "1"
            });
            $(".social-item-full-wrap .next-div").css({
                "pointer-events": "auto",
                "opacity": "1"
            });
            $(".social-item-full-wrap:nth-child(1) .prev-div").css({
                "pointer-events": "none",
                "opacity": "0.3"
            });
            $(".social-item-full-wrap:nth-child(1) .next-div").css({
                "pointer-events": "auto",
                "opacity": "1"
            });
            $(".social-item-full-wrap:last-child .next-div").css({
                "pointer-events": "none",
                "opacity": "0.3"
            });
            $(".social-item-full-wrap:last-child .prev-div").css({
                "pointer-events": "auto",
                "opacity": "1"
            });
        }
    }
    $(document).on("click", ".socialBtn .close-div", function() {
        $(this).parents(".social-item-full-wrap").remove();
        LoadPreview();
        check_length();
    })

    $(document).on("click", ".prev-div", function() {
        var par = $(this).parents(".social-item-full-wrap");
        // console.log("par : " + par);
        $(par).insertBefore($(par).prev());
        LoadPreview(false,false,this.getAttribute('data-anchor'));
        check_length();
    })
    $(document).on("click", ".next-div", function() {
        var par = $(this).parents(".social-item-full-wrap");
        $(par).insertAfter($(par).next());
        LoadPreview(false,false,this.getAttribute('data-anchor'));
        check_length();
    })

    $(".socialIconContain button").on("click", function() {
        currentPos = $(this).data('anchor');
        var data_social = $(this).attr('data-socialiconid');
        var data_val = $(this).attr('data-val');
        var text = "";
        var type = "";
        var class_url = "";
        var attr_url = "";
        if (data_social == "dribbble" || data_social == "line" || data_social == "snapchat") {
            text = "<?= l('qr_step_2_com_social_icon.user_id') ?>";
            class_url = "noturl";
            type = 'text'
            urlPlaceHolder = "<?= l('qr_step_2_com_social_icon.input.user_id.placeholder') ?>";


            if (data_social == "line") {
                attr_url = "https://line.me/R/ti/p/";
            }
            if (data_social == "dribbble") {
                attr_url = "https://dribbble.com/";
            }
            if (data_social == "snapchat") {
                attr_url = "https://www.snapchat.com/add/";
            }
            
            console.log(class_url);
        } else {
            type = 'url'
            text = "<?= l('qr_step_2_com_social_icon.url') ?>";
            class_url = "url";
            urlPlaceHolder = "<?= l('qr_step_2_com_social_icon.input.url.placeholder') ?>";
        }

        var qrType = $('input[name="qrtype_input"]').val();
        console.log("#qrType : " + qrType);
        if (qrType == 'vcard') {
            textPlaceHolder = "<?= l('qr_step_2_com_social_icon.input.text_2.placeholder') ?>";
        } else {
            textPlaceHolder = "<?= l('qr_step_2_com_social_icon.input.text_1.placeholder') ?>";
        }

        var _uri = "<?php echo ASSETS_FULL_URL; ?>images/socialicon/" + data_val + ".svg";


        var data_add = '<div class="social-item-full-wrap"><div class="socialItem row"> <div class="socialInner col" ><button type="button" class="social-icon-btn d-block" data-socialiconurl="' + _uri + '" onclick="getQRFromUrl(this);" data-reload-qr-code><img class="img-fluid" src="' + _uri + '"><input type="hidden" name="social_icon_url[]" value="' + _uri + '"></button><p class="social-icon-heading d-none">' + data_social + '</p></div><div class="socialBtn col-8"><button type="button" class="jss4776 social-option-btn prev-div up-btn"><span class="icon-arrow-h-right social-icon-up grey"></span></button><button type="button" class="jss4776 next-div down-btn social-option-btn"><span class="icon-arrow-h-right social-icon-down grey"></span></button><button class="close-div social-option-btn delete-btn" type="button"><span class="icon-trash social-icon-delete d-flex grey"></span></button></div></div><div class="row social-icon-field-wrap w-100 m-auto"><hr class="social-hr"><input class="' + data_val + '" onchange="LoadPreview()" value="'+ data_social +'" name="social_icon[]" type="hidden" class="step-form-control"><div class="col-6 scoial-field social-url-wrap"><div class="form-group mb-3 ' + class_url +'"> <label class="filed-label">'+ text +'<span class="text-danger text-bold">*</span></label> <input id="socialUrl" placeholder="' + urlPlaceHolder + '" required data-attr="'+ attr_url +'" name="social_icon_name[]" type="'+ type +'" value="" data-anchor="socialBlock" class="anchorLoc socialUrl step-form-control main-input '+ data_social +' " input_validate></div></div><div class="col-6 scoial-field"><div class="form-group m-0"><label class="filed-label">Text</label><input onchange="LoadPreview()" value="" name="social_icon_text[]" placeholder="'+ textPlaceHolder +'"  type="text" data-anchor="socialBlock" class="anchorLoc step-form-control"></div></div></div></div>';
        
        $(".socialFormContainer").append(data_add);

        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        })

        $(".social-item-full-wrap").each((i,e)=>{
            $(e).find("input").each((j,elm)=>{elm.setAttribute('data-anchor',`socialBlock_${i+1}`)});
            $(e).find(".up-btn").each((j,elm)=>{
                elm.classList.add('anchorLoc');
                elm.setAttribute('data-anchor',`socialBlock_${i}`);
            });
            $(e).find(".down-btn").each((j,elm)=>{
                elm.classList.add('anchorLoc');
                elm.setAttribute('data-anchor',`socialBlock_${i+2}`);
            });
        })

        LoadPreview();
        check_length();
    })


    $(".socialFormContainer").on("touchend", ".social-option-btn", function() {
        setTimeout(function() {
            $(".social-option-btn").css({
                'background-color': '#fff'
            });
        }, 1000);
    });
</script>