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
    <div class="collapse color-comp-1 show" id="acc_Design">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="form-group m-0">
                <label for="colorPalette" class="color-palette-text"><?= l('qr_step_2_com_colorPalette.color_palette') ?></label>
                <div class="colorPaletteForm row m-0">
                    <div class="formcolorPalette formcolorPalette-2 active col-md-2" id="formcolorPalette1">
                        <input type="color" name="" class="colorPalette color-palette-1 w-100" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" readonly />
                    </div>
                    <div class="formcolorPalette formcolorPalette-2 col-md-2" id="formcolorPalette2">
                        <input type="color" name="" class="colorPalette color-palette-1 w-100" value="#ecedf1" />
                    </div>
                    <!-- <div class="formcolorPalette" id="formcolorPalette3">
                        <input type="color" name="" class="colorPalette w-100" value="#ececf0" />
                    </div> -->
                    <div class="formcolorPalette formcolorPalette-2 col-md-2" id="formcolorPalette4">
                        <input type="color" name="" class="colorPalette w-100" value="#daebf6" />
                    </div>
                    <div class="formcolorPalette formcolorPalette-2 col-md-2" id="formcolorPalette5">
                        <input type="color" name="" class="colorPalette w-100" value="#b69edf" />
                    </div>
                    <div class="formcolorPalette formcolorPalette-2 col-md-2" id="formcolorPalette6">
                        <input type="color" name="" class="colorPalette w-100" value="#7ec09f" />
                    </div>
                    <div class="formcolorPalette formcolorPalette-2 col-md-2" id="formcolorPalette7">
                        <input type="color" name="" class="colorPalette w-100" value="#edc472" />
                    </div>
                </div>

                <div class="colorPaletteInner">
                    <div class="form-group m-0">
                        <label for=""><?= l('qr_step_2_com_colorPalette.primary_color') ?></label>
                        <div class="customColorPicker primary-color-picker">
                            <label for="primaryColor">

                                <input type="text" name="primaryColorValue" class="primaryColorValue color-code" id="primaryColorValue" maxlength="7" placeholder="#000000" onchange="LoadPreview(false,false,'color_palette')" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" style="text-transform:uppercase; border: hidden; font-size:15px;" color_validate />

                                <input id="primaryColor" name="primaryColor" onchange="LoadPreview(false,false,'color_palette')" class="primaryColor custompicker-coloris pickerField pickerFieldes" type="text" value="<?php echo (!empty($filledInput)) ? $filledInput['primaryColor'] : '#527ac9'; ?>" data-reload-qr-code />

                                <span class="icon-edit grey step-edit-icon"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>