<style>
    .select-box {
        display: flex !important;
    }

    .drp-icon-btn-open {
        position: absolute;
    }

    .drp-icon-btn-close {
        position: absolute;
    }

    @media(max-width:768.98px) {
        .font-touch-add-btn {
            background-color: var(--primary-green-1) !important;
            color: var(--white) !important;
            transition: 0.2s;
        }
    }

    @media(max-width:576.98px) {
        #acc_nameOfFonts .dropdown .btn.drp-btn {
            /* -webkit-user-select: none; */
            /* user-select: none; */
        }
    }
</style>

<div class="custom-accodian consider">
    <button class="btn accodianBtn collapsed" type="button" data-toggle="collapse" data-target="#acc_nameOfFonts" aria-expanded="true" aria-controls="acc_nameOfFonts">
        <div class="qr-step-icon">
            <span class="icon-fonts grey steps-icon"></span>
        </div>

        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_fonts.fonts') ?></span>
            <span class="fields-helper-heading"><?= l('qr_step_2_com_fonts.help_txt.fonts') ?></span>
        </span>

        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse " id="acc_nameOfFonts">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="bg-container">
                <div class="row">
                    <div class="form-group m-0 col-md-6 col-sm-12">
                        <label for="filters_title_by" class="fieldLabel"><?= l('qr_step_2_com_fonts.font_title') ?></label>
                        <div class="custom-select-box font-select-box">

                            <div class="select-box">

                                <input class="filters_title_by step-form-control" readonly type="text" value="<?php echo (!empty($filledInput) && ($filledInput['font_title'])) ? ($filledInput['font_title']) : 'GT Walsheim Pro'; ?>" style="position: relative; font-family: <?php echo (!empty($filledInput) && ($filledInput['font_title'])) ? ($filledInput['font_title']) : 'GT Walsheim Pro'; ?> ;" id="filters_title_by" onchange="LoadPreview()" name="font_title">


                                <button type="button" class="drp-icon-btn-open">
                                    <i id="drp-icon-open" class="fa-solid fa-angle-down"></i>
                                </button>
                                <button type="button" class="drp-icon-btn-close">
                                    <i id="drp-icon-close" class="fa-solid fa-angle-up"></i>
                                </button>
                            </div>
                            <div class="dropdown" id="dropdown">
                                <button type="button" class="btn drp-btn btn-walsh" value="GT Walsheim Pro">GT Walsheim Pro</button>
                                <button type="button" class="btn drp-btn btn-lato" value="Lato">Lato</button>
                                <button type="button" class="btn drp-btn btn-open" value="Open Sans">Open Sans</button>
                                <button type="button" class="btn drp-btn btn-robo" value="Roboto">Roboto</button>
                                <button type="button" class="btn drp-btn btn-oswa" value="Oswald">Oswald</button>
                                <button type="button" class="btn drp-btn btn-mont" value="Montserrat">Montserrat</button>
                                <button type="button" class="btn drp-btn btn-sour" value="Source Sans Pro">Source Sans Pro</button>
                                <button type="button" class="btn drp-btn btn-slab" value="Slabo 27px">Slabo 27px</button>
                                <button type="button" class="btn drp-btn btn-rale" value="Raleway">Raleway</button>
                                <button type="button" class="btn drp-btn btn-merr" value="Merriwealther">Merriwealther</button>
                                <button type="button" class="btn drp-btn btn-noto" value="Noto Sans">Noto Sans</button>
                            </div>
                        </div>

                    </div>
                    <div class="form-group m-0 col-md-6 col-sm-12">
                        <label for="filters_text_by" class="fieldLabel"><?= l('qr_step_2_com_fonts.texts') ?></label>
                        <div class="custom-select-box font-select-box">
                            <div class="select-box">

                                <input class="filters_title_by step-form-control" readonly type="text" value="<?php echo (!empty($filledInput) && ($filledInput['font_text'])) ? ($filledInput['font_text']) : 'GT Walsheim Pro'; ?>" style="font-family: <?php echo (!empty($filledInput) && ($filledInput['font_text'])) ? ($filledInput['font_text']) : 'GT Walsheim Pro'; ?> ;" id="filters_text_by" onchange="LoadPreview()" name="font_text">
                                <button type="button" class="drp-icon-btn-open">
                                    <i id="drp-icon-open" class="fa-solid fa-angle-down"></i>
                                </button>
                                <button type="button" class="drp-icon-btn-close">
                                    <i id="drp-icon-close" class="fa-solid fa-angle-up"></i>
                                </button>
                            </div>
                            <div class="dropdown" id="dropdown">
                                <button type="button" class="btn drp-btn btn-walsh" value="GT Walsheim Pro">GT Walsheim Pro</button>
                                <button type="button" class="btn drp-btn btn-lato" value="Lato">Lato</button>
                                <button type="button" class="btn drp-btn btn-open" value="Open Sans">Open Sans</button>
                                <button type="button" class="btn drp-btn btn-robo" value="Roboto">Roboto</button>
                                <button type="button" class="btn drp-btn btn-oswa" value="Oswald">Oswald</button>
                                <button type="button" class="btn drp-btn btn-mont" value="Montserrat">Montserrat</button>
                                <button type="button" class="btn drp-btn btn-sour" value="Source Sans Pro">Source Sans Pro</button>
                                <button type="button" class="btn drp-btn btn-slab" value="Slabo 27px">Slabo 27px</button>
                                <button type="button" class="btn drp-btn btn-rale" value="Raleway">Raleway</button>
                                <button type="button" class="btn drp-btn btn-merr" value="Merriwealther">Merriwealther</button>
                                <button type="button" class="btn drp-btn btn-noto" value="Noto Sans">Noto Sans</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".custom-select-box input").click(function() {
        if ($(this).parents('.custom-select-box').children('.dropdown').hasClass('active')) {
            $(this).parents('.custom-select-box').children('.dropdown').removeClass('active')
            $(this).parents('.custom-select-box').children('.select-box').children('.drp-icon-btn-open').css("display", "block");
            $(this).parents('.custom-select-box').children('.select-box').children('.drp-icon-btn-close').css("display", "none");

        } else {
            $(this).parents('.custom-select-box').children('.dropdown').addClass('active')
            $(this).parents('.custom-select-box').children('.select-box').children('.drp-icon-btn-open').css("display", "none");
            $(this).parents('.custom-select-box').children('.select-box').children('.drp-icon-btn-close').css("display", "block");
            $('.font-select-box #dropdown').focus();
        }
    });

    $(document).ready(function() {
        $(".drp-icon-btn-close").css("display", "none");
    });

    $(".drp-icon-btn-open").click(function() {
        $(this).parents('.custom-select-box').children('.dropdown').addClass('active')
        $(this).css("display", "none");
        $(".dropdown .active").focus();
        $(this).next(".drp-icon-btn-close").css("display", "block");
        $('.font-select-box #dropdown').focus();
    });

    $(".drp-icon-btn-close").click(function() {
        $(this).parents('.custom-select-box').children('.dropdown').removeClass('active')
        $(".drp-icon-btn-close").css("display", "none");
        $(".drp-icon-btn-open").css("display", "block");
    });

    let isScrolling = false;

    var scrollElemnt = $(".font-select-box #dropdown .active");

    $(".font-select-box #dropdown").on('scroll', () => {
        if (!isScrolling) {
            isScrolling = true;
            $(".custom-select-box .dropdown .drp-btn").css({
                'pointer-events': 'none',
                'touch-action': 'none'
            });
        }

        clearTimeout(scrollTimeout);
        var scrollTimeout = setTimeout(() => {
            isScrolling = false;
            $(".custom-select-box .dropdown .drp-btn").css({
                'pointer-events': 'auto',
                'touch-action': 'auto'
            });
            $('.font-select-box #dropdown').focus();
        }, 100);
    });

    $(".custom-select-box .dropdown .drp-btn").on('click', function(e) {
        e.preventDefault();
        $(this).parents(".dropdown").removeClass('active');
        let setFont = $(this).parents(".custom-select-box").children('.select-box').children('input');
        setFont.attr("value", $(this).attr("value"));
        setFont.css("font-family", $(this).attr("value"));
        LoadPreview();
        setTimeout(function() {
            $(".drp-icon-btn-close").css("display", "none");
            $(".drp-icon-btn-open").css("display", "block");
        }, 800);
    });

    $(".custom-select-box .dropdown").mouseleave(function() {
        $(this).next(".dropdown").removeClass('active')
    });
    $(".custom-select-box").mouseleave(function() {
        $(".dropdown").removeClass('active')
        $(".drp-icon-btn-close").css("display", "none");
        $(".drp-icon-btn-open").css("display", "block");
    });
    $(".custom-select-box input").mouseleave(function() {
        $(this).removeClass('active')
        $(".drp-icon-btn-close").css("display", "none");
        $(".drp-icon-btn-open").css("display", "block");
    });
</script>
