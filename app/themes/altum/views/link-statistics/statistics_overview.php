<?php defined('ALTUMCODE') || die() ?>

<div class="card mb-4">
    <div class="card-body">
        <div class="chart-container">
            <canvas id="pageviews_chart"></canvas>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5"><?= l('link_statistics.statistics.country') ?></h3>
                <p></p>

                <?php $i = 0; foreach($data->statistics['country_code'] as $key => $value): $i++; if($i > 5) break; ?>
                    <?php $percentage = round($value / $data->statistics['country_code_total_sum'] * 100, 1) ?>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <img src="<?= ASSETS_FULL_URL . 'images/countries/' . ($key ? mb_strtolower($key) : 'unknown') . '.svg' ?>" class="img-fluid icon-favicon mr-1" />
                                <?php if($key): ?>
                                    <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=city_name&country_code=' . $key . '&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" title="<?= $key ?>" class="align-middle"><?= get_country_from_country_code($key) ?></a>
                                <?php else: ?>
                                    <span class="align-middle"><?= $key ? get_country_from_country_code($key) : l('global.unknown') ?></span>
                                <?php endif ?>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($percentage) . '%' ?></small>
                                <span class="ml-3"><?= nr($value) ?></span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="px-4 py-2">
                <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=country&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted"><i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5"><?= l('link_statistics.statistics.referrer_host') ?></h3>
                <p></p>

                <?php $i = 0; foreach($data->statistics['referrer_host'] as $key => $value): $i++; if($i > 5) break; ?>
                    <?php $percentage = round($value / $data->statistics['referrer_host_total_sum'] * 100, 1) ?>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <?php if(!$key): ?>
                                    <span><?= l('link_statistics.statistics.referrer_direct') ?></span>
                                <?php elseif($key == 'qr'): ?>
                                    <span><?= l('link_statistics.statistics.referrer_qr') ?></span>
                                <?php else: ?>
                                    <img src="https://external-content.duckduckgo.com/ip3/<?= $key ?>.ico" class="img-fluid icon-favicon mr-1" />
                                    <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=referrer_path&referrer_host=' . $key . '&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" title="<?= $key ?>" class="align-middle"><?= $key ?></a>
                                    <a href="<?= 'https://' . $key ?>" target="_blank" rel="nofollow noopener" class="text-muted ml-1"><i class="fa fa-fw fa-xs fa-external-link-alt"></i></a>
                                <?php endif ?>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($percentage) . '%' ?></small>
                                <span class="ml-3"><?= nr($value) ?></span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="px-4 py-2">
                <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=referrer_host&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted"><i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5"><?= l('link_statistics.statistics.device') ?></h3>
                <p></p>

                <?php $i = 0; foreach($data->statistics['device_type'] as $key => $value): $i++; if($i > 5) break; ?>
                    <?php $percentage = round($value / $data->statistics['device_type_total_sum'] * 100, 1) ?>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <?php if(!$key): ?>
                                    <span><?= l('global.unknown') ?></span>
                                <?php else: ?>
                                    <span><i class="fa fa-fw fa-sm fa-<?= $key ?> text-muted mr-1"></i> <?= l('global.device.' . $key) ?></span>
                                <?php endif ?>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($percentage) . '%' ?></small>
                                <span class="ml-3"><?= nr($value) ?></span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="px-4 py-2">
                <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=device&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted"><i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5"><?= l('link_statistics.statistics.os') ?></h3>
                <p></p>

                <?php $i = 0; foreach($data->statistics['os_name'] as $key => $value): $i++; if($i > 5) break; ?>
                    <?php $percentage = round($value / $data->statistics['os_name_total_sum'] * 100, 1) ?>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <?php if(!$key): ?>
                                    <span><?= l('global.unknown') ?></span>
                                <?php else: ?>
                                    <span><?= $key ?></span>
                                <?php endif ?>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($percentage) . '%' ?></small>
                                <span class="ml-3"><?= nr($value) ?></span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="px-4 py-2">
                <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=os&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted"><i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5"><?= l('link_statistics.statistics.browser') ?></h3>
                <p></p>

                <?php $i = 0; foreach($data->statistics['browser_name'] as $key => $value): $i++; if($i > 5) break; ?>
                    <?php $percentage = round($value / $data->statistics['browser_name_total_sum'] * 100, 1) ?>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <?php if(!$key): ?>
                                    <span><?= l('global.unknown') ?></span>
                                <?php else: ?>
                                    <span><?= $key ?></span>
                                <?php endif ?>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($percentage) . '%' ?></small>
                                <span class="ml-3"><?= nr($value) ?></span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="px-4 py-2">
                <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=browser&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted"><i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5"><?= l('link_statistics.statistics.language') ?></h3>
                <p></p>

                <?php $i = 0; foreach($data->statistics['browser_language'] as $key => $value): $i++; if($i > 5) break; ?>
                    <?php $percentage = round($value / $data->statistics['browser_language_total_sum'] * 100, 1) ?>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <?php if(!$key): ?>
                                    <span><?= l('global.unknown') ?></span>
                                <?php else: ?>
                                    <span><?= get_language_from_locale($key) ?></span>
                                <?php endif ?>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($percentage) . '%' ?></small>
                                <span class="ml-3"><?= nr($value) ?></span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="px-4 py-2">
                <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=language&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted"><i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?></a>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="d-flex align-items-center mb-3">
        <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fa fa-fw fa-sm fa-chart-bar mr-1"></i> <?= l('link_statistics.statistics.latest') ?></h2>

        <div class="flex-fill">
            <hr class="border-gray-100" />
        </div>
    </div>

    <div class="table-responsive table-custom-container">
        <table class="table table-custom">
            <thead>
            <tr>
                <th><?= l('link_statistics.table.country') ?></th>
                <th><?= l('link_statistics.table.city') ?></th>
                <th><?= l('link_statistics.table.device') ?></th>
                <th><?= l('link_statistics.table.os') ?></th>
                <th><?= l('link_statistics.table.browser') ?></th>
                <th><?= l('link_statistics.table.referrer') ?></th>
                <th><?= l('global.datetime') ?></th>
            </tr>
            </thead>

            <tbody>

            <?php $i = 1; ?>
            <?php foreach($data->latest as $row): ?>
                <?php if($i++ > 10) break ?>
                <tr>
                    <td class="text-nowrap">
                        <img src="<?= ASSETS_FULL_URL . 'images/countries/' . ($row->country_code ? mb_strtolower($row->country_code) : 'unknown') . '.svg' ?>" class="img-fluid icon-favicon mr-1" />
                        <span class="align-middle"><?= $row->country_code ? get_country_from_country_code($row->country_code) : l('global.unknown') ?></span>
                    </td>

                    <td class="text-nowrap">
                        <?= $row->city_name ?? l('global.unknown') ?>
                    </td>

                    <td class="text-nowrap">
                        <?= $row->device_type ? l('global.device.' . $row->device_type) : l('global.unknown') ?>
                    </td>

                    <td class="text-nowrap">
                        <?= $row->os_name ?? l('global.unknown') ?>
                    </td>

                    <td class="text-nowrap">
                        <?= $row->browser_name ?? l('global.unknown') ?>
                    </td>

                    <td class="text-nowrap">
                        <?php if(!$row->referrer_host): ?>
                            <span><?= l('link_statistics.statistics.referrer_direct') ?></span>
                        <?php elseif($row->referrer_host == 'qr'): ?>
                            <span><?= l('link_statistics.statistics.referrer_qr') ?></span>
                        <?php else: ?>
                            <img src="https://external-content.duckduckgo.com/ip3/<?= $row->referrer_host ?>.ico" class="img-fluid icon-favicon mr-1" />
                            <a href="<?= url('transfer-statistics/' . $data->transfer->transfer_id . '?type=referrer_path&referrer_host=' . $row->referrer_host) ?>" title="<?= $row->referrer_host ?>" class="align-middle"><?= $row->referrer_host ?></a>
                            <a href="<?= 'https://' . $row->referrer_host ?>" target="_blank" rel="nofollow noopener" class="text-muted ml-1"><i class="fa fa-fw fa-xs fa-external-link-alt"></i></a>
                        <?php endif ?>
                    </td>

                    <td class="text-nowrap">
                        <span class="text-muted" data-toggle="tooltip" title="<?= \Altum\Date::get($row->datetime, 1) ?>"><?= \Altum\Date::get_timeago($row->datetime) ?></span>
                    </td>
                </tr>
            <?php endforeach ?>

            <tr>
                <td colspan="7">
                    <a href="<?= url('link-statistics/' . $data->link->link_id . '?type=entries&start_date=' . $data->datetime['start_date'] . '&end_date=' . $data->datetime['end_date']) ?>" class="text-muted">
                        <i class="fa fa-angle-right fa-sm fa-fw mr-1"></i> <?= l('link_statistics.statistics.view_more') ?>
                    </a>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

