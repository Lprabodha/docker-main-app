<div class="couponLocation">
    <div class="couponButtonGroup d-none">

        <button type="button" class="outlineBtn squreBtn <?php echo isset($filledInput['offer_street']) || isset($filledInput['offer_number']) || isset($filledInput['offer_postalcode']) || isset($filledInput['offer_city']) || !isset($filledInput['latitude']) && !isset($filledInput['longitude']) && !isset($filledInput['offer_url1']) ? 'active' : '' ?>" id="Complete"><?= l('qr_step_2_com_location.complete') ?></button>

        <button type="button" class="outlineBtn squreBtn <?php echo isset($filledInput['offer_url1']) ? 'active' : '' ?>" id="Url"><?= l('qr_step_2_com_location.url') ?></button>
        <button type="button" class="outlineBtn squreBtn <?php echo isset($filledInput['latitude']) || isset($filledInput['longitude']) ? 'active' : '' ?>" id="Coordinates"><?= l('qr_step_2_com_location.complete') ?></button>
    </div>
</div>



<!-- Complete Div -->
<div id="LocationInputs" class="location-area">
    <div class="d-flex align-items-end mb-4 w-100 address-full-wrap" style="display: <?php echo isset($filledInput['offer_street']) || isset($filledInput['offer_number']) || isset($filledInput['offer_postalcode']) || isset($filledInput['offer_city']) ||  !isset($filledInput['latitude']) && !isset($filledInput['longitude']) && !isset($filledInput['offer_url1'])  ? 'flex !important' : 'none !important' ?>  ;" id="mapInput">

        <div class="form-group m-0 w-100 ship-address-wrap address-fill">
            <label for="ship_address" class="filed-label"><?= l('qr_step_2_com_location.serach_address') ?></label>
            <input id="ship-address1" name="ship_address" autocomplete="off"  onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.serach_address.placeholder') ?>" data-anchor="locationBlock" class="anchorLoc step-form-control location-field" value="<?php echo (!empty($filledInput)) ? $filledInput['ship_address'] : ''; ?>"  onfocus="this.setAttribute('autocomplete', 'new-password');"  data-reload-qr-code <?php echo isset($filledInput['offer_street']) || isset($filledInput['offer_number']) || isset($filledInput['offer_postalcode']) || isset($filledInput['offer_city']) ? 'disabled' : '' ?> />
            <div class="step-icon-wrap">
                <span class="icon-search step-search grey"></span>
            </div>
        </div>
        <div class="address-fill form-group address-btn-area-wrap">
            <button type="button" class="address-btn outlineBtn manualyBtn" id="manualyBtn"><?php echo isset($filledInput['offer_street']) || isset($filledInput['offer_number']) || isset($filledInput['offer_postalcode']) || isset($filledInput['offer_city']) && !isset($filledInput['latitude']) && !isset($filledInput['longitude']) && !isset($filledInput['offer_url1']) ?  l('qr_step_2_com_location.delete_btn') :  l('qr_step_2_com_location.manual_entry')  ?></button>
        </div>
    </div>

    <div>
        <div id="manualEntry">
            <?php if (isset($filledInput['offer_street']) || isset($filledInput['offer_number']) || isset($filledInput['offer_postalcode']) || isset($filledInput['offer_city'])) { ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="custom-control custom-switch customSwitchToggle">
                        <input 
                            <?= isset($filledInput['street_number']) ? 'checked' : '' ?> 
                            onchange="LoadPreview()" 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="customSwitchToggle" 
                            name="street_number" 
                        >
                        <label onchange="LoadPreview()" class="custom-control-label" id="custom_checkbox" for="customSwitchToggle"><?= l('qr_step_2_com_location.street_number_first') ?></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 pr-2 street-field-wrap">
                        <div class="form-group">
                            <label for="offer_street"><?= l('qr_step_2_com_location.street') ?></label>
                            <input id="route" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.street.placeholder') ?>" name="offer_street" data-anchor="locationBlock" class="anchorLoc step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_street'] : ''; ?>" data-reload-qr-code="">
                        </div>
                    </div>
                    <div class="col-6 pl-2 number-postal-wrap">
                        <div class="row number-full-wrap">
                            <div class="col-6 pr-2">
                                <div class="form-group">
                                    <label for="street_number"><?= l('qr_step_2_com_location.number') ?></label>
                                    <input id="street_number" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.number.placeholder') ?>" name="offer_number" data-anchor="locationBlock" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_number'] : ''; ?>" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-6 pl-2">
                                <div class="form-group">
                                    <label for="offer_postalcode"><?= l('qr_step_2_com_location.postal_code') ?></label>
                                    <input id="postal_code" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.postal_code.placeholder') ?>" name="offer_postalcode" data-anchor="locationBlock" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_postalcode'] : ''; ?>" data-reload-qr-code="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pr-2">
                        <div class="form-group">
                            <label for="offer_city"><?= l('qr_step_2_com_location.city') ?></label>
                            <input id="locality" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.city.placeholder') ?>" name="offer_city" data-anchor="locationBlock" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_city'] : ''; ?>" data-reload-qr-code="">
                        </div>
                    </div>
                    <div class="col-6 pl-2">
                        <div class="form-group">
                            <label for="offer_state"><?= l('qr_step_2_com_location.state') ?></label>
                            <input id="administrative_area_level_1" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.state.placeholder') ?>" name="offer_state" data-anchor="locationBlock" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_state'] : ''; ?>" data-reload-qr-code="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group m-0">
                            <label for="offer_country"><?= l('qr_step_2_com_location.country') ?></label>
                            <input id="country" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.country.placeholder') ?>" name="offer_country" data-anchor="locationBlock" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_country'] : ''; ?>" data-reload-qr-code="">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Url Div -->
