<?php defined('ALTUMCODE') || die() ?>



<footer class="footer">


    <div class="container">
        <div class="row p-3">
            <div class="col-md-6">
                <h3 class="text-start text-white font-weight-bold"><?= l('footer.title') ?></h3>
            </div>
            <div class="col-md-6">
                <a href="login"><button type="button" class="btn rounded-pill" style="height:54px; padding:0">
                        <span class="font-weight-bold"><?= l('footer.register_btn') ?></span>
                    </button></a>
            </div>
        </div>

        <hr class="hr-light" >



        <div class="row footer_menu_row">
            <div class="col-lg-3 footer-section-image">
                <div class="row  ">
                    <div class="col-12 float-left mb-4 mr-2 ">
                        <a href="index.html"><img src="<?= ASSETS_FULL_URL . 'images/footerlogo.png' ?>" class="footer_image" alt="QR code generator"></a>
                    </div>

                    <div class="col-12 mb-4  text-white font-weight-bold">
                        <p><?= l('global.title') ?></p>
                    </div>

                    <div class="col-12 col-lg-auto text-white font-weight-bold mb-4 ">
                        <div class="d-flex flex-wrap">
                            <?php foreach(require APP_PATH . 'includes/admin_socials.php' as $key => $value): ?>
                                <?php if(isset(settings()->socials->{$key}) && !empty(settings()->socials->{$key})): ?>
                                    <a href="<?= sprintf($value['format'], settings()->socials->{$key}) ?>" class="mr-2 mr-lg-0 ml-lg-2 mb-2 text-white font-weight-bold" target="_blank" data-toggle="tooltip" title="<?= $value['name'] ?>"><i class="<?= $value['icon'] ?> fa-fw fa-lg"></i></a>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>

                </div>
            </div>


            <hr class="mobile_hr">

            <div class="col-lg-2 footer-section">
                <div class="row menu-icon link_topic">
                    <div class="col-11 p-0 link_topic">
                        <h6 class="text-white font-weight-bold text-uppercase"><?= l('footer.service') ?></h6>
                    </div>
                    <div class="col-1 p-0 mobile_button_area">
                        <span class="text-white"><i class="fa fa-plus" id="plus" aria-hidden="true"></i><i class="fa fa-minus" id="minus" aria-hidden="true"></i></span>
                    </div>
                    <ul class="ul_list nav-list" id="nav-list">
                        <li class="list_item"><a class="text-white" href="<?= url('qr') ?>"><?= l('footer.service.create_qr') ?></a></li>
                        <li class="list_item"><a class="text-white" href="<?= url('plan') ?>"><?= l('footer.service.plans') ?></a></li>
                    </ul>
                </div>
            </div>

            <hr class="mobile_hr">

            <div class="col-lg-2 footer-section">
                <div class="row menu-icon2">
                    <div class="col-11 p-0">
                        <h6 class="text-white font-weight-bold text-uppercase"><?= l('footer.company') ?></h6>
                    </div>
                    <div class="col-1 p-0 mobile_button_area">
                        <span class="text-white"><i class="fa fa-plus" id="plus2" aria-hidden="true"></i><i class="fa fa-minus" id="minus2" aria-hidden="true"></i></span>
                    </div>
                    <ul class="ul_list nav-list2">
                        <li class="list_item"><a class="text-white" href="<?= url('terms-and-conditions') ?>"><?= l('footer.company.terms_cond') ?></a></li>
                        <li class="list_item"><a class="text-white" href="<?= url('privacy-policy') ?>"><?= l('footer.company.privacy') ?></a></li>
                    </ul>
                </div>
            </div>

            <hr class="mobile_hr">

            <div class="col-lg-2 footer-section">
                <div class="row menu-icon3">
                    <div class="col-11 p-0">
                        <h6 class="text-white font-weight-bold text-uppercase"><?= l('footer.help') ?></h6>
                    </div>
                    <div class="col-1 p-0 mobile_button_area">
                        <span class="text-white"><i class="fa fa-plus" id="plus3" aria-hidden="true"></i><i class="fa fa-minus" id="minus3" aria-hidden="true"></i></span>
                    </div>
                    <ul class="ul_list nav-list3">
                        <li class="list_item"><a class="text-white" href="<?= url('contact') ?>"><?= l('footer.help.contact') ?></a></li>
                        <li class="list_item"><a class="text-white" href="<?= url('faq') ?>"><?= l('footer.help.faq') ?></a></li>
                    </ul>
                </div>
            </div>

            <hr class="mobile_hr">

            <div class="col-lg-2 footer-section">
                <div class="row menu-icon4">
                    <div class="col-11 p-0">
                        <h6 class="text-white font-weight-bold text-uppercase"><?= l('footer.get-touth') ?></h6>
                    </div>
                    <div class="col-1 p-0 mobile_button_area">
                        <span class="text-white"><i class="fa fa-plus" id="plus4" aria-hidden="true"></i><i class="fa fa-minus" id="minus4" aria-hidden="true"></i></span>
                    </div>
                    <ul class="ul_list nav-list4">
                        <li class="list_item"><a class="text-white" href="#">Info@gmail.com</a></li>
                    </ul>
                </div>
            </div>
            <hr class="mobile_hr">
        </div>       
        <div class="row">
            <div class="col-md-12 copyright">
                <p class="text-white" style="font-size: smaller;">QR Code’ is a trademark of DENSO WAVE INCORPORATED</p>
                <p class="text-white" style="font-size: smaller;"><?=  date("Y"); ?> © QR.New, Uk</p>
            </div>
        </div>
    </div>