<?php ob_start() ?>
    <script src="<?= ASSETS_FULL_URL . 'js/libraries/Chart.bundle.min.js' ?>"></script>
    <script src="<?= ASSETS_FULL_URL . 'js/chartjs_defaults.js' ?>"></script>

    <script>
        'use strict';

        <?php if(count($data->pageviews)): ?>
        let css = window.getComputedStyle(document.body)

        /* Pageviews chart */
        let pageviews_chart = document.getElementById('pageviews_chart').getContext('2d');

        let pageviews_color = '#10b981';
        let pageviews_gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
        pageviews_gradient.addColorStop(0, 'rgba(16, 185, 129, .1)');
        pageviews_gradient.addColorStop(1, 'rgba(16, 185, 129, 0.025)');

        let visitors_color = '#3b82f6';
        let visitors_gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
        visitors_gradient.addColorStop(0, 'rgba(59, 130, 246, .1)');
        visitors_gradient.addColorStop(1, 'rgba(59, 130, 246, 0.025)');
            
        /* Display chart */
        new Chart(pageviews_chart, {
            type: 'line',
            data: {
                labels: <?= $data->pageviews_chart['labels'] ?>,
                datasets: [
                    {
                        label: <?= json_encode(l('link_statistics.pageviews')) ?>,
                        data: <?= $data->pageviews_chart['pageviews'] ?? '[]' ?>,
                        backgroundColor: pageviews_gradient,
                        borderColor: pageviews_color,
                        fill: true
                    },
                    {
                        label: <?= json_encode(l('link_statistics.visitors')) ?>,
                        data: <?= $data->pageviews_chart['visitors'] ?? '[]' ?>,
                        backgroundColor: visitors_gradient,
                        borderColor: visitors_color,
                        fill: true
                    }
                ]
            },
            options: chart_options
        });

        <?php endif ?>
    </script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
