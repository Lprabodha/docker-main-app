<?php
$code = null;
$currentUser = $this->user;
if ($exchange_rate = exchange_rate($currentUser)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
} else {
    $code = 'USD';
}

if (get_user_currency($code)) {
    $currencySymbol = $symbol;
    $currency = $code;
} else {
    $currency = 'USD';
    $currencySymbol = '$';
}

// $total = get_plan_price($plan->plan_id, $code); 
// $monthlyPrice = get_plan_month_price($plan->plan_id, $code); 

?>


<div class="modal fade switchPlanModal" id="SwitchPlanModal" tabindex="-1" aria-labelledby="SwitchPlanModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content overflow-auto">
            <div class="section1 position-relative w-100 h-100" id="section1" style="display: flex;">
                <button 
                    type="button" 
                    class="sp-modal-close position-absolute top-0 end-0 text-muted pe-none" 
                    data-dismiss="modal" 
                    aria-label="Close" 
                    style="opacity: 0;scale:0.5;transition:0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)"
                    onclick="keepMonthly()"
                >
                    <span class="icon-failed d-block m-auto"></span>
                </button>
                <div class="modal-header d-flex flex-column gap-4 justify-content-center w-100">
                    <div class="title-container text-center">
                        <h3 class="title"><?= l('billing.switch_plan.step1.title') ?></h3>
                    </div>
                    <div class="sub-title text-center text-muted"><?= l('billing.switch_plan.step1.sub_title') ?></div>
                </div>
                <div class="switchPlan-modal-body d-flex align-items-center justify-content-center w-100">
                    <?php
                    $planDetails = [
                        3 => [
                            'planId' => '1',
                            'type' => l('billing.switch_plan.step1.plan_type.monthly'),
                            'discount' => '0',
                            'price' => get_plan_month_price(1, $code),
                            'disPrice' => '0',
                            'desc' => l('billing.switch_plan.step1.plan_desc.monthly'),
                            'symbol' => $currencySymbol
                        ],
                        1 => [
                            'planId' => '2',
                            'type' => l('billing.switch_plan.step1.plan_type.annually'),
                            'discount' => '60',
                            'price' => get_plan_month_price(1, $code),
                            'disPrice' =>  get_plan_month_price(2, $code),
                            'desc' => l('billing.switch_plan.step1.plan_desc.annually'),
                            'symbol' => $currencySymbol
                        ],
                        2 => [
                            'planId' => '3',
                            'type' => l('billing.switch_plan.step1.plan_type.quarterly'),
                            'discount' => '40',
                            'price' => get_plan_month_price(1, $code),
                            'disPrice' => get_plan_month_price(3, $code),
                            'desc' => l('billing.switch_plan.step1.plan_desc.quarterly'),
                            'symbol' => $currencySymbol
                        ],
                    ];
                    ?>

                    <div class="container-fluid sp-container d-none d-sm-flex">
                        <?php foreach ($planDetails as $plan) {
                            PlanCardComp($plan);
                        } ?>
                    </div>

                    <div class="d-flex flex-column d-sm-none mobile-plan-cards w-100">
                        <?php ksort($planDetails);
                        foreach ($planDetails as $plan) : ?>
                            <div class="d-flex w-100 w-sm-75 align-items-center justify-content-center position-relative">
                                <?php $plan['planId'] != '1' ? DiscountBadge($plan['discount'], 'border shadow-sm mx-0', false) : null ?>
                                <?php PlanCardMobileComp($plan) ?>
                            </div>
                        <?php endforeach ?>
                        <button class="btn mx-auto d-block add-to-cart sp-buy-btn sp-buy-btn-fill w-100 fw-bold" onclick='goToSection(1,2,<?= json_encode($planDetails[1]) ?>)' id="step1GoBtn"><?= l('billing.switch_plan.package.footer_btn.continue') ?></button>
                    </div>

                </div>
                <div class="switchPlan-modal-footer text-center d-flex flex-column justify-content-center mt-3 mt-sm-4 mb-2">
                    <p class="text-muted mb-3"><?= l('billing.switch_plan.step1.footer.heading_1') ?></p>
                    <p class="text-muted sp-footer-desc"><?= sprintf(l('billing.switch_plan.step1.footer.heading_2'), (new \DateTime($this->user->plan_expiration_date))->format('Y-m-d')) ?></p>
                    <p class="text-muted sp-footer-desc mt-1"><?= sprintf(l('billing.switch_plan.step1.footer.heading_3')) ?></p>
                </div>
            </div>
            <div class="section2 position-relative w-100 h-100" id="section2" style="display: none;">
                <!-- <div class="d-flex flex-column align-items-center justify-content-center"> -->
                    <button type="button" class="sp-modal-close position-absolute top-0 end-0 text-muted" data-dismiss="modal" aria-label="Close" onclick="keepMonthly()">
                        <span class="icon-failed d-block m-auto"></span>
                    </button>
    
                    <div class="modal-header d-flex flex-column gap-3 gap-sm-4 justify-content-center w-100 mt-4 mt-sm-5"> 
                        <div class="title-container text-center">
                            <h2 class="title">...</h2>
                        </div>
                        <div class="sub-title text-center text-muted">
                            <p class="mb-2 mb-sm-3">...</p>
                            <span>...</span>
                        </div>
                    </div>
        
                    <div class="sp-modal-body d-flex w-100 flex-column justify-content-center align-items-center mt-4">
                        <div class="d-flex w-100 w-sm-75 align-items-center justify-content-center position-relative mt-0 mt-md-5">
                            <?php DiscountBadge(60,'border shadow-sm',false) ?>
                            
                            <?php BillCardComp() ?> 
    
                        </div>
                        <div class="d-flex flex-column-reverse flex-sm-row gap-3 btn-footer mb-2">
                            <button 
                                class="btn mx-auto d-block add-to-cart sp-buy-btn sp-buy-btn-outline"
                                onclick="goToSection(2,1)"
                            ><?=l('billing.switch_plan.step2.go_back_btn')?></button>
                            <button 
                                class="btn mx-auto d-block add-to-cart sp-buy-btn sp-buy-btn-fill"
                                id="planSwitchBtn"
                                onclick="switchPlan(this)"
                            ><?=l('billing.switch_plan.step2.switch_btn')?></button>
                        </div>
                    </div>
                <!-- </div>  -->
            </div>
            <div class="section3 position-relative h-100" id="section3" style="display: none;">
    
                <button type="button" class="sp-modal-close position-absolute top-0 end-0 text-muted" data-dismiss="modal" aria-label="Close" onclick="keepMonthly()">
                    <span class="icon-failed"></span>
                </button>
    
                <div class="sp-modal-body h-100 w-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="w-100 w-sm-50 text-center mb-5">
                        <h1 class="fw-bold"><?=l('billing.switch_plan.step3.title')?></h1>
                        <h6 class="px-3 mt-4"><?=l('billing.switch_plan.step3.sub_title')?></h6>
                    </div>
                    <div class="d-flex justify-content-center flex-column-reverse flex-sm-row gap-3 btn-footer">
                        <button 
                            class="btn mx-auto d-block add-to-cart sp-buy-btn sp-buy-btn-outline sp-close-outline-btn"
                            data-dismiss="modal" aria-label="Close"
                        ><?=l('billing.switch_plan.step3.close_btn')?></button>
                        <button 
                            class="btn mx-auto d-block add-to-cart sp-buy-btn sp-buy-btn-fill"
                            onclick="javascript:location.href='<?=url('qr-codes')?>'"
                        ><?=l('billing.switch_plan.step3.go_dashboard_btn')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php function DiscountBadge($discount,$StyleClass=null,$pill=true){ ?>
    <div class="sp-discount-area d-flex justify-content-center align-items-center <?= $pill ?'rounded-pill':'' ?> <?=$StyleClass?>">
        <div class="present-icon-bg my-auto rounded-circle">
            <span>%</span>
        </div>
        <span class="discount-detail"> <?=str_replace('{discount}',$discount,l('billing.switch_plan.discount'))?></span>
    </div>
<?php } ?>

