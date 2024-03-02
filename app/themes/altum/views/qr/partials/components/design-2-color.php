<div class="custom-accodian consider">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_Design" aria-expanded="true" aria-controls="acc_Design">
        <div class="qr-step-icon">
            <span class="icon-design grey steps-icon"></span>
        </div>
        
        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_colorPalette.design') ?></span>
            <span class="fields-helper-heading"><?= l('qr_step_2_com_colorPalette.help_txt.design') ?></span>
        </span>

        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse color-comp-2 show" id="acc_Design">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="form-group m-0">
                <label for="colorPalette" class="color-palette-text"><?= l('qr_step_2_com_colorPalette.color_palette') ?></label>
                <div class="colorPaletteForm row m-0">
                    <div class="formcolorPalette active col-md-2" id="formcolorPalette1">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" readonly />
                            <input type="color" name="" class="colorPalette" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" readonly />
                        </div>
                    </div>
                    <div class="formcolorPalette col-md-2" id="formcolorPalette2">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="#ecedf1" />
                            <input type="color" name="" class="colorPalette" value="#232321" />
                        </div>
                    </div>
                    <!-- <div class="formcolorPalette col" id="formcolorPalette3">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="#ececf0" />
                            <input type="color" name="" class="colorPalette" value="#5279c9" />
                        </div>
                    </div> -->
                    <div class="formcolorPalette col-md-2" id="formcolorPalette4">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="#daebf6" />
                            <input type="color" name="" class="colorPalette" value="#537ac9" />
                        </div>
                    </div>
                    <div class="formcolorPalette col-md-2" id="formcolorPalette5">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="#b69edf" />
                            <input type="color" name="" class="colorPalette" value="#242420" />
                        </div>
                    </div>
                    <div class="formcolorPalette col-md-2" id="formcolorPalette6">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="#7ec09f" />
                            <input type="color" name="" class="colorPalette" value="#242420" />
                        </div>
                    </div>
                    <div class="formcolorPalette col-md-2" id="formcolorPalette7">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette" value="#edc472" />
                            <input type="color" name="" class="colorPalette" value="#232421" />
                        </div>
                    </div>
                </div>

                <div class="select-color-code-wrap d-none">
                    <div class="color-text col-8">
                        <label for="colorPalette"><?= l('qr_step_2_com_colorPalette.primary_color') ?></label>
                    </div>
                    <div class="color-palette col-4 row">
                        <input type="color" id="selectPrimary" name="primaryColor" class="col-6 primaryColor current-color pickerFieldes" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" data-reload-qr-code />
                        <input type="color" id="selectSecondary" name="SecondaryColor" class="col-6 current-color SecondaryColor pickerFields" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>"  data-reload-qr-code />
                    </div>
                </div>

                <div class="colorPaletteInner">
                    <div class="form-group m-0">
                        <label for=""><?= l('qr_step_2_com_colorPalette.primary_color') ?></label>
                        <div class="customColorPicker primary-color-picker">
                            <label for="primaryColor">
                                <input type="text" name="primaryColorValue" class="primaryColorValue iconColorPiker color-code" id="primaryColorValue" maxlength="7" placeholder="#000000" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" color_validate />

                                <input id="primaryColor" name="primaryColor" onchange="LoadPreview(false,false,'color_palette')" class="primaryColor custompicker-coloris pickerField pickerFieldes" type="text" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" style="" data-reload-qr-code />

                                <span class="icon-edit grey step-edit-icon"></span>
                            </label>
                        </div>

                    </div>
                    <div class="swap-btn-full-wrap">
                        <hr class="swap-hr">
                        <div class="swap-btn-wrap">
                            <button type="button" class="swap-btn m-auto d-block" id="swapBtn" onclick="swapValues()">
                                <span class="icon-swap grey swap-icon"></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label for=""><?= l('qr_step_2_com_colorPalette.secondary_color') ?></label>
                        <div class="customColorPicker secondary-color-picker">
                            <label for="SecondaryColor">
                                <input type="text" name="secondaryColorValue" id="secondaryColorValue" class="secondaryColorValue iconColorPiker color-code" maxlength="7" placeholder="#000000" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>"  color_validate />

                                <input id="SecondaryColor" name="SecondaryColor" onchange="LoadPreview(false,false,'color_palette')" class="SecondaryColor custompicker-coloris pickerField pickerFields" type="text" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" style="" data-reload-qr-code />

                                <span class="icon-edit grey step-edit-icon"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // $("#swapBtn").on("change keyup",
    //     function() {
    //         // var primaryC = document.getElementById("primaryColor").value;;
    //         // var secondaryC = document.getElementById("secondaryColor").value;;

    //         // console.log("primaryC : "+ primaryC);
    //         // console.log("secondaryC : "+ secondaryC);

    //         var activeIndexPrimary = $('.formcolorPalette.active').index();
    //         $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:first').val($('#SecondaryColor').val());
    //         $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:last').val($('#primaryColor').val());
    //     }
    // );
</script>
