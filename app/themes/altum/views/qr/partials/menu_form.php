<?php defined('ALTUMCODE') || die() ?>

<?php

$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'menu') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];

    $companyLogo = $filledInput['companyLogoImage'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid =  null;
    $companyLogo =  null;
}

?>

<div id="step2_form">

    <?php
    $allergens = array(
        "cereals",
        "crustaceans",
        "eggs",
        "fish",
        "peanuts",
        "soy",
        "milk",
        "fruits",
        "celery",
        "mustard",
        "sesame",
        "sulfur",
        "lupins",
        "molluscs",

    );

    ?>

    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">

    <!-- add color palette -->
    <?php include_once('components/design-1-color.php'); ?>

    <!-- menu information section -->
    <div class="custom-accodian menu-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_menuInfo" aria-expanded="true" aria-controls="acc_menuInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_menu.information') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_menu.help_txt.information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show main-collapse" id="acc_menuInfo">
            <div class="collapseInner">

                <input type="hidden" name="activeId" value="" data-reload-qr-code>
                <input type="hidden" name="visible" value="false" data-reload-qr-code>

                <div class="welcome-screen mb-4">
                    <span class="d-flex align-items-center">
                        <span><?= l('qr_step_2_menu.input.companyLogo') ?> </span>
                        <span class="info-tooltip-icon ctp-tooltip mt-1" tp-content="<?= l('qr_step_2_menu.help_tooltip.companyLogo') ?>"></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">
                            <input type="hidden" id="companyLogoImage" class="anchorLoc" data-anchor="menu_info" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">


                            <input type="file" id="companyLogo" name="companyLogo" data-anchor="menu_info" class="form-control py-2 anchorLoc" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image d-flex align-item-center justify-content-center" id="company_logo_img">

                                <?php if ($companyLogo) { ?>
                                    <img src="<?php echo $companyLogo; ?>" alt="Company Logo image" id="cl-upl-img" />
                                <?php } ?>
                                <span class="icon-upload-image mb-0" id="cl-tmp-mage" style="display:<?php echo $companyLogo ? 'none' : 'flex'; ?>;"></span>

                            </div>
                            <div class="add-icon" id="company_log_add_icon" style="opacity:0; display:<?php echo  $companyLogo ? 'none' : 'block'; ?>;">
                                <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                </svg>
                            </div>
                            <div class="add-icon" id="company_log_edit_icon" style="opacity:0; display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                </svg>
                            </div>
                        </label>
                        <button type="button" class="delete-btn cl_screen_delete" id="cl_screen_delete" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">

                            <?= l('qr_step_2_menu.delete') ?>
                        </button>
                    </div>
                </div>
                <div class="form-group step-form-group">
                    <label for="companyTitle"> <?= l('qr_step_2_menu.input.companyTitle') ?> </label>
                    <input id="companyTitle" data-anchor="menu_info" name="companyTitle" value="<?php echo (!empty($filledInput['companyTitle'])) ? $filledInput['companyTitle'] : ''; ?>" placeholder="<?= l('qr_step_2_menu.input.companyTitle.placeholder') ?>" class="form-control anchorLoc" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group m-0">
                    <label for="companyDescription"> <?= l('qr_step_2_menu.input.companyDescription') ?></label>
                    <input id="companyDescription" data-anchor="menu_info" name="companyDescription" value="<?php echo (!empty($filledInput['companyDescription'])) ? $filledInput['companyDescription'] : ''; ?>" placeholder="<?= l('qr_step_2_menu.input.companyDescription.placeholder') ?>" class="form-control anchorLoc" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyDescription']['max_length'] ?>" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <!-- menu section -->
    <div class="custom-accodian menu-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_product" aria-expanded="true" aria-controls="acc_product">
            <div class="qr-step-icon">
                <span class="icon-document grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_menu.type') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_menu.help_txt.type') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show main-collapse" id="acc_product">
            <div class="collapseInner collapseInner1 menu-product-wrap">

                <?php if (empty($filledInput['sections'])) { ?>
                    <div id="add_section" class="menu-product-section" data-section-id="1" data-section-index="1">

                        <div class="custom-accodian sub-accordian mb-0">
                            <div class="form-group mb-0 d-flex align-items-center justify-content-between">
                                <div class="d-flex">
                                    <input type="hidden" name="sectionId[]" value="1" data-reload-qr-code>
                                    <button class="btn accodianBtn section-btn" type="button" data-toggle="collapse" data-target="#menu_section_1" aria-expanded="true" aria-controls="menu_section_1" style="width: auto">
                                        <span class="icon-arrow-h-right grey toggle-icon"></span>
                                        <p class="paraheading  section-name mb-0"><?= l('qr_step_2_menu.section') ?> 1</p>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center section-order" style="margin-left: 8px;">
                                    <button type="button" data-target="#sectionDeleteModal" data-toggle="modal" class="formCustomBtn delete-sec-btn delete-section">
                                        <span class="icon-trash"></span>
                                    </button>
                                    <div class="p-0 menuActionButtons">
                                        <div class="d-flex ">
                                            <button type="button" class="menu-order-up jss1426 jss1424">
                                                <span class="icon-arrow-down"></span>
                                            </button>
                                            <button type="button" class="menu-order-down jss1426 jss1424">
                                                <span class="icon-arrow-down"></span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="collapse show section-collapse" id="menu_section_1">
                                <div class="form-group col-12">
                                    <label for="sectionNames"> <?= l('qr_step_2_menu.input.section.name') ?> <span class="text-danger text-bold">*</span></label>
                                    <input class="form-control sectionNames anchorLoc" data-anchor="menuSec_Name1" id="sectionNames" type="text" name="sectionNames_1[]" placeholder="<?= l('qr_step_2_menu.input.sectionNames.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate />
                                </div>
                                <div class="form-group col-12 m-0">
                                    <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?></label>
                                    <input class="form-control anchorLoc" data-anchor="menuSec_Desc1" id="sectionDescriptions" type="text" name="sectionDescriptions_1[]" placeholder="<?= l('qr_step_2_menu.input.sectionDescriptions.placeholder') ?>" data-reload-qr-code />
                                </div>
                                <div class="product-container">
                                    <div id="add_product" class="add_product" data-product-id="1">
                                        <input type="hidden" name="productId_1[]" value="1" data-reload-qr-code>
                                        <div class="productAccodian">
                                            <div class="custom-accodian sub-accordian mb-0">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex product-toggle-btn">
                                                        <button class="btn accodianBtn product-btn section-btn" type="button" data-toggle="collapse" data-target="#menu_product_1_1" aria-expanded="true" aria-controls="menu_product_1_1">
                                                            <span class="icon-arrow-h-right grey toggle-icon"></span>
                                                            <p class="paraheading product-name mb-0 "><?= l('qr_step_2_menu.input.productName') ?> 1</p>
                                                        </button>
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                        <div class="p-0 productActionButtons">
                                                            <div class="d-flex ">
                                                                <button type="button" class="formCustomBtn delete-sec-btn  delete-product">
                                                                    <span class="icon-trash"></span>
                                                                </button>
                                                                <button type="button" class="product-order-up jss1426 jss1424">
                                                                    <span class="icon-arrow-down"></span>
                                                                </button>
                                                                <button type="button" class="product-order-down jss1426 jss1424">
                                                                    <span class="icon-arrow-down"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse show product-collapse" id="menu_product_1_1">
                                                    <div class="collapseInner p-0 mt-2">
                                                        <div class="welcome-screen">
                                                            <span style="display:flex;">
                                                                <?= l('qr_step_2_menu.image') ?>
                                                                <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_menu.help_tooltip.product_image') ?>"></span>
                                                            </span>
                                                            <!-- Before Upload Priview -->
                                                            <div class="screen-upload mb-4">
                                                                <label for="productImages" class="product-image-wrap">
                                                                    <input type="hidden" class="productImghidden anchorLoc" data-anchor="menuProd1_1" name="productImg_1[]" value="">
                                                                    <input type="file" id="productImages1" name="productImages_1[]" data-anchor="menuProd1_1" class="anchorLoc form-control py-2 productImages" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" required="required" input_size_validate />
                                                                    <input type="hidden" class="product-index" name="productIndex_1[]" value="1">

                                                                    <div class="input-image">
                                                                        <span class="icon-add-image defaultImage"></span>

                                                                    </div>
                                                                    <div class="add-icon addpImage" style="opacity: 0;" onclick="trigerproductimage(1)">
                                                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="add-icon editpImage" style="opacity: 0;" onchange="trigerproductimage(1)">
                                                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                                                            <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                                        </svg>
                                                                    </div>
                                                                </label>
                                                                <button type="button" class="delete-btn p_delete" style="display:none;">
                                                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                                                        <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                                                        <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                                                    </svg>
                                                                    <?= l('qr_step_2_menu.delete') ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                                                <label for="productNames"> <?= l('qr_step_2_menu.input.name') ?> <span class="text-danger text-bold">*</span></label>
                                                                <input class="form-control pName anchorLoc" data-anchor="menuProd1_1" type="text" name="productNames_1[]" placeholder="<?= l('qr_step_2_menu.input.pName.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate/>
                                                            </div>
                                                            <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                                                <label for="productNamesTranslated"><?= l('qr_step_2_menu.translated_name') ?></label>
                                                                <input class="form-control anchorLoc" data-anchor="menuProd1_1" type="text" id="productNamesTranslated" name="productNamesTranslated_1[]" placeholder="<?= l('qr_step_2_menu.input.productNamesTranslated.placeholder') ?>" data-reload-qr-code />
                                                            </div>
                                                        </div>
                                                        <div class="form-group mobile-form-group">
                                                            <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?></label>
                                                            <input class="form-control anchorLoc" data-anchor="menuProd1_1" type="text" id="productDescriptions" name="productDescriptions_1[]" placeholder="<?= l('qr_step_2_menu.input.productDescriptions.placeholder') ?>" data-reload-qr-code />
                                                        </div>
                                                        <div class="form-group  col-sm-12 p-0 mobile-form-group">
                                                            <label for="productPrices"><?= l('qr_step_2_menu.price') ?></label>
                                                            <input class="form-control anchorLoc" data-anchor="menuProd1_1" type="text" id="productPrices" name="productPrices_1[]" placeholder="<?= l('qr_step_2_menu.input.productPrices.placeholder') ?>" data-reload-qr-code />
                                                        </div>

                                                        <div class="allerg-block form-group col-md-12 p-0">
                                                            <label for="productPrices"><?= l('qr_step_2_menu.allergens.title') ?></label>
                                                            <div class="container px-0">
                                                                <div class="mt-1 row  mx-0  align-item-center all_allergens">
                                                                    <?php foreach ($allergens as $key => $value) { ?>
                                                                        <div class="col-auto px-0">
                                                                            <div class="allergens_btn">
                                                                                <input 
                                                                                    type="checkbox" 
                                                                                    class="allergens_checkbox allergens anchorLoc" 
                                                                                    data-anchor="menuProd1_1" 
                                                                                    value="<?php echo $value; ?>" 
                                                                                    name="allergens_1_1[]" 
                                                                                    <?php echo (!empty($filledInput)) ? (($filledInput[$value]) ? 'checked' : $value) : ''; ?> 
                                                                                    data-reload-qr-code
                                                                                    onclick="LoadPreview()"
                                                                                >
                                                                                <label class="check_effect"></label>
                                                                                <span class="tooltip text-center"><?= l('qr_step_2_menu.allergens.' . $value) ?></span>
                                                                                <img class="allergens_img" src="<?= ASSETS_FULL_URL . 'images/allergens-icons/' . $value . '.svg'; ?>" alt="">
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="productAccodianbutton">
                                    <button data-add="menu-product" id="add1" type="button" class="outlineBtn addRowButton add-product menu add1">
                                        <span class="icon-add-square mr-1 smIcon"></span> <?= l('qr_step_2_menu.add_product') ?>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php
                        $sIndex = 1; 
                        foreach ($filledInput['sections'] as $keySec => $section) { 
                    ?>
                        <div id="add_section" class="menu-product-section" data-section-index="<?= $sIndex ?>" data-section-id="<?=$keySec?>">
                            <div class="custom-accodian sub-accordian mb-0">
                                <input type="hidden" name="sectionId[]" value="<?php echo $keySec ?>" data-reload-qr-code>
                                <div class="form-group d-flex align-items-center justify-content-between mb-0">
                                    <div class="d-flex">
                                        <button class="btn accodianBtn section-btn" type="button" data-toggle="collapse" data-target="#menu_section_<?php echo $keySec ?>" aria-expanded="true" aria-controls="menu_section_" <?php echo $keySec ?> style="width: auto">
                                            <span class="icon-arrow-h-right grey toggle-icon"></span>
                                            <p class="paraheading section-name mb-0"><?php echo ($section['name'][0]); ?></p>
                                        </button>
                                    </div>

                                    <div class="d-flex align-items-center section-order" style="margin-left: 8px">
                                        <button type="button" data-target="#sectionDeleteModal" data-toggle="modal" class="formCustomBtn delete-sec-btn delete-section">
                                            <span class="icon-trash"></span>
                                        </button>
                                        <div class="p-0 menuActionButtons">
                                            <div class="d-flex ">
                                                <button type="button" class="menu-order-up jss1426 jss1424">
                                                    <span class="icon-arrow-down"></span>
                                                </button>
                                                <button type="button" class="menu-order-down jss1426 jss1424">
                                                    <span class="icon-arrow-down"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse show section-collapse" id="menu_section_<?php echo $keySec ?>">
                                    <div class="form-group col-12">
                                        <label for="sectionNames"> <?= l('qr_step_2_menu.input.section.name') ?> <span class="text-danger text-bold">*</span></label>
                                        <input class="form-control sectionNames anchorLoc" data-anchor="menuSec_Name<?= $keySec ?>" id="sectionNames" value="<?php echo ($section['name'][0]) ?>" type="text" name="sectionNames_<?php echo $keySec ?>[]" placeholder="<?= l('qr_step_2_menu.input.sectionNames.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate/>
                                    </div>
                                    <div class="form-group col-12 m-0">
                                        <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?> </label>
                                        <input class="form-control anchorLoc" data-anchor="menuSec_Desc<?= $keySec ?>" id="sectionDescriptions" value="<?php echo (!empty($section['description'])) ? ($section['description'][0]) : ''; ?>" type="text" name="sectionDescriptions_<?php echo $keySec ?>[]" placeholder="<?= l('qr_step_2_menu.input.sectionDescriptions.placeholder') ?>" data-reload-qr-code />
                                    </div>

                                    <div class="product-container">

                                        <?php $productNo = 1 ?>
                                        <?php
                                            $pIndex = 1; 
                                            foreach (($section['products']['names']) as $keyPro => $productName) { 
                                        ?>
                                            <div id="add_product" class="add_product" data-product-id="<?php echo $section['products']['productIds'][$keyPro] ?>">
                                                <input type="hidden" name="productId_<?php echo $keySec ?>[]" value="<?php echo $section['products']['productIds'][$keyPro] ?>" data-reload-qr-code>

                                                <div class="productAccodian">
                                                    <div class="custom-accodian sub-accordian mb-0">
                                                        <div class="d-flex justify-content-between">

                                                            <div class="d-flex product-toggle-btn">
                                                                <button class="btn accodianBtn product-btn section-btn" type="button" data-toggle="collapse" data-target="#menu_product_<?php echo $keySec ?>_<?php echo $section['products']['productIds'][$keyPro] ?>" aria-expanded="true" aria-controls="menu_product_<?php echo $keySec ?>_<?php echo $section['products']['productIds'][$keyPro] ?>">
                                                                    <span class="icon-arrow-h-right grey toggle-icon"></span>
                                                                    <p class="paraheading product-name mb-0 "><?php echo $productName; ?></p>
                                                                </button>
                                                            </div>

                                                            <div class="d-flex align-items-center">

                                                                <div class="p-0 productActionButtons">
                                                                    <div class="d-flex ">
                                                                        <button type="button" class="formCustomBtn delete-sec-btn delete-product">
                                                                            <span class="icon-trash"></span>
                                                                        </button>
                                                                        <button type="button" class="product-order-up jss1426 jss1424">
                                                                            <span class="icon-arrow-down"></span>
                                                                        </button>
                                                                        <button type="button" class="product-order-down jss1426 jss1424">
                                                                            <span class="icon-arrow-down"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapse show product-collapse" id="menu_product_<?php echo $keySec ?>_<?php echo $section['products']['productIds'][$keyPro] ?>">
                                                            <div class="collapseInner p-0 mt-2">
                                                                <div class="welcome-screen">
                                                                    <span style="display:flex;">
                                                                        <?= l('qr_step_2_menu.image') ?>
                                                                        <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_menu.help_tooltip.product_image') ?>"></span>
                                                                    </span>
                                                                    <!-- Before Upload Priview -->
                                                                    <div class="screen-upload mb-4">
                                                                        <input type="hidden" class="product-image anchorLoc" data-anchor="menuProd<?= $keySec ?>_<?= $keyPro ?>" name="productImg_<?php echo $keySec ?>[]" value="<?php echo $section['products']['images'][$keyPro] ?>">
                                                                        <label for="productImages" class="product-image-wrap">

                                                                            <input type="file" id="productImages<?php echo $section['products']['productIds'][$keyPro] ?>" name="productImages_<?php echo $keySec ?>[]" class="form-control py-2 productImages anchorLoc" data-anchor="menuProd_img<?= $productNo ?>" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" required="required" input_size_validate data-reload-qr-code />

                                                                            <div class="input-image">

                                                                                <?php if ($section['products']['images'][$keyPro]) { ?>
                                                                                    <img src="<?php echo $section['products']['images'][$keyPro] ?>" height="" width="" class="upl-p-img" alt="Product image" id="section-product-img" />
                                                                                <?php  } ?>
                                                                                <span class="icon-add-image defaultImage" style="display:<?php echo $section['products']['images'][$keyPro]  ? 'none' : 'flex'; ?>;"></span>

                                                                            </div>
                                                                            <div class="add-icon addpImage" onclick="trigerproductimage(<?php echo $section['products']['productIds'][$keyPro] ?>)" style="opacity:0;">
                                                                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                                                                </svg>
                                                                            </div>
                                                                            <div class="add-icon editpImage" style="opacity:0;" onclick="trigerproductimage(<?php echo $section['products']['images'][$keyPro] ?>)">
                                                                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                                                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                                                </svg>
                                                                            </div>
                                                                        </label>
                                                                        <button type="button" class="delete-btn p_delete menu-product-delete" style="display:<?php echo  $section['products']['images'][$keyPro] ? 'block' : 'none'; ?>;">
                                                                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                                                                <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                                                                <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                                                            </svg>
                                                                            <?= l('qr_step_2_menu.delete') ?>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                                                        <label for="productNames"> <?= l('qr_step_2_menu.input.name') ?> <span class="text-danger text-bold">*</span></label>
                                                                        <input class="form-control pName anchorLoc" data-anchor="menuProd<?= $keySec ?>_<?= $keyPro ?>" type="text" value="<?php echo $productName ?>" name="productNames_<?php echo $keySec ?>[]" placeholder="<?= l('qr_step_2_menu.input.pName.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate/>
                                                                    </div>
                                                                    <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                                                        <label for="productNamesTranslated"><?= l('qr_step_2_menu.translated_name') ?></label>
                                                                        <input class="form-control anchorLoc" data-anchor="menuProd<?= $keySec ?>_<?= $keyPro ?>" type="text" value="<?php echo (!empty($section['products']['translated'])) ? $section['products']['translated'][$keyPro] : '' ?>" id="productNamesTranslated" name="productNamesTranslated_<?php echo $keySec ?>[]" placeholder="<?= l('qr_step_2_menu.input.productNamesTranslated.placeholder') ?>" data-reload-qr-code />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mobile-form-group">
                                                                    <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?> </label>
                                                                    <input class="form-control anchorLoc" data-anchor="menuProd<?= $keySec ?>_<?= $keyPro ?>" type="text" value="<?php echo $section['products']['description'][$keyPro] ?>" id="productDescriptions" name="productDescriptions_<?php echo $keySec ?>[]" placeholder="<?= l('qr_step_2_menu.input.productDescriptions.placeholder') ?>" data-reload-qr-code />
                                                                </div>
                                                                <div class="form-group col-sm-12 p-0 mobile-form-group">
                                                                    <label for="productPrices"><?= l('qr_step_2_menu.price') ?></label>
                                                                    <input class="form-control anchorLoc" data-anchor="menuProd<?= $keySec ?>_<?= $keyPro ?>" type="text" value="<?php echo (!empty($section['products']['prices'])) ? $section['products']['prices'][$keyPro] : '' ?>" id="productPrices" name="productPrices_<?php echo $keySec ?>[]" placeholder="<?= l('qr_step_2_menu.input.productPrices.placeholder') ?>" data-reload-qr-code />
                                                                </div>

                                                                <div class="allerg-block form-group col-md-12 p-0">
                                                                    <label for="productPrices"><?= l('qr_step_2_menu.allergens.title') ?></label>
                                                                    <div class="container px-0">
                                                                        <div class="mt-1 row  mx-0  align-item-center all_allergens">
                                                                            <?php foreach ($allergens as $key => $value) { ?>
                                                                                <div class="col-auto px-0">
                                                                                    <div class="allergens_btn">

                                                                                        <input 
                                                                                            type="checkbox" 
                                                                                            class="allergens_checkbox allergens anchorLoc" 
                                                                                            data-anchor="menuProd<?= $keySec ?>_<?= $keyPro ?>" 
                                                                                            value="<?php echo  $value ?>" 
                                                                                            name="allergens_<?php echo $keySec ?>_<?php echo $section['products']['productIds'][$keyPro] ?>[]" 
                                                                                            <?php echo (!empty($section['products']['allergens'])) ? (in_array($value, ($section['products']['allergens'][$keyPro]), true) ? 'checked' : $value) : ''; ?> 
                                                                                            data-reload-qr-code
                                                                                            onclick="LoadPreview()"
                                                                                        >


                                                                                        <label class="check_effect"></label>
                                                                                        <span class="tooltip text-center"><?= l('qr_step_2_menu.allergens.' . $value) ?></span>
                                                                                        <img class="allergens_img" src="<?php echo (ASSETS_FULL_URL) . 'images/allergens-icons/' . $value .  '.svg' ?>" alt="">
                                                                                    </div>
                                                                                </div>
                                                                            <?php  } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $productNo = $productNo + 1 ?>
                                        <?php $pIndex++; } ?>

                                    </div>
                                    <div class="productAccodianbutton">
                                        <button data-add="menu-product" id="add1" type="button" class="outlineBtn addRowButton add-product menu">
                                            <span class="icon-add-square mr-1 smIcon"></span> <?= l('qr_step_2_menu.add_product') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $sIndex++; } ?>
                <?php } ?>

            </div>
            <div class="productSectionBtn">
                <button id="add" type="button" class="outlineBtn addRowButton product-section-btn">
                    <span class="icon-add-square mr-1 smIcon"></span>
                    <?= l('qr_step_2_menu.add_section') ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Opening hours section  -->
    <?php include_once('components/opeaning-hours.php'); ?>


    <!-- location section End -->
    <div class="custom-accodian d-none">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_location" aria-expanded="true" aria-controls="acc_location">
            <div class="qr-step-icon">
                <span class="icon-location grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_menu.location') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_menu.help_txt.location') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_location">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <?php include_once('components/location.php'); ?>
            </div>
        </div>
    </div>
    <!-- location section End -->




    <!-- contact information section  -->
    <div class="menu-contact-info-wrp">
        <?php include_once('components/contact-information.php'); ?>
    </div>

    <!-- social icons section  -->
    <?php include_once('components/social-icons.php'); ?>

    <!-- fonts  -->
    <?php include_once('components/fonts.php'); ?>

    <!-- Welcome Screen sections -->
    <?php include_once('components/welcome-screen.php'); ?>

    <!-- Name sections -->
    <?php include_once('components/qr-name.php'); ?>

    <!-- password sections -->
    <?php include_once('components/password.php'); ?>

    <!-- Folder sections -->
    <?php include_once('components/folder.php'); ?>


</div>



<!-- section delete modal -->
<div class="modal smallmodal fade" data-backdrop="static" id="sectionDeleteModal" tabindex="-1" aria-labelledby="sectionDeleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="modal-img">
                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 140 140">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #e5e7ef;
                            }

                            .cls-2 {
                                fill: #fff;
                            }
                        </style>
                    </defs>
                    <circle class="cls-1" cx="70" cy="70" r="70" />
                    <path class="cls-2" d="M81.84,98H56.58a8,8,0,0,1-8-7.33L45.22,50h48L89.81,90.63A8,8,0,0,1,81.84,98Z" />
                    <path d="M101.19,49h-64a1,1,0,0,0,0,2H44.3l3.32,39.72a9,9,0,0,0,9,8.25H81.84a9.06,9.06,0,0,0,9-8.25L94.12,51h7.07a1,1,0,0,0,0-2ZM88.81,90.55a7,7,0,0,1-7,6.41H56.58a7,7,0,0,1-7-6.41L46.31,51h45.8Z" />
                    <path d="M57.22,45h24a2,2,0,0,0,0-4h-24a2,2,0,0,0,0,4Z" />
                    <path d="M58,88h.07A1,1,0,0,0,59,86.93l-2-27a1,1,0,1,0-2,.14l2,27A1,1,0,0,0,58,88Z" />
                    <path d="M79.93,88H80a1,1,0,0,0,1-.93l2-27a1,1,0,1,0-2-.14l-2,27A1,1,0,0,0,79.93,88Z" />
                    <path d="M69,88a1,1,0,0,0,1-1V60a1,1,0,0,0-2,0V87A1,1,0,0,0,69,88Z" />
                </svg>
                <p><?= l('qr_step_2_menu.section_delete_popup') ?></p>
            </div>
            <div class="modal-body d-flex modal-btn justify-content-around">
                <button id="sectionCloseBtn" class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_step_2_menu.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn red-btn delete-section" id="sectionDeleteBtn"><?= l('qr_step_2_menu.delete_modal.header') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- for passing language variables to qr_form.js -->