<?php function BillCardComp(){ ?>
    <div class="sp-plan-card">
        <div class="d-flex align-items-center align-sm-items-start justify-content-between mt-2 mt-sm-4">
            <h3 class="fw-bold plan-name">...</h3>
            <div class="text-right">
                <div class="position-relative">
                    <!-- <div class="position-absolute top-50 start-50 sp-brush-line sp-brush-line-middle"></div> -->
                    <h5 class="fw-bold plan-price">...</h5>
                </div>
                <h3 class="fw-bold discounted-price">...</h3>
            </div>
        </div>
        <hr class="card-hr mt-2 mb-3 top-hr mx-3">
        <div class="d-flex align-items-center mt-2 mt-sm-1 justify-content-between">
            <h3 class="fw-bold total-plan-label"><?=l('billing.switch_plan.step2.total')?></h3>
            <div class="text-right">
                <h2 class="fw-bold total-price">...</h2>
                <p class="text-muted total-price-footer">...</p>
            </div>
        </div>
    </div>
<?php } ?>

<?php function PlanCardMobileComp($plan){ ?>
    <div 
        class="sp-plan-card shadow-sm <?=$plan['planId'] == '2' ? 'sp-plan-card-active' : ''?>" 
        id="plan_<?=$plan['planId']?>"
        onclick='activeCheckMark(<?=json_encode($plan)?>)'
    >
        <div 
            class="d-flex align-items-center align-sm-items-start justify-content-between <?=$plan['planId'] != '1' ? 'mt-2 mt-sm-4':null?>"
            <?=$plan['planId'] == '1' ? 'style="height:50px;"' : null ?>
        >
            <div class="d-flex align-items-center gap-2">
                <div 
                    class="radio-check <?=$plan['planId'] == '2' ? 'radio-check-active' : ''?>" 
                    id="planCheck_<?=$plan['planId']?>">
                </div>
                <div>
                    <?php if($plan['planId'] == '1'): ?>
                    <div class="d-flex align-items-center plan-name-section">
                        <h4 class="fw-bold plan-name" ><?=l('billing.switch_plan.step1.keep_monthly_plan')?></h4>
                        <!-- <h4 class="fw-bold plan-name" ><?=l('billing.switch_plan.package.current_plan')?></h4> -->
                        <!-- <small class="fw-bold ml-1"><?=l('billing.switch_plan.package.(monthly)')?></small> -->
                    </div>
                    <?php else: ?>
                        <h4 class="fw-bold plan-name"><?=str_replace('{plan}',$plan['type'],l('billing.switch_plan.plan_name_label'))?></h4>
                    <?php endif ?>
                    <p class="text-muted mt-1 invoice-label"><?=$plan['desc']?></p>
                </div>
            </div>
            <div class="text-right <?=$plan['planId'] != '1' ? 'prices-sec': ''?> m-price-container-dynamic">
            <?php if($plan['planId'] == '1'): ?>
                <h3 class="fw-bold discounted-price"><?=str_replace(['{symbol}','{price}'],[$plan['symbol'],custom_currency_format($plan['price'])],l('billing.switch_plan.monthly_prices'))?></h3>
            <?php else: ?>
                <div class="position-relative">
                    <div class="position-absolute top-50 start-50 sp-brush-line sp-brush-line-middle"></div>
                    <h5 class="fw-bold plan-price"><?=str_replace(['{symbol}','{price}'],[$plan['symbol'],custom_currency_format($plan['price'])],l('billing.switch_plan.monthly_prices'))?></h5>
                </div>
                <h3 class="fw-bold discounted-price"><?=str_replace(['{symbol}','{price}'],[$plan['symbol'],custom_currency_format($plan['disPrice'])],l('billing.switch_plan.monthly_prices'))?></h3>
            <?php endif ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php function PlanCardComp($plan) { ?>
    <div class="package col-xl-4 mx-auto col-id-2 px-0">
        <div class="annual-full-card-wrapper">
            <div class="annual-full-card">
                <button 
                    type="button" 
                    class="btn mx-auto d-block rounded-pill sp-plan-btn sp-plan-btn-<?= $plan['planId'] == '1' ? 'outline' : 'fill' ?>" 
                    <?= $plan['planId'] == '1' ? 'style="cursor:auto;"' : 'onclick=\'goToSection(1,2,' . json_encode($plan) . ')\'' ?>
                >
                    <?= $plan['type'] ?>
                </button>
                <div class="plan-card mx-auto monthly-plan">
                    <div class="sp-package-header default-header">
                        <?php $plan['planId'] != '1' ? DiscountBadge($plan['discount'], 'my-2') : null ?>

                        <?php if ($plan['planId'] == '1') : ?>
                            <div class="package-header default-header mt-0 text-center" >
                            <!-- <div class="package-header default-header mx-4" style="margin-top:10px;margin-bottom:16px"> -->
                                <h4 class="package-header-topHeading my-2"><?=l('billing.switch_plan.package.current_plan')?></h4>
                                <h2 class="package-header-heading pl-0 current-package-header">
                                    <?= str_replace(['{symbol}', '{price}'], [$plan['symbol'],custom_currency_format($plan['price'])], l('billing.switch_plan.monthly_prices')) ?>
                                </h2>
                                <!-- USD -->
                                <p class="package-subheader mt-2 pl-0"><?=$plan['desc']?></p>
                            </div>
                        <?php else : ?>
                            <div class="sp-price-area d-flex align-items-center flex-column justify-contents-center">

                                <h2 class="new-package-header-heading price-container-dynamic">
                                    <span class="strike-price m-price"><?= str_replace(['{symbol}', '{price}'], [$plan['symbol'],custom_currency_format($plan['price'])], l('billing.switch_plan.monthly_prices')) ?></span>
                                    <span class="shown-price disPrice"><?= str_replace(['{symbol}', '{price}'], [$plan['symbol'],custom_currency_format($plan['disPrice'])], l('billing.switch_plan.monthly_prices')) ?></span>                                                                           
                                </h2>

                                <!-- <div class="sp-arrow-right"></div>
                                <div class="d-flex align-items-center gap-3 price-container-dynamic">
                                    <div class="position-relative" >
                                        <div class="position-absolute top-50 start-50 translate-middle sp-brush-line"></div>
                                        <h5 class="fw-bold m-price">
                                            <?= str_replace(['{symbol}', '{price}'], [$plan['symbol'],custom_currency_format($plan['price'])], l('billing.switch_plan.monthly_prices')) ?>
                                        </h5>
                                    </div>
                                    <h4 class="fw-bold disPrice">
                                        <?= str_replace(['{symbol}', '{price}'], [$plan['symbol'],custom_currency_format($plan['disPrice'])], l('billing.switch_plan.monthly_prices')) ?>
                                    </h4>
                                </div> -->
                                <!-- <div class="w-100"> -->
                                    <p class="package-subheader mt-2 pl-0"><?=$plan['desc']?></p>
                                <!-- </div> -->
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="buy-btn-area">
                        <hr class="card-hr my-3 top-hr mx-3">
                        <button class="<?= $plan['planId'] == '1' ? 'current-sw-plan-btn' : '' ?> btn mx-auto d-block rounded-pill add-to-cart sp-buy-btn sp-buy-btn-<?= $plan['planId'] == '1' ? 'outline' : 'fill' ?>" <?= $plan['planId'] == '1' ? 'data-dismiss="modal" onclick="keepMonthly()" aria-label="Close"' : 'onclick=\'goToSection(1,2,' . json_encode($plan) . ')\'' ?>>
                                <?= $plan['planId'] == '1' ? l('billing.switch_plan.package.footer_btn.keep') : l('billing.switch_plan.package.footer_btn.continue') ?>
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>

    $(".sp-close-outline-btn").on( "click", function() {
        $(".sp-modal-close").trigger("click");
    });

    const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50" class="new-spinner"><circle r="20" cy="50" cx="50"></circle></svg></div>`;

    function switchPlanModalOpened(){
        const SWP_Modal = $("#SwitchPlanModal");
        SWP_Modal.css( "display", "block" )
        SWP_Modal.css( "opacity", 1 )
        SWP_Modal.addClass("show");
        SWP_Modal.removeClass("fade");
        $(document.body).css('overflow','hidden');

        const closeBtn = $('.section1 .sp-modal-close');
        setTimeout(()=>{
            closeBtn.css('opacity','1');
            closeBtn.css('scale','1');
            closeBtn.removeClass('pe-none');
        },10000)
    }

    // $( ".sp-modal-close" ).on( "click",spModalClose);

    async function spModalClose(){
        const SWP_Modal = $("#SwitchPlanModal");
        SWP_Modal.css('opacity',0);
        await setTimeout(()=>{
            SWP_Modal.css( "display", "none" );
            SWP_Modal.removeClass("show");
            $(document.body).css('overflow','auto');
        },600)
    }

    function stringReplace(string,replace){
        const regexp = new RegExp(Object.keys(replace).join('|'),"gi");
        return string.replace(regexp,(match)=>{
            return replace[match];
        })
    }

    function goToSection(currPos,pos,props=null){

        if(props){ dynamicSection(pos,props) }

        const CurrSection = $(`#section${currPos}`);
        const section = $(`#section${pos}`);

        CurrSection.animate({
            opacity: 0
        }, 100, () => {
            CurrSection.css('display', 'none');
            section.css('display', 'flex');
            $('.modal-content').scrollTop(0)
            section.animate({
                opacity: 1
            }, 100);
        })

    }

    function dynamicSection(sectionNo, data) {

        const {planId,discount,disPrice,price,type,symbol,desc} = data;
        const expireDate = '<?= (new \DateTime($this->user->plan_expiration_date))->format('Y-m-d') ?>';
        let total = 0;

        if (sectionNo === 2) {
            const section = $(`#section${sectionNo}`);
            switch (planId) {
                case '2':
                    total = (Number(disPrice) * 12).toFixed(2);
                    section.find('.title').text('<?= l('billing.switch_plan.step2.title.annually') ?>');
                    section.find('.sub-title>p').html(stringReplace('<?= l('billing.switch_plan.annually_step2.sub_title1') ?>', {
                        '{expireDate}': expireDate,
                        '{totalPrice}':`<strong class="sw-price">${symbol} ${number_format(total)}</strong>`
                    }));
                    section.find('.sub-title>span').text('<?= l('billing.switch_plan.annually_step2.sub_title2') ?>');
                    section.find('.discount-detail').text(stringReplace('<?= l('billing.switch_plan.discount') ?>', {
                        '{discount}': discount
                    }));
                    section.find('.plan-name').text('<?= l('billing.switch_plan.step2.plan_label.annual') ?>');
                    section.find('.plan-price').text(stringReplace('<?= l('billing.switch_plan.monthly_prices') ?>', {
                        '{symbol}': symbol,
                        '{price}': number_format(price)
                    }));
                    section.find('.discounted-price').text(stringReplace('<?= l('billing.switch_plan.monthly_prices') ?>', {
                        '{symbol}': symbol,
                        '{price}': number_format(disPrice.toFixed(2))
                    }));
                    section.find('.total-price').text(`${symbol} ${number_format(total)}`);
                    section.find('.total-price-footer').text(desc);
                    break;
                case '3':
                    total = (Number(disPrice) * 3).toFixed(2);
                    section.find('.title').text('<?= l('billing.switch_plan.step2.title.quarterly') ?>');
                    section.find('.sub-title>p').html(stringReplace('<?= l('billing.switch_plan.quarterly_step2.sub_title1') ?>', {
                        '{expireDate}': expireDate,
                        '{totalPrice}':`<strong class="sw-price">${symbol} ${number_format(total)}</strong>`
                    }));
                    section.find('.sub-title>span').text('<?= l('billing.switch_plan.quarterly_step2.sub_title2') ?>');
                    section.find('.discount-detail').text(stringReplace('<?= l('billing.switch_plan.discount') ?>', {
                        '{discount}': discount
                    }));
                    section.find('.plan-name').text('<?= l('billing.switch_plan.step2.plan_label.quarterly') ?>');
                    section.find('.plan-price').text(stringReplace('<?= l('billing.switch_plan.monthly_prices') ?>', {
                        '{symbol}': symbol,
                        '{price}': number_format(price)
                    }));
                    section.find('.discounted-price').text(stringReplace('<?= l('billing.switch_plan.monthly_prices') ?>', {
                        '{symbol}': symbol,
                        '{price}': number_format(disPrice.toFixed(2)),
                    }));
                    section.find('.total-price').text(`${symbol} ${number_format(total)}`);
                    section.find('.total-price-footer').text('<?=l('billing.switch_plan.step2.quarterly_desc')?>');
                    break;
                default:
                    break;
            }
            if(symbol=='Ch$'){
                section.find('.sp-brush-line').addClass('-chd');
            }
        }
        $("#planSwitchBtn")[0].planData = {total: total,...data};
    }

    function activeCheckMark(SelectedPlanData) {
        $('.mobile-plan-cards .sp-plan-card').each((i, card) => {
            if ($(card).find('.radio-check')[0].id == `planCheck_${SelectedPlanData?.planId}`) {
                card.classList.add('sp-plan-card-active');
                $(card).find('.radio-check').addClass('radio-check-active');

                const step1GoBtn = $('#step1GoBtn');
                if (SelectedPlanData?.planId == '1') {
                    step1GoBtn.text('<?= l('billing.switch_plan.package.footer_btn.keep') ?>')
                        .attr('data-dismiss', "modal")
                        .attr('aria-label', "Close")
                        .attr('onclick','keepMonthly()');
                } else {
                    step1GoBtn.text('<?= l('billing.switch_plan.package.footer_btn.continue') ?>')
                        .removeAttr('data-dismiss', "modal")
                        .removeAttr('aria-label', "Close")
                        .attr('onclick', `goToSection(1,2,${JSON.stringify(SelectedPlanData)})`)
                }

            } else {
                card.classList.remove('sp-plan-card-active');
                $(card).find('.radio-check').removeClass('radio-check-active');
            }
        })
    }

    function switchPlan(e) {
        const switchBtnHtml = $("#planSwitchBtn").html();
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax_new') ?>',
            data: {
                user_id: '<?= $this->user->user_id ?>',
                discount: e.planData.discount,
                plan_id: e.planData.planId,
                action: 'switch_plan',
            },
            beforeSend:function(){
                $("#planSwitchBtn").html(spinnerHTML);
            },
            success: function(response) {
                $("#planSwitchBtn").html(switchBtnHtml);
                if (response.data.complete) {
                    goToSection(2,3,{})
                } else {
                    show_alert('error',response.data.error);
                }
            },
            error:function(e){
                show_alert('error',e.responseJSON?.errors?.error);
                $("#planSwitchBtn").html(switchBtnHtml);
            }
        });
    }

    function keepMonthly() {

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax_new') ?>',
            data: {
                user_id: '<?= $this->user->user_id ?>',
                action: 'keep_monthly',
            },
            success: function(response) {
                if (response.data.result == true) {
                    spModalClose();
                }
            }

        });
    }
    
    $(document).ready(dynamicStylesForCurrencySymbols);
    $(window).resize(dynamicStylesForCurrencySymbols);
    
    function dynamicStylesForCurrencySymbols(e) {
        if(innerWidth > 375){
            return false; //Disabled
            $('.price-container-dynamic').each((i,e)=>{
                const disPriceText = $(e).find('.disPrice');
                const mPriceText = $(e).find('.m-price');
                const brushLine = $(e).find('.sp-brush-line');
                
                //Discounted Price Label
                [
                    {count:15,
                        size:{default:24,xxl:18,xl:17,lapXl:21,ipad:14,lap:15,md:13}
                    },
                    {count:13,
                        size:{default:21,xxl:19,lapXl:17,xl:19,ipad:15,lap:18,md:19}
                    },
                    {count:12,
                        size:{default:24,xxl:24,xl:22,lapXl:24,lap:19,ipad:17,md:18,lap2Xl:23}
                    },
                    {count:11,
                        size:{default:24,xxl:22,xl:20,lapXl:20,lap:23,ipad:17,md:18,lap2Xl:23}
                    },
                    {count:10,
                        size:{default:24,xxl:22,xl:20,lapXl:24,lap:23,ipad:17,md:18,lap2Xl:23}
                    }
                ].forEach((v,i)=>{
                    if(disPriceText.text().trim().length <= v.count){
                        disPriceText.css('fontSize',`${responsive(v.size)}px`);
                    }
                });

                //Monthly Price Label
                [
                    {count:15,
                        size:{default:20,xxl:15,xl:14,lapXl:16,ipad:13,lap:12,md:12},
                        brushWidth:{default:155,xxl:155,lapXl:125,xl:130,ipad:125,lap:112,md:110}
                    },
                    {count:13,
                        size:{default:17,xxl:16,lapXl:14,xl:15,ipad:13,lap:15,md:15},
                        brushWidth:{default:155,xxl:140,lapXl:125,xl:135,ipad:110,lap:115}
                    },
                    {count:12,
                        size:{default:18,xxl:18,lapXl:18,lap:15,ipad:15,md:14},
                        brushWidth:{default:115,xxl:115,xl:135,lapXl:100,lap2Xl:135}
                    },
                    {count:11,
                        size:{default:18,xxl:18,lapXl:15,lap:19,ipad:15,md:14,lap2Xl:20},
                        brushWidth:{default:115,xxl:115,xl:135,lapXl:100,lap2Xl:135}
                    }
                ].forEach((v,i)=>{
                    if(mPriceText.text().trim().length <= v.count){
                        mPriceText.css('fontSize',`${responsive(v.size)}px`);
                        brushLine.width(`${responsive(v.brushWidth)}px`);
                    }
                });


            })

            // Monthly Card's Monthly Price Label
            const monthlyCardPrice = $('.section1 .package-header-heading');
            
            [
                {count:15,
                    size:{default:24,xxl:19,xl:23,lapXl:19,ipad:20,lap:22,md:20}
                },
                {count:13,
                    size:{default:24,xxl:22,lapXl:20,md:21,lap:19,lap2Xl:20}
                },
                {count:12,
                    size:{default:29,xxl:24,lapXl:23,ipad:28,lap:28,md:26,lap2Xl:23}
                },
                {count:11,
                    size:{default:29,xxl:25,lapXl:22,ipad:27,lap:19,md:25,xl:25}
                }
            ].forEach((v,i)=>{
                if(monthlyCardPrice.text().trim().length <= v.count){
                    monthlyCardPrice.css("fontSize",`${responsive(v.size)}px`);
                }
            })
        }else {
            $('.m-price-container-dynamic').each((i,e)=>{
                const disPriceText = $(e).find('.discounted-price');
                const mPriceText = $(e).find('.plan-price');
                const brushLine = $(e).find('.sp-brush-line');

                [
                    {count:15,
                        size:{default:14}
                    },
                    {count:11,
                        size:{default:17}
                    }
                ].forEach((v,i)=>{
                    if(disPriceText.text().trim().length <= v.count){
                        disPriceText.css('fontSize',`${responsive(v.size)}px`);
                    }
                });

                [
                    {count:15,
                        size:{default:12},
                        brushWidth:{default:155}
                    },
                    {count:11,
                        size:{default:13},
                        brushWidth:{default:115}
                    }
                ].forEach((v,i)=>{
                    if(mPriceText.text().trim().length <= v.count){
                        mPriceText.css('fontSize',`${responsive(v.size)}px`);
                        brushLine.width(`${responsive(v.brushWidth)}px`);
                    }
                });
            });
        }
    }

    function responsive(breakPoints){
        if(innerWidth >= 2560){
            return breakPoints?.xxl || breakPoints?.default;
        }
        else if((innerWidth >= 1920) && (innerHeight >= 971)){
            return breakPoints?.lap2Xl || breakPoints?.default;
        }
        else if((innerWidth >= 1517) && (innerHeight >= 734)){
            return breakPoints?.lapXl || breakPoints?.default;
        }
        else if(innerWidth >= 1440){
            return breakPoints?.xl || breakPoints?.default;
        }
        else if(innerWidth >= 1024 && innerHeight >= 1292){
            return breakPoints?.ipad || breakPoints?.default;
        }
        else if(innerWidth >= 1024){
            return breakPoints?.lap || breakPoints?.default;
        }
        else if(innerWidth <= 1025 && innerWidth >= 769){
            return breakPoints?.md || breakPoints?.default;
        }
        else if(innerWidth >= 375){
            return breakPoints?.xsm || breakPoints?.default;
        }
        else{
            return breakPoints?.default;
        }
    }

</script>