<?php defined('ALTUMCODE') || die() ?>

<style>
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
        width: 50%;
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
</style>

<div class="modal fade" id="user_plan_generate_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="modal-title">
                        Select the Pricing Page to generate a unique link
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?= l('global.close') ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="radio-block-wrp">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-primary active">
                            <input type="radio" name="options" id="option1" checked>
                            <h5 class="mb-0 card-title link-name">
                                Default Pricing Page
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option2">
                            <h5 class="mb-0 card-title link-name">
                                70% OFF Promo Page
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option3">
                            <h5 class="mb-0 card-title link-name">
                                $8.99 Monthly Page
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option4">
                            <h5 class="mb-0 card-title link-name">
                                $50 One Time Payment Page
                            </h5>
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="options" id="option5">
                            <h5 class="mb-0 card-title link-name">
                                Payment Method Update
                            </h5>
                        </label>
                    </div>
                </div>



                <div class="url-view-block" title="Click to add Clipboard">

                </div>

                <div class="mt-4">
                    <a href="" target="_blank" id="user_payment_url" class="btn btn-lg  btn-generate-link">Generate Link</a>
                </div>
            </div>

        </div>
    </div>
</div>



<?php ob_start() ?>
<script>
    'use strict';

    $('input[type=radio][name=options]').change(function() {
        if ($(".url-view-block").hasClass("active")) {
            $('.url-view-block').removeClass('active')
        }
    });




    /* On modal show load new data */
    $('#user_plan_generate_modal').on('show.bs.modal', event => {

        if ($(".url-view-block").hasClass("active")) {
            $('.url-view-block').removeClass('active')
        }



        let user_id = $(event.relatedTarget).data('user-id');
        let referral_key = $(event.relatedTarget).data('user-referral-key');

        $(event.currentTarget).find('#user_payment_url').attr('href', `${url}plans-and-prices?id=${referral_key}`);

        document.getElementById('user_payment_url').addEventListener('click', function(event) {

            document.querySelector('.url-view-block').classList.add('active');

            event.preventDefault();
            const selectedOption = document.querySelector('input[name="options"]:checked').id;
            const urlContent = document.querySelector('.url-view-block').textContent;
            let content;
            switch (selectedOption) {
                case 'option1':
                    // content = "Selected: Default Pricing Page";
                    content = `${url}plans-and-prices?referral_key=${referral_key}`;

                    break;
                case 'option2':
                    content = `${url}plans-and-prices?promo_code=70OFF&referral_key=${referral_key}`;
                    break;
                case 'option3':
                    content = `${url}plans-and-prices?plan_type=discounted&referral_key=${referral_key}`;
                    break;
                case 'option4':
                    content = `${url}plans-and-prices?plan_type=onetime&referral_key=${referral_key}`;
                    break;
                case 'option5':
                    content = `${url}update-payment-method?referral_key=${referral_key}`;
                    break;
                default:
                    content = `${url}plans-and-prices?referral_key=${referral_key}`;
                    break;
            }
            document.querySelector('.url-view-block').textContent = content;
        });
    });

    $(".url-view-block").click(function(e) {
        navigator.clipboard.writeText(e.target.textContent);
        show_alert('success', 'Link Copied to Clipboard!');
    })
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>