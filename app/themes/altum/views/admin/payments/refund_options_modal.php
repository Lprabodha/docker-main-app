<?php defined('ALTUMCODE') || die() ?>


<style>
    /* @import url("../../../assets/css/components/spinner.css?v=6"); */
    @import url("../../../assets/css/components/spinner.css");

    .link-card {
        border: 2px solid #28c254;
        font-size: 12px;
        font-weight: bold;
        color: #28c254;
        margin-top: 10px;
    }

    .link-card .card-body {
        padding: 0.9rem !important;
    }

    .btn-generate-link {
        color: #fff;
        font-weight: bold;
        background-color: #28c254;
        width: 100%;
    }

    .radio-block-wrp .link-name {
        text-align: left;
    }

    .radio-block-wrp .btn-group-toggle {
        flex-direction: column;
        row-gap: 8px;
        width: 100%;
    }

    .radio-block-wrp .btn-group>.btn:not(:first-child),
    .radio-block-wrp .btn-group>.btn-group:not(:first-child)>.btn,
    .radio-block-wrp .btn-group>.btn:not(:last-child):not(.dropdown-toggle),
    .radio-block-wrp .btn-group>.btn-group:not(:last-child)>.btn {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .radio-block-wrp .btn {
        padding: 16px 8px;
    }

    .radio-block-wrp .btn.btn-outline-primary {
        color: #28c254;
        border-color: #28c254;
    }

    .radio-block-wrp .btn-outline-primary:hover {
        color: #28c254;
        background-color: rgba(40, 194, 84, 0.15);
        border-color: #28c254;
    }

    .radio-block-wrp .btn-outline-primary:not(:disabled):not(.disabled):active,
    .radio-block-wrp .btn-outline-primary:not(:disabled):not(.disabled).active,
    .radio-block-wrp .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #28c254;
        border-color: #28c254;
    }

    .radio-block-wrp .btn-outline-primary:not(:disabled):not(.disabled):active:focus,
    .radio-block-wrp .btn-outline-primary:not(:disabled):not(.disabled).active.focus,
    .radio-block-wrp .btn-outline-primary:not(:disabled):not(.disabled).active:focus,
    .radio-block-wrp .show>.btn-outline-primary.dropdown-toggle:focus {
        box-shadow: 0 0 0 0rem rgba(40, 194, 84, 0.5);

    }

    .url-view-block {
        padding: 8px;
        background-color: rgba(40, 194, 84, 0.15);
        margin-top: 1.5rem;
        font-style: italic;
        font-style: 14px;
        border-radius: 0.25rem;
        display: none;
        word-wrap: break-word;
        color: #11762e;
        transition: 0.2s;
    }

    .url-view-block:hover {
        box-shadow: 0px 0px 7px 0px #28c254;
    }

    .url-view-block.active {
        display: block;
    }

    .model-fade-in.active {
        opacity: 1;
    }

    .refund-input-text {
        font-size: 14px;
    }

    #refund_btn,
    #partial_refund_btn,
    .input-wrap {
        position: relative;
    }

    .input-wrap #currency {
        position: absolute;
        right: 35px;
        top: 52%;
        transform: translateY(-50%);
    }

    .refund-op-wrap .link-name {
        font-size: 18px;
    }
</style>

