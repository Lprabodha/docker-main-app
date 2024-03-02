<div class="custom-accodian">
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
    <div class="collapse color-comp-3 show" id="acc_Design">
        <div class="collapseInner">
            <div class="form-group m-0">
                <label for="colorPalette" class="color-palette-text"><?= l('qr_step_2_com_colorPalette.color_palette') ?></label>
                <div class="colorPaletteForm row m-0">
                    <div class="formcolorPalette form-color-3 active col-md-2" id="formcolorPalette1">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette color-palatte-3" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" readonly />
                            <input type="color" name="" class="colorPalette middlePalette color-palatte-3" value="<?php echo (!empty($filledInput)) ? $filledInput['linkColor'] : '#F7F7F7'; ?>" />
                            <input type="color" name="" class="colorPalette color-palatte-3" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" readonly />
                        </div>
                    </div>
                    <div class="formcolorPalette form-color-3 col-md-2" id="formcolorPalette2">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#ecedf1" />
                            <input type="color" name="" class="colorPalette middlePalette color-palatte-3" value="#F7F7F7" />
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#232321" />
                        </div>
                    </div>
                    <!-- <div class="formcolorPalette" id="formcolorPalette3">
                            <input type="color" name="" class="colorPalette" value="#ececf0" />
                            <input type="color" name="" class="colorPalette middlePalette" value="#FFFFFF" />
                            <input type="color" name="" class="colorPalette" value="#5279c9" />
                        </div> -->
                    <div class="formcolorPalette form-color-3 col-md-2" id="formcolorPalette4">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#daebf6" />
                            <input type="color" name="" class="colorPalette middlePalette color-palatte-3" value="#F7F7F7" />
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#537ac9" />
                        </div>
                    </div>
                    <div class="formcolorPalette form-color-3 col-md-2" id="formcolorPalette5">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#b69edf" />
                            <input type="color" name="" class="colorPalette middlePalette color-palatte-3" value="#F7F7F7" />
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#242420" />
                        </div>
                    </div>
                    <div class="formcolorPalette form-color-3 col-md-2" id="formcolorPalette6">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#7ec09f" />
                            <input type="color" name="" class="colorPalette middlePalette color-palatte-3" value="#F7F7F7" />
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#242420" />
                        </div>
                    </div>
                    <div class="formcolorPalette form-color-3 col-md-2" id="formcolorPalette7">
                        <div class="color-wrap row">
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#edc472" />
                            <input type="color" name="" class="colorPalette middlePalette color-palatte-3" value="#F7F7F7" />
                            <input type="color" name="" class="colorPalette color-palatte-3" value="#232421" />
                        </div>
                    </div>
                </div>

                <div class="select-color-code-wrap d-none">
                    <div class="color-text col-8">
                        <label for="colorPalette"><?= l('qr_codes.color_palette') ?></label>
                    </div>
                    <div class="color-palette col-4 row">
                        <input type="color" id="selectPrimary" name="primaryColor" class="col-4 primaryColor current-color pickerFieldes" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" data-reload-qr-code />
                        <input type="color" id="selectThird" name="ThirdColor" class="col-4 current-color SecondaryColor pickerFields" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" data-reload-qr-code />
                        <input type="color" id="selectSecondary" name="SecondaryColor" class="col-4 current-color SecondaryColor pickerFields" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" data-reload-qr-code />
                    </div>
                </div>

                <div class="colorPaletteInner row select-color-3 m-auto">
                    <div class="form-group p-0 col-md-4 form-color-group-3">
                        <label for=""><?= l('qr_step_2_com_colorPalette.background_color') ?></label>
                        <div class="customColorPicker coustom-color-piker-3 primary-color-picker">
                            <label for="primaryColor">

                                <input type="text" name="primaryColorValue" class="primaryColorValue iconColorPiker color-code" id="primaryColorValue" maxlength="7" placeholder="#000000" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" color_validate />

                                <input id="primaryColor" name="primaryColor" onchange="LoadPreview(false,false,'color_palette')" class="pickerField custompicker-coloris pickerFieldes" type="text" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" data-reload-qr-code />

                                <span class="icon-edit grey step-edit-icon"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group p-0 col-md-4 form-color-group-3">
                        <label for=""><?= l('qr_step_2_com_colorPalette.background_color_link') ?></label>
                        <div class="customColorPicker coustom-color-piker-3 link-color-picker">
                            <label for="linkColor">

                                <input type="text" name="linkColorValue" id="linkColorValue" class="linkColorValue iconColorPiker color-code" maxlength="7" placeholder="#000000" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['linkColor'] : '#F7F7F7'; ?>" color_validate />

                                <input id="linkColor" name="linkColor" onchange="LoadPreview(false,false,'color_palette')" class="pickerField custompicker-coloris pickerWhiteBorder bg-color-palette" type="text" value="<?php echo (!empty($filledInput)) ? $filledInput['linkColor'] : '#FFFFFF'; ?>" data-reload-qr-code />

                                <span class="icon-edit grey step-edit-icon black"></span>

                            </label>
                        </div>
                    </div>
                    <div class="form-group p-0 col-md-4 form-color-group-3">
                        <label for=""><?= l('qr_step_2_com_colorPalette.link_text') ?></label>
                        <div class="customColorPicker coustom-color-piker-3 secondary-color-picker">
                            <label for="SecondaryColor">

                                <input type="text" name="secondaryColorValue" id="secondaryColorValue" class="secondaryColorValue iconColorPiker color-code" maxlength="7" placeholder="#000000" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" color_validate />

                                <input id="SecondaryColor" name="SecondaryColor" onchange="LoadPreview(false,false,'color_palette')" class="pickerField custompicker-coloris pickerFields" type="text" value="<?php echo (!empty($filledInput)) ? $filledInput['SecondaryColor'] : '#7ec09f'; ?>" data-reload-qr-code />

                                <span class="icon-edit grey step-edit-icon"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>