<?php
$langVariables = array(
    l('qr_step_2_com_welcome_screen.max_size_allowed_10mb'),
    l('qr_step_2.max_allow_10mb.error'),
    l('qr_step_2.loading')
);
$langVariablesJson = json_encode($langVariables);
?>

<script site-url="<?php echo UPLOADS_FULL_URL; ?>" lang-variables="<?= htmlspecialchars($langVariablesJson, ENT_QUOTES, 'UTF-8'); ?>" src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>


<script>
    const timer = document.querySelectorAll(".timepicker");
    M.Timepicker.init(timer, {});

    $(document).on('focus', '.timepicker', function() {
        const timer = document.querySelectorAll(".timepicker");
        M.Timepicker.init(timer, {});
        $(".timepicker-close:first-child").addClass("time-cancel-btn");
        $(".timepicker-close:last-child").addClass("time-ok-btn");
    });

    $('.time-ok-btn').html('<?= str_replace("'", "\'", l('global.date.ok')) ?> ');
    $('.time-cancel-btn').html('<?= str_replace("'", "\'", l('global.date.clear')) ?>');

    $(document).on('click', '.timepicker-close , .bottom-back-btn', function() {
        $(".timepicker-modal").removeClass("open");
        $(".timepicker-modal").hide();
        $('.bg-white').css({
            'overflow': 'auto'
        });
    });

    $(document).ready(function() {
        $(".timepicker-modal").removeClass("open");
        $(".timepicker-modal").hide();
    });

    var image_uploaded = false;
    var productImagesArray = [];

    var phoneNumber = 0;
    var emailNumber = 0;

    var base_url = '<?php echo UPLOADS_FULL_URL; ?>';

    $(".menu-product-wrap").on('keyup change paste', 'input, select, textarea', ".menu-product-section", function() {
        let visible = true;
        let activeSectionId = $(this).parents('.menu-product-section').data('section-id');

        $('[name="activeId"]').attr('value', activeSectionId);
        $('[name="visible"]').attr('value', visible);
    });

    $('#acc_openingHours').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="activeId"]').attr('value', '');
    });
    $('#acc_menuInfo').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="activeId"]').attr('value', '');
    });

    $('#acc_location').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="activeId"]').attr('value', '');
    });

    $('#acc_contactInfo').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="activeId"]').attr('value', '');
    });

    $('#acc_social').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="activeId"]').attr('value', '');
    });

    $('#acc_Design').on('keyup change paste', 'input, select, textarea', ".colorPaletteInner", function() {
        $('[name="activeId"]').attr('value', '');
    });


    $('.change-color').on('change click', function() {
        $('[name="activeId"]').attr('value', '');
        LoadPreview();
    });

    $('.pickerField').on('change keyup paste', function() {
        $('[name="activeId"]').attr('value', '');
        LoadPreview();
    });

    window.addEventListener('load', (event) => {
        LoadPreview();

        <?php if ($qrUid) { ?>
            reload_qr_code_event_listener();
            $('#qr-code-wrap').addClass('active');
            $("#2").attr('disabled', false)
            $("#2").removeClass("disable-btn");

        <?php } ?>
    });

    var currentPos;
    $(document).on("input click", '.anchorLoc, .anchorLocBtn', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {

        } else {
            currentPos = e.target.getAttribute('data-anchor');
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/menu';

    function LoadPreview(welcome_screen = false, showLoader = true,anchor=null) {
        // console.trace();

        // if (showLoader)
        //     setFrame();

        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        var companyLogoFile = document.getElementById('companyLogoImage').value;
        let companyTitle = document.getElementById('companyTitle').value.replace(/&/g, '%26');
        let companyDescription = document.getElementById('companyDescription').value.replace(/&/g, '%26');

        let activeId = $("input[name='activeId").val();
        let isVisible = $("input[name='visible").val();

        // contact information
        let contactName = document.getElementById('contactName').value.replace(/&/g, '%26');

        var contactWebValue = document.getElementById('contactWebsite').value.replace(/&/g, '%26');
        var contactWebsite = set_url(contactWebValue);

        let contactMobile = $("input[name='contactMobileTitles[]']").map((i,e)=>{
            return ({
                title:e.value,
                number:$("input[name='contactMobiles[]']")[i].value
            })
        }).get();

        let contactEmails = $("input[name='contactEmailTitles[]']").map((i,e)=>{
            return ({
                title:e.value,
                email:$("input[name='contactEmails[]']")[i].value
            });
        }).get();

        //Sections and Products
        let sections = $("input[name='sectionId[]']").map((i,e)=>{
            const sectionID = e.value;
            return ({
                id:sectionID,
                name:$(`input[name='sectionNames_${sectionID}[]']`).val(),
                description:$(`input[name='sectionDescriptions_${sectionID}[]']`).val(),
                products:$(`input[name='productId_${sectionID}[]']`).map((j,e)=>{
                    const productID = e.value
                    return({
                        id:productID,
                        name:$(`input[name='productNames_${sectionID}[]']`)[j].value,
                        image:$(`input[name='productImg_${sectionID}[]']`)[j].value,
                        translated:$(`input[name='productNamesTranslated_${sectionID}[]']`)[j].value,
                        description:$(`input[name='productDescriptions_${sectionID}[]']`)[j].value,
                        price:$(`input[name='productPrices_${sectionID}[]']`)[j].value,
                        allergens:$(`input[name='allergens_${sectionID}_${productID}[]']`).map((k,e)=>{
                            if (e.checked) {
                                return e.value;
                            }
                        }).get()
                    })
                }).get()
            })
        }).get();

        //map opening hours to an object
        var mondayObj = [];
        var tuesdayObj = [];
        var wednesdayObj = [];
        var thursdayObj = [];
        var fridayObj = [];
        var saturdayObj = [];
        var sundayObj = [];

        if ($("#checkboxMon").is(':checked')) {

            var mondayTo = $("input[name='Monday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Monday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    mondayObj.push({
                        'from': $(v).val(),
                        'to': mondayTo[i],
                    });
                }
            });
        }

        if ($("#checkboxTue").is(':checked')) {
            var tuesdayTo = $("input[name='Tuesday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Tuesday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    tuesdayObj.push({
                        'from': $(v).val(),
                        'to': tuesdayTo[i],
                    });
                }
            });
        }


        if ($("#checkboxWed").is(':checked')) {
            var WednesdayTo = $("input[name='Wednesday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Wednesday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    wednesdayObj.push({
                        'from': $(v).val(),
                        'to': WednesdayTo[i],
                    });
                }
            });
        }

        if ($("#checkboxThu").is(':checked')) {
            var thursdayTo = $("input[name='Thursday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Thursday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    thursdayObj.push({
                        'from': $(v).val(),
                        'to': thursdayTo[i],
                    });
                }
            });
        }

        if ($("#checkboxFri").is(':checked')) {

            var fridayTo = $("input[name='Friday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Friday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    fridayObj.push({
                        'from': $(v).val(),
                        'to': fridayTo[i],
                    });
                }
            });
        }

        if ($("#checkboxSat").is(':checked')) {
            var saturdayTo = $("input[name='Saturday_To[]']").map(function(index) {
                return $(this).val();
            }).get();


            $("input[name='Saturday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    saturdayObj.push({
                        'from': $(v).val(),
                        'to': saturdayTo[i],
                    });
                }
            });
        }

        if ($("#checkboxSun").is(':checked')) {
            var sundayTo = $("input[name='Sunday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Sunday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    sundayObj.push({
                        'from': $(v).val(),
                        'to': sundayTo[i],
                    });
                }
            });

        }
        var weekDays = {
            'Monday': mondayObj,
            'Tuesday': tuesdayObj,
            'Wednesday': wednesdayObj,
            'Thursday': thursdayObj,
            'Friday': fridayObj,
            'Saturday': saturdayObj,
            'Sunday': sundayObj,
        }

        let areAllDaysNull = Object.values(weekDays).every(day => day.length === 0);

        // set social icons
        let socialLinks = $("input[name='social_icon_name[]']").map((i,elm)=>{
            return {
                name:$(elm).attr('data-attr') + '' + $(elm).val(),
                text:$("input[name='social_icon_text[]']")[i].value,
                icon:$("input[name='social_icon[]']")[i].value,
                url:$("input[name='social_icon_url[]']")[i].value
            }
        }).get();

        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var screen = document.getElementById("editscreen").value;
        // console.log(JSON.stringify(sectionNames[1]));
        // console.log(JSON.stringify(sectionDescriptions[1]));
        // console.log(JSON.stringify(sectionId) == "[]");

        //check if any product item is empty
        const TemplateData = {
            sections : [{
                "id": "1",
                "name": "<?= l('qr_step_2_menu.lp_def_sec_1') ?>",
                "description": "",
                "products": [
                    {
                        "id": "1",
                        "name": "<?= l('qr_step_2_menu.lp_def_sec_1_pro_name') ?>",
                        "image": "https://online-qr-generator.com/uploads/menu/645d593b275ff_1_productImages_vegetable-salad.jpeg",
                        "translated": "<?= l('qr_step_2_menu.lp_def_sec_1_pro_translated') ?>",
                        "description": "<?= l('qr_step_2_menu.lp_def_sec_1_pro_description') ?>",
                        "price": "<?= l('qr_step_2_menu.lp_def_sec_1_pro_prices') ?>",
                        "allergens": [
                            "cereals",
                            "crustaceans"
                        ]
                    }
                ]
            },
            {
                "id": "78",
                "name": "<?= l('qr_step_2_menu.lp_def_sec_3') ?>",
                "description": "",
                "products": [
                    {
                        "id": "1",
                        "name": "<?= l('qr_step_2_menu.lp_def_sec_3_pro_name') ?>",
                        "image": "https://online-qr-generator.com/uploads/menu/645d593b275ff_8_productImages_donuts.png",
                        "translated": "<?= l('qr_step_2_menu.lp_def_sec_3_pro_translated') ?>",
                        "description": "<?= l('qr_step_2_menu.lp_def_sec_3_pro_description') ?>",
                        "price": "<?= l('qr_step_2_menu.lp_def_sec_3_pro_prices') ?>",
                        "allergens": ["milk", "fruits"]
                    }
                ]
            },
            {
                "id": "8",
                "name": "<?= l('qr_step_2_menu.lp_def_sec_2') ?>",
                "description": "",
                "products": [
                    {
                        "id": "1",
                        "name": "<?= l('qr_step_2_menu.lp_def_sec_2_pro_name') ?>",
                        "image": "https://online-qr-generator.com/uploads/menu/645d593b275ff_78_productImages_Orange.jpg",
                        "translated": "<?= l('qr_step_2_menu.lp_def_sec_2_pro_translated') ?>",
                        "description": "<?= l('qr_step_2_menu.lp_def_sec_2_pro_description') ?>",
                        "price": "<?= l('qr_step_2_menu.lp_def_sec_2_pro_prices') ?>",
                        "allergens": ["peanuts", "soy"]
                    }
                ]
            },
            {
                "id": "139",
                "name": "<?= l('qr_step_2_menu.lp_def_sec_4') ?>",
                "description": "",
                "products": [
                    {
                        "id": "1",
                        "name": "<?= l('qr_step_2_menu.lp_def_sec_4_pro_name') ?>",
                        "image": "https://online-qr-generator.com/uploads/menu/645d593b275ff_139_productImages_fish.jpg",
                        "translated": "<?= l('qr_step_2_menu.lp_def_sec_4_pro_translated') ?>",
                        "description": "<?= l('qr_step_2_menu.lp_def_sec_4_pro_description') ?>",
                        "price": "<?= l('qr_step_2_menu.lp_def_sec_4_pro_prices') ?>",
                        "allergens": ["eggs", "fish"]
                    }
                ]
            }],
            companyLogoFile : '<?=LANDING_PAGE_URL?>images/images/new/tastyfood.webp',
            companyTitle : '<?= str_replace("'", "\'", l('qr_step_2_menu.lp_def_company_title')) ?>',
            companyDescription : '<?= str_replace("'", "\'", l('qr_step_2_menu.lp_def_company_description')) ?>',
            weekDays : {
                "Saturday": [{from: "10:00",to: "14:00"},{from: "17:00",to: "23:00"}],
                "Sunday": [{from: "10:00",to: "17:00"}],
                "Monday": [{from: "10:00",to: "17:00"}],
                "Tuesday": [{from: "10:00",to: "17:00"}],
                "Wednesday": [{from: "10:00",to: "17:00"}],
                "Thursday": [{from: "10:00",to: "17:00"}]
            },
            socialLinks:[
                {
                    name:'',
                    text:'',
                    icon:'Facebook',
                    url:'<?=LANDING_PAGE_URL?>images/social/facebook.png'
                },
                {
                    name:'',
                    text:'',
                    icon:'Instagram',
                    url:'<?=LANDING_PAGE_URL?>images/social/instagram.png'
                },
                {
                    name:'',
                    text:'',
                    icon:'Google',
                    url:'<?=LANDING_PAGE_URL?>images/social/google.png'
                },
                {
                    name:'',
                    text:'',
                    icon:'Twitter',
                    url:'<?=LANDING_PAGE_URL?>images/social/twitter.png'
                },
                {
                    name:'',
                    text:'',
                    icon:'TikTok',
                    url:'<?=LANDING_PAGE_URL?>images/ListOfLinks/tiktok.png'
                },
            ],
            contactName:'<?= str_replace("'", "\'", l('qr_step_2_menu.lp_def_contact_name')) ?>',
            contactWebsite:'#',
            contactEmails:[{title:'',email:'<?= str_replace("'", "\'", l('qr_step_2_menu.lp_def_contact_email')) ?>'}],
            contactMobile:[{title:"",number:'<?= str_replace("'", "\'", l('qr_step_2_menu.lp_def_contact_contact_mobiles')) ?>'}]
        }

        let empty = false;
        if(
            sections.filter((e,i)=>{return e.name == "" && i == 0 ? true : false}).length === 1 &&
            socialLinks.length == 0 &&
            contactMobile.length == 0 &&
            contactEmails.length == 0 && 
            contactName === '' &&
            contactWebsite === '' &&
            companyLogoFile === '' &&
            companyTitle === '' &&
            companyDescription === ''
        ){
            empty = true;
        }

        const PreviewData = {      
            live: true,
            sections: empty ? TemplateData.sections : sections,
            socialLinks: empty ? TemplateData.socialLinks : socialLinks,
            contactMobiles: empty ? TemplateData.contactMobile : contactMobile,
            contactEmails: empty ? TemplateData.contactEmails : contactEmails,
            change: anchor || currentPos,
            activeId: activeId,
            contactName: empty ? TemplateData.contactName : contactName,
            contactWebsite: empty ? TemplateData.contactWebsite : contactWebsite,
            font_title: font_title,
            font_text: font_text,
            primaryColor: primaryColor,
            companyLogo: empty ? TemplateData.companyLogoFile : companyLogoFile,
            companyTitle: empty ? TemplateData.companyTitle : companyTitle,
            companyDescription: empty ? TemplateData.companyDescription : companyDescription,
            screen: !welcome_screen ? false : screen,
            weekDays: empty ? TemplateData.weekDays : weekDays,
            areAllDaysNull : areAllDaysNull,
            type:'menu',
            static:false,
            step:2
        };
        
        document.getElementById('iframesrc').contentWindow.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');

        // var frame = $('#iframesrc')[0];
        // var frame2 = $('#iframesrc2')[0];
        // link = link.replace(/#/g, '%23'); //convert # symbol 
        // frame.contentWindow.location.replace(link);
        // if (document.getElementById('iframesrc2')) {
        //     frame2.contentWindow.location.replace(link);
        // }

        // document.getElementById("loader").style.display = "none";
        // document.getElementById("iframesrc").style.visibility = "visible";
        // document.getElementById("preview_link").value = (!welcome_screen && screen !== "") ? welcomeLinks : link;
        // document.getElementById("preview_link2").value = (!welcome_screen && screen !== "") ? welcomeLinks : link;

        let im_url = $('#qr_code').attr('src');
        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }
        handdleQrcodeBtn();
    }

    if($('#qr_status').val()){
        $('#iframesrc').ready(function(){
            setTimeout(()=>{
                LoadPreview()
            },1000)
        })
    }

    $(document).on('click', '.delete-btn', function() {
        LoadPreview(false);
    });


    $('.colorPalette').on('click', function(e) {
        element.classList.add("active");
    });

    //product images upload
    $(document).on('change', '.productImages', function() {
        var element = $(this);
        var sectionId = $(element).parents('.menu-product-section').data('section-id');
        elementId = $(element).attr("id");
        var elementNames = sectionId + "_" + elementId;

        const [file_product] = $(this).prop('files');

        if (!file_product) {
            let delButn = $(element).closest('.screen-upload').find('.p_delete');
            delButn.click();
            return;
        }

        if (file_product) {

            $(element).parent().css("border", "1px dashed #28c254");
            $(element).closest('.screen-upload').next('.productsizeErrorMesg').remove();

            if ($(element).closest('.screen-upload').find('.upl-p-img')) {
                $(element).closest('.screen-upload').find('.upl-p-img').remove();
            }
            $(element).closest('.screen-upload').find('.addpImage').hide();
            // elem.setAttribute("height", "60");
            // elem.setAttribute("width", "60");
            // elem.css("height", "100%");
            //Removed From Here 


            if (productImagesArray[elementNames]) {
                // Deleting from Server 
                deleteCurrentLinks(productImagesArray[elementNames]);
            }

            // Note that to count exact value like operating system use 1000 instead of 1024 below functions 
            sizeinMB = file_product.size / Math.pow(1024, 2);
            if (sizeinMB > 10) {
                $(element).val(null);

                element.parent().css({
                    "border": "2px solid red"
                });

                $(element).parent().parent().after("<span class='productsizeErrorMesg' style='color:red;margin-top:15px;'><?= l('qr_step_2_menu.max_allowed_10mb') ?></span>");
                // document.getElementById("cl-tmp-mage")
                // $(element).closest('.screen-upload').find('.defaultImage').style.display = "flex";
                $(element).closest('.screen-upload').find('.defaultImage').show();
                $(element).prev().val('');
                // console.log(x);
            } else {
                // Added HEre
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file_product));
                elem.setAttribute("alt", "Product image");
                elem.setAttribute("class", "upl-p-img");
                $(element).closest('.screen-upload').find('.defaultImage').hide();
                $(element).closest('.screen-upload').find('.input-image').append(elem)
                $(element).closest('.screen-upload').find('.p_delete').attr('data-eleName', elementNames);

                // Added HEre
                $(".preview-qr-btn").attr("disabled", true);
                $("#temp_next").attr("disabled", true);
                $(element).parent().append('<div id="welcome-screens-loader" class="spinner-border text-secondary welcome-screens-loader" role="status"><span class="sr-only"><?= l('qr_step_2.loading') ?></span></div>');
                let previewImage = $(element).nextAll('.input-image:first').find(".upl-p-img");
                $(previewImage).css({
                    'filter': 'blur(1px)',
                });
                let form = document.querySelector('form#myform');
                let form_data = new FormData(form);
                newFormData = filterOnlyCurrentFile(form_data, file_product, sectionId);
                $.ajax({
                    type: 'POST',
                    method: 'post',
                    url: qrFormPostUrl,
                    data: newFormData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                        $(element).parent().find(".welcome-screens-loader").remove();
                        $(previewImage).css({
                            'filter': 'none',
                        });

                        $(element).closest('.screen-upload').find('.editpImage').show();
                        $(element).closest('.screen-upload').find('.p_delete').show();
                        LoadPreview(false, false);
                        document.querySelector('#qr_code').src = response.details.data;
                        document.querySelector('#download_svg').href = response.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            document.querySelector('input[name="qr_code"]').value = response.details.data;
                        }

                        // We are here doing this step to store the path of the current Welcome Screens and then delete it from the server if required 
                        let uId = document.getElementById('uId').value;
                        var filesscreens = file_product;
                        var productImageUnqId = $("#uploadUniqueId").val();
                        var fileExtension = filesscreens.name.substr(filesscreens.name.lastIndexOf('.') + 1);
                        var types = document.querySelector('input[name="type"]').value;
                        productImagesArray[elementNames] = filesscreens ? "menu/" + uId + "_" + sectionId + "_productImages_" + productImageUnqId + '.' + fileExtension + "" : "";
                        $(element).closest('.screen-upload').find(`input[name="productImg_${sectionId}[]"]`).val(base_url + productImagesArray[elementNames]);
                        LoadPreview(false);

                    },
                    error: function(response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                    }
                });
            }
        }

    });

    const filterOnlyCurrentFile = (formData, files, sectionId) => {
        // Loop through all fields in the FormData object
        var formData = formData;
        for (let pair of formData.entries()) {
            const fieldName = pair[0];
            const fieldValue = pair[1];

            // Check if the field is a file input and not named "screens"
            if (fieldValue instanceof File && fieldName !== "qr_code_logo") {
                // Remove the file input if it is not named "screens"
                formData.delete(fieldName);
            }
        }
        formData.append('productImagess', files);
        formData.append('newSectionIds', sectionId);
        return formData;
    }

    const deleteCurrentLinks = (files) => {
        if (checkIfValueExistsMoreThanOnce(productImagesArray, files)) {
            return;
        }
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

    function checkIfValueExistsMoreThanOnce(arr, value) {
        let count = 0;
        for (const key in arr) {
            if (arr.hasOwnProperty(key)) {
                if (arr[key] === value) {
                    count++;
                }
                if (count > 1) {
                    return true
                }
            }
        }
        return false;
    }


    //remove product image

    $(document).on('click', '.p_delete', function() {

        $(this).closest('.screen-upload').find('input').val('');
        $(this).closest('.screen-upload').find('.addpImage').show();
        $(this).closest('.screen-upload').find('.editpImage').hide();
        $(this).closest('.screen-upload').find('.p_delete').hide();
        $(this).closest('.screen-upload').find('.defaultImage').show()
        $(this).closest('.screen-upload').find('.product-image').val('')

        $(this).closest('.screen-upload').find('.upl-p-img').remove();

        $(this).closest('.screen-upload').find("label[for='productImages']").css("border", "2px solid #96949C");
        $(this).closest('.screen-upload').next('.productsizeErrorMesg').remove();


        LoadPreview(false);
        // Deleting from Servers 
        let elementKeyss = $(this).attr("data-eleName");
        deleteCurrentLinks(productImagesArray[elementKeyss]);
        productImagesArray[elementKeyss] = undefined;

    });
    //remove product image
</script>


<script>
    function trigerproductimage(id) {
        $('#productImages' + id).trigger('click');
    }

    //prevent page redirect on keypress
    $('input').keypress(function(e) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    })


    // add menu section
    $(".product-section-btn").on("click", function() {
        // LoadPreview();
        var productSection = $(".menu-product-wrap .menu-product-section").length;
        productSection = productSection + 1;

        var randomNumber = Math.floor(Math.random() * 500);

        var productSectionAdd =
            `
            <div id="add_section" class="menu-product-section mt-3" data-section-id="` + randomNumber + `" data-section-index="${productSection}">
                <div class="custom-accodian sub-accordian mb-0">
                        <input type="hidden" name="sectionId[]" value="` + randomNumber + `" data-reload-qr-code>
                        <div class="form-group d-flex align-items-center justify-content-between mb-0">
                            <div class="d-flex">
                                <button class="btn accodianBtn section-btn" type="button" data-toggle="collapse" data-target="#menu_section_` + randomNumber + `" aria-expanded="true" aria-controls="menu_section_"` + randomNumber + ` style="width: auto">
                                <span class="icon-arrow-h-right grey toggle-icon"></span>
                                <p class="paraheading section-name mb-0"><?= l('qr_step_2_menu.section') ?> ` + productSection + `</p>
                                </button>
                            </div>
                                
                            <div class="d-flex align-items-center section-order" style="margin-left: 8px">
                                <button type="button" data-target="#sectionDeleteModal" data-toggle="modal" class="formCustomBtn delete-sec-btn delete-section"  >
                                    <span class="icon-trash"></span>
                                </button>
                                <div class="p-0 menuActionButtons">
                                    <div class="d-flex ">
                                        <button type="button" class="menu-order-up jss1426 jss1424">
                                            <span class="icon-arrow-down"></span>
                                        </button>
                                        <button type="button" class="menu-order-down jss1426 jss1424">
                                            <span class="icon-arrow-down"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show section-collapse" id="menu_section_` + randomNumber + `">
                            <div class="form-group col-12">
                                <label for="sectionNames"> <?= l('qr_step_2_menu.input.section.name') ?> <span class="text-danger text-bold">*</span></label>
                                <input class="form-control sectionNames anchorLoc" data-anchor="menuSec_Name${productSection}" id="sectionNames" type="text"  name="sectionNames_` + randomNumber + `[]" placeholder="<?= l('qr_step_2_menu.input.sectionNames.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate />
                            </div>
                            <div class="form-group col-12 m-0">
                                <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?> </label>
                                <input class="form-control anchorLoc" data-anchor="menuSec_Desc${productSection}" id="sectionDescriptions" type="text"  name="sectionDescriptions_` + randomNumber + `[]" placeholder="<?= l('qr_step_2_menu.input.sectionDescriptions.placeholder') ?>"  data-reload-qr-code />
                            </div>
                            <div class="product-container">
                                <div id="add_product" class="add_product" data-product-id="1">
                                <input type="hidden" name="productId_` + randomNumber + `[]" value="1" data-reload-qr-code>
                                    <div class="productAccodian">
                                        <div class="custom-accodian sub-accordian mb-0">
                                            <div class="d-flex justify-content-between">
                                                    <div class="d-flex product-toggle-btn">
                                                        <button class="btn accodianBtn product-btn section-btn" type="button" data-toggle="collapse" data-target="#menu_product_` + randomNumber + `_1" aria-expanded="true" aria-controls="menu_product_` + randomNumber + `_1">
                                                            <span class="icon-arrow-h-right grey toggle-icon"></span>
                                                            <p class="paraheading product-name mb-0 "><?= l('qr_step_2_menu.input.productName') ?> </p>
                                                        </button>
                                                    </div>
                                     
                                                <div class="d-flex align-items-center">
                                                    
                                                    <div class="p-0 productActionButtons">
                                                            <div class="d-flex ">
                                                                <button type="button" class="formCustomBtn delete-sec-btn  delete-product">
                                                                        <span class="icon-trash"></span>
                                                                </button>
                                                                <button type="button" class="product-order-up jss1426 jss1424">
                                                                    <span class="icon-arrow-down"></span>
                                                                </button>
                                                                <button type="button" class="product-order-down jss1426 jss1424">
                                                                    <span class="icon-arrow-down"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
    
                                            <div class="collapse show product-collapse" id="menu_product_` + randomNumber + `_1">
                                                <div class="collapseInner p-0 mt-2">
                                                    <div class="welcome-screen">
                                                        <span style="display:flex;">
                                                            <?= l('qr_step_2_menu.image') ?>
                                                            <span 
                                                                class="info-tooltip-icon ctp-tooltip"
                                                                tp-content="<?= l('qr_step_2_menu.help_tooltip.product_image') ?>"
                                                            ></span>
                                                        </span>
                                                        <!-- Before Upload Priview -->
                                                        <div class="screen-upload mb-4">
                                                            <label for="productImages" class="product-image-wrap">
                                                            <input type="hidden" class="productImghidden anchorLoc" data-anchor="menuProd${productSection}_1" name="productImg_` + randomNumber + `[]" value="">
                                                                <!-- //onchange="setTimeout(function() { document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);"  -->
                                                                <input type="file"  id="productImages` + randomNumber + `" name="productImages_` + randomNumber + `[]" class="form-control py-2 productImages anchorLoc" data-anchor="menuProd_img${productSection}" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp"  required="required" input_size_validate data-reload-qr-code />
                                                                <input type="hidden" class="product-index" name="productIndex_` + randomNumber + `[]" value="1">
    
                                                                <div class="input-image">
                                                                    <span class="icon-add-image defaultImage"></span>
                                                                </div>
                                                                <div class="add-icon addpImage" style="opacity: 0;" onclick="trigerproductimage(` + randomNumber + `)">
                                                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                                                    </svg>
                                                                </div>
                                                                <div class="add-icon editpImage" style="opacity: 0;" onchange="trigerproductimage(` + randomNumber + `)">
                                                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                                                        <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                                    </svg>
                                                                </div>
                                                            </label>
                                                            <button type="button" class="delete-btn p_delete" style="display:none;">
                                                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                                                    <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                                                    <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                                                </svg>
                                                                <?= l('qr_step_2_menu.delete') ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                                            <label for="productNames"> <?= l('qr_step_2_menu.input.name') ?>  <span class="text-danger text-bold">*</span></label>
                                                            <input class="form-control pName anchorLoc"  data-anchor="menuProd${productSection}_1" type="text"  name="productNames_` + randomNumber + `[]" placeholder="<?= l('qr_step_2_menu.input.pName.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate />
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                                            <label for="productNamesTranslated"><?= l('qr_step_2_menu.translated_name') ?></label>
                                                            <input class="form-control anchorLoc" data-anchor="menuProd${productSection}_1" type="text" id="productNamesTranslated"  name="productNamesTranslated_` + randomNumber + `[]" placeholder="<?= l('qr_step_2_menu.input.productNamesTranslated.placeholder') ?>" data-reload-qr-code />
                                                        </div>
                                                    </div>
                                                    <div class="form-group mobile-form-group">
                                                        <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?></label>
                                                        <input class="form-control anchorLoc" data-anchor="menuProd${productSection}_1" type="text" id="productDescriptions"  name="productDescriptions_` + randomNumber + `[]" placeholder="<?= l('qr_step_2_menu.input.productDescriptions.placeholder') ?>"  data-reload-qr-code  />
                                                    </div>
                                                    <div class="form-group col-sm-12 p-0 mobile-form-group">
                                                        <label for="productPrices"><?= l('qr_step_2_menu.price') ?></label>
                                                        <input class="form-control anchorLoc" data-anchor="menuProd${productSection}_1" type="text" id="productPrices" name="productPrices_` + randomNumber + `[]"  placeholder="<?= l('qr_step_2_menu.input.productPrices.placeholder') ?>" data-reload-qr-code />
                                                    </div>
    
                                                    <div class="allerg-block form-group col-md-12 p-0">
                                                        <label for="productPrices"><?= l('qr_step_2_menu.allergens.title') ?></label>
                                                        <div class="container px-0">
                                                        <div class="mt-1 row  mx-0  align-item-center all_allergens">
                                                        <?php foreach ($allergens as $key => $value) { ?>
                                                            <div class="col-auto px-0">
                                                                <div class="allergens_btn">
                                                                    <input 
                                                                        type="checkbox" 
                                                                        class="allergens_checkbox allergens anchorLoc" 
                                                                        data-anchor="menuProd${productSection}_1"  
                                                                        value="<?php echo $value ?>" 
                                                                        name="allergens_` + randomNumber + `_1[]"
                                                                        <?php echo (!empty($filledInput) && isset($filledInput[$value])) ? (($filledInput[$value]) ? 'checked' : $value) : ''; ?> 
                                                                        data-reload-qr-code
                                                                        onclick="LoadPreview()"
                                                                    >
                                                                    <label class="check_effect"></label>
                                                                    <span class="tooltip text-center"><?= l('qr_step_2_menu.allergens.' . $value) ?></span>
                                                                    <img class="allergens_img" src="<?php echo (ASSETS_FULL_URL) . 'images/allergens-icons/' . $value .  '.svg' ?>" alt="">
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productAccodianbutton">
                                <button data-add="menu-product" id="add1" type="button" class="outlineBtn addRowButton add-product menu add1">
                                <span class="icon-add-square mr-1 smIcon"></span>
                                <?= l('qr_step_2_menu.add_product') ?>
                                </button>
                            </div>
                        </div>
                </div>
            </div>
                `;

        $('.menu-product-wrap').append(productSectionAdd);
        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        })

        tooltipUpdate();
        LoadPreview();
    });

    // menu product append form product section
    $(".menu-product-wrap").on("click", ".add-product", function() {
        // LoadPreview();


        var product = $(this).parents(".menu-product-section").children('.custom-accodian').children('.collapse').children('.product-container').children('.add_product').length;
        product = product + 1;
        const sectionIndex = $(this).parents('.menu-product-section').data('section-index');

        var sectionId = $(this).parents('.menu-product-section').data('section-id');

        var randomNumber = Math.floor(Math.random() * 100);


        var productBlockAdd =
            `
        <div id="add_product" class="add_product" data-product-id="` + randomNumber + `">
        <input type="hidden" name="productId_` + sectionId + `[]" value="` + randomNumber + `" data-reload-qr-code>

            <div class="productAccodian">
                <div class="custom-accodian sub-accordian mb-0">
                    <div class="d-flex justify-content-between">
                    
                        <div class="d-flex product-toggle-btn">
                            <button class="btn accodianBtn product-btn section-btn" type="button" data-toggle="collapse" data-target="#menu_product_` + sectionId + `_` + randomNumber + `" aria-expanded="true" aria-controls="menu_product_` + sectionId + `_` + randomNumber + `">
                                <span class="icon-arrow-h-right grey toggle-icon"></span>
                                <p class="paraheading product-name mb-0"><?= l('qr_step_2_menu.input.productName') ?> ` + product + `</p>

                            </button>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="p-0 productActionButtons">
                                <div class="d-flex ">
                                    <button type="button" class="formCustomBtn delete-sec-btn  delete-product">
                                            <span class="icon-trash"></span>
                                    </button>
                                    <button type="button" class="product-order-up jss1426 jss1424">
                                        <span class="icon-arrow-down"></span>
                                    </button>
                                    <button type="button" class="product-order-down jss1426 jss1424">
                                        <span class="icon-arrow-down"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse show product-collapse" id="menu_product_` + sectionId + `_` + randomNumber + `">
                        <div class="collapseInner p-0 mt-2">
                            <div class="welcome-screen">
                                <span style="display:flex;">
                                    <?= l('qr_step_2_menu.image') ?>
                                    <span 
                                        class="info-tooltip-icon ctp-tooltip"
                                        tp-content="<?= l('qr_step_2_menu.help_tooltip.product_image') ?>"
                                    ></span>
                                </span>
                                <!-- Before Upload Priview -->
                                <div class="screen-upload mb-4">
                                    <label for="productImages" class="product-image-wrap">
                                    <input type="hidden" class="productImghidden anchorLoc" data-anchor="menuProd${sectionIndex}_${product}"  name="productImg_` + sectionId + `[]" value="">
                                        <!-- //onchange="setTimeout(function() { document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);"  -->
                                        <input type="file" id="productImages` + randomNumber + `" name="productImages_` + sectionId + `[]" class="form-control py-2 productImages" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp"  required="required" input_size_validate data-reload-qr-code />
         
                                        <div class="input-image">
                                            <span class="icon-add-image defaultImage"></span>
                                        </div>
                                        <div class="add-icon addpImage" style="opacity: 0;"  onclick="trigerproductimage(` + randomNumber + `)">
                                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                            </svg>
                                        </div>
                                        <div class="add-icon editpImage" style="opacity: 0;" onclick="trigerproductimage(` + randomNumber + `)">
                                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                                <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                            </svg>
                                        </div>
                                    </label>
                                    <button type="button" class="delete-btn p_delete" style="display:none;">
                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                            <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                            <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                        </svg>
                                        <?= l('qr_step_2_menu.delete') ?>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                    <label for="productNames"> <?= l('qr_step_2_menu.input.name') ?> <span class="text-danger text-bold">*</span></label>
                                    <input class="form-control pName anchorLoc" data-anchor="menuProd${sectionIndex}_${product}" type="text"  name="productNames_` + sectionId + `[]" placeholder="<?= l('qr_step_2_menu.input.pName.placeholder') ?>" required="required" data-reload-qr-code input_validate required_validate/>
                                </div>
                                <div class="form-group col-md-6 col-sm-12 mobile-form-group">
                                    <label for="productNamesTranslated"><?= l('qr_step_2_menu.translated_name') ?></label>
                                    <input class="form-control anchorLoc" data-anchor="menuProd${sectionIndex}_${product}" type="text" id="productNamesTranslated"  name="productNamesTranslated_` + sectionId + `[]" placeholder="<?= l('qr_step_2_menu.input.productNamesTranslated.placeholder') ?>" data-reload-qr-code />
                                </div>
                            </div>
                            <div class="form-group mobile-form-group">
                                <label for="productDescriptions"> <?= l('qr_step_2_menu.input.description') ?></label>
                                <input class="form-control anchorLoc" data-anchor="menuProd${sectionIndex}_${product}" type="text" id="productDescriptions"  name="productDescriptions_` + sectionId + `[]" placeholder="<?= l('qr_step_2_menu.input.productDescriptions.placeholder') ?>"  data-reload-qr-code  />
                            </div>
                            <div class="form-group col-sm-12 p-0 mobile-form-group">
                                <label for="productPrices"><?= l('qr_step_2_menu.price') ?></label>
                                <input class="form-control anchorLoc" data-anchor="menuProd${sectionIndex}_${product}" type="text" id="productPrices" name="productPrices_` + sectionId + `[]"  placeholder="<?= l('qr_step_2_menu.input.productPrices.placeholder') ?>" data-reload-qr-code />
                            </div>

                            <div class="allerg-block form-group col-md-12 p-0">
                                <label for="productPrices"><?= l('qr_step_2_menu.allergens.title') ?></label>
                                <div class="container px-0">
                                <div class="mt-1 row  mx-0  align-item-center all_allergens">
                                <?php foreach ($allergens as $key => $value) { ?>
                                    <div class="col-auto px-0">
                                        <div class="allergens_btn">
                                            <input 
                                                type="checkbox" 
                                                class="allergens_checkbox allergens anchorLoc" 
                                                data-anchor="menuProd${sectionIndex}_${product}" 
                                                value="<?php echo $value ?>" 
                                                name="allergens_` + sectionId + `_` + randomNumber + `[]"
                                                <?php echo (!empty($filledInput) && isset($filledInput[$value])) ? (($filledInput[$value]) ? 'checked' : $value) : ''; ?> 
                                                data-reload-qr-code
                                                onclick="LoadPreview()"
                                            >
                                            <label class="check_effect"></label>
                                                <span class="tooltip text-center"><?= l('qr_step_2_menu.allergens.' . $value) ?></span>
                                                <img class="allergens_img" src="<?php echo (ASSETS_FULL_URL) . 'images/allergens-icons/' . $value .  '.svg' ?>" alt="">
                                            </div>
                                    </div>
                                <?php } ?>
                                </div>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;

        $(this).parent().prev().append(productBlockAdd);

        tooltipUpdate();
        LoadPreview();
    });

    // delete product 
    $(document).on('click', '.delete-product', function() {
        let delButn = $(this).parent().parent().parent().find(".p_delete");
        // delButn.click();
        $('[name="activeId"]').attr('value', '');
        $(this).parents('.add_product').remove();
        console.log($(this).parents('.add_product'));
        LoadPreview();
    });

    // delete section
    $('.menu-product-wrap').on('click', '.delete-section', function(e) {
        let sectionDivs = $(this).parent().parent().parent();
        sectionDivs.find(".p_delete").each(function() {
            $(this).click();
        });
        $('[name="activeId"]').attr('value', '');
        let sec = $(this).closest(".menu-product-section");

        $('#sectionDeleteBtn').click(function(ev) {
            ev.preventDefault();
            sec.remove();
            $('#sectionCloseBtn').click();
            LoadPreview();
        });
    });


    $(document).ready(function() {

        // reorder section menu
        $(".menu-product-wrap").on("click", ".menu-order-up", function() {
            var mainNodes = $(this).parents('.menu-product-wrap').children('.menu-product-section');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if (mainNodeslength > 1) {
                $(this).parents('.menu-product-section').insertBefore($(this).parents('.menu-product-section').prev());
            }
            $('[name="activeId"]').attr('value', '');
            LoadPreview();
        });
        $(".menu-product-wrap").on("click", ".menu-order-down", function() {
            var mainNodes = $(this).parents('.menu-product-wrap').children('.menu-product-section');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if ((mainNodeslength > 1) && (mainNodes.is(':not(:first-child)'))) {
                $(this).parents('.menu-product-section').insertAfter($(this).parents('.menu-product-section').next());
            }
            $('[name="activeId"]').attr('value', '');
            LoadPreview();
        });



        // reorder product menu
        $(".menu-product-wrap").on("click", ".product-order-up", function() {
            var mainNodes = $(this).parents('.product-container').children('.add_product');

            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if (mainNodeslength > 1) {
                var currentNode = $(this).parents('.add_product');
                var previousNode = $(this).parents('.add_product').prev();
                currentNode.insertBefore(previousNode);
                previousNode.insertAfter(currentNode);
            }
            LoadPreview();
        });
        $(".menu-product-wrap").on("click", ".product-order-down", function() {
            var mainNodes = $(this).parents('.product-container').children('.add_product');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if ((mainNodeslength > 1) && (mainNodes.is(':not(:first-child)'))) {
                $(this).parents('.add_product').insertAfter($(this).parents('.add_product').next());
            }
            LoadPreview();
        });

        // Rename sections

        $(document).on('change keyup', ".sectionNames", function() {
            $(this).parents('.menu-product-section').find('.section-name').html($(this).val());
        })

        //Rename product

        $(document).on('change keyup', ".pName", function() {
            $(this).parents('.add_product').find('.product-name').html($(this).val());
        })

    });
    
    function handdleQrcodeBtn() {
        var isDisable = true;
        document.getElementById("myform").querySelectorAll("[required_validate]").forEach(function(i) {
            var inputFieldValue = $(i).val();
            var isRequired      = $(i).prop('required'); 

            if (inputFieldValue != '') {
                isDisable = false;
            } else {
                isDisable = true;
            }
        });

        if (isDisable == true) {
            $("#2").attr('disabled', true);
            $("#2").addClass("disable-btn");
        } else {
            $("#2").attr('disabled', false);
            $("#2").removeClass("disable-btn");
        }
    }
</script>