</footer>

<script>
    function animation(max_width) {
        if (max_width.matches) {
            $(".menu-icon").click(function() {
                $(this).toggleClass("menu-animation");
                $(".nav-list").toggle("easing", function() {
                    $(".nav-list").toggleClass("nav-animation");
                    var true_icon = document.getElementById("plus");
                    var minus_icon = document.getElementById("minus");
                    var nav_list = document.getElementById("nav-list");
                    if (window.getComputedStyle(minus_icon).display == "none") {
                        document.getElementById("plus").style.display = "none";
                        document.getElementById("minus").style.display = "block";
                    } else {
                        document.getElementById("minus").style.display = "none";
                        document.getElementById("plus").style.display = "block";
                    }
                });
            });

            $(".menu-icon2").click(function() {
                $(this).toggleClass("menu-animation");

                $(".nav-list2").toggle("easing", function() {
                    $(".nav-list2").toggleClass("nav-animation");
                    var true_icon = document.getElementById("plus2");
                    var minus_icon = document.getElementById("minus2");
                    if (window.getComputedStyle(minus_icon).display == "none") {
                        document.getElementById("minus2").style.display = "block";
                        document.getElementById("plus2").style.display = "none";
                    } else {
                        document.getElementById("minus2").style.display = "none";
                        document.getElementById("plus2").style.display = "block";
                    }
                });
            });

            $(".menu-icon3").click(function() {
                $(this).toggleClass("menu-animation");

                $(".nav-list3").toggle("easing", function() {
                    $(".nav-list3").toggleClass("nav-animation");
                    var true_icon = document.getElementById("plus3");
                    var minus_icon = document.getElementById("minus3");
                    if (window.getComputedStyle(minus_icon).display == "none") {
                        document.getElementById("minus3").style.display = "block";
                        document.getElementById("plus3").style.display = "none";
                    } else {
                        document.getElementById("minus3").style.display = "none";
                        document.getElementById("plus3").style.display = "block";
                    }
                });
            });

            $(".menu-icon4").click(function() {
                $(this).toggleClass("menu-animation");

                $(".nav-list4").toggle("easing", function() {
                    $(".nav-list4").toggleClass("nav-animation");
                    var true_icon = document.getElementById("plus4");
                    var minus_icon = document.getElementById("minus4");
                    if (window.getComputedStyle(minus_icon).display == "none") {
                        document.getElementById("minus4").style.display = "block";
                        document.getElementById("plus4").style.display = "none";
                    } else {
                        document.getElementById("minus4").style.display = "none";
                        document.getElementById("plus4").style.display = "block";
                    }
                });
            });
        }
    }
    var max_width = window.matchMedia("(max-width: 990px)");
    animation(max_width);
    max_width.addListener(animation);

</script>