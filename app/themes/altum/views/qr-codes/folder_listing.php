<?php if (count($data->projects) > 0) : ?>

    <div class="folder-container">
        <?php foreach ($data->projects as $project) : ?>
            <div class="folder-wrap position-relative">

                <a href="<?= url('qr-codes?project_id=' . $project->project_id) ?>" class=" a-decoration " data-toggle="tooltip" title="<?= l('qr_codes.menu') ?>" style="text-decoration:none">
                    <div class="my-folder">
                        <div class="card-top d-flex align-items-center folder-section">
                            <div class="icon-wrp mr-2 p-2">
                                <span class="icon-folder"></span>
                            </div>
                            <div class="files-count file-section"><?= $project->total_project ?? 0 ?> File(s)</div>
                            <button class="kebab-butto folder-model-dropdown-btn position-relative" style="z-index:15;" type="button" data-toggle="dropdown" data-boundary="viewport">
                                <svg class="MuiSvgIcon-root folder-dropdown-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                    <circle cx="12" cy="4" r="2"></circle>
                                    <circle cx="12" cy="12" r="2"></circle>
                                    <circle cx="12" cy="20" r="2"></circle>
                                </svg>
                            </button>
                        </div>

                        <div class="folder-inner">
                            <h4 class=""><?= $project->name ?></h4>
                            <span class="d-flex align-items-center">
                                <span class="icon-calendar mr-1"></span>
                                <?= date("M d, Y", strtotime($project->datetime)) ?>
                            </span>
                        </div>
                    </div>
                </a>
                <div id="folder-details-model" class="dropdown-menu-right folder-drop-down-model">
                    <button id="edit-folder-link" data-toggle="modal" data-folder-name="<?= (!empty($project) && !empty($project->name)) ? $project->name : '' ?>" data-folder-id="<?= (!empty($project) && !empty($project->project_id)) ? $project->project_id : '' ?>" data-user-id="<?php echo $project->user_id; ?>" data-target="#EditFolderNameModal" class="dropdown-item d-flex align-items-center edit-folder">
                        <span class="dropmenu-icon icon-edit mr-1"></span>
                        <span class="text"><?= l('qr_codes.edit_folder_name') ?></span>
                    </button>
                    <button class="dropdown-item d-flex align-items-center delete-folder" data-toggle="modal" data-target="#deleteFolderModal" data-folder-id="<?= $project->project_id ?>" data-user-id="<?php echo $project->user_id; ?>">
                        <span class="dropmenu-icon icon-trash act-btn-icon mr-1"></span>
                        <span class="text"><?= l('qr_codes.delete_folder') ?></span>
                    </button>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else : ?>
    <button type="button" class="btn outline-btn add-new-folder createFolder" data-toggle="modal" data-target="#createFolder">
        <span class="icon-folder-add"></span>
        <span class="text"><?= l('qr_codes.new_folder') ?></span>
    </button>
<?php endif ?>


<!-- Edit folder name modal-->
<div class="modal custom-modal fade" id="EditFolderNameModal" tabindex="-1" aria-labelledby="EditFolderNameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="create-modal-text"><?= l('qr_codes.edit_folder') ?></h1>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>
            <form id="editFolderForm" name="edit_folder_form" action="" target="_blank">
                <input type="hidden" name="user_id" id="user_id" value="">
                <input type="hidden" name="project_id" id="project_id" value="">
                <div class="form-group m-0" data-type="url" data-url="">
                    <label for="Name"><?= l('qr_codes.name') ?></label>
                    <input type="text" name="name" id="name" class="form-control" data-reload-qr-code="" value="">
                </div>
                <p id="nameReqEdit" class="nameReq" style="display:none;color:red"><?= l('qr_codes.name_is_required') ?></p>
                <div class="modal-body modal-btn modalFooter">
                    <button class="btn primary-btn m-0 grey-btn  r-4" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                    <button type="submit" id="editFolder" class="r-4 btn primary-btn save-edits-btn ml-2" name="Save"><?= l('qr_codes.save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Project Modal -->
<div class="modal smallmodal fade" id="deleteFolderModal" tabindex="-1" aria-labelledby="deleteFolderModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space">
            <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
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
                <p><?= l('qr_codes.folder_deleted_message_line1') ?><br>
                    <?= l('qr_codes.folder_deleted_message_line2') ?>
                </p>
            </div>

            <form id="deleteFolderForm" name="delete_folder_form" action="" target="_blank">
                <input type="hidden" id="project_id" name="project_id" class="folder-id" value="">
                <input type="hidden" name="user_id" id="user-id" value="">
                <div class="modal-body modal-btn justify-content-center">
                    <button class="btn primary-btn grey-btn  m-0 r-4 me-2 close" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                    <button class="btn primary-btn red-btn r-4" id="deleteFolderButton" name="folder_delete"><?= l('qr_codes.delete') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('.kebab-butto').click(function() {
        var modaldrop = $(this).parents('.folder-wrap').children('.folder-drop-down-model');

        // Check if model is currently open
        if (modaldrop.css('display') === 'block') {
            // Close the model
            modaldrop.css('display', 'none');
        } else {
            // Close any other open models
            $('.folder-drop-down-model').css('display', 'none');

            // Open the current model
            modaldrop.css('display', 'block');

            // Attach a click event to document to close the model on any click outside
            setInterval(function() {
                $(document).on("click", function() {
                    if (modaldrop.css('display') === 'block') {
                        $(modaldrop).css({
                            'display': 'none'
                        });
                    }
                });
            }, 500);

        }
    });

    $(".delete-folder").click(function() {
        $("#deleteFolderModal").click();
        var folder_id = $(this).data('folder-id');
        var user_id = $(this).data('user-id');

        $(".folder-id").val(folder_id);
        $("#user-id").val(user_id);
    });


    $(".edit-folder").click(function() {
        $("#EditFolderNameModal").click();
        var folder_id = $(this).data('folder-id');
        var user_id = $(this).data('user-id');
        var name = $(this).data('folder-name');

        $("#project_id").val(folder_id);
        $("#user_id").val(user_id);
        $("#name").val(name);
    });

    $(document).ready(function() {

        function clearFormData() {
            $('#editFolderForm input[name="name"]').val('');
        }

        // Event handler for opening the modal
        $('#EditFolderModal').on('show.bs.modal', function() {
            clearFormData();
        });

    });
</script>