<?php defined('ALTUMCODE') || die() ?>
<?php
if (isset($data->qr_code[0]['data'])) {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $categories = json_decode($data->qr_code[0]['settings'], true);
    $QrName =  $data->qr_code[0]['name'];


    $categoriesCount =  count($categories['feedback_categories']);
} else {
    $filledInput = array();
    $categories = array();
    $QrName = null;
}

?>

<div id="step2_form">
    <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['uId'] : uniqid();  ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />




    <!-- QR Name -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrCode" aria-expanded="false" aria-controls="acc_nameOfQrCode">
            <span> <?= l('qr_codes.input.qrname') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse" id="acc_nameOfQrCode">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="<?php echo (!empty($QrName)) ? $QrName : '';  ?>" maxlength="<?= $data->qr_code_settings['type']['images']['name']['max_length'] ?>" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>
    <!-- QR Name -->

    <!-- Design  -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_Design" aria-expanded="true" aria-controls="acc_Design">
            <span>Design</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_Design">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <label for="colorPalette">Colour palette</label>
                    <div class="colorPaletteForm">
                        <div class="formcolorPalette active" id="formcolorPalette1">
                            <input type="color" name="" class="colorPalette w-100" value="#527ac9" readonly />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette2">
                            <input type="color" name="" class="colorPalette w-100" value="#ecedf1" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette3">
                            <input type="color" name="" class="colorPalette w-100" value="#ececf0" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette4">
                            <input type="color" name="" class="colorPalette w-100" value="#daebf6" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette5">
                            <input type="color" name="" class="colorPalette w-100" value="#b69edf" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette6">
                            <input type="color" name="" class="colorPalette w-100" value="#7ec09f" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette7">
                            <input type="color" name="" class="colorPalette w-100" value="#edc472" />
                        </div>
                    </div>

                    <div class="colorPaletteInner">
                        <div class="form-group m-0">
                            <label for="">Primary</label>
                            <div class="customColorPicker">
                                <label for="primaryColor">
                                    <input id="primaryColor" name="primaryColor" onchange="LoadPreview()" class="pickerField" type="color" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" data-reload-qr-code /><span><?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Design  -->

    <!-- Font -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfFonts" aria-expanded="true" aria-controls="acc_nameOfFonts">
            <span>Fonts</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_nameOfFonts">
            <div class="collapseInner">
                <div class="bg-container">
                    <div class="row">
                        <div class="form-group m-0 col-md-6 col-sm-12">
                            <label for="filters_cities_by" class="fieldLabel">Title</label>
                            <select name="search_by" id="filters_title_by" class="form-control">
                                <option value="Lato" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Lato')) ? 'selected' : ''; ?> style="  ">Lato</option>
                                <option value="Open Sans" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Open Sans')) ? 'selected' : ''; ?> style="font-family: Open Sans, sans-serif;">Open Sans</option>
                                <option value="Roboto" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Roboto')) ? 'selected' : ''; ?> style="font-family: Roboto, sans-serif;">Roboto</option>
                                <option value="Oswald" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Oswald')) ? 'selected' : ''; ?> style="font-family: Oswald, sans-serif;">Oswald</option>
                                <option value="Montserrat" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Montserrat')) ? 'selected' : ''; ?> style="font-family: Montserrat, sans-serif;">Montserrat</option>
                                <option value="Source Sans Pro" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Source Sans Pro')) ? 'selected' : ''; ?> style="font-family: Source Sans Pro, sans-serif;">Source Sans Pro</option>
                                <option value="Slabo 27px" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Slabo 27px')) ? 'selected' : ''; ?> style="font-family: Slabo 27px, serif;">Slabo 27px</option>
                                <option value="Raleway" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Raleway')) ? 'selected' : ''; ?> style="font-family: Raleway, sans-serif;">Raleway</option>
                                <option value="Merriwealther" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Merriwealther')) ? 'selected' : ''; ?> style="font-family: Merriweather, serif;">Merriwealther</option>
                                <option value="Noto Sans" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Noto Sans')) ? 'selected' : ''; ?> style="font-family: Noto Sans, sans-serif;">Noto Sans</option>
                            </select>
                        </div>
                        <div class="form-group m-0 col-md-6 col-sm-12">
                            <label for="filters_cities_by" class="fieldLabel">Texts</label>
                            <select name="search_by" id="filters_text_by" class="form-control">
                                <option value="Lato" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Lato')) ? 'selected' : ''; ?> style="  ">Lato</option>
                                <option value="Open Sans" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Open Sans')) ? 'selected' : ''; ?> style="font-family: Open Sans, sans-serif;">Open Sans</option>
                                <option value="Roboto" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Roboto')) ? 'selected' : ''; ?> style="font-family: Roboto, sans-serif;">Roboto</option>
                                <option value="Oswald" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Oswald')) ? 'selected' : ''; ?> style="font-family: Oswald, sans-serif;">Oswald</option>
                                <option value="Montserrat" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Montserrat')) ? 'selected' : ''; ?> style="font-family: Montserrat, sans-serif;">Montserrat</option>
                                <option value="Source Sans Pro" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Source Sans Pro')) ? 'selected' : ''; ?> style="font-family: Source Sans Pro, sans-serif;">Source Sans Pro</option>
                                <option value="Slabo 27px" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Slabo 27px')) ? 'selected' : ''; ?> style="font-family: Slabo 27px, serif;">Slabo 27px</option>
                                <option value="Raleway" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Raleway')) ? 'selected' : ''; ?> style="font-family: Raleway, sans-serif;">Raleway</option>
                                <option value="Merriwealther" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Merriwealther')) ? 'selected' : ''; ?> style="font-family: Merriweather, serif;">Merriwealther</option>
                                <option value="Noto Sans" <?php echo (!empty($filledInput) && ($filledInput['search_by'] == 'Noto Sans')) ? 'selected' : ''; ?> style="font-family: Noto Sans, sans-serif;">Noto Sans</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Font -->

    <!-- Basic Information -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <span>Basic Information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <div class="collapseInner">


                <div class="form-group">
                    <label for="basic-info">Name</label>
                    <input id="basic_info" onchange="LoadPreview()" placeholder="Company or product to be reviewed" name="basic_info" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['basic_info'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group">
                    <label for="title">Title <span class="text-danger text-bold">*</span></label>
                    <input id="title" onchange="LoadPreview()" placeholder="e.g Leave us your feedback" name="title" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['title'] : ''; ?>" required="required" data-reload-qr-code input_validate />
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Information -->

    <!-- Add Categories Here -->

    <!-- Categories -->
    <div class="custom-accodian categories-adding-accordion">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_categories" aria-expanded="true" aria-controls="acc_categories">
            <span>Categories</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_categories">
            <div class="collapseInner">
                <p class="jss256 error-message cat-error-message">It must have at least 1 element(s)</p>
                <div class="category-fields-wrp" id="sortable">

                    <?php if ($categories['feedback_categories']) { ?>

                        <?php foreach ($categories['feedback_categories'] as $key => $category) { ?>

                            <?php $catgoryId = $key + 1 ?>

                            <div class="main-category" id="mainCategory<?php echo $catgoryId ?>" data-sub-id="<?php echo $catgoryId ?>">
                                <div class="main-category-block">
                                    <div class="title-wrp">
                                        <span>Category </span>
                                        <div class="buttons-wrp">
                                            <button class="m-cat-btns m-cat-up" type="button"><i class="fa-solid fa-angle-up"></i></button>
                                            <button class="m-cat-btns m-cat-down" type="button"><i class="fa-solid fa-angle-down"></i></button>
                                            <button id="del-cate<?php echo $catgoryId ?>" class="m-cat-btns m-cat-delete" type="button"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="field-wrp">
                                        <div class="icon-list-wrp">

                                            <div class="form-group">
                                                <label for="feedback-category-">Icon <span class="text-danger text-bold"></span></label>
                                                <div class="dropdown-cat-icon">
                                                    <button type="button" class="dropbtn drop-btn"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/<?php echo $category['icon'] ? $category['icon'] : 'Empty' ?>.png">
                                                    </button>
                                                    <div id="myDropdown" class="dropdown-content single-cat-icon">
                                                        <button class="cat-icon-btn" data-icon-pick="Empty" value="Empty" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Empty.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Star" value="Star" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Star.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Availability" value="Availability" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Availability.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Ambience" value="Ambience" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Ambience.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Parking" value="Parking" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Parking.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Processing" value="Processing" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Processing.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Program" value="Program" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Program.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Error" value="Error" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Error.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Beverages" value="Beverages" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Beverages.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Food" value="Food" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Food.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Restrooms" value="Restrooms" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Restrooms.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Location" value="Location" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Location.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Seats" value="Seats" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Seats.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Room" value="Room" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Room.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Hours" value="Hours" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Hours.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Connectivity" value="Connectivity" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Connectivity.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Catering" value="Catering" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Catering.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Conference" value="Conference" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Conference.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Selection" value="Selection" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Selection.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Housekeeping" value="Housekeeping" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Housekeeping.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Staff" value="Staff" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Staff.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Person" value="Person" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Person.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Wellness" value="Wellness" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Wellness.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Services" value="Services" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Services.png"></button>
                                                        <button class="cat-icon-btn" data-icon-pick="Price" value="Prices" type="button"><img class="img-fluid" src="<?php echo (ASSETS_FULL_URL) ?>/images/category-icons/Price.png"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-wrp">
                                            <div class="form-group">
                                                <input type="hidden" class="main-cat-icon-in" name="feedback-categories-icon[]" value="<?php echo $category['icon'] ?>">
                                                <label for="feedback-category-">Name <span class="text-danger text-bold">*</span></label>
                                                <input id="feedback-category-" onchange="LoadPreview()" placeholder=" " required name="feedback-categories[]" class="form-control" value="<?php echo $category['name'] ?>" required="" data-reload-qr-code input_validate />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-category ">
                                    <div class="sub-category-block">
                                        <?php foreach ($categories['feedback_sub_categories'][$catgoryId] as $key => $subCategory) { ?>

                                            <div class="field-wrp sub-category-field">
                                                <div class="input-wrp">
                                                    <div class="form-group ">
                                                        <label for="feedback-category-">Name <span class="text-danger text-bold">*</span></label>
                                                        <input id="feedback-category-" onchange="LoadPreview()" placeholder=" " required name="sub_categories_<?php echo $catgoryId ?>[]" class="form-control" value="<?php echo $subCategory['name'] ?>" required="" data-reload-qr-code input_validate />
                                                        <div class="buttons-wrp">
                                                            <button class="m-cat-btns m-subcat-up" type="button"><i class="fa-solid fa-angle-up"></i></button>
                                                            <button class="m-cat-btns m-subcat-down" type="button"><i class="fa-solid fa-angle-down"></i></button>
                                                            <button id="del-subcate<?php echo $catgoryId ?>" class="m-cat-btns m-subcat-delete" type="button"><i class="fa-solid fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                    <div class="add-subcategory">
                                        <button type="button" class="btn add-subcategory-btn rounded-btn w-100">
                                            <i class="fa-solid fa-plus"></i> Add Sub Category
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    <?php  } ?>
                </div>

                <div class="add-maincategory-wrp d-flex align-items-center">
                    <button type="button" class="btn rounded-btn add-maincategory-btn">
                        <i class="fa-solid fa-plus"></i> Add Category
                    </button>
                    <div class="select-category-wrp">
                        <div class="select-category">
                            <button type="button" class="def-cat-btn">Select Categoty</button>
                            <div class="dropdown">
                                <ul>
                                    <li class="main-cat-item">
                                        <button type="button">Gastronomy</button>
                                        <ul class="dropdown-sub">
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Food" value="Food" type="button">Food</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Beverages" value="Beverages" type="button">Beverages</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Person" value="Person" type="button">Services</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Ambience" value="Ambience" type="button">Ambience</button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="main-cat-item">
                                        <button type="button">Hotels</button>
                                        <ul class="dropdown-sub">
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Room" value="Room" type="button">Room</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Food" value="Food" type="button">Restaurent</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Beverages" value="Beverages" type="button">Bar</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Empty" value="Reception" type="button">Reception</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Housekeeping" value="Housekeeping" type="button">Housekeeping</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Conference" value="Conference" type="button">Conference Area</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Wellness" value="Wellness" type="button">Wellness And Spa</button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="main-cat-item">
                                        <button type="button">Events</button>
                                        <ul class="dropdown-sub">
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Catering" value="Catering" type="button">Catering</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Location" value="Location" type="button">Location</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Program" value="Program" type="button">Program</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Price" value="Price" type="button">Price</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Seats" value="Seats" type="button">Seats</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Restrooms" value="Restrooms" type="button">Restrooms</button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="main-cat-item">
                                        <button type="button">Retail</button>
                                        <ul class="dropdown-sub">
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Selection" value="Selection" type="button">Selection</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Price" value="Price" type="button">Prices</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Staff" value="Staff" type="button">Staff</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Hours" value="Hours" type="button">Opening Hours</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Parking" value="Parking" type="button">Parking</button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="main-cat-item">
                                        <button type="button">Services</button>
                                        <ul class="dropdown-sub">
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Services" value="Services" type="button">Services</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Person" value="Person" type="button">Consultation</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Processing" value="Processing" type="button">Processing time</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Price" value="Prices" type="button">Prices</button>
                                            </li>
                                            <li>
                                                <button class="def-category" onclick="LoadPreview()" data-icon="Availability" value="Availability" type="button">Availability</button>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Categories -->
    <div class="overlay"></div>

    <!-- Contact Information -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_contactInfo" aria-expanded="true" aria-controls="acc_contactInfo">
            <span>Contact information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_contactInfo">
            <div class="collapseInner">

                <div class="email-wrapper">
                    <div class="form-group">
                        <label for="feedback-email">Email <span class="text-danger text-bold">*</span></label>
                        <input id="feedback-email" onchange="LoadPreview()" placeholder=" E.g. name@email.com" name="feedback_email" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['feedback_email'] : ''; ?>" required="" data-reload-qr-code input_validate />
                    </div>
                </div>
                <div class="form-group">
                    <label for="feedback-website">Website <span class="text-danger text-bold">*</span></label>
                    <input id="feedback-website" onchange="LoadPreview()" placeholder=" https://…" name="feedback_website" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['feedback_website'] : ''; ?>" required="" data-reload-qr-code input_validate />
                </div>


            </div>
        </div>
    </div>
    <!-- Contact Information -->

    <!-- Welcome Screen -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_welcomeScreen" aria-expanded="true" aria-controls="acc_welcomeScreen">
            <span>Welcome Screen</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_welcomeScreen">
            <div class="collapseInner">
                <div class="welcome-screen">
                    <span>Image</span>
                    <!-- Before Upload Priview -->
                    <div class="screen-upload justify-content-between">
                        <div class="d-flex align-items-center mr-2">
                            <label for="screen">
                                <input type="file" id="screen" name="screen" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" data-reload-qr-code />
                                <div class="input-image" id="input-image">
                                    <svg class="MuiSvgIcon-root" id="tmp-mage" style="display:block;" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                                        <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                                        <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                                    </svg>
                                </div>
                                <div class="add-icon" id="add-icon" style="display:block;">
                                    <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                    </svg>
                                </div>
                                <div class="add-icon" id="edit-icon" style="display:none;">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                        <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                    </svg>
                                </div>
                            </label>
                            <button type="button" class="delete-btn" id="screen_delete" style="display:none;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                    <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                        <button type="button" class="upload-btn" onclick="LoadPreview(true)">Preview</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Welcome Screen -->

    <!-- Password -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_password" aria-expanded="false" aria-controls="acc_password">
            <span> Password</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse" id="acc_password">
            <div class="collapseInner">
                <div class="form-group m-0" id="passwordBlock">
                    <div class="d-flex align-items-center mb-3">
                        <div class="roundCheckbox passwordCheckbox mr-3">
                            <input type="checkbox" id="passcheckbox" />
                            <label class="m-0" for="passcheckbox"></label>
                        </div>
                        <label class="passwordlabel mb-0">Activate password to access the QR code</label>
                    </div>
                    <!-- <input id="passwordField" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code /> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Password -->

    <?php //include_once('accodian-form-group/tracking-analytics.php'); 
    ?>

</div>

<script>
    function LoadPreview(welcome_screen = false) {
        var base_url = '<?php echo SITE_URL; ?>'

        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        // let SecondaryColor = document.getElementById('SecondaryColor').value;

        var title = document.getElementById('title').value;
        var basic_info = document.getElementById('basic_info').value;


        var main_feedback_catgories = $("input[name='feedback-categories[]']").map(function(index) {
            return $(this).val();

        }).get();

        var catgories_icon = $("input[name='feedback-categories-icon[]']").map(function() {
            return $(this).val();
        }).get();


        var index = 1;

        var sub_cat = $("input[name='sub_categories_" + index + "[]']").map(function() {
            return $(this).val();
        }).get();



        var feedback_catgories = [];
        catgories_icon.forEach((icon, i) =>
            feedback_catgories = [...feedback_catgories, {
                "name": main_feedback_catgories[i],
                "icon": icon
            }]
        )

        var feedback_sub_categories = [];

        sub_cat.forEach((name) =>
            feedback_sub_categories = [...feedback_sub_categories, {
                "name": name
            }]
        )

        // var screen = filesscreen && filesscreen.length ? base_url + "uploads/screen/" + uId + "_" + filesscreen[0].name + "" : "";

        if (title == '' && basic_info == '' && feedback_catgories.length == 0 && feedback_sub_categories.length == 0) {
            title = 'Give us your feedback';
            basic_info = 'Hotel Opera';

            feedback_catgories = [{
                    'name': 'Restaurant',
                    'icon': 'Food'
                },
                {
                    'name': 'Room',
                    'icon': 'Room'
                },
                {
                    'name': 'Beverages',
                    'icon': 'Beverages'
                }
            ]

            feedback_sub_categories = [
                [{
                        'name': 'Food'
                    },
                    {
                        'name': 'Beverages'
                    },
                    {
                        'name': 'Service'
                    }
                ],
            ]

        }



        let link = `<?php echo LANDING_PAGE_URL; ?>feedback?title=${title}&basic_info=${basic_info}&feedback_categories=${JSON.stringify(feedback_catgories)}&feedback_sub_categories=${JSON.stringify(feedback_sub_categories)}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL; ?>feedback?title=${title}&basic_info=${basic_info}&feedback_categories=${JSON.stringify(feedback_catgories)}&feedback_sub_categories=${JSON.stringify(feedback_sub_categories)}`
        }

        document.getElementById('iframesrc').src = link;
        document.getElementById("preview_link").value = link;
        document.getElementById("preview_link2").value = link;
        if (document.getElementById('iframesrc2')) {
            document.getElementById('iframesrc2').src = link;
        }
        let im_url = $('#qr_code').attr('src');
        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }
    }
</script>
<!-- Category -js -->
<!-- Category -js -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        var mainCatCount = $('div.main-category').length;
        if (mainCatCount > 0) {
            $('.cat-error-message').addClass('d-none');
        }
    });


    var categoryArray = '<?php echo $categories['feedback_categories'] ?>'

    var categoryCount = '<?php echo $categoriesCount ?>'


    if (categoryArray == null || categoryArray.length == 0) {
        var MainCateIdin = 0;
    } else {

        if (categoryCount > 0) {
            var MainCateIdin = categoryCount;
        } else {
            var MainCateIdin = 0;
        }

    }

    $(document).ready(function() {
        var iconPath = '<?php echo (ASSETS_FULL_URL) ?>/images/category-icons';
        $(".add-maincategory-wrp").on("click", ".add-maincategory-btn", function() {
            LoadPreview();
            MainCateIdin++;

            var mainCategoryAdd = `
                <div class="main-category" id="mainCategory` + MainCateIdin + `" data-sub-id="` + MainCateIdin + `">
                    <div class="main-category-block">
                        <div class="title-wrp">
                                <span>Category  </span>
                                <div class="buttons-wrp  ">
                                        <button class="m-cat-btns m-cat-up" type="button"><i class="fa-solid fa-angle-up"></i></button>
                                        <button class="m-cat-btns m-cat-down" type="button"><i class="fa-solid fa-angle-down"></i></button>
                                        <button id="del-cate` + MainCateIdin + `" class="m-cat-btns m-cat-delete"  type="button"><i class="fa-solid fa-trash"></i></button>
                                </div>
                        </div>
                        <div class="field-wrp">
                            <div class="icon-list-wrp ">
                            
                                <div class="form-group">
                                        <label for="feedback-category-">Icon  <span class="text-danger text-bold"></span></label>
                                        <div class="dropdown-cat-icon">
                                            <button type="button"class="dropbtn drop-btn" ><img class="img-fluid" src="` + iconPath + `/Empty.png">
                                            </button>
                                            <div id="myDropdown" class="dropdown-content single-cat-icon">
                                                <button class="cat-icon-btn" data-icon-pick="Empty" value="Empty" type="button"><img class="img-fluid" src="` + iconPath + `/Empty.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Star" value="Star" type="button"><img class="img-fluid" src="` + iconPath + `/Star.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Availability" value="Availability" type="button"><img class="img-fluid" src="` + iconPath + `/Availability.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Ambience" value="Ambience" type="button"><img class="img-fluid" src="` + iconPath + `/Ambience.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Parking" value="Parking" type="button"><img class="img-fluid" src="` + iconPath + `/Parking.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Processing" value="Processing" type="button"><img class="img-fluid" src="` + iconPath + `/Processing.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Program" value="Program" type="button"><img class="img-fluid" src="` + iconPath + `/Program.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Error" value="Error" type="button"><img class="img-fluid" src="` + iconPath + `/Error.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Beverages" value="Beverages" type="button"><img class="img-fluid" src="` + iconPath + `/Beverages.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Food" value="Food" type="button"><img class="img-fluid" src="` + iconPath + `/Food.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Restrooms" value="Restrooms" type="button"><img class="img-fluid" src="` + iconPath + `/Restrooms.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Location" value="Location" type="button"><img class="img-fluid" src="` + iconPath + `/Location.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Seats" value="Seats" type="button"><img class="img-fluid" src="` + iconPath + `/Seats.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Room" value="Room" type="button"><img class="img-fluid" src="` + iconPath + `/Room.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Hours" value="Hours" type="button"><img class="img-fluid" src="` + iconPath + `/Hours.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Connectivity" value="Connectivity" type="button"><img class="img-fluid" src="` + iconPath + `/Connectivity.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Catering" value="Catering" type="button"><img class="img-fluid" src="` + iconPath + `/Catering.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Conference" value="Conference" type="button"><img class="img-fluid" src="` + iconPath + `/Conference.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Selection" value="Selection" type="button"><img class="img-fluid" src="` + iconPath + `/Selection.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Housekeeping" value="Housekeeping" type="button"><img class="img-fluid" src="` + iconPath + `/Housekeeping.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Staff" value="Staff" type="button"><img class="img-fluid" src="` + iconPath + `/Staff.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Person" value="Person" type="button"><img class="img-fluid" src="` + iconPath + `/Person.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Wellness" value="Wellness" type="button"><img class="img-fluid" src="` + iconPath + `/Wellness.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Services" value="Services" type="button"><img class="img-fluid" src="` + iconPath + `/Services.png"></button>
                                                <button class="cat-icon-btn" data-icon-pick="Price" value="Prices" type="button"><img class="img-fluid" src="` + iconPath + `/Prices.png"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-wrp">
                                    <div class="form-group">
                                    <input type="hidden" class="main-cat-icon-in" name="feedback-categories-icon[]" onchange="LoadPreview()" value="">
                                        <label for="feedback-category-">Name  <span class="text-danger text-bold">*</span></label>
                                        <input id="feedback-categories" onchange="LoadPreview()" placeholder=" " required name="feedback-categories[]" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['buttonUrl'] : ''; ?>" required="" data-reload-qr-code input_validate />
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="sub-category ">
                        <div class="sub-category-block">
                        </div>
                        <div class="add-subcategory">
                        <button type="button" class="btn add-subcategory-btn rounded-btn w-100">
                        <i class="fa-solid fa-plus"></i> Add Sub Category
                        </button>
                        </div>
                    </div>
                </div>
            `;

            $('.category-fields-wrp').append(mainCategoryAdd);
            var mainCatCount = $('div.main-category').length;
            if (mainCatCount > 0) {
                $('.cat-error-message').addClass('d-none');
            }

        });

        $(".category-fields-wrp").on("click", ".cat-icon-btn", function() {
            var pickedIcon = $(this).data("icon-pick");
            var pickIcon = $(this).val();
            var setIconTo = $(this).parents('.field-wrp').find('.input-wrp > .form-group > .main-cat-icon-in');
            setIconTo.val(pickIcon);
            // $(this).parents('.field-wrp').find('.input-wrp > .form-group > .main-cat-icon-in').val() = $(this).val();
            // mainCatIconIn = $(this).val();
            // console.log($(this).parents('.field-wrp').find('.input-wrp > .form-group .main-cat-icon-in'));
            var iconPicker = $(this).parents('.single-cat-icon').prev().children().attr("src", iconPath + '/' + pickedIcon + ".png");
            // console.log(iconPath);
            LoadPreview();
        });

        $('.def-category').click(function() {
            LoadPreview();
            var defCategory = $(this).val();
            var defCategoryIcon = $(this).data('icon');
            MainCateIdin++;
            // var MainCateIdin = 0;

            // fetch(iconPath + `/` + defCategoryIcon + `.png`, { method: 'HEAD' })
            //     .then(res => {
            //         if (res.ok) {
            //         console.log('Image exists.')
            //         } else {
            //         console.log('Image does not exist.')
            //         }
            //     })
            // .catch(err => console.log('Error:', err))
            var defMainCategoryAdd = `
                <div class="main-category" id="mainCategory` + MainCateIdin + `" data-sub-id="` + MainCateIdin + `">
                    <div class="main-category-block">
                        <div class="title-wrp">
                                <span>Category  </span>
                                <div class="buttons-wrp  ">
                                        <button class="m-cat-btns m-cat-up" type="button"><i class="fa-solid fa-angle-up"></i></button>
                                        <button class="m-cat-btns m-cat-down" type="button"><i class="fa-solid fa-angle-down"></i></button>
                                        <button id="del-cate` + MainCateIdin + `" class="m-cat-btns m-cat-delete"  type="button"><i class="fa-solid fa-trash"></i></button>
                                </div>
                        </div>
                        <div class="field-wrp">
                            <div class="icon-list-wrp">
                                <div class="form-group">
                                    <label for="feedback-category-">Icon  <span class="text-danger text-bold"></span></label>
                                    <div class="dropdown-cat-icon">
                                        <button type="button"class="dropbtn drop-btn" ><img class="img-fluid" src="` + iconPath + `/` + defCategoryIcon + `.png">
                                        </button>
                                        <div id="myDropdown" class="dropdown-content single-cat-icon">
                                            <button class="cat-icon-btn"data-icon-pick="Empty"  value="Empty" type="button"><img class="img-fluid" src="` + iconPath + `/Empty.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Star"  value="Star" type="button"><img class="img-fluid" src="` + iconPath + `/Star.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Availability"  value="Availability" type="button"><img class="img-fluid" src="` + iconPath + `/Availability.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Ambience"  value="Ambience" type="button"><img class="img-fluid" src="` + iconPath + `/Ambience.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Parking"  value="Parking" type="button"><img class="img-fluid" src="` + iconPath + `/Parking.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Processing"  value="Processing" type="button"><img class="img-fluid" src="` + iconPath + `/Processing.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Program"  value="Program" type="button"><img class="img-fluid" src="` + iconPath + `/Program.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Error"  value="Error" type="button"><img class="img-fluid" src="` + iconPath + `/Error.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Beverages"  value="Beverages" type="button"><img class="img-fluid" src="` + iconPath + `/Beverages.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Food"  value="Food" type="button"><img class="img-fluid" src="` + iconPath + `/Food.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Restrooms"  value="Restrooms" type="button"><img class="img-fluid" src="` + iconPath + `/Restrooms.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Location"  value="Location" type="button"><img class="img-fluid" src="` + iconPath + `/Location.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Seats"  value="Seats" type="button"><img class="img-fluid" src="` + iconPath + `/Seats.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Room"  value="Room" type="button"><img class="img-fluid" src="` + iconPath + `/Room.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Hours"  value="Hours" type="button"><img class="img-fluid" src="` + iconPath + `/Hours.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Connectivity"  value="Connectivity" type="button"><img class="img-fluid" src="` + iconPath + `/Connectivity.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Catering"  value="Catering" type="button"><img class="img-fluid" src="` + iconPath + `/Catering.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Conference"  value="Conference" type="button"><img class="img-fluid" src="` + iconPath + `/Conference.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Selection"  value="Selection" type="button"><img class="img-fluid" src="` + iconPath + `/Selection.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Housekeeping"  value="Housekeeping" type="button"><img class="img-fluid" src="` + iconPath + `/Housekeeping.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Staff"  value="Staff" type="button"><img class="img-fluid" src="` + iconPath + `/Staff.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Person"  value="Person" type="button"><img class="img-fluid" src="` + iconPath + `/Person.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Wellness"  value="Wellness" type="button"><img class="img-fluid" src="` + iconPath + `/Wellness.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Services"  value="Services" type="button"><img class="img-fluid" src="` + iconPath + `/Services.png"></button>
                                            <button class="cat-icon-btn"data-icon-pick="Price"  value="Prices" type="button"><img class="img-fluid" src="` + iconPath + `/Prices.png"></button>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>

                            <div class="input-wrp">
                                <div class="form-group">
                                <input type="hidden" class="main-cat-icon-in" name="feedback-categories-icon[]" onchange="LoadPreview()" value="` + defCategory + `">
                                    <label for="feedback-category-">Name  <span class="text-danger text-bold">*</span></label>
                                    <input id="feedback-categories" onchange="LoadPreview()" placeholder=" " required name="feedback-categories[]" class="form-control" value="` + defCategory + `" required="" data-reload-qr-code input_validate />
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="sub-category ">

                        <div class="sub-category-block">

                        
                        </div>

                        <div class="add-subcategory">
                        <button type="button" class="btn add-subcategory-btn rounded-btn w-100">
                        <i class="fa-solid fa-plus"></i> Add Sub Category
                        </button>
                        </div>
                    </div>
                </div>
            `;
            var mainCatCount = $('div.main-category').length;
            if (mainCatCount >= 0) {
                $('.cat-error-message').addClass('d-none');
            }

            $('.category-fields-wrp').append(defMainCategoryAdd);
            $('.overlay').removeClass('active');
            $('.select-category .dropdown').removeClass('active');

        });
        $('.category-fields-wrp').on('click', '.m-cat-delete', function() {
            MainCateIdin--;
            $(this).parents('.main-category').remove();
            var mainCatCount = $('div.main-category').length;
            if (mainCatCount == 0) {
                $('.cat-error-message').removeClass('d-none');
            }

            LoadPreview();
        });
        $('.category-fields-wrp').on('click', '.m-cat-up', function() {
            var mainNodes = $(this).parents('.category-fields-wrp').children('.main-category');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if (mainNodeslength > 1) {
                $(this).parents('.main-category').insertBefore($(this).parents('.main-category').prev());
            }


            LoadPreview();
        });
        $('.category-fields-wrp').on('click', '.m-cat-down', function() {
            var mainNodes = $(this).parents('.category-fields-wrp').children('.main-category');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if ((mainNodeslength > 1) && (mainNodes.is(':not(:first-child)'))) {
                $(this).parents('.main-category').insertAfter($(this).parents('.main-category').next());
            }

            LoadPreview();
        });
        $('.category-fields-wrp').on('click', '.add-subcategory-btn', function() {

            LoadPreview();

            var subCateId = $(this).parents('.main-category').data('sub-id');
            console.log(subCateId);

            var subCategoryAdd = `
                <div class="field-wrp sub-category-field">
                    <div class="input-wrp">
                        <div class="form-group ">
                            <label for="feedback-category-">Name  <span class="text-danger text-bold">*</span></label>
                            <input id="sub_categories" onchange="LoadPreview()" placeholder=" " required name="sub_categories_` + subCateId + `[]" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['buttonUrl'] : ''; ?>" required="" data-reload-qr-code input_validate />
                            <div class="buttons-wrp  ">
                                        <button class="m-cat-btns m-subcat-up" type="button"><i class="fa-solid fa-angle-up"></i></button>
                                        <button class="m-cat-btns m-subcat-down" type="button"><i class="fa-solid fa-angle-down"></i></button>
                                        <button id="del-subcate` + subCateId + `" class="m-cat-btns m-subcat-delete"  type="button"><i class="fa-solid fa-trash"></i></button>
                                </div>
                        </div>
                    </div>
                </div>`;

            $(this).parent().prev().append(subCategoryAdd);

        });
        $('.category-fields-wrp').on('click', '.m-subcat-delete', function() {
            LoadPreview();
            var subCateId = 0;
            subCateId = subCateId - 1;
            $(this).parent().parent().parent().parent().remove();
        });
        $('.category-fields-wrp').on('click', '.m-subcat-up', function() {
            LoadPreview();
            var mainNodes = $(this).parents('.sub-category-block').children('.sub-category-field');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if (mainNodeslength > 1) {
                $(this).parents('.sub-category-field').insertBefore($(this).parents('.sub-category-field').prev());
            }

        });
        $('.category-fields-wrp').on('click', '.m-subcat-down', function() {
            LoadPreview();
            var mainNodes = $(this).parents('.sub-category-block').children('.sub-category-field');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if ((mainNodeslength > 1) && (mainNodes.is(':not(:first-child)'))) {
                $(this).parents('.sub-category-field').insertAfter($(this).parents('.sub-category-field').next());
            }

        });
        $('.category-fields-wrp').on('click', '.cat-icon-btn', function() {
            LoadPreview();
            $('.overlay').removeClass('active');
            $(this).parents('.dropdown-content').removeClass('active');
        });
        $(".def-cat-btn").click(function() {
            LoadPreview();
            $(this).next('.dropdown').toggleClass('active');
            $('.overlay').addClass('active');
        });
        $('.category-fields-wrp').on('click', '.drop-btn', function() {
            LoadPreview();
            $(this).next('.dropdown-content').addClass('active');
            $('.overlay').addClass('active');
        });
        $(".overlay").click(function() {
            LoadPreview();
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('.select-category .dropdown').removeClass('active');
                $('.dropdown-cat-icon .dropdown-content').removeClass('active');
            }
        });



    });
</script>