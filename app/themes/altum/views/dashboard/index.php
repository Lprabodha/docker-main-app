<?php defined('ALTUMCODE') || die() ?>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">

<div class="container-fluid space-block container-warp">
  <?= \Altum\Alerts::output_alerts() ?>

  <div class="custom-heading-wrp d-flex justify-content-between align-items-center scale-block">
    <h1 class="custom-title"><?= l('analytics') ?></h1>
    <button class="btn outline-btn export-btn btn-with-icon" type="button" id="exportBtn">
      <span class="icon-export"></span>
      <?= l('analytics.export') ?>
    </button>
  </div>
  <?= $data->planExpireBannerHtml ?>


  <?php if ($data->reviewBanner && $this->user->is_review == false && $this->user->onboarding_funnel != 4) : ?>
    <?php include_once(THEME_PATH . '/views/qr-codes/components/review-banner.php') ?>
  <?php endif ?>

  <?php if ($data->total_qr_codes > 0) : ?>
    <div class="filter-container scale-block">

      <form id="filterForm" class="filter-form-wrp" name="filter_form" method="POST" action="<?= url('dashboard/export') ?>">
        <input type="hidden" name="user_id" value="<?php echo $data->user_id; ?>">

        <div class="date-export-container">
        </div>
        <div class="row">

          <div class="col-xxl-2 col-lg-4 col-sm-6 mb-xxl-0 mb-lg-2 mb-sm-2 mb-2" style="">
            <div class="dateItem">
              <label class="fieldLabel"><?= l('analytics.period') ?></label>
              <select class="form-select multiSelect custom-select" aria-label="Peroid select" id="select_period">
                <option value="today"><?= l('analytics.today') ?></option>
                <option value="yesterday"><?= l('analytics.yesterday') ?></option>
                <option value="week" selected><?= l('analytics.last_7') ?></option>
                <option value="month"><?= l('analytics.last_30') ?></option>
                <option value="quarter"><?= l('analytics.last_90') ?></option>
                <option value="lifetime"><?= l('analytics.lifetime') ?></option>
                <option value="custom"><?= l('analytics.custom') ?></option>
              </select>


            </div>
          </div>
          <div class="col-xxl-2 col-lg-4 col-sm-6 mb-xxl-0 mb-lg-2 mb-sm-2 mb-2">
            <div class="dateItem datepicker-parent item-with-icon">
              <label class="fieldLabel"><?= l('analytics.pick_range') ?></label>
              <input class="form-control" name="date_range" placeholder="Oct 10, 2022 - Nov 10, 2022" id="kt_daterangepicker_1" onclick="javascript:this.blur();this.onfocus=()=>this.blur()" style="cursor: pointer;" readonly>
              <span class="icon-calendar icon-qr " style="pointer-events:none;"></span>
            </div>
          </div>
          <div class="col-xxl-2 col-lg-4 col-sm-6 mb-xxl-0 mb-lg-2 mb-sm-2 mb-2 mob-filters ">
            <div class="form-group custom-mui-drop-down mb-0">
              <label for="filters_qrcode_by" class="fieldLabel"><?= l('analytics.qr_code') ?></label>

              <select name="qr_code[]" id="qrCode" class="multiSelect form-control" multiple aria-label="Default select example" data-live-search="true">
                <?php
                foreach ($data->qr_codes as $qr_code) {
                  echo '<option value="' . $qr_code->qr_code_id . '">' . $qr_code->name . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-xxl-2 col-lg-4 col-sm-6 mb-xxl-0 mb-lg-2 mb-sm-2 mb-2 mob-filters  filters-set-position">
            <div class="form-group custom-mui-drop-down mb-0">
              <label for="filters_operatingsystem_by" class="fieldLabel height-checker set-font"><?= l('analytics.os') ?></label>
              <select name="os_name[]" id="osName" class="multiSelect form-control " multiple aria-label="dsgfsdfgsdfgsdfg sdf gsdfg " data-live-search="true">
                <?php
                foreach ($data->os_name_arr as $value) {
                  echo '<option value="' . $value['os_name'] . '">' . $value['os_name'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-xxl-2 col-lg-4 col-sm-6 mb-xxl-0 mb-lg-2 mb-sm-2 mb-2 mob-filters">
            <div class="form-group custom-mui-drop-down mb-0">
              <label for="filters_countries_by" class="fieldLabel"><?= l('analytics.counties') ?></label>
              <select name="country_name[]" id="countryName" class="multiSelect form-control" multiple aria-label="Default select example" data-live-search="true">
                <?php
                foreach ($data->country_name_arr as $value) {
                  echo '<option value="' . $value['country_name'] . '">' . $value['country_name'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-xxl-2 col-lg-4 col-sm-6 mb-xxl-0 mb-lg-2 mb-sm-2 mb-2 mob-filters" style="">
            <div class="form-group custom-mui-drop-down mb-0">
              <label for="filters_cities_by" class="fieldLabel"><?= l('analytics.cities') ?></label>
              <select id="citiesList" name="city_name[]" class="multiSelect form-control" multiple aria-label="Default select example" data-live-search="true">
                <?php
                foreach ($data->city_name_arr as $value) {
                  echo '<option value="' . $value['city_name'] . '">' . $value['city_name'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div style="margin-bottom: 22px;">
        </div>
      </form>
      <div class="row d-sm-none d-flex justify-content-center align-items-center filter-toggler">
        <div class="col-auto mx-auto">
          <span class="icon-wrp"></span>
          <span class="col-auto filter-text"><?= l('analytics.more_filters'); ?></span>
        </div>
        <!-- </div> -->
      </div>
    </div>

    <div class="all-qrinfo scale-block">
      <div class="col px-0 all-qr-info-wrp">
        <div class="row">
          <div class="col-xl-4 col-lg-12 xl-mb-0 mb-2 qr-info-card">
            <div class="qritem">
              <div class="icon-wrp">
                <span class="icon-scan-barcode grey"></span>
              </div>
              <div class="text-content">
                <label class="itemlabel"><?= l('analytics.total_qr') ?></label>

              </div>
              <div class="count-wrp">
                <span class="itemcount" id="totalQrCode"><?= $data->total_qr_codes ?></span>
              </div>

            </div>
          </div>
          <div class="col-xl-4 col-lg-12 xl-mb-0 mb-2 qr-info-card">
            <div class="qritem">
              <div class="icon-wrp">
                <span class="icon-scan green"></span>

              </div>
              <div class="text-content">
                <label class="itemlabel"><?= l('analytics.total_scans') ?></label>

              </div>
              <div class="count-wrp">
                <span class="itemcount" id="totalScan">0</span>
              </div>

            </div>

          </div>
          <div class="col-xl-4 col-lg-12 xl-mb-0 mb-2 qr-info-card">
            <div class="qritem">
              <div class="icon-wrp">
                <span class="icon-scan blue"></span>

              </div>
              <div class="text-content">
                <label class="itemlabel unique-scans-label">
                  <?= l('analytics.total_unique_scans') ?>
                  <div class="unq-scan-tooltip-wrap">
                    <span class="info-tooltip-icon ctp-tooltip" tp-content='<?= str_replace("'", "\'", l('analytics.total_unique_scans.tooltip')) ?>'></span>
                  </div>
                </label>

              </div>
              <div class="count-wrp">
                <span class="itemcount" id="totalUniqueScan">0</span>
              </div>

            </div>

          </div>
        </div>

      </div>

    </div>
    <div class="qrrecord-container">
      <div class="scan-activities">
        <div class="card">
          <div class="cardHeader">
            <div class="date-block">
              <span><?= l('analytics.date') ?></span>
              <span id="picked-range" class="picked-range"></span>
            </div>
            <div class="title-block">
              <?= l('analytics.scan_activity') ?>
            </div>
          </div>
          <div class="cardBody custom-legend">
            <div class="legend-box" id="legendBox">
            </div>
            <div class="chart-container custom-tooltip" id="canvasContainer">
              <canvas id="pageviews_chart"></canvas>
              <!-- <div id="toolTipBlock" class="custom-tooltip-block"></div> -->
            </div>
          </div>

        </div>
      </div>
      <div class="row ">
        <div class="col-xl-4 mb-xxl-0 mb-2 scan-by-blocks">
          <div class="scan-by-block">
            <div class="title-block">
              <span><?= l('analytics.os') ?></span>
            </div>
            <div class="content-block " id="scanOS">
              <div class="row">
                <div class="col-sm-4 col-auto dougnut-wrp osChartWrap">
                  <canvas id="osChart">
                  </canvas>
                </div>
                <div class="col-sm-8 col-12 d-flex align-items-center">
                  <div class="legend w-100" id="osLegend">
                  </div>
                </div>

              </div>
              <div class="norecords"></div>
            </div>
            <div class="norecords"></div>
          </div>
        </div>
        <div class="col-xl-4 mb-xxl-0 mb-2 scan-by-blocks">
          <div class="scan-by-block">
            <div class="title-block">
              <span><?= l('analytics.scan_country') ?> </span>
            </div>
            <div class="content-block" id="scanCountry">
              <div class="row">
                <div class="col-sm-4 col-auto dougnut-wrp countryChartWrap">
                  <canvas id="countryChart">
                  </canvas>
                </div>
                <div class="col-sm-8 col-12 d-flex align-items-center">
                  <div class="legend w-100" id="countryLegend">
                  </div>
                </div>
              </div>
              <div class="norecords"></div>

            </div>
          </div>

        </div>
        <div class="col-xl-4 mb-xxl-0 mb-2 scan-by-blocks">
          <div class="scan-by-block">
            <div class="title-block">
              <span><?= l('analytics.scan_city') ?></span>
            </div>
            <div class="content-block" id="scanCity">
              <div class="row">
                <div class="col-sm-4 col-auto dougnut-wrp cityChartWrap">
                  <canvas id="cityChart">

                  </canvas>
                </div>
                <div class="col-sm-8 col-12 d-flex align-items-center">
                  <div class="legend w-100" id="cityLegend">
                  </div>
                </div>
              </div>
              <div class="norecords"></div>
            </div>
            <div class="norecords"></div>

          </div>

        </div>

      </div>

    </div>
</div>
</div>
</div>
<?php else : ?>
  <h3><?= l('analytics.no_scan') ?></h3>
<?php endif; ?>


</div>


<div class="modal custom-modal download-modal smallmodal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-dialog-export">
    <div class="modal-content">

      <div class="modal-header align-items-start">
        <h1><?= l('analytics.export') ?></h1>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
            <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
          </svg>
        </button>
      </div>



      <div class="modal-body p-0">
        <div class="form-group mb-2">
          <button class="btn outline-btn m-0" name="CSV" onclick="download('csv')">CSV</button>
        </div>
        <div class="form-group mb-2">
          <button class="btn outline-btn m-0" name="XLSX" onclick="download('xlsx')">XLSX</button>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
  'name' => 'qr_code',
  'resource_id' => 'qr_code_id',
  'has_dynamic_resource_name' => true,
  'path' => 'qr-codes/delete'
]), 'modals'); ?>

<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link href="<?= ASSETS_FULL_URL . 'css/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/daterangepicker.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/chart.js' ?>"></script>

<?php
$langVariables = array(
  l('analytics.none_selected'),
  l('analytics.all_selected')
);
$langVariablesJson = json_encode($langVariables);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
  'use strict';



  function getHeightByClass(className) {
    var element = document.querySelector('.' + className);
    if (element) {
      var height = element.getBoundingClientRect().height;

      return height;
    } else {
      console.error('Element with class ' + className + ' not found');
      return null;
    }
  }

  $(window).on('resize', function() {
    var labelHeight = getHeightByClass('height-checker');
    console.log($(this).width());
    console.log('Label height:', labelHeight);
    if ($(this).width() > 1399 && labelHeight > 16) {
      $(".filters-set-position").addClass('set-top');
    } else {
      $(".filters-set-position").removeClass('set-top');
    }
  });

  $(document).ready(function() {
    var labelHeight = getHeightByClass('height-checker');
    if (labelHeight > 16) {
      $(".filters-set-position").addClass('set-top');
      console.log('Label height:', labelHeight);
    }
  });





  $(document).ready(function() {
    $('#deleteFolderModal').on('show.bs.modal', function(event) {
      console.log("dsfgsdfgsdfgsdfgsdfg");
    });
    // console.log($( ".btn-group .multiselect-selected-text" ).text('asdfasdfasdfasd fasdf asdf asdf asdf '));
  });




  $('.filter-toggler').click(function() {
    $(this).parents('.filter-container').toggleClass('active');
    if ($(this).find('div > .filter-text').text() == '<?= l('analytics.more_filters'); ?>') {
      $(this).find('div > .filter-text').text('<?= l('analytics.less_filters'); ?>');
      $(this).find('div > .icon-wrp').addClass('minus');
    } else {
      $(this).find('div > .icon-wrp').removeClass('minus');
      $(this).find('div > .filter-text').text('<?= l('analytics.more_filters'); ?>');

    }
  });


  // $(document).ready(function() {
  //   $('#date_range_icon').click(function() {
  //     $('#kt_daterangepicker_1').focus();
  //   });
  // });

  function download(type) {

    var dateRange = $("#kt_daterangepicker_1").val();
    var type = $("<input>")
      .attr("type", "hidden")
      .attr("name", "file_type").val(type);

    var date_range = $("<input>")
      .attr("type", "hidden")
      .attr("name", "date_range").val(dateRange);

    $('#filterForm').append(date_range);
    $('#filterForm').append(type);

    var form = $("#filterForm")[0];
    form.submit();


    $("#exportModal").modal('toggle');


    var event = "all_click";

    var data = {
      "userId": "<?php echo $this->user->user_id ?>",
      "clicktext": "Export Info"
    }
    googleDataLayer(event, data);
  }
  /* Pageviews chart */
  function chart(chartData) {
    // console.log(chartData.labels.length)
    if (chartData) {
      var maxPageviews = Math.max(...chartData.pageviews);
      var maxVisitors = Math.max(...chartData.visitors);
      var max;
      if (maxPageviews >= maxVisitors) {
        if (maxPageviews <= 5) {
          max = 5;
        } else {
          max = maxPageviews;
        }

      } else {
        max = maxVisitors;
      }
      if (maxPageviews > 5) {
        max = Math.ceil(max / 10) * 10;
      }
      $(".chart-container").html('<canvas id="pageviews_chart"></canvas>');
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
      const data = {
        labels: chartData.labels,
        datasets: [{
            label: '<?= l('analytics.scans') ?>',
            data: chartData.pageviews,
            backgroundColor: pageviews_gradient,
            borderColor: pageviews_color,
            borderWidth: 1,
            fill: true,
            pointStyle: 'circle',
            pointRadius: chartData.labels.length == 1 ? 2 : 0,           
            pointBackgroundColor: '#10b981'
          },
          {
            label: '<?= l('analytics.unique_scans') ?>',
            data: chartData.visitors,
            backgroundColor: visitors_gradient,
            borderColor: visitors_color,
            borderWidth: 1,
            fill: true,
            pointStyle: 'circle',
            pointRadius: chartData.labels.length == 1 ? 2 : 0,           
            pointBackgroundColor: '#3b82f6'
          },
        ],

      };

      const bar = {
        id: 'bar',
        beforeDatasetsDraw(chart) {
          const {
            ctx,
            tooltip,
            scales: {
              x,
              y
            },
            chartArea: {
              top,
              bottom,
              left,
              right,
              width,
              height
            }
          } = chart;
          if (tooltip._active[0]) {
            var cords = tooltip._active[0].element.x;
            var grad = ctx.createLinearGradient(0, top, 0, bottom);
            grad.addColorStop(0, 'rgba(29, 92, 249,1)');
            grad.addColorStop(1, 'rgba(29, 92, 249,0.3)');
            ctx.beginPath();
            ctx.strokeStyle = grad;
            ctx.lineWidth = 2;
            ctx.setLineDash([2, 2]);
            // Adjust the top position of the vertical hover bar to the bottom of the tooltip
            ctx.moveTo(cords, tooltip.yAlign === 'top' ? tooltip.caretY + 6 : tooltip.caretY - 30);
            ctx.lineTo(cords, bottom);
            ctx.stroke();
            // Calculate the height from the bottom of the chart to the tooltip
            const tooltipHeight = bottom - (tooltip.yAlign === 'top' ? tooltip.caretY + 6 : tooltip.caretY - 6);
          }
        }
      };

      const getOrCreateLegendList = (chart, id) => {
        const legendContainer = document.getElementById(id);
        let legendList = legendContainer.querySelector('UL');
        if (!legendList) {
          legendList = document.createElement('UL');
          legendList.classList.add('chartLegend');
          legendContainer.appendChild(legendList);
        }
        return legendList;
      }


      const getOrCreateTooltip = (chart) => {
        let tooltipEl = chart.canvas.parentNode.querySelector('div');

        if (!tooltipEl) {
          tooltipEl = document.createElement('div');
          tooltipEl.classList.add('custom-tooltip-block');
          tooltipEl.setAttribute('id', 'toolTipBlock');
          tooltipEl.style.background = 'white';
          tooltipEl.style.borderRadius = '10px';
          tooltipEl.style.fontWeight = 'bold';
          // tooltipEl.style.color = 'red';
          tooltipEl.style.opacity = 1;
          tooltipEl.style.pointerEvents = 'none';
          tooltipEl.style.position = 'absolute';
          tooltipEl.style.transform = 'translate(-50%, 0)';
          tooltipEl.style.transition = 'all .1s ease';
          tooltipEl.style.padding = 8;

          const table = document.createElement('table');
          table.style.margin = '0px';

          tooltipEl.appendChild(table);
          chart.canvas.parentNode.appendChild(tooltipEl);
        }

        return tooltipEl;
      };

      const externalTooltipHandler = (context) => {
        // Tooltip Element
        const {
          chart,
          tooltip
        } = context;
        const tooltipEl = getOrCreateTooltip(chart);

        console.log(tooltip);

        // Hide if no tooltip
        if (tooltip.opacity === 0) {
          tooltipEl.style.opacity = 0;

          return;
        }

        // Set Text
        if (tooltip.body) {
          const titleLines = tooltip.title || [];
          const bodyLines = tooltip.body.map(b => b.lines);

          const tableHead = document.createElement('thead');
          const tableBody = document.createElement('tbody');

          let objectDate = new Date();
          // let year = objectDate.getFullYear()

          titleLines.forEach(title => {
            const parts = title.split("-");
            const year = parts[0];
            const monthAndDate = parts[1];

            const tr = document.createElement('tr');
            tr.style.borderWidth = 0;

            const th = document.createElement('th');
            th.style.borderWidth = 0;
            const text = document.createTextNode(monthAndDate + ", " + year);
            tr.appendChild(text);
            tableBody.appendChild(tr);
          });

          bodyLines.forEach((body, i) => {
            const tr = document.createElement('tr');
            tr.style.borderWidth = 0;

            const th = document.createElement('th');
            th.style.borderWidth = 0;
            const text = document.createTextNode(body);

            const splitStrings = [];
            for (const string of body) {
              splitStrings.push(string.split(":"));
            }

            tableBody.appendChild(tr);
            splitStrings.forEach((splitString) => {
              for (const string of splitString) {
                const td = document.createElement('td');
                td.style.borderWidth = 0;
                const texttd = document.createTextNode(string);
                td.appendChild(texttd);
                tr.appendChild(td);
              }
            });

          });

          const tableRoot = tooltipEl.querySelector('table');

          // Remove old children
          while (tableRoot.firstChild) {
            tableRoot.firstChild.remove();
          }

          // Add new children
          tableRoot.appendChild(tableHead);
          tableRoot.appendChild(tableBody);
        }

        const {
          offsetLeft: positionX,
          offsetTop: positionY
        } = chart.canvas;

        // Display, position, and set styles for font
        tooltipEl.style.opacity = 1;
        tooltipEl.style.left = positionX + tooltip.caretX + 'px';
        tooltipEl.style.top = (positionY + tooltip.caretY) - 120 + 'px';
        tooltipEl.style.font = tooltip.options.bodyFont.string;
        tooltipEl.style.padding = tooltip.options.padding + 'px ' + tooltip.options.padding + 'px';

        // Tooltip remover
        var canvas = document.getElementById('pageviews_chart');
        // var message = document.getElementById('toolTipBlock');

        // Event listener for touchmove
        document.addEventListener('touchmove', function(event) {

          // console.log(canvas);
          // console.log(message);
          var touch = event.touches[0];
          var touchX = touch.clientX;
          var touchY = touch.clientY;

          var canvasRect = canvas.getBoundingClientRect();
          var canvasLeft = canvasRect.left;
          var canvasTop = canvasRect.top;
          var canvasRight = canvasRect.right;
          var canvasBottom = canvasRect.bottom;

          if (
            touchX < canvasLeft ||
            touchX > canvasRight ||
            touchY < canvasTop ||
            touchY > canvasBottom
          ) {
            tooltipEl.style.display = 'none';
          } else {
            tooltipEl.style.display = 'block';
          }
        });
        // Tooltip remover

      };

      const htmlLegendPlugin = {
        id: 'htmlLegend',
        afterUpdate(chart, args, options) {

          const ul = getOrCreateLegendList(chart, options.containerID);

          while (ul.firstChild) {
            ul.firstChild.remove()
          }

          const legendItems = chart.options.plugins.legend.labels.generateLabels(chart);
          legendItems.forEach((item, index, arr) => {
            const li = document.createElement('LI');
            li.classList.add('legendItem');

            li.onclick = () => {
              const {
                type
              } = chart.config;
              if (type === 'pie' || type === 'doughnut') {
                chart.toggleDatavisibility(item.index);
              } else {
                chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
              }
              chart.update();
            }

            const colorBox = document.createElement('SPAN');
            colorBox.classList.add('color-box');
            colorBox.style.backgroundColor = item.strokeStyle;

            const textBox = document.createElement('SPAN');
            textBox.classList.add('text-box');
            textBox.style.color = item.hidden ? '#ccc' : item.fontColor;
            const text = document.createTextNode(item.text);

            li.appendChild(colorBox);
            li.appendChild(textBox);
            textBox.appendChild(text);
            ul.appendChild(li);
          })
        }
      };

      const formattedLabels = data.labels.map(date => date.substring(5));

      const config = {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: data.datasets
        },

        options: {
          layout: {
            padding: {
              top: 15,
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                callback: function(value, index, ticks) {
                  return formattedLabels[value];
                }
              },
              bounds: data.labels.length == 1 ? [0, 100] : [0, 0],
              offset: data.labels.length == 1 ? true : false,
            },
            y: {
              grid: {
                display: true,
              },
              beginAtZero: true,
              ticks: {
                padding: 0,
                stepSize: maxPageviews <= 5 ? 1 : 0,
              },
              border: {
                dash: [4, 8],
              },
              suggestedMin: 0,
              suggestedMax: max,

            },

          },
          interaction: {
            mode: 'index',
          },
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              enabled: false,
              mode: 'index',
              intersect: false,
              caretPadding: 20,
              bodyLineHeight: 1.2,
              position: 'nearest',
              backgroundColor: '#FFFFFF',
              displayColors: false,
              bodySpacing: 8,
              multiKeyBackground: '#fff',
              usePointStyle: true,
              borderWidth: 1,
              borderColor: '#EBEBEB',
              bodyFont: {
                size: 16,
                weight: 700,
              },
              external: externalTooltipHandler,
              callbacks: {
                labels: data.labels
              }
            },
            htmlLegend: {
              containerID: 'legendBox'
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          pointRadius: 0,
          pointHoverRadius: 5,
          pointHoverBorderWidth: 2,
          pointHitRadius: 15,
          hoverBackgroundColor: 'white',

        },

        plugins: [
          bar,
          htmlLegendPlugin,
        ]
      };

      const myChart = new Chart(
        pageviews_chart,
        config,
      );

      // var labels = myChart.config._config.data.labels;
      // labels = data.labels.map(date => date.substring(5));

      Chart.Tooltip.positioners.top = function(elements, eventPosition) {

        const {
          chartArea: {
            top
          },
          scales: {
            x,
            y
          },

        } = this.chart;
        return {
          x: x.getPixelForValue(x.getValueForPixel(eventPosition.x)),
          y: top + 5,
          xAlign: 'center',
          yAlign: 'bottom',

        }


      };

    } else {
      $(".chart-container").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('analytics.no_data') ?></p></div>');
    }


  }


  // Doughnut Chart
  let lengthLimit = 20;
  let backgroundColor = [
    "#8CE6A5",
    "#EC9E72",
    "#F8CA71",
    "#FBE275",
    "#E6DD8C",
    "#C9E68C",
    "#65D0BD",
    "#5D82D5",
    "#D55DA5",
    "#D55D64",
    //new color code
    "#8CE6A5",
    "#EC9E72",
    "#F8CA71",
    "#FBE275",
    "#E6DD8C",
    "#C9E68C",
    "#65D0BD",
    "#5D82D5",
    "#D55DA5",
    "#D55D64",
  ];
  let str;
  let osChart;
  let countryChart;
  let cityChart;

  function legendData(chartData) {
    const max = chartData.values.reduce((a, b) => (a + b), 0);
    const idx = []
    $.each(chartData.values, function(k, v) {
      idx.push((v / max * 100).toFixed(0));
    });
    str = ""
    str += '<table class="custom-grid-table-wrp w-100">';
    str += '<tbody>';
    $.each(chartData.labels, function(k, v) {
      if (k => 0) {
        var prse
        str += '<tr><td><div><span style="background-color:' + backgroundColor[k] + ';"></span> ' + chartData.labels[k] + '</div></td><td>' + chartData.values[k] + '</td><td style="text-align:center;background-color:' + chartData.labels[k] + '">' + idx[k] + '%</td></tr>';
      }
    });
    str += '</tbody></table>';
    return str;

  }

  async function osDoughnutChart(chartData) {

    if (chartData.values.length > 0) {
      str = legendData(chartData);
      if (chartData.values.length > 20) {
        chartData.labels.length = chartData.values.length = lengthLimit;
      }

      const ctx = $('#osChart');
      if (osChart) {
        osChart.destroy();
        $(".scan-by-block .content-block#scanOS .row").css("max-height", "1000px");
        $(".scan-by-block .content-block#scanOS .norecords .no-records-wrp").remove();
        osChart = new Chart(ctx, configuration(chartData));
        $("#osLegend").html(str);
        $('.osChartWrap').show();

      } else {
        $(".scan-by-block .content-block#scanOS .row").css("max-height", "1000px");
        $(".scan-by-block .content-block#scanOS .norecords .no-records-wrp").remove();
        osChart = new Chart(ctx, configuration(chartData));
        $("#osLegend").html(str);
      }
    } else {
      if (osChart) {
        osChart.destroy();
      }
      $(".scan-by-block .content-block#scanOS .row").css("max-height", "0px");
      $(".scan-by-block .content-block#scanOS .norecords").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('analytics.no_data') ?></p></div>');
      $('#osLegend table').remove();
      $('.osChartWrap').hide();

    }
  }

  async function countryDoughnutChart(chartData) {
    if (chartData.values.length > 0) {
      str = legendData(chartData);
      if (chartData.values.length > 20) {
        chartData.labels.length = chartData.values.length = lengthLimit;
      }

      const ctx = $('#countryChart');
      if (countryChart) {
        countryChart.destroy();
        $(".scan-by-block .content-block#scanCountry .row").css("max-height", "1000px");
        $(".scan-by-block .content-block#scanCountry .norecords .no-records-wrp").remove();
        countryChart = new Chart(ctx, configuration(chartData));
        $("#countryLegend").html(str);
        $('.countryChartWrap').show();
      } else {
        $(".scan-by-block .content-block#scanCountry .row").css("max-height", "1000px");
        $(".scan-by-block .content-block#scanCountry .norecords .no-records-wrp").remove();
        countryChart = new Chart(ctx, configuration(chartData));
        $("#countryLegend").html(str);
      }
    } else {
      if (countryChart) {
        countryChart.destroy();
      }
      $(".scan-by-block .content-block#scanCountry .row").css("max-height", "0px");
      $(".scan-by-block .content-block#scanCountry .norecords").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('analytics.no_data') ?></p></div>');
      $('#countryLegend table').remove();
      $('.countryChartWrap').hide();


    }
  }

  async function cityDoughnutChart(chartData) {
    if (chartData.values.length > 0) {
      str = legendData(chartData);
      if (chartData.values.length > 20) {
        chartData.labels.length = chartData.values.length = lengthLimit;
      }


      const ctx = $('#cityChart');
      if (cityChart) {
        cityChart.destroy();
        $(".scan-by-block .content-block#scanCity .row").css("max-height", "1000px");
        $(".scan-by-block .content-block#scanCity .norecords .no-records-wrp").remove();
        cityChart = new Chart(ctx, configuration(chartData));
        $("#cityLegend").html(str);
        $('.cityChartWrap').show();

      } else {
        $(".scan-by-block .content-block#scanCity .row").css("max-height", "1000px");
        $(".scan-by-block .content-block#scanCity .norecords .no-records-wrp").remove();
        cityChart = new Chart(ctx, configuration(chartData));
        $("#cityLegend").html(str);
      }
    } else {
      if (cityChart) {
        cityChart.destroy();
      }
      $(".scan-by-block .content-block#scanCity .row").css("max-height", "0px");
      $(".scan-by-block .content-block#scanCity .norecords").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('analytics.no_data') ?></p></div>');
      $('#cityLegend table').remove();
      $('.cityChartWrap').hide();

    }
  }

  function configuration(chartData) {

    const legendMarginRight = {
      id: 'legendMarginRight',
      afterInit(chart, args, options) {
        const fitValue = chart.legend.fit;
        chart.legend.fit = function fit() {
          fitValue.bind(chart.legend)();
          let width = this.width = 200;
          return width;
        }
      }
    }

    const configuration = {
      type: 'doughnut',
      data: {
        labels: chartData.labels,
        datasets: [{
          data: chartData.values,
          backgroundColor: backgroundColor,
        }, ],
        hoverOffset: 4
      },
      options: {
        elements: {
          arc: {
            borderWidth: 0,
          }
        },
        plugins: {
          legend: {
            display: false,
          }
        },

      },
      plugins: [legendMarginRight]
    }

    return configuration;

  }
  // Doughnut Chart


  moment.tz.setDefault("UTC");

  $('#kt_daterangepicker_1').daterangepicker({
    autoUpdateInput: true,
    locale: <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>,
    autoApply: true,
    startDate: moment().subtract(6, 'days').format("ll"),
    endDate: moment().format("ll"),
    timePicker: false,
    maxDate: moment().format("ll"),
  }, (start, end) => {
    /* Redirect */
    setTimeout(function() {
      reloadData();
    }, 100);

  });

  let isDRPVisible = true;
  $('#kt_daterangepicker_1').on("click", (elm) => {
    const daterangepicker = $(".daterangepicker");
    if (!isDRPVisible && daterangepicker.css('display') == 'block') {
      daterangepicker.css('display', 'none');
    } else {
      isDRPVisible = false;
      daterangepicker.css('display', 'block');
    }
  })

  $('#kt_daterangepicker_1').on('hide.daterangepicker', () => {
    isDRPVisible = true;
  });

  $('#kt_daterangepicker_1').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('ll') + ' - ' + picker.endDate.format('ll'));
    $('#select_period').val('custom');
    $('#select_period').next('.btn-group');
    $('#select_period').next('.btn-group').children('button span').prop('disabled', 'Custom');
    $('#select_period').next('.btn-group').children('button').children('.multiselect-selected-text').text('Custom');
    var listItems = $('#select_period').next('.btn-group').children('ul').children('li');
    if ((listItems.hasClass('active'))) {
      listItems.removeClass('active');
      listItems.last().addClass('active');
    }
  });

  $(document).ready(function() {
    $('#picked-range').text(moment().subtract(6, 'days').format('ll') + ' - ' + moment().format('ll'));
  });

  $('#select_period').on('change', function() {
    switch (this.value) {
      case 'today':
        $('#kt_daterangepicker_1').val(moment().format('ll') + ' - ' + moment().format('ll'));
        $('#kt_daterangepicker_1').prop('disabled', false);
        $('#picked-range').text(moment().format('ll'));
        setTimeout(function() {
          reloadData();
        }, 100);
        break;
      case 'yesterday':
        $('#kt_daterangepicker_1').val(moment().subtract(1, 'days').format('ll') + ' - ' + moment().subtract(1, 'days').format('ll'));
        $('#kt_daterangepicker_1').prop('disabled', false);
        $('#picked-range').text(moment().subtract(1, 'days').format('ll'));
        setTimeout(function() {
          reloadData();
        }, 100);
        break;
      case 'week':
        $('#kt_daterangepicker_1').val(moment().subtract(6, 'days').format('ll') + ' - ' + moment().format('ll'));
        $('#kt_daterangepicker_1').prop('disabled', false);
        $('#picked-range').text(moment().subtract(6, 'days').format('ll') + ' - ' + moment().format('ll'));
        setTimeout(function() {
          reloadData();
        }, 100);
        break;
      case 'month':
        $('#kt_daterangepicker_1').val(moment().subtract(29, 'days').format('ll') + ' - ' + moment().format('ll'));
        $('#kt_daterangepicker_1').prop('disabled', false);
        $('#picked-range').text(moment().subtract(29, 'days').format('ll') + ' - ' + moment().format('ll'));
        setTimeout(function() {
          reloadData();
        }, 100);
        break;
      case 'quarter':
        $('#kt_daterangepicker_1').val(moment().subtract(89, 'days').format('ll') + ' - ' + moment().format('ll'));
        $('#kt_daterangepicker_1').prop('disabled', false);
        $('#picked-range').text(moment().subtract(89, 'days').format('ll') + ' - ' + moment().format('ll'));
        setTimeout(function() {
          reloadData();
        }, 100);
        break;
      case 'lifetime':
        if ('<?= $data->firstScanDate ?>' !== '') {
          $('#kt_daterangepicker_1').val(moment('<?= $data->firstScanDate ?>').format('ll') + ' - ' + moment('<?= $data->lastScanDate ?>').format('ll'));
          $('#picked-range').text(moment('<?= $data->firstScanDate ?>').format('ll') + ' - ' + moment('<?= $data->lastScanDate ?>').format('ll'));
          $('#kt_daterangepicker_1').prop('disabled', false);
        } else {
          $('#kt_daterangepicker_1').val('<?= str_replace("'", "\'", l('analytics.no_data_1')) ?>');
          $('#picked-range').text('<?= str_replace("'", "\'", l('analytics.no_data_1')) ?>');
          $('#kt_daterangepicker_1').prop('disabled', false);
        }
        setTimeout(function() {
          reloadData();
        }, 100);
        break;
      case 'custom':
        $("#kt_daterangepicker_1").focus();
        break;
      default:
        $('#kt_daterangepicker_1').prop('disabled', false);
    }
  });

  $(document).on('change', '.multiSelect', function() {
    reloadData()
  });
  let css = window.getComputedStyle(document.body)

  $("#exportBtn").click(function() {
    $('#exportModal').modal('show');

    var event = "all_click";

    var data = {
      "userId": "<?php echo $this->user->user_id ?>",
      "clicktext": "Export Info"
    }
    googleDataLayer(event, data);
  });


  $('#filterForm').submit(function(e) {
    e.preventDefault();
    $("#kt_daterangepicker_1").prop('disabled', false);
    this.submit();
    setTimeout(function() {
      $('#exportModal').modal('hide');
      if ($('#select_period').val() != 'custom') {
        $("#kt_daterangepicker_1").prop('disabled', true);
      }

    }, 100);
  });

  function reloadData() {
    var dateRange = $("#kt_daterangepicker_1").val();

    var form = $("#filterForm")[0];

    var formData = new FormData(form);

    formData.append('action', 'loadDashboardData');
    formData.append('date_range', dateRange);

    $.ajax({
      type: 'POST',
      url: '<?php echo url('api/ajax') ?>',
      data: formData,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: function(response) {
        var data = response.data.data;

        $("#totalScan").text(data['totalScan']);
        $("#totalUniqueScan").text(data['totalUniqueScan']);
        makeTableByOs(data['scan_by_os_rows'], 'scanByOs', data['totalScan']);
        makeGroupByTable(data['scan_by_country_rows'], 'scanByCountry', data['totalScan']);
        makeGroupByTable(data['scan_by_city_rows'], 'scanByCity', data['totalScan']);
        chart(data['chart_data']);
        osDoughnutChart(data['os_chart']);
        countryDoughnutChart(data['country_chart']);
        cityDoughnutChart(data['city_chart']);
      },
      error: () => {
        /* Re enable submit button */
        // submit_button.removeClass('disabled').text(text);
      },

    });
  }

  function makeTableByOs(rows, id, totalScan) {
    var trHtml = '';
    var totalScan = parseInt(totalScan)
    if (rows.length > 0) {
      rows.forEach(function each(row, index) {
        var rowTotalScan = parseInt(row[1]);
        var per = ((rowTotalScan * 100) / totalScan).toFixed(2);
        trHtml +=
          `<tr>
              <td class="opsystem">${row[0]}</td>
              <td class="scans">
                <div class="d-flex align-items-center">
                  <span class="number">${rowTotalScan}</span>
                  <div class="progress d-none">
                    <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: ${per}%" aria-valuenow="${per}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </td>
              <td class="percentage">${per}%</td>
          </tr>`;

      });
    } else {
      trHtml = `<tr><td colspan="3" class="no-data"><span><?= l('analytics.no_data') ?><span></td></tr>`
    }
    $(`#${id}`).find('tbody').html(trHtml);
  }

  function makeGroupByTable(rows, id, totalScan) {
    var trHtml = '';
    var totalScan = parseInt(totalScan)
    if (rows.length > 0) {
      rows.forEach(function each(row, index) {
        var rowTotalScan = parseInt(row[1]);
        var per = ((rowTotalScan * 100) / totalScan).toFixed(2);
        trHtml +=
          `<tr>
              <td class="">${index + 1}</td>
              <td class="name">${row[0]}</td>
              <td class="scans">
                <div class="d-flex align-items-center">
                  <span class="number">${rowTotalScan}</span>
                  <div class="progress d-none">
                    <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: ${per}%" aria-valuenow="${per}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </td>
              <td class="percentage">${per}%</td>
          </tr>`;

      });
    } else {
      trHtml = `<tr><td colspan="4" class="no-data"><span><?= l('analytics.no_data') ?><span></td></tr>`
    }
    $(`#${id}`).find('tbody').html(trHtml);
  }

  $(function() {

    $('#qrCode').multiselect({
      includeSelectAllOption: true,
      allSelectedText: '<?= l('analytics.all_select') ?>'
    });

    $("#qrCode").multiselect('selectAll', false);
    $("#qrCode").multiselect('updateButtonText');

  });

  $(function() {

    $('#citiesList').multiselect({
      includeSelectAllOption: true,
      nonSelectedText: '<?= l('analytics.none_select') ?>',
      allSelectedText: '<?= l('analytics.all_select') ?>'
    });

    $("#citiesList").multiselect('selectAll', false);
    $("#citiesList").multiselect('updateButtonText');

  });
  $(function() {

    $('#countryName').multiselect({
      includeSelectAllOption: true,
      nonSelectedText: '<?= l('analytics.none_select') ?>',
      allSelectedText: '<?= l('analytics.all_select') ?>'
    });

    $("#countryName").multiselect('selectAll', false);
    $("#countryName").multiselect('updateButtonText');

  });
  $(function() {

    $('#osName').multiselect({
      includeSelectAllOption: true,
      nonSelectedText: '<?= l('analytics.none_select') ?>',
      allSelectedText: '<?= l('analytics.all_select') ?>'
    });

    $("#osName").multiselect('selectAll', false);
    $("#osName").multiselect('updateButtonText');

  });

  function makeMultiSelect() {
    $('.multiSelectCities').multiselect({
      // buttonWidth : '160px',
      includeSelectAllOption: true,
      nonSelectedText: 'Select an Option'
    });
  }

  $(document).ready(function() {
    reloadData();
    makeMultiSelect()
    $('.multiSelect').multiselect({
      // buttonWidth : '160px',
      includeSelectAllOption: true,
      nonSelectedText: 'Select an Option'
    });
    //   /**ajax call */
  });

  function changeCities(thisObj) {

    var form = $("#filterForm")[0];
    var formData = new FormData(form);
    formData.append('action', 'loadCitiesData');

    $.ajax({
      type: 'POST',
      url: '<?php echo url('api/ajax') ?>',
      data: formData,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: function(response) {
        var data = response.data.data.cities;
        var trHtml = "";
        if (data.length > 0) {
          for (var k in data) {
            trHtml += `<option value="${data[k]['city_name']}"> ${data[k]['city_name']} </option>`;
          }
        }
        $('.multiSelectCities').multiselect('destroy');
        $('#citiesList').html(trHtml);
        makeMultiSelect()
      },
      error: () => {
        /* Re enable submit button */
        // submit_button.removeClass('disabled').text(text);
      },
    });
  }
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
<script src="<?= ASSETS_FULL_URL . 'js/customTooltip.js' ?>"></script>

<script type="text/javascript">
  // var qrFormPostUrl = "<?= url('analytics') ?>";

  new CustomToolTip({
    targetClass: 'ctp-tooltip',
    collision: '.all-qr-info-wrp',
    typoGraphy: {
      weight: 400
    },
    enableCollision: window.innerWidth >= 2560 ? false : true,
    enableTopCollision: false,
  });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>