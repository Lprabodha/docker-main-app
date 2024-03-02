<?php defined('ALTUMCODE') || die() ?>


<div class="container my-5 d-flex justify-content-center">
    <div class="col-12 col-lg-10">

        <div class="d-print-none d-flex justify-content-between mb-5">
            <div></div>
            <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fa fa-fw fa-sm fa-print"></i> <?= l('invoice.print') ?></button>
        </div>

        <div class="card bg-gray-50 border-0">
            <div class="card-body p-5">

                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="mb-3 mb-md-0">
                        <img src="<?= ASSETS_FULL_URL . 'images/logo.webp'  ?>" class="img-fluid navbar-logo invoice-logo" alt="<?= l('global.accessibility.logo_alt') ?>" loading="lazy" />

                    </div>

                    <div class="d-flex flex-column">
                        <h3 class="text-muted"><?= l('invoice.invoice') ?></h3>

                        <table>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold text-muted pr-3"><?= l('invoice.invoice_nr') ?>:</td>
                                    <td><?= $data->payment->business->invoice_nr_prefix . $data->payment->id ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-muted pr-3"><?= l('invoice.invoice_date') ?>:</td>
                                    <!-- <td><?= \Altum\Date::get($data->payment->datetime, 1) ?></td> -->
                                    <td><?= $data->invoice_time ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-6 mb-md-0">
                            <h5><?= l('invoice.vendor') ?></h5>


                            <table>
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.name') ?>:</td>
                                        <td><?= settings()->business->name ?></td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.address') ?>:</td>
                                        <td><?= settings()->business->address ?></td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.city') ?>:</td>
                                        <td><?= settings()->business->city ?></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.county') ?>:</td>
                                        <td><?= settings()->business->county ?></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.zip') ?>:</td>
                                        <td><?= settings()->business->zip ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.email') ?>:</td>
                                        <td><?= settings()->business->email ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-muted pr-3"><?= l('invoice.phone') ?>:</td>
                                        <td><?= settings()->business->phone ?></td>
                                    </tr> -->


                                    <?php if (!empty($data->payment->business->tax_type) && !empty($data->payment->business->tax_id)) : ?>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= $data->payment->business->tax_type ?>:</td>
                                            <td><?= $data->payment->business->tax_id ?></td>
                                        </tr>
                                    <?php endif ?>

                                    <?php if (!empty($data->payment->business->custom_key_one) && !empty($data->payment->business->custom_value_one)) : ?>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= $data->payment->business->custom_key_one ?>:</td>
                                            <td><?= $data->payment->business->custom_value_one ?></td>
                                        </tr>
                                    <?php endif ?>

                                    <?php if (!empty($data->payment->business->custom_key_two) && !empty($data->payment->business->custom_value_two)) : ?>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= $data->payment->business->custom_key_two ?>:</td>
                                            <td><?= $data->payment->business->custom_value_two ?></td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 col-md-6">
                            <h5><?= l('invoice.customer') ?></h5>

                            <table>
                                <tbody>
                                    <?php if ($data->payment->billing) : ?>
                                        <?php if (!empty($data->user_tax_data->name) || !empty($data->user->name)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.name') ?>:</td>
                                                <td><?= $data->user_tax_data->name ? $data->user_tax_data->name : $data->user->name ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->payment->email)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.email') ?>:</td>
                                                <td><?= $data->user_tax_data->email ? $data->user_tax_data->email : $data->user->email ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->user_tax_data->company_name)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.company') ?>:</td>
                                                <td><?= $data->user_tax_data->company_name ? ($data->user_tax_data->company_name == "#" ? '' : $data->user_tax_data->company_name) : $data->user->company_name ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->user_tax_data->tax_id)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.tax_id') ?>:</td>
                                                <td><?= $data->user_tax_data->tax_id ? ($data->user_tax_data->tax_id == "#" ? '' : $data->user_tax_data->tax_id) : $data->user->tax_id ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->user_tax_data->address)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.address') ?>:</td>
                                                <td>
                                                    <?= strpos($data->user_tax_data->address, ",") != false ? $data->user_tax_data->address . ($data->user_tax_data->postal_code ? ", " . $data->user_tax_data->postal_code : '') : str_replace(",", "", $data->user_tax_data->address) . ($data->user_tax_data->postal_code ? ", " . $data->user_tax_data->postal_code : ''); ?>
                                                </td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->user_tax_data->city)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.city') ?>:</td>
                                                <td> <?= $data->user_tax_data->city ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->payment->billing->county) || !empty($data->user_tax_data->country)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.county') ?>:</td>
                                                <td><?= $data->payment->billing->county ?? get_country_from_country_code($data->user_tax_data->country) ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->payment->billing->zip)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.zip') ?>:</td>
                                                <td><?= $data->payment->billing->zip ?></td>
                                            </tr>
                                        <?php endif ?>


                                        <?php if (!empty($data->payment->billing->phone)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.phone') ?>:</td>
                                                <td><?= $data->payment->billing->phone ?></td>
                                            </tr>
                                        <?php endif ?>

                                    <?php else : ?>

                                        <?php if (!empty($data->payment->name)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.name') ?>:</td>
                                                <td><?= $data->payment->name ?></td>
                                            </tr>
                                        <?php endif ?>

                                        <?php if (!empty($data->payment->email)) : ?>
                                            <tr>
                                                <td class="font-weight-bold text-muted pr-3"><?= l('invoice.email') ?>:</td>
                                                <td><?= $data->payment->email ?></td>
                                            </tr>
                                        <?php endif ?>

                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th><?= l('invoice.table.item') ?></th>
                                <th class="text-right"><?= l('invoice.table.amount') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data->payment->new_plan_id && $data->payment->refund_amount && ($data->payment->new_plan_id != $data->payment->plan_id)) : ?>

                                <?php
                                switch ($data->payment->new_plan_id) {
                                    case (1):
                                        $new_plan_name  = sprintf(l('invoice.table.plan'), 'Monthly');
                                        break;
                                    case (2):
                                        $new_plan_name  = sprintf(l('invoice.table.plan'), 'Annual');
                                        break;
                                    case (3):
                                        $new_plan_name  = sprintf(l('invoice.table.plan'), 'Quarterly');
                                        break;
                                }

                                $newAmount = $data->payment->discount_amount + ($data->payment->base_amount - $data->payment->refund_amount);

                                ?>

                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span><?= $new_plan_name ?></span>
                                        </div>
                                    </td>
                                    <td class="text-right"><?= number_format($newAmount, 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                </tr>
                            <?php endif ?>

                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php
                                        switch ($data->payment->plan_id) {
                                            case (1):
                                                $name  = l('invoice.table.plan_1');
                                                break;
                                            case (2):
                                                $name  = l('invoice.table.plan_2');
                                                break;
                                            case (3):
                                                $name  = l('invoice.table.plan_3');
                                                break;
                                            case (4):
                                                $name  = l('invoice.table.plan_4');
                                                break;
                                            case (5):
                                                $name  = l('invoice.table.plan_5');
                                                break;
                                            case (6):
                                                $name  = l('invoice.table.plan_6');
                                                break;
                                            case (7):
                                                $name  = l('invoice.table.plan_7');
                                                break;
                                        }

                                        ?>

                                        <?php



                                        if ($data->payment->previous_plan) {
                                            switch ($data->payment->previous_plan) {
                                                case (1):
                                                    $previous_plan_name  = sprintf(l('invoice.table.plan'), 'Monthly');
                                                    break;
                                                case (2):
                                                    $previous_plan_name  = sprintf(l('invoice.table.plan'), 'Annual');
                                                    break;
                                                case (3):
                                                    $previous_plan_name  = sprintf(l('invoice.table.plan'), 'Quarterly');
                                                    break;
                                            }
                                        }

                                        ?>

                                        <span><?= $name; ?></span>

                                    </div>
                                </td>
                                <?php if ($data->payment->previous_plan) : ?>
                                    <td class="text-right"><?= number_format(($data->payment->base_amount ? $data->payment->base_amount + $data->payment->credit_amount : $data->payment->total_amount + $data->payment->credit_amount), 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                <?php elseif ($data->payment->new_plan_id && ($data->payment->new_plan_id != $data->payment->plan_id) &&  $data->payment->refund_amount) :  ?>
                                    <td class="text-right"><?= '-' . number_format(($data->payment->base_amount ? $data->payment->base_amount : $data->payment->total_amount), 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                <?php else :  ?>
                                    <td class="text-right"><?= number_format(($data->payment->base_amount ? $data->payment->base_amount : $data->payment->total_amount), 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                <?php endif ?>
                            </tr>
                            <?php if ($data->payment->previous_plan) : ?>
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <?php
                                            switch ($data->payment->previous_plan) {
                                                case (1):
                                                    $previous_plan_name  = sprintf(l('invoice.table.plan'), 'Monthly');
                                                    break;
                                                case (2):
                                                    $previous_plan_name  = sprintf(l('invoice.table.plan'), 'Annual');
                                                    break;
                                                case (3):
                                                    $previous_plan_name  = sprintf(l('invoice.table.plan'), 'Quarterly');
                                                    break;
                                            }
                                            ?>
                                            <span><?= $previous_plan_name; ?></span>

                                        </div>
                                    </td>
                                    <td class="text-right"><?= '-' . number_format(($data->payment->credit_amount), 2) . ' ' . strtoupper($data->payment->currency) ?></td>

                                </tr>
                            <?php endif ?>

                            <?php if ($data->payment->discount_amount) : ?>
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span><?= l('invoice.table.code') ?></span>
                                            <span class="text-muted"><?= sprintf(l('invoice.table.code_help'), $data->payment->code) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-right"><?= '-' . number_format($data->payment->discount_amount, 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                </tr>
                            <?php endif ?>

                            <?php if (!empty($data->payment_taxes)) : ?>
                                <?php foreach ($data->payment_taxes as $row) : ?>

                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span><?= $row->name ?></span>
                                                <div>
                                                    <span class="text-muted"><?= l('pay_custom_plan.summary.' . ($row->type == 'inclusive' ? 'tax_inclusive' : 'tax_exclusive')) ?>.</span>
                                                    <span class="text-muted"><?= $row->description ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($row->type == 'inclusive') : ?>
                                                <?= $row->amount ?>
                                            <?php else : ?>
                                                <?= '+' . $row->amount ?>
                                            <?php endif ?>
                                            <span><?= strtoupper($data->payment->currency) ?></span>
                                        </td>
                                    </tr>

                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="d-flex flex-column">
                                    <span class="font-weight-bold"><?= l('invoice.table.total') ?></span>
                                </td>
                                <?php if ($data->payment->new_plan_id && $data->payment->refund_amount) :  ?>
                                    <?php
                                    $total = $data->payment->refund_amount;
                                    ?>

                                    <td class="text-right font-weight-bold"><?= '-' . number_format($total, 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                <?php else : ?>
                                    <td class="text-right font-weight-bold"><?= number_format($data->payment->total_amount, 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                <?php endif ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-2 pl-2">
                    <div class="row">

                        <?php if ($data->payment->is_refund) :         ?>
                            <div class="col-12 col-md-8 mb-8 mb-md-0">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.status') ?>:</td>
                                            <td><?= l('invoice.refunded') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.payment_method') ?>:</td>
                                            <td><?= ucfirst($data->payment->type) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.card_number') ?>:</td>
                                            <td><?= ucfirst($data->payment->payment_proof) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.transaction_date') ?>:</td>
                                            <td><?= (new \DateTime($data->payment->datetime))->format('M d, Y ') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.refund_id') ?>:</td>
                                            <td><?= $data->payment->refund_id ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>


                        <?php elseif ($data->payment->is_discount_refund) : ?>



                            <div class="col-12 col-md-8 mb-8 mb-md-0">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.status') ?>:</td>
                                            <td><?= l('invoice.partial_refunded') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.payment_method') ?>:</td>
                                            <td><?= ucfirst($data->payment->type) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.card_number') ?>:</td>
                                            <td><?= ucfirst($data->payment->payment_proof) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.transaction_date') ?>:</td>
                                            <td><?= (new \DateTime($data->payment->datetime))->format('M d, Y ') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.refund_id') ?>:</td>
                                            <td><?= $data->payment->refund_id ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.refund_amount') ?>:</td>
                                            <td><?= number_format($data->payment->refund_amount, 2) . ' ' . strtoupper($data->payment->currency) ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="col-12 col-md-8 mb-8 mb-md-0">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.status') ?>:</td>
                                            <td><?= l('invoice.paid') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.payment_method') ?>:</td>
                                            <td><?= ucfirst($data->payment->type) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.card_number') ?>:</td>
                                            <td><?= ucfirst($data->payment->payment_proof) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-muted pr-3"><?= l('invoice.transaction_date') ?>:</td>
                                            <td><?= (new \DateTime($data->payment->datetime))->format('M d, Y ') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif ?>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        console.log("#timezone" + timezone);
    });
</script>