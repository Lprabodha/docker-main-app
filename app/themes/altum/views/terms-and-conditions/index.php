<?php defined('ALTUMCODE') || die() ?>

<style>
    .sub-content-7-wrap .sub-content-heading {
        text-decoration: underline;
        font-size: 19px;
    }

    .sub-content-7-wrap .sub-content-subheading-1 {
        font-size: 17px;
        font-weight: 500;
    }

    .sub-content-7-wrap .sub-content-subheading-2 {
        font-weight: 600;
    }

    .sub-content-7-wrap .subscription-content,
    .sub-content-7-wrap .payment-content {
        margin-bottom: 40px;
    }
</style>

<div class="section-faq">

	<div class="-container">

        <div class="-section-title">
            <?= l('terms_conditions.title') ?>
        </div>

		<div class="-section-description">
            <p><?= l('terms_conditions.lastupdate') ?>: December 19, 2023</p>
		</div>

        <div class="termsContain">

        <div class="termsDetail">
            <h2><?= l('terms_conditions.sub_title') ?></h2>

            <p><?= l('terms_conditions.detail_paragraph') ?></p>

            <p><?= l('terms_conditions.sub_paragraph_1') ?></p>
            <p><?= l('terms_conditions.sub_paragraph_2') ?></p>
            <p><?= l('terms_conditions.sub_paragraph_3') ?></p>
            <p><?= l('terms_conditions.sub_paragraph_4') ?></p>
            <p><?= l('terms_conditions.sub_paragraph_5') ?></p>
            <p><?= l('terms_conditions.sub_paragraph_6') ?></p>
            <p><?= l('terms_conditions.sub_paragraph_7') ?></p>



            <h2>1. <?= l('terms_conditions.sub_title_1') ?></h2>
            <p class="mb-0">
                <?= l('terms_conditions.sub_content_1.1') ?>
            </p>
            <p>
                <?= l('terms_conditions.sub_content_1.2') ?>
            </p>
            <p>
                <?= l('terms_conditions.sub_content_1.3') ?>
            </p>
            <p>
                <?= l('terms_conditions.sub_content_1.4') ?>
            </p>

            <h2>2. <?= l('terms_conditions.sub_title_2') ?></h2>
            <h3><?= l('terms_conditions.sub_title_2.1') ?></h3>

            <p><?= l('terms_conditions.sub_content_2.1') ?></p>
            <p><?= l('terms_conditions.sub_content_2.2') ?></p>
            <p><?= l('terms_conditions.sub_content_2.3') ?></p>
            <p><?= l('terms_conditions.sub_content_2.4') ?></p>

            <h3><?= l('terms_conditions.sub_title_2.2') ?></h3>

            <p><?= l('terms_conditions.sub_content_2.5') ?></p>

            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_2.5.1') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_2.5.2') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_2.5.3') ?></p>
            </div>


            <h2>3. <?= l('terms_conditions.sub_title_3') ?></h2>
            <p>
                <?= l('terms_conditions.sub_content_3.1') ?>
            </p>
            <p>
                <?= l('terms_conditions.sub_content_3.2') ?>
            </p>


            <h2>4. <?= l('terms_conditions.sub_title_4') ?></h2>
            <p class="mb-0"><?= l('terms_conditions.sub_content_4.1') ?></p>


            <h2>5. <?= l('terms_conditions.sub_title_5') ?></h2>
            <p>
                <?= l('terms_conditions.sub_content_5.1') ?>
            </p>

            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <?= l('terms_conditions.sub_content_5.1.1') ?>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <?= l('terms_conditions.sub_content_5.1.2') ?>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <?= l('terms_conditions.sub_content_5.1.3') ?>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <?= l('terms_conditions.sub_content_5.1.4') ?>
            </div>

            <p>
                <?= l('terms_conditions.sub_content_5.2') ?>
            </p>
            <p>
                <?= l('terms_conditions.sub_content_5.3') ?>
            </p>
            <p>
                <?= l('terms_conditions.sub_content_5.4') ?>
            </p>


            <h2>6. <?= l('terms_conditions.sub_title_6') ?></h2>
            <div class="sub-content-7-wrap">
                <div class="subscription-content">
                    <p class="sub-content-heading"><?= l('terms_conditions.sub_content_6.1_heading') ?></p>
                    <p><?= l('terms_conditions.sub_content_6.1_content_1') ?></p>
                    <p><?= l('terms_conditions.sub_content_6.1_content_2') ?></p>
        
                    <p class="sub-content-subheading-1" style="margin-top: 25px !important;"><?= l('terms_conditions.sub_content_6.1_subheading_1') ?></p>
        
                    <p style="margin-bottom: 0px !important;"><?= l('terms_conditions.sub_content_6.1_subheading_1_1') ?></p>
                    <p style="margin-top: 0px !important;"><?= l('terms_conditions.sub_content_6.1_subheading_1_2') ?></p>
        
        
                    <p class="sub-content-subheading-2" style="margin-top: 25px !important;"><?= l('terms_conditions.sub_content_6.1_subscription_st_1') ?></p>
                    <p><?= sprintf(l('terms_conditions.sub_content_6.1_subscription_st_1_1'), SITE_URL . 'login') ?></p>
        
                    <p class="sub-content-subheading-2"><?= l('terms_conditions.sub_content_6.1_subscription_st_2') ?></p>
                    <p><?= l('terms_conditions.sub_content_6.1_subscription_st_2_1') ?></p>
        
                    <p class="sub-content-subheading-2"><?= l('terms_conditions.sub_content_6.1_subscription_st_3') ?></p>
                    <p><?= l('terms_conditions.sub_content_6.1_subscription_st_3_1') ?></p>
                </div>
    
                <div class="payment-content">
                    <p class="sub-content-heading"><?= l('terms_conditions.sub_content_6.2_heading') ?></p>
                    <p><?= l('terms_conditions.sub_content_6.2_content_1') ?></p>
                    
                    <p><?= l('terms_conditions.sub_content_6.2_content_2') ?></p>
                </div>
    
                <div class="refund-content">
                    <p class="sub-content-heading"><?= l('terms_conditions.sub_content_6.3_heading') ?></p>
                    <p style="margin-bottom: 0px !important;"><?= l('terms_conditions.sub_content_6.3_content_1') ?></p>
                    <p style="margin-bottom: 0px !important; margin-top: 0px !important;"><?= l('terms_conditions.sub_content_6.3_content_2') ?></p>
                    <p style="margin-bottom: 0px !important; margin-top: 0px !important;"><?= l('terms_conditions.sub_content_6.3_content_3') ?></p>
                    <p style="margin-top: 0px !important;"><?= l('terms_conditions.sub_content_6.3_content_4') ?></p>
                </div>
            </div>


            <h2 class="mb-0">7. <?= l('terms_conditions.sub_title_7') ?></h2>

            <p> <?= l('terms_conditions.sub_content_7.1') ?></p>
            <p> <?= l('terms_conditions.sub_content_7.2') ?></p>
            <p> <?= l('terms_conditions.sub_content_7.3') ?></p>
            <p> <?= l('terms_conditions.sub_content_7.4') ?></p>
            <p> <?= l('terms_conditions.sub_content_7.5') ?></p>
            <p> <?= l('terms_conditions.sub_content_7.6') ?></p>

            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.1') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.2') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.3') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.4') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.5') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.6') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.7') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.8') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.9') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.10') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.11') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.12') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.13') ?></p>
            </div>
            <div class="termsDetailInner termsDetailText">
                <span class="dot"></span>
                <p><?= l('terms_conditions.sub_content_7.6.14') ?></p>
            </div>


            <h2>8. <?= l('terms_conditions.sub_title_8') ?></h2>
            <p> <?= l('terms_conditions.sub_content_8.1') ?></p>
            <p> <?= l('terms_conditions.sub_content_8.2') ?></p>


            <h2>9. <?= l('terms_conditions.sub_title_9') ?></h2>

            <p> <?= l('terms_conditions.sub_content_9.1') ?></p>


            <h2>10. <?= l('terms_conditions.sub_title_10') ?></h2>
            <p> <?= l('terms_conditions.sub_content_10.1') ?></p>

            <h2>11. <?= l('terms_conditions.sub_title_11') ?></h2>
            <p> <?= l('terms_conditions.sub_content_11.1') ?></p>
            <p> <?= l('terms_conditions.sub_content_11.2') ?></p>

            <h2>12. <?= l('terms_conditions.sub_title_12') ?></h2>

            <p> <?= l('terms_conditions.sub_content_12.1') ?></p>
            <p> <?= l('terms_conditions.sub_content_12.2') ?></p>


            <h2>13. <?= l('terms_conditions.sub_title_13') ?></h2>
            <p> <?= l('terms_conditions.sub_content_13.1') ?></p>

            <h2>14. <?= l('terms_conditions.sub_title_14') ?></h2>


            <h3><?= l('terms_conditions.sub_title_14.1') ?></h3>

            <p><?= l('terms_conditions.sub_content_14.1') ?></p>


            <h3><?= l('terms_conditions.sub_title_14.2') ?></h3>
            <p><?= l('terms_conditions.sub_content_14.2') ?></p>


            <h3><?= l('terms_conditions.sub_title_14.3') ?></h3>
            <p><?= l('terms_conditions.sub_content_14.3') ?></p>


            <h2>15. <?= l('terms_conditions.sub_title_15') ?></h2>
            <p><?= l('terms_conditions.sub_content_15.1') ?></p>

            <h2>16. <?= l('terms_conditions.sub_title_16') ?></h2>
            <p><?= l('terms_conditions.sub_content_16.1') ?></p>

            <h2>17. <?= l('terms_conditions.sub_title_17') ?></h2>
            <p><?= l('terms_conditions.sub_content_17.1') ?></p>

            <h2>18. <?= l('terms_conditions.sub_title_18') ?></h2>
            <p><?= l('terms_conditions.sub_content_18.1') ?></p>

            <h2>19. <?= l('terms_conditions.sub_title_19') ?></h2>
            <p><?= l('terms_conditions.sub_content_19.1') ?></p>

            <h2>20. <?= l('terms_conditions.sub_title_20') ?></h2>
            <p><?= l('terms_conditions.sub_content_20.1') ?></p>

            <h2>21. <?= l('terms_conditions.sub_title_21') ?></h2>
            <p><?= l('terms_conditions.sub_content_21.1') ?></p>

            <h2>22. <?= l('terms_conditions.sub_title_22') ?></h2>
            <p><?= l('terms_conditions.sub_content_22.1') ?></p>

            <h2>23. <?= l('terms_conditions.sub_title_23') ?></h2>
            <p><?= l('terms_conditions.sub_content_23.1') ?></p>

            <p><strong>support@online-qr-generator.com</strong></p>

        </div>
    </div>

    </div>
</div>