<div class="modal fade" id="refund_options_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="modal-title">
                        Subscription Refund & Renewal Options
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?= l('global.close') ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="radio-block-wrp refund-op-wrap">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-primary active">
                            <input type="radio" name="options" id="option1" checked>
                            <h5 class="mb-0 card-title link-name">
                                Full refund + Immediately cancel the current subscription + cancel next renewal
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option2">
                            <h5 class="mb-0 card-title link-name">
                                Full refund + Keep current subscription active + Keep next renewal active
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option3">
                            <h5 class="mb-0 card-title link-name">
                                Partial refund + Immediately cancel current subscription + cancel next renewal
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option4">
                            <h5 class="mb-0 card-title link-name">
                                Partial refund + Keep current subscription active + Keep next renewal active
                            </h5>
                        </label>
                    </div>
                </div>


                <div class="url-view-block" title="Click to add Clipboard">

                </div>

                <div class="mt-4 flex">
                    <button id="refund_btn" class="btn btn-lg  btn-generate-link">
                        <span class="refund-op-btn-text">Refund</span>
                        <div class="default-spinner refund-op-spinner"></div>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal model-fade-in" id="partial_refund_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="modal-title">
                        Partial Refund
                    </h5>
                    <button type="button" class="close refunt-btn-close" data-dismiss="modal" aria-label="<?= l('global.close') ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="mb-3">
                    <label for="refund_amount" class="form-label refund-input-text">Refund Amount</label>
                    <div class="input-wrap">
                        <input type="number" class="form-control" id="refund_amount" class="refund_amount">
                        <span id="currency"></span>
                    </div>
                </div>

                <div class="url-view-block" title="Click to add Clipboard">

                </div>

                <div class="mt-4 flex">
                    <button id="partial_refund_btn" class="btn btn-lg  btn-generate-link">
                        <span class="refund-partial-text">Refund Payment</span>
                        <div class="default-spinner refund-partial-spinner"></div>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>



<?php ob_start() ?>
<script>
    'use strict';

    let payment_id = '';
    let option = null;

    $('input[type=radio][name=options]').change(function() {
        if ($(".url-view-block").hasClass("active")) {
            $('.url-view-block').removeClass('active')
        }
    });

    /* On modal show load new data */
    $('#refund_options_modal').on('show.bs.modal', event => {

        if ($(".url-view-block").hasClass("active")) {
            $('.url-view-block').removeClass('active')
        }
        payment_id = $(event.relatedTarget).data('id');
    });

    const refundButton = document.getElementById("refund_btn");
    refundButton.addEventListener("click", function(event) {
        const radioButtons = document.querySelectorAll('#refund_options_modal input[type="radio"]');
        const refundButton = document.getElementById('refund_btn');
        $(".refund-op-btn-text").addClass("invisible");
        $(".refund-op-spinner").show();
        let selectedId = null;
        radioButtons.forEach(radioButton => {
            if (radioButton.checked) {
                selectedId = radioButton.id;
                option = selectedId;
            }
        });

        if (selectedId == "option3" || selectedId == "option4") {
            const refundModal = $("#partial_refund_modal");
            const refundOptionsModal = $("#refund_options_modal");
            let currency = document.getElementById("user_currency").value;
            $('#currency').text(currency);
            refundOptionsModal.hide();
            refundModal.fadeIn().show().addClass("active show");
        } else {
            var data = {
                action: 'refund_payment',
                payment_id: payment_id,
                option: selectedId,
                global_token: global_token
            }

            $.ajax({
                type: 'POST',
                url: '<?= url('api/ajax_new') ?>',
                data: data,
                dataType: 'json',
                success: function(response) {
                    window.location.reload();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

    });

    const partialRefundButton = document.getElementById("partial_refund_btn");
    partialRefundButton.addEventListener("click", function(event) {
        const refundAmount = document.getElementById("refund_amount");

        var data = {
            action: 'refund_payment',
            payment_id: payment_id,
            option: option,
            global_token: global_token,
            refund_amount: refundAmount.value
        }

        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax_new') ?>',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.data.message != null) {
                    show_alert('error', response.data.message)
                    $(".refund-partial-text").removeClass("invisible");
                    $(".refund-partial-spinner").hide();
                    refundAmount.value = "";
                } else {
                    window.location.reload();
                }

            },
            error: function(error) {
                // show_alert('error', 'Something went wrong!');
            }
        });
    });

    $(".refunt-btn-close").on("click", function() {
        const refundModal = $("#partial_refund_modal");
        const refundOptionsModal = $("#refund_options_modal");
        $(".refund-op-btn-text").removeClass("invisible");
        $(".refund-op-spinner").hide();
        refundModal.fadeOut().hide();
        refundOptionsModal.removeClass("fade").fadeIn().show().addClass("model-fade-in active");
    });

    $("#partial_refund_btn").on("click", function() {
        const refundAmount = document.getElementById("refund_amount");
        if (refundAmount.value == null || refundAmount.value == '') {
            show_alert('error', 'Please add a refund amount!');
        } else {
            $(".refund-partial-text").addClass("invisible");
            $(".refund-partial-spinner").show();
        }

    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>