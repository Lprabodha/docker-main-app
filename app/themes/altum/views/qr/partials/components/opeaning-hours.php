<div class="custom-accodian">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_openingHours" aria-expanded="true" aria-controls="acc_openingHours">
        <div class="qr-step-icon">
            <span class="icon-time-circle grey steps-icon"></span>
        </div>

        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_opening_hours.opening_hours') ?></span>
            <span class="fields-helper-heading"><?= l('qr_step_2_com_opening_hours.help_txt.opening_hours') ?></span>
        </span>

        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse show" id="acc_openingHours">
        <hr class="accordian-hr">
        <div class="collapseInner p-0">
            <div class="form-group m-0">
                <style>
                    @media (min-width: 481px) and (max-width: 767px) {
                        .d-sm-block1 {
                            display: block !important;
                        }
                    }

                    @media (max-width: 480px) {
                        .d-sm-block1 {
                            display: block !important;
                        }
                    }
                </style>
                <!-- button -->
                <style>
                    .btn-outline-primary {
                        width: 50px;
                        height: 50px;
                        border-width: 3px !important;
                        border-radius: 4px !important;
                        color: #220E27;
                        border-color: #EAEAEC;
                    }
                </style>
                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="day-full-wrap">
                                <div class="roundCheckbox">
                                    <input type="checkbox" data-anchor="openingBlock" class="anchorLoc opening-hours-checkbox" id="checkboxMon" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Monday_From'])) ? 'checked' : '') : ''; ?> />
                                    <label class="m-0" for="checkboxMon"></label>
                                </div>
                                <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.monday') ?></label>
                            </div>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="MondayData">

                            <?php if (isset($filledInput['Monday_From']) && isset($filledInput['Monday_To'])) { ?>
                                <?php foreach ($filledInput['Monday_From'] as $key => $mondayFrom) { ?>
                                    <div class="row d-flex align-items-center w-100 mt-1 removea hour-fields">
                                        <hr>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Monday_From" onchange="LoadPreview()" name="Monday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $mondayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control opening-hours-input Monday_From open-field" <?php echo (!empty($filledInput)) ? ($mondayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Monday_To" name="Monday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Monday_To'][$key] : ''; ?>" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control opening-hours-input Monday_To open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Monday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Monday')" class="add-btn-outline Monday_To m-auto opening-hours-input d-flex append-hour-btn" <?php echo (!empty($filledInput)) ? ($mondayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 add-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline Monday_To m-auto d-flex ">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row d-flex align-items-center w-100 hour-fields">
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Monday_From" onchange="LoadPreview()" name="Monday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc step-form-control opening-hours-input Monday_From open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Monday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Monday_To" name="Monday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control opening-hours-input Monday_To open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Monday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Monday')" class="add-btn-outline Monday_To m-auto d-flex opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Monday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" data-anchor="openingBlock" class="anchorLoc opening-hours-checkbox" id="checkboxTue" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Tuesday_From'])) ? 'checked' : '') : ''; ?> />
                                <label class="m-0" for="checkboxTue"></label>
                            </div>
                            <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.tuesday') ?></label>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="TuesdayData">

                            <?php if (isset($filledInput['Tuesday_From']) && isset($filledInput['Tuesday_To'])) { ?>
                                <?php foreach ($filledInput['Tuesday_From'] as $key => $tuesdayFrom) { ?>
                                    <div class="row align-items-center w-100 hour-fields d-flex mt-1 removea">
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Tuesday_From" onchange="LoadPreview()" name="Tuesday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $tuesdayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control opening-hours-input Tuesday_From open-field" <?php echo (!empty($filledInput)) ? ($tuesdayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Tuesday_To" name="Tuesday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Tuesday_To'][$key] : ''; ?>" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control opening-hours-input Tuesday_To open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Tuesday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Tuesday')" class="add-btn-outline m-auto d-flex Tuesday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ($tuesdayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline m-auto d-flex Tuesday_To ">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row align-items-center w-100 hour-fields d-flex">
                                    <div class="name col-5  hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Tuesday_From" onchange="LoadPreview()" name="Tuesday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc  step-form-control Tuesday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Tuesday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Tuesday_To" name="Tuesday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc  step-form-control Tuesday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Tuesday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Tuesday')" class="add-btn-outline m-auto d-flex Tuesday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Tuesday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" data-anchor="openingBlock" class="anchorLoc opening-hours-checkbox" id="checkboxWed" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Wednesday_From'])) ? 'checked' : '') : ''; ?> />
                                <label class="m-0" for="checkboxWed"></label>
                            </div>
                            <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.wedesday') ?></label>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="WednesdayData">

                            <?php if (isset($filledInput['Wednesday_From']) && isset($filledInput['Wednesday_To'])) { ?>
                                <?php foreach ($filledInput['Wednesday_From'] as $key => $wednesdayFrom) { ?>
                                    <div class="row d-flex align-items-center w-100 hour-fields mt-1 removea">
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Wednesday_From" onchange="LoadPreview()" name="Wednesday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $wednesdayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control Wednesday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ($wednesdayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Wednesday_To" name="Wednesday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Wednesday_To'][$key] : ''; ?>" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control Wednesday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Wednesday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Wednesday')" class="add-btn-outline m-auto d-flex Wednesday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ($wednesdayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline m-auto d-flex Wednesday_To ">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row d-flex align-items-center w-100 hour-fields">
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Wednesday_From" onchange="LoadPreview()" name="Wednesday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc step-form-control Wednesday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Wednesday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Wednesday_To" name="Wednesday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc  step-form-control Wednesday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Wednesday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Wednesday')" class="add-btn-outline m-auto d-flex Wednesday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Wednesday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" data-anchor="openingBlock" class="anchorLoc opening-hours-checkbox" id="checkboxThu" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Thursday_From'])) ? 'checked' : '') : ''; ?> />
                                <label class="m-0" for="checkboxThu"></label>
                            </div>
                            <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.thursday') ?></label>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="ThursdayData">

                            <?php if (isset($filledInput['Thursday_From']) && isset($filledInput['Thursday_To'])) { ?>
                                <?php foreach ($filledInput['Thursday_From'] as $key => $thursdayFrom) { ?>
                                    <div class="row d-flex align-items-center w-100 hour-fields mt-1 removea">
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Thursday_From" onchange="LoadPreview()" name="Thursday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $thursdayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control Thursday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ($thursdayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Thursday_To" name="Thursday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Thursday_To'][$key] : ''; ?>" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control Thursday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Thursday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Thursday')" class="add-btn-outline m-auto d-flex Thursday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ($thursdayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline m-auto d-flex Thursday_To ">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row d-flex align-items-center w-100 hour-fields">
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Thursday_From" onchange="LoadPreview()" name="Thursday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc step-form-control Thursday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Thursday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Thursday_To" name="Thursday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc  step-form-control Thursday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Thursday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap  add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Thursday')" class="add-btn-outline m-auto d-flex Thursday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Thursday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" data-anchor="openingBlock" class="anchorLoc opening-hours-checkbox" id="checkboxFri" <?php echo (!empty($filledInput)) ? (isset(($filledInput['Friday_From'])) ? 'checked' : '') : ''; ?> />
                                <label class="m-0" for="checkboxFri"></label>
                            </div>
                            <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.friday') ?></label>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="FridayData">

                            <?php if (isset($filledInput['Friday_From']) && isset($filledInput['Friday_To'])) { ?>
                                <?php foreach ($filledInput['Friday_From'] as $key => $fridayFrom) { ?>
                                    <div class="row d-flex align-items-center w-100 hour-fields mt-1 removea">
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Friday_From" onchange="LoadPreview()" name="Friday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $fridayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control Friday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ($fridayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Friday_To" name="Friday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Friday_To'][$key] : ''; ?>" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control Friday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Friday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Friday')" class="add-btn-outline m-auto d-flex Friday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ($fridayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline m-auto d-flex Friday_To">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row d-flex align-items-center w-100 hour-fields">
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Friday_From" onchange="LoadPreview()" name="Friday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc  step-form-control Friday_From opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Friday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Friday_To" name="Friday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control Friday_To opening-hours-input open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Friday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Friday')" class="add-btn-outline m-auto d-flex Friday_To opening-hours-input append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Friday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" data-anchor="openingBlock" class="anchorLoc" id="checkboxSat" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Saturday_From'])) ? 'checked' : '') : ''; ?> />
                                <label class="m-0" for="checkboxSat"></label>
                            </div>
                            <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.saturday') ?></label>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="SaturdayData">

                            <?php if (isset($filledInput['Saturday_From']) && isset($filledInput['Saturday_To'])) { ?>
                                <?php foreach ($filledInput['Saturday_From'] as $key => $saturdayFrom) { ?>
                                    <div class="row d-flex align-items-center w-100 hour-fields mt-1 removea">
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Saturday_From" onchange="LoadPreview()" name="Saturday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $saturdayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control Saturday_From open-field" <?php echo (!empty($filledInput)) ? ($saturdayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Saturday_To" name="Saturday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Saturday_To'][$key] : ''; ?>" placeholder="To" class="step-form-control Saturday_To open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Saturday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Saturday')" class="add-btn-outline m-auto d-flex Saturday_To append-hour-btn" <?php echo (!empty($filledInput)) ? ($saturdayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline m-auto d-flex Saturday_To ">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row d-flex align-items-center w-100 hour-fields">
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Saturday_From" onchange="LoadPreview()" name="Saturday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc  step-form-control Saturday_From open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Saturday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Saturday_To" name="Saturday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc  step-form-control Saturday_To open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Saturday_To'][$key])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Saturday')" class="add-btn-outline m-auto d-flex Saturday_To append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Saturday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="checkboxBorder d-sm-block1 time-full-wrap">
                    <div class="open-hours-wrap row w-100">
                        <div class="col-sm-3 day-wrap d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" data-anchor="openingBlock" class="anchorLoc " id="checkboxSun" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Sunday_From'])) ? 'checked' : '') : ''; ?> />
                                <label class="m-0" for="checkboxSun"></label>
                            </div>
                            <label class="m-0 open-hours-label"><?= l('qr_step_2_com_opening_hours.sunday') ?></label>
                        </div>
                        <div class="col-sm-9 hours-field-wrap" id="SundayData">

                            <?php if (isset($filledInput['Sunday_From']) && isset($filledInput['Sunday_To'])) { ?>
                                <?php foreach ($filledInput['Sunday_From'] as $key => $sundayFrom) { ?>
                                    <div class="row d-flex align-items-center w-100 hour-fields mt-1 removea">
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center append-hour-field">
                                            <input type="time" id="Sunday_From" onchange="LoadPreview()" name="Sunday_From[]" placeholder="From" value="<?php echo (!empty($filledInput)) ? $sundayFrom : ''; ?>" data-anchor="openingBlock" class="anchorLoc step-form-control Sunday_From open-field" <?php echo (!empty($filledInput)) ? ($sundayFrom ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>
                                        <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                            <input type="time" id="Sunday_To" name="Sunday_To[]" onchange="LoadPreview()" value="<?php echo (!empty($filledInput)) ? $filledInput['Sunday_To'][$key] : ''; ?>" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control Sunday_To open-field" <?php echo (!empty($filledInput)) ? (($filledInput['Sunday_To'][$key]) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                        </div>

                                        <?php if ($key == 0) { ?>
                                            <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                                <button type="button" onclick="addRow('Sunday')" class="add-btn-outline m-auto d-flex Sunday_To append-hour-btn" <?php echo (!empty($filledInput)) ? ($sundayFrom ? '' : 'disabled') : 'disabled'; ?>>
                                                    <span class="icon-add grey plus-mark"></span>
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center">
                                                <button type='button' onclick="removeRow(this)" class="close-btn-outline m-auto d-flex Sunday_To ">
                                                    <span class="icon-trash grey close-mark"></span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row d-flex align-items-center w-100 hour-fields">
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Sunday_From" onchange="LoadPreview()" name="Sunday_From[]" placeholder="From" value="" data-anchor="openingBlock" class="anchorLoc  step-form-control Sunday_From open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Sunday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center">
                                        <input type="time" id="Sunday_To" name="Sunday_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc  step-form-control Sunday_To open-field" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Sunday_From'])) ? '' : 'disabled') : 'disabled'; ?> data-reload-qr-code />
                                    </div>
                                    <div class="name col-2 add-btn-wrap add-btn-mobile d-flex mx-auto align-items-center">
                                        <button type="button" onclick="addRow('Sunday')" class="add-btn-outline m-auto d-flex Sunday_To append-hour-btn" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Sunday_From'])) ? '' : 'disabled') : 'disabled'; ?>>
                                            <span class="icon-add grey plus-mark"></span>
                                        </button>
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
<script>
    $(document).ready(function() {
        let userOs = detectOs();
        if (userOs == 'MacOS') {
            changeInputField();
            appendFiledMac();
        } else {
            $(".open-field").attr('type', 'time');
        }
    });

    function detectOs() {
        let userAgent = window.navigator.userAgent,
            platform = window.navigator.platform,
            macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
            windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
            iosPlatforms = ['iPhone', 'iPad', 'iPod'],
            os = null;

        if (macosPlatforms.indexOf(platform) !== -1) {
            os = 'MacOS';
        } else if (/Android/.test(userAgent)) {
            os = 'Android';
        }

        return os;
    }

    function appendFiledMac() {
        $(".append-hour-btn").on("click", function() {
            changeInputField();
        });
    }

    function changeInputField() {
        $(".open-field").attr('type', 'text').attr('readonly', true).addClass("timepicker");
        var addIcon = $('<span class="time-icon"></span>');
        $(".hour-field-wrap").append(addIcon);
    }

    $('.hour').each(function() {
        for (var h = 1; h < 13; h++) {
            $(this).append('<option value="' + h + '">' + h + '</option>');
        }
        $(this).filter('.from').val('9');
        $(this).filter('.to').val('5');
    });

    $('.min').each(function() {
        var min = [':00', ':15', ':30', ':45'];
        for (var m = 0; m < min.length; m++) {
            $(this).append('<option value="' + min[m] + '">' + min[m] + '</option>');
        }

        $(this).val(':00');
    });

    $(document).on('click', '#ampm', function() {
        console.log("ampm");
        $('#ampm').addClass('active');
        $('#24hr').removeClass('active');
    });
    $(document).on('click', '#24hr', function() {
        console.log("24hr")
        $('#24hr').addClass('active');
        $('#ampm').removeClass('active');
    });

    $('.ampm').each(function() {
        $(this).append('<option value="AM">AM</option>');
        $(this).append('<option value="PM">PM</option>');

        $(this).filter('.from').val('AM');
        $(this).filter('.to').val('PM');
    });

    $('#checkboxMon').on('click', function() {
        LoadPreview();
        if ($(this).is(':checked')) {
            $('.Monday_From').attr('disabled', false);
            $('.Monday_To').attr('disabled', false);
        } else {
            $('.Monday_From').attr('disabled', true);
            $('.Monday_To').attr('disabled', true);
            var mondayLength = $('.Monday_From').length;
            if (mondayLength > 1) {
                $(".removea").remove();
            }
        }
    });

    $('#checkboxTue').on('click', function() {
        LoadPreview();
        if ($(this).is(':checked')) {
            $('.Tuesday_From').attr('disabled', false);
            $('.Tuesday_To').attr('disabled', false);
        } else {
            $('.Tuesday_From').attr('disabled', true);
            $('.Tuesday_To').attr('disabled', true);
            var tuesdayLength = $('.Tuesday_From').length;
            if (tuesdayLength > 1) {
                $(".removea").remove();
            }
        }
    });
    $('#checkboxWed').on('click', function() {
        LoadPreview();
        if ($(this).is(':checked')) {
            $('.Wednesday_From').attr('disabled', false);
            $('.Wednesday_To').attr('disabled', false);
        } else {
            $('.Wednesday_From').attr('disabled', true);
            $('.Wednesday_To').attr('disabled', true);
            var wednsdayLength = $('.Wednesday_From').length;
            if (wednsdayLength > 1) {
                $(".removea").remove();
            }
        }


    });
    $('#checkboxThu').on('click', function() {
        LoadPreview();
        if ($(this).is(':checked')) {
            $('.Thursday_From').attr('disabled', false);
            $('.Thursday_To').attr('disabled', false);
        } else {
            $('.Thursday_From').attr('disabled', true);
            $('.Thursday_To').attr('disabled', true);
            var thursdayLength = $('.Thursday_From').length;
            if (thursdayLength > 1) {
                $(".removea").remove();
            }
        }


    });
    $('#checkboxFri').on('click', function() {
        LoadPreview();
        if ($(this).is(':checked')) {
            $('.Friday_From').attr('disabled', false);
            $('.Friday_To').attr('disabled', false);
        } else {
            $('.Friday_From').attr('disabled', true);
            $('.Friday_To').attr('disabled', true);
            var fridayLength = $('.Friday_From').length;
            if (fridayLength > 1) {
                $(".removea").remove();
            }
        }


    });
    $('#checkboxSat').on('click', function() {
        LoadPreview();
        if ($(this).is(':checked')) {
            $('.Saturday_From').attr('disabled', false);
            $('.Saturday_To').attr('disabled', false);
        } else {
            $('.Saturday_From').attr('disabled', true);
            $('.Saturday_To').attr('disabled', true);
            var saturdayLength = $('.Saturday_From').length;
            if (saturdayLength > 1) {
                $(".removea").remove();
            }
        }


    });
    $('#checkboxSun').on('click', function() {

        if ($(this).is(':checked')) {
            $('.Sunday_From').attr('disabled', false);
            $('.Sunday_To').attr('disabled', false);
        } else {
            $('.Sunday_From').attr('disabled', true);
            $('.Sunday_To').attr('disabled', true);
            var sundayLength = $('.Sunday_From').length;
            if (sundayLength > 1) {
                $(".removea").remove();
            }
        }
        LoadPreview();
    });

    function addRow(day) {
        var data = `<div class="row align-items-center w-100 hour-fields d-flex mt-1 removea"><hr class="add-hours-hr"><div class="name col-5 hour-field-wrap append-hour-field d-flex mx-auto align-items-center"><input type="time" id="${day}_From" onchange="LoadPreview()" name="${day}_From[]" placeholder="From" value="" data-anchor="openingBlock"  class=" anchorLoc step-form-control ${day}_From open-field"  data-reload-qr-code /></div><div class="name col-5 hour-field-wrap d-flex mx-auto align-items-center"><input type="time" id="${day}_To" name="${day}_To[]" onchange="LoadPreview()" value="" placeholder="To" data-anchor="openingBlock" class="anchorLoc step-form-control ${day}_To open-field"  data-reload-qr-code /></div><div class="name col-2 close-btn-wrap d-flex mx-auto align-items-center"><button type='button' onclick="removeRow(this)"  class="close-btn-outline m-auto d-flex ${day}_To " ><span class="icon-trash grey close-mark"></span></button></div></div>`
        $("#" + day + "Data").append($(data).hide().fadeIn(300));
        LoadPreview();
    }

    function removeRow(element) {
        $(element).closest(".row").fadeOut(300, function() {
            $(element).closest(".row").remove();
            LoadPreview();
        })
    }

    $(document).on('touchstart', '.add-btn-outline', function() {
        $(this).addClass('touch-add-btn');
    });

    $(document).on('touchend', '.add-btn-outline.touch-add-btn', function() {
        $(this).removeClass('touch-add-btn');
    });

    // $(document).ready(function() {
    //     $('.opening-hours-checkbox').prop('checked', true);
    //     // LoadPreview();
    //     if ($('.opening-hours-checkbox').is(':checked')) {
    //         console.log("true");
    //         $('.opening-hours-input').attr('disabled', false);
    //     }
    // });

    // $(document).on('click', '.add-btn-outline', function() {
    //     console.log("ture");
    //     console.log($(".day-full-wrap").position(0));
    // });
</script>