<div id="UrlEntry" class="location-area" style="display: <?php echo  isset($filledInput['offer_url1']) && !isset($filledInput['offer_street']) && !isset($filledInput['offer_number']) && !isset($filledInput['offer_postalcode']) && !isset($filledInput['offer_city'])  && !isset($filledInput['latitude']) && !isset($filledInput['longitude']) ? 'block' : 'none' ?>;">
    <?php if (isset($filledInput['offer_url1'])) { ?>
        <div class="form-group">
            <label for="offer_url1" class="filed-label"><?= l('qr_step_2_com_location.url') ?></label>
            <input id="offer_url1" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.url') ?>" name="offer_url1" class="step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['offer_url1'] : ''; ?>" data-reload-qr-code />
        </div>
    <?php } ?>
</div>


<!-- Coordinates Div -->
<div id="CoEntry" class="location-area" style="display: <?php echo  isset($filledInput['latitude']) && isset($filledInput['longitude']) && !isset($filledInput['offer_street']) && !isset($filledInput['offer_number']) && !isset($filledInput['offer_postalcode']) && !isset($filledInput['offer_city']) && !isset($filledInput['offer_url1']) ? 'block' : 'none' ?>;">
    <?php if (isset($filledInput['latitude']) && isset($filledInput['longitude'])) { ?>
        <div class="row align-items-end">
            <div class="form-group pr-2 col-6">
                <label for="latitude" class="filed-label"><?= l('qr_step_2_com_location.latitude') ?></label>
                <input id="latitude" onchange="LoadPreview()" type="number" placeholder="38.8951" name="latitude" class="step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['latitude'] : ''; ?>" data-reload-qr-code />
            </div>
            <div class="form-group pl-2 col-6">
                <label for="longitude" class="filed-label"><?= l('qr_step_2_com_location.longitude') ?></label>
                <input id="longitude" onchange="LoadPreview()" type="number" placeholder="-77.0364" name="longitude" class="step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['longitude'] : ''; ?>" data-reload-qr-code />
            </div>
        </div>
    <?php } ?>
</div>



