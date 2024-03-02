<?php defined('ALTUMCODE') || die() ?>


<section class="banner">
    <div class="container">
        <div class="white-box">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="banner-heading">
                        <h2><?= l('global.title') ?></h2>
                        <p>Easily generate, manage and statistically track your QR codes.</p>
                        <?php if (\Altum\Middlewares\Authentication::check()) :
                            redirect("qr-codes/")
                        ?>
                            <a href="qr/"><?= l('qr_code_create.title') ?> <i class="fas fa-arrow-right"></i></a>
                        <?php else : ?>
                            <?php if (settings()->users->register_is_enabled) : ?>
                                <a data-toggle="modal" data-target="#registerModal"><?= l('qr_code_create.title') ?> <i class="fas fa-arrow-right"></i></a>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="hero-img">
                        <img src="<?= ASSETS_FULL_URL . 'images/Group 81.png' ?>" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="step-of-qr">
    <div class="container">
        <h2 class="step-heading">You are one step away from creating your own QR</h2>
        <div class="step-for-qr">
            <div class="steps">
                <div class="squre-box">
                    <h4>1</h4>
                </div>
                <h3>Select the content of your QR</h3>
                <p>Choose from a wide variety of options: PDF, menu, video, business cards, web, apps, etc.</p>
            </div>
            <div class="steps">
                <div class="squre-box">
                    <h4>2</h4>
                </div>
                <h3>Customise and design it to your liking</h3>
                <p>Choose colour, shape, style and the information you want to convey through your QR to get a unique design.</p>
            </div>
            <div class="steps">
                <div class="squre-box">
                    <h4>3</h4>
                </div>
                <h3>Log in and print or download it.</h3>
                <p>Choose the most suitable format for your business (pdf,png,svg,jpg...) print it or show it in digital format and that`s it!</p>
            </div>
        </div>
    </div>
</section>

<section class="marketing-features">
    <div class="container">
        <div class="marketing-heading">
            <h2><?= l('home.marketing-heading.heading') ?></h2>
            <p><?= l('home.marketing-heading.paragraph') ?></p>
        </div>
        <div class="features-boxes">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.qr-heading') ?></h5>
                                <p><?= l('home.features.qr-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="fas fa-external-link-alt"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.link-heading') ?></h5>
                                <p><?= l('home.features.link-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.file-heading') ?></h5>
                                <p><?= l('home.features.file-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="fas fa-palette"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.palette-heading') ?></h5>
                                <p><?= l('home.features.palette-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="far fa-chart-bar"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.chart-heading') ?></h5>
                                <p><?= l('home.features.chart-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="far fa-address-card"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.address-heading') ?></h5>
                                <p><?= l('home.features.address-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.download-heading') ?></h5>
                                <p><?= l('home.features.download-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="#">
                        <div class="feature-box">
                            <div class="icon">
                                <i class="far fa-dollar-sign"></i>
                            </div>
                            <div class="features">
                                <h5><?= l('home.features.dollar-heading') ?></h5>
                                <p><?= l('home.features.dollar-paragraph') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="analys-qr">
    <div class="container">
        <div class="analysis-heading">
            <h2><?= l('home.analysis-heading') ?></h2>
            <p><?= l('home.analysis-paragraph') ?></p>
        </div>
        <section class="bg-diffrent">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-12">
                        <div class="category-lists-slider">
                            <div class="swiper-container" id="catgory-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="category-button active" data-id="data1">
                                            <img src="<?= ASSETS_FULL_URL . 'images/menu.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data2">
                                            <img src="<?= ASSETS_FULL_URL . 'images/vcard.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data3">
                                            <img src="<?= ASSETS_FULL_URL . 'images/business.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data4">
                                            <img src="<?= ASSETS_FULL_URL . 'images/website.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data5">
                                            <img src="<?= ASSETS_FULL_URL . 'images/apps.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data6">
                                            <img src="<?= ASSETS_FULL_URL . 'images/wifi.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data7">
                                            <img src="<?= ASSETS_FULL_URL . 'images/video.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data8">
                                            <img src="<?= ASSETS_FULL_URL . 'images/pdf.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data9">
                                            <img src="<?= ASSETS_FULL_URL . 'images/images.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data10">
                                            <img src="<?= ASSETS_FULL_URL . 'images/listoflinks.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data11">
                                            <img src="<?= ASSETS_FULL_URL . 'images/mp3.png' ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="category-button" data-id="data12">
                                            <img src="<?= ASSETS_FULL_URL . 'images/Coupon.png' ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="slider-button slider-prev"><i class="fa fa-chevron-left"></i></div>
                            <div class="slider-button slider-next"><i class="fa fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="data-text active" id="data1">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.menu') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr//2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_menu.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data2">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.v-card') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr//2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_vcard.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('qr_codes.type.business') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/business/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_business.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.website') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/website/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_webpage.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data5">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.app') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/app/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_apps.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.wifi') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/wifi/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_wifi.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data7">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.video') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/video/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_video.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.pdf') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/pdf/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_pdf.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.images') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/images/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_images.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data10">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.links') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/links/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_linkoflinks.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data11">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.mp3') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/mp3/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_apps.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-text" id="data12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <h4><?= l('home.coupon') ?></h4>
                                        <p><?= l('home.qr-type-paragraph') ?></p>

                                        <a href="qr/coupon/2" class="btn-create"><?= l('qr_codes.create') ?></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="box">
                                        <img src="<?= ASSETS_FULL_URL . 'images/en_video.png' ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<section class="basic-concept">
    <div class="container">
        <h2><?= l('home.basic_concepts.header') ?></h2>
        <div class="accrodians">
            <div class="accordion">
                <button class="accordion__button"><?= l('home.basic_concepts.button_1') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_1') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_2') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_2') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_3') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_3') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_4') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_4') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_5') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_5') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_6') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_6') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_7') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_7') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_8') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_8') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_9') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_9') ?></p>

                <button class="accordion__button"><?= l('home.basic_concepts.button_10') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.basic_concepts.content_10') ?></p>
            </div>
        </div>
    </div>
</section>

<section class="creation-of-qr">
    <div class="container">
        <h2 class="pt-0"><?= l('home.design_accordian.header') ?></h2>
        <div class="accrodians">
            <div class="accordion">
                <button class="accordion__button"><?= l('home.design_accordian.button_1') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.design_accordian_content_1') ?></p>

                <button class="accordion__button"><?= l('home.design_accordian.button_2') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.design_accordian_content_2') ?></p>

                <button class="accordion__button"><?= l('home.design_accordian.button_3') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.design_accordian_content_3') ?></p>

                <button class="accordion__button"><?= l('home.design_accordian.button_4') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.design_accordian_content_4') ?></p>
            </div>
        </div>

        <h2><?= l('home.scanning_accordian.header') ?></h2>
        <div class="accrodians">
            <div class="accordion">
                <button class="accordion__button"><?= l('home.scanning_accordian.button_1') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.scanning_accordian_content_1') ?></p>

                <button class="accordion__button"><?= l('home.scanning_accordian.button_2') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.scanning_accordian_content_2') ?></p>

                <button class="accordion__button"><?= l('home.scanning_accordian.button_3') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.scanning_accordian_content_3') ?></p>

                <button class="accordion__button"><?= l('home.scanning_accordian.button_4') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.scanning_accordian_content_4') ?></p>
                <button class="accordion__button"><?= l('home.scanning_accordian.button_5') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.scanning_accordian_content_5') ?></p>

                <button class="accordion__button"><?= l('home.scanning_accordian.button_6') ?><i class="fa fa-plus"></i></button>
                <p class="accordion__content"><?= l('home.scanning_accordian_content_6') ?></p>

            </div>
        </div>
    </div>
</section>

<section class="know-more">
    <div class="container">
        <div class="know-more-heading">
            <h2><?= l('home.know-more.header') ?></h2>
            <p><?= l('home.know-more.paragraph') ?></p>
            <a href="<?= url('faq') ?>"><?= l('home.know-more.question') ?></a>
        </div>
    </div>
</section>


<!-- bootsrap js -->
<script src="<?= ASSETS_FULL_URL . 'js/bootstrap.min.js' ?>"></script>

<!--  box section js -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

<script src="https://unpkg.com/swiper@6.8.1/swiper-bundle.min.js"></script>

<!-- slider js -->
<script src="<?= ASSETS_FULL_URL . 'js/owl.carousel.min.js' ?>"></script>

<!-- aos js -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



<!-- fancy-box JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>


<!--  toggle js -->

<script>
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    const links = document.querySelectorAll(".nav-links li");

    hamburger.addEventListener('click', () => {
        //Animate Links
        navLinks.classList.toggle("open");
        links.forEach(link => {
            link.classList.toggle("fade");
        });

        //Hamburger Animation
        hamburger.classList.toggle("toggle");
    });
</script>

<!-- accrodian js -->
<script>
    const allButtons = document.querySelectorAll(".accordion__button");

    allButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const btnChild = button.firstElementChild;

            button.nextElementSibling.classList.toggle("active");

            if (btnChild.classList.contains("fa-plus")) {
                btnChild.classList.replace("fa-plus", "fa-minus");
            } else {
                btnChild.classList.replace("fa-minus", "fa-plus");
            }
        });
    });
</script>

<!-- preview box js -->

<script>
    // ----------swiper-slider---------
    var swiper = '';
    $(window).on('load', function() {
        swiper = new Swiper('#catgory-slider', {
            loop: false,
            slidesPerView: "auto",
            allowTouchMove: false,
            spaceBetween: 5,
            mousewheel: true,
            slideToClickedSlide: true,
            centeredSlides: false,
            navigation: {
                nextEl: '.slider-next',
                prevEl: '.slider-prev',
            }
        });
    });


    $(".category-button").click(function() {
        $(".category-button").removeClass("active");
        $(this).addClass('active');
        var getid = $(this).data('id');
        console.log(getid);
        $(".data-text").removeClass('active');
        $("#" + getid).addClass("active");
    });
</script>

