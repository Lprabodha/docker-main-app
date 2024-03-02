<?php

use Altum\Middlewares\Authentication;
use Altum\Models\User;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>

<div class="dropdown">
    <button type="button" value="<?= $data->user_id ?>" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple optionsButton" data-toggle="modal" data-target="<?= $data->status == "upcoming" ? '#subscription_cancel_modal' : '' ?>" data-boundary="viewport">
        <i class="fa fa-fw fa-ellipsis-v <?= $data->processor == 'offline_payment' && !$data->status ? 'text-danger' : null ?>"></i>
    </button>

    <?php if ($data->status == "upcoming") : ?>
        <div class="dropdown-menu dropdown-menu-right">
            <button id="cancelSubBtn" value="<?= $data->user_id ?>" target="_blank" class="dropdown-item"><i class="fa fa-fw fa-sm fa-trash mr-2"></i> Cancel</button>
        </div>
    <?php endif ?>

</div>


<div class="modal fade" id="subscription_cancel_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="modal-title">
                        <i class="fa fa-fw fa-sm fa-trash text-danger-900 mr-2"></i>
                        Cancel subscription
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?= l('global.close') ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <p class="text-muted">If you choose to cancel this subscription, all of QR codes will be deactivated once current subscription period expires.</p>

                <div class="mt-4">

                    <input type="hidden" id="uid" value="">

                    <a href="" va id="subscription_cancel_btn" class="btn btn-lg  btn-danger d-flex justify-content-center align-items-center">
                        <span class="mr-2" style="display: none;" id="cancel_loader">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                <circle cx="50" cy="50" fill="none" stroke="white" stroke-width="12" r="38" stroke-dasharray="179 61">
                                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                </circle>
                            </svg>
                        </span>
                        Cancel</a>
                </div>
            </div>

        </div>
    </div>
</div>