<script>
    // Disable Chrome autofill suggestion for the input field
    var inputField = document.getElementById('ship-address1');
    inputField.setAttribute('readonly', '');   
    inputField.addEventListener('touchstart', function() {
        this.removeAttribute('readonly');
    });
    inputField.addEventListener('focus', function() {
        this.removeAttribute('readonly');
    });

    $(document).ready(function() {
        initAutocomplete();
    });

    <?php if (isset($filledInput['offer_street']) || isset($filledInput['offer_number']) || isset($filledInput['offer_postalcode']) || isset($filledInput['offer_city'])) { ?>
        var manualClicked = true;
    <?php } else { ?>;
        var manualClicked = false;
    <?php  } ?>

    <?php if (isset($filledInput['latitude']) || isset($filledInput['longitude']) && !isset($filledInput['offer_street']) && !isset($filledInput['offer_number']) && !isset($filledInput['offer_postalcode']) && !isset($filledInput['offer_city']) && !isset($filledInput['offer_url1'])) { ?>
        var coClicked = true;
    <?php } else { ?>;
        var coClicked = false;
    <?php  } ?>

    <?php if (isset($filledInput['offer_url1']) && !isset($filledInput['offer_street']) && !isset($filledInput['offer_number']) && !isset($filledInput['offer_postalcode']) && !isset($filledInput['offer_city']) && !isset($filledInput['latitude'])  && !isset($filledInput['longitude'])) { ?>
        var urlClicked = true;
    <?php } else { ?>;
        var urlClicked = false;
    <?php  } ?>


    var phoneNumber = 0;
    var emailNumber = 0;

    $(document).on('click', '#Complete', function() {

        $('#Complete').addClass('active');
        $('#Url').removeClass('active');
        $('#Coordinates').removeClass('active');
        $('#LocationInputs').show();
        $("#mapInput").css("display", "block");
        $('#UrlEntry').hide();
        $('#CoEntry').hide();
        // urlClicked = false;

        if (urlClicked || coClicked) {
            document.getElementById('ship-address1').disabled = false;
            urlClicked = false;
            coClicked = false;
            $(document).find('#UrlEntry').empty();
            $(document).find('#CoEntry').empty();
        }

        LoadPreview();
    });


    $(document).on('click', '#Url', function() {


        $('#Url').addClass('active');
        $('#Complete').removeClass('active');
        $('#Coordinates').removeClass('active');
        $('#LocationInputs').hide();
        $('#CoEntry').hide();
        $('#UrlEntry').show();
        $('#ship-address1').val('');
        $(document).find('#manualyBtn').html("<?= l('qr_step_2_com_location.manual_entry') ?>");

        if (!urlClicked) {

            var contentHtml = `
                        <div class="form-group">
                            <label for="offer_url1" class="filed-label"><?= l('qr_step_2_com_location.url') ?></label>
                            <input id="offer_url1" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.url.placeholder') ?>" name="offer_url1" class="step-form-control" value=""  data-reload-qr-code />
                        </div>
                                `;
            $('#UrlEntry').append(contentHtml);
            urlClicked = true;
            //prevent page redirect on keypress
            $('input').keypress(function(e) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            })
        } else {
            $('#UrlEntry').show();

        }

        if (coClicked || manualClicked) {
            manualClicked = false;
            coClicked = false;
            $(document).find('#manualEntry').empty();
            $(document).find('#CoEntry').empty();
        }

        LoadPreview();
    });

    $(document).on('click', '#Coordinates', function() {

        $('#Coordinates').addClass('active');
        $('#Complete').removeClass('active');
        $('#Url').removeClass('active');
        $('#LocationInputs').hide();
        $('#UrlEntry').hide();
        $('#CoEntry').show();
        $('#ship-address1').val('');
        $(document).find('#manualyBtn').html("<?= l('qr_step_2_com_location.manual_entry') ?>");
        // CoEntry
        if (!coClicked) {

            var contentHtml = `
            <div class="row align-items-end">
                        <div class="form-group pr-2 col-6">
                            <label for="latitude" class="filed-label"><?= l('qr_step_2_com_location.latitude') ?></label>
                            <input id="latitude" onchange="LoadPreview()" type="number" placeholder="38.8951" name="latitude" class="step-form-control" value=""  data-reload-qr-code />
                        </div>
                        <div class="form-group pl-2 col-6">
                            <label for="longitude" class="filed-label"><?= l('qr_step_2_com_location.longitude') ?></label>
                            <input id="longitude" onchange="LoadPreview()" type="number" placeholder="-77.0364" name="longitude" class="step-form-control" value="" data-reload-qr-code />
                        </div>
                    </div>
                                `;
            $('#CoEntry').append(contentHtml);
            coClicked = true;
            //prevent page redirect on keypress
            $('input').keypress(function(e) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            })
        } else {
            $('#CoEntry').show();
        }

        if (urlClicked || manualClicked) {
            urlClicked = false;
            manualClicked = false;
            $(document).find('#UrlEntry').empty();
            $(document).find('#manualEntry').empty();
        }

        LoadPreview();
    });
</script>