<?php
$user_id = $data->user_id;
$folders = $data->folders;

$url = $_SERVER['HTTP_REFERER'];
$query_string = parse_url($url, PHP_URL_QUERY);
$query_params = explode("&", $query_string);

$project_id = null;

foreach ($query_params as $query_param) {
    $key_value = explode("=", $query_param);
    if ($key_value[0] == "project_id") {
        $project_id = isset($key_value[1]) ? $key_value[1] : null;
        break;
    }
}

if ($project_id !== null) {
    $queryStr = "SELECT * FROM `projects` WHERE `project_id` = '{$project_id}'";
    $qrCodesQrResource = database()->query($queryStr);
    $selectedFolder = $qrCodesQrResource->fetch_all(MYSQLI_ASSOC);
    $selectedFolderName = isset($selectedFolder[0]['name']) ? $selectedFolder[0]['name'] : null;
}


$folderIdFromEdit = isset($data->folderId[0]['project_id']) ? $data->folderId[0]['project_id'] : null;


?>

<style>
    .select-box {
        display: flex !important;
    }

    .folder-drp-icon-btn-open {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .folder-drp-icon-btn-close {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .folder-select-wrap {
        padding: 10px !important;
    }

    .folder-select-wrap .folder-select {
        padding: 11px 8px 11px 36px;
    }

    .folder-dropdown .folder-dropdown-icons {
        font-size: 17px;
        margin-right: 8px;
    }

    .select-folder-dropdown-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 8px;
        font-size: 20px;
        display: none;
    }

    .folder-dropdown {
        width: 100%;
        position: absolute;
        background-color: #fff;
        padding: 0px;
        z-index: 9999;
        border-radius: 8px;
        left: 0;
        overflow: hidden;
        max-height: 0;
        transition: 0.5s ease-in-out;
    }

    .custom-select-box-folder .dropdown {
        z-index: 1000;
        bottom: 48px;
        overflow-y: auto;
    }

    .custom-select-box-folder .dropdown.active {
        max-height: 150px;
        transition: 0.5s ease-in-out;
        bottom: 48px;
    }

    .select-box .folder-select,
    .no-folder-icon {
        cursor: pointer;
    }

    .folder-drp-btn:focus {
        box-shadow: none !important;
    }

    .folder-drp-icon-btn-open>i,
    .folder-drp-icon-btn-close>i {
        color: #000 !important;
    }
</style>

<!-- Add Folder Modal -->
<div class="modal custom-modal fade create-folder-modal" id="createFolder" tabindex="-1" aria-labelledby="createFolder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="create-modal-text"><?= l('qr_step_2_com_folder.create_new_folder') ?></h1>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBtn">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 28px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>

            <input type="hidden" id="user_id" name="user_id" value="" required>
            <div class="form-group m-0 create-model-form-group p-3" data-type="url" data-url="">
                <label for="Name"><?= l('qr_step_2_com_folder.input.folder_name') ?></label>
                <input type="text" id="name_folder" name="name_folder" class=" step-form-control">
            </div>
            <p id="nameReq" class="pl-3" style="display:none;color:red"><?= l('qr_step_2_com_folder.error.name_is_required') ?></p>
            <div class="modal-body modal-btn modalFooter create-folder-model-footer p-3">
                <button class="btn primary-btn m-0 grey-btn close-folder-model-btn r-4 font-medium" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_step_2_com_folder.cancel_btn') ?></button>
                <button type="submit" id="makeFolder" class=" r-4 btn primary-btn create-folder-model-btn create-folder-btn ml-2" name="Create"><?= l('qr_step_2_com_folder.create_btn') ?></button>
            </div>

        </div>
    </div>
</div>

<div id="folderSection" class="custom-accodian">
    <button class="btn accodianBtn collapsed" type="button" data-toggle="collapse" data-target="#acc_folder" aria-expanded="false" aria-controls="acc_folder">
        <div class="qr-step-icon">
            <span class="icon-folder grey steps-icon"></span>
        </div>
        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_folder.title') ?></span>
            <span class="fields-helper-heading"><?= l('qr_step_2_com_folder.help_txt.title') ?></span>
        </span>
        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse " id="acc_folder">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="step-form-group folder-select-wrap">
                <div class="form-group m-0 col-md-6 col-sm-12 p-0" style="max-width: 100%;">

                    <div class="custom-select-box-folder">

                        <div class="select-box">

                            <input id="folder_title" class="filters_title_by folder-select" readonly type="text" value="<?php echo ($project_id != null ? $selectedFolderName : ($folderIdFromEdit ? $filledInput['folder_title'] : l('qr_step_2_com_folder.no_folder'))); ?>" onchange="LoadPreview()" name="folder_title">

                            <input type="hidden" id="project_id" value="<?php echo isset($project_id) ? $project_id : (isset($filledInput['project_id']) ? $filledInput['project_id'] : ''); ?>" name="project_id">
                            <span class="icon-noFolder select-folder-dropdown-icon no-folder-icon"></span>
                            <button type="button" class="folder-drp-icon-btn-open">
                                <i id="drp-icon-open" class="fa-solid fa-angle-down"></i>
                            </button>
                            <button type="button" class="folder-drp-icon-btn-close">
                                <i id="drp-icon-close" class="fa-solid fa-angle-up"></i>
                            </button>
                        </div>
                        <div class="dropdown folder-dropdown" id="dropdownFolder">
                            <button id="createFolderBtn" type="button" class="btn drp-btn folder-drp-btn touchstart" data-hold="true" value="Create Folder" data-toggle="modal" data-target="#createFolder"><span class="icon-folder-add folder-dropdown-icons">
                                </span><?= l('qr_step_2_com_folder.create') ?></button>
                            <button type="button" class="btn drp-btn folder-drp-btn touchstart" value="No Folder" id=""><span class="icon-noFolder folder-dropdown-icons"></span><?= l('qr_step_2_com_folder.no_folder') ?></button>
                            <?php foreach ($folders as $folder) : ?>
                                <button type="button" data-hold="true" class="btn drp-btn folder-drp-btn touchstart" id="<?php echo $folder['project_id']; ?>" value="<?php echo $folder['name']; ?>">
                                    <?php echo $folder['name']; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        var url = window.location.href;
        var queryParams = new URLSearchParams(url.split('&')[1]);
        var qrOnboarding = queryParams.get('qr_onboarding');
        
        if (qrOnboarding !== null) {
            if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf')) {
                $('#folderSection').css('display', 'none');
            }
        }
    });

    // Handle the touch move event on mobile devices
    $('#dropdownFolder').on('touchmove', function(event) {
        $('#dropdownFolder').addClass('active');
    });

    $(".custom-select-box-folder input").click(function() {
        if ($(this).parents('.custom-select-box-folder').children('.dropdown').hasClass('active')) {
            $(this).parents('.custom-select-box-folder').children('.dropdown').removeClass('active');
            $(this).parents('.custom-select-box-folder').children('.select-box').children('.folder-drp-icon-btn-open').css("display", "none");
            $(this).parents('.custom-select-box-folder').children('.select-box').children('.folder-drp-icon-btn-close').css("display", "block");
        } else {
            $(this).parents('.custom-select-box-folder').children('.dropdown').addClass('active')
            $(this).parents('.custom-select-box-folder').children('.select-box').children('.folder-drp-icon-btn-open').css("display", "block");
            $(this).parents('.custom-select-box-folder').children('.select-box').children('.folder-drp-icon-btn-close').css("display", "none");
        }
    });

    $('.folder-drp-btn').click(function() {
        var buttonValue = $(this).val();
        $('#project_id').val(buttonValue);
        $('#folder_title').val(buttonValue);
    });

    var projectIds = [];
    var projectNames = [];

    <?php foreach ($folders as $folder) : ?>
        projectIds.push(<?php echo $folder['project_id'] ?>);
        projectNames.push("<?php echo $folder['name'] ?>");
    <?php endforeach; ?>


    $(".folder-drp-icon-btn-close, .no-folder-icon").click(function() {
        $(this).parents('.custom-select-box-folder').children('.dropdown').addClass('active')
        $(".folder-drp-icon-btn-close").css("display", "none");
        $(".folder-drp-icon-btn-open").css("display", "block");
    });

    $(".folder-drp-icon-btn-open").click(function() {
        $(this).parents('.custom-select-box-folder').children('.dropdown').removeClass('active')
        $(".folder-drp-icon-btn-close").css("display", "block");
        $(".folder-drp-icon-btn-open").css("display", "none");
    });

    $("#dropdownFolder").on("scroll", function() {
        isScrolling = true;
        selectFolder();
        clearTimeout($.data(this, 'scrollTimer'));
        $.data(this, 'scrollTimer', setTimeout(function() {
            isScrolling = false;
        }, 250));
    });

    $(".custom-select-box-folder .dropdown .drp-btn").on('click', function(e) {
        e.preventDefault();
        let setFont = $(this).parents(".custom-select-box-folder").children('.select-box').children('input');
        let project_id = $(this).prop('id');
        $('#project_id').val(project_id);
        setFont.attr("value", $(this).attr("value"));
        $("#project_id").attr("value", $(this).attr("id"));
        removeActiveDropdown();
    });

    function selectFolder() {
        if (!isScrolling) {
            $(".custom-select-box-folder .dropdown .drp-btn").on('touchstart click', function() {
                let setFont = $(this).parents(".custom-select-box-folder").children('.select-box').children('input');
                let project_id = $(this).prop('id');
                $('#project_id').val(project_id);
                setFont.attr("value", $(this).attr("value"));
                $("#project_id").attr("value", $(this).attr("id"));
                removeActiveDropdown();
            });
        }
    }

    $(document).ready(function() {
        var userid = $('input[name="userid"]').val();
        $('#user_id').val(userid);
    });

    function changeSelectFolderIcon() {
        var folderName = $('#folder_title').val();
        if (folderName == "No Folder") {
            $(".no-folder-icon").css("display", "block");
            $(".folder-select").css("padding", "11px 8px 11px 36px");
        } else {
            $(".no-folder-icon").css("display", "none");
            $(".folder-select").css("padding", "11px 8px 11px 24px");
        }
    }

    $(".folder-drp-btn").on("click", function() {
        changeSelectFolderIcon();
    });

    $("#modalCloseBtn ,#createFolder .close-folder-model-btn").on("click", function() {
        $('#folder_title').val('No Folder');
    });

    $(document).ready(function() {
        $(".folder-drp-icon-btn-open").css("display", "none");
        $(".folder-drp-icon-btn-close").css("display", "block");
        changeSelectFolderIcon();
    });

    $(document).on('click', '#createFolder .close, #createFolder .close-folder-model-btn', function() {
        changeSelectFolderIcon();
    });

    var modelContent = $(".custom-select-box-folder > .select-box");
    $(document).on("click", function(e) {
        if (!modelContent.is(e.target) && modelContent.has(e.target).length === 0) {
            // e.preventDefault();
            removeActiveDropdown();
        }
    });

    function removeActiveDropdown() {
        $('.custom-select-box-folder').children('.dropdown').removeClass('active');
        $(".folder-drp-icon-btn-close").css("display", "block");
        $(".folder-drp-icon-btn-open").css("display", "none");
    }
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#makeFolder', function(e) {
            e.preventDefault();
            var folderName = $('#name_folder').val();

            if (folderName) {
                $("#nameReq").hide();
                $("#createFolder").find("button.close").trigger('click');
                $("#createFolder").find('form').trigger('reset');
                $(".modal-backdrop").remove();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo url('api/ajax') ?>',
                    data: {
                        action: 'createFolder',
                        name: folderName,
                        user_id: $('input[name="userid"]').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        var data = response.data;
                        var currentFolder = data[0].pop();
                        $('#name_folder').val('');

                        // Create a new button element
                        var newButton = $('<button>').addClass('btn drp-btn touchstart');
                        newButton.attr('id', currentFolder.project_id);
                        newButton.attr('data-hold', 'true');
                        newButton.val(currentFolder.project_id);
                        newButton.text(currentFolder.name);

                        // Append the new button to the dropdown div
                        $('#dropdownFolder').append(newButton);

                        newButton.on('touchstart', function() {
                            $(this).trigger('click');
                        });


                        newButton.on('click', function(event) {
                            event.preventDefault();
                            $(this).parents(".dropdown").removeClass('active');
                            let setFont = $(this).parents(".custom-select-box").children('.select-box').children('input');
                            let project_id = $(this).prop('id');
                            $('#project_id').val(currentFolder.project_id);
                            $('#folder_title').val(currentFolder.name);
                            setFont.attr("value", $(this).attr("value"));
                            $("#project_id").attr("value", $(this).attr("id"));
                        });

                        newButton.trigger('click');
                        newButton.addClass('selected');
                        $('#dropdownFolder').val('');
                        changeSelectFolderIcon();


                        // Data Layer Implementation (GTM)
                        var event = "all_click";

                        var qrData = {
                            "userId": "<?= $data->user_id ?>",
                            "clicktext": "Create Folder",
                        };
                        googleDataLayer(event, qrData);
                    },
                    error: function(xhr, status, error) {

                    }
                });
            } else {
                $("#nameReq").show();
            }
        });
    });
</script>