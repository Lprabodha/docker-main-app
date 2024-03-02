<?php defined('ALTUMCODE') || die() ?>
<style>
    li.page-item.act {
        position: relative;
    }

    li.page-item.act.arrows a {
        position: relative;
        z-index: -1;
        display: none;
    }

    li.page-item.act.left::after {
        content: "‹";
        left: -35px;
        /* background: blue; */
    }

    li.page-item:not(:last-child) {
        margin-right: 8px;
    }

    li.page-item.act.right::after {
        content: "›";
        right: -35px;
        /* background: red; */
    }

    .page-item .page-link {
        border-width: 2px;
        /* border-color: transparent; */
    }

    .page-item .page-link,
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        border-radius: 8px;
    }

    .page-item.active .page-link {
        color: #28C254;
        background-color: #f7f7f7;
        border-color: #28C254;
    }

    .page-link {
        color: #28C254;
    }

    .page-link:active {
        box-shadow: unset;
    }

    .page-link {
        background-color: #f7f7f7;
    }

    .page-link:hover {
        z-index: 2;
        color: #28C254;
        background-color: #F5F8FB;
        /* border-color: #28C254; */
    }

    li.page-item.arrows {
        font-size: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    li.page-item.arrows .page-link {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 12px;
    }

    li.page-item.act::after {
        /* position: absolute; */
        width: 34px;
        height: 35px;
        color: #cdcdcd;
        top: 0;
        z-index: 12;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #cdcdcd;
        border-radius: 8px;
        font-size: 32px;
        padding-bottom: 7px;
        /* opacity: 0; */
    }

    .pagination.mr34 {
        padding: 0 34px;
        margin-right: 35px;
    }

    @media (max-width: 991.98px) {
        .text-muted {
            text-align: center;
        }

        .pagination {
            justify-content: center;
            width: max-content;
        }

        li.page-item:not(:last-child) {
            margin-right: 4px;
        }

        @media (max-width: 480px) {
            li.page-item.act::after {
                width: 28px;
            }

            .pagination li.page-item.disabled span.page-link,
            .pagination li.page-item.arrows a.page-link,
            .pagination li.page-item a.page-link {
                padding-left: 8px;
                padding-right: 8px;
            }

            .pagination li.page-item.arrows a.page-link {
                width: 28px;
            }

            .pagination li.page-item.disabled span.page-link {
                padding-left: 6px;
                padding-right: 6px;
            }
        }
    }
</style>

<div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center">
    <div class="">
        <p class="text-muted">
            <?= sprintf(l('qr_codes.pagination.results'), $data->paginator->getCurrentPageFirstItem(), $data->paginator->getCurrentPageLastItem(), $data->paginator->getTotalItems()) ?>
        </p>
    </div>

    <div class="d-flex justify-content-center align-items-center px-3">
        <ul id="pagination" class="pagination <?php if ($data->paginator->getNextUrl()) {
                                                } else {
                                                    echo 'mx-auto';
                                                } ?>">
            <?php
            // if ($data->paginator->getPrevUrl()): 
            ?>
            <li class="page-item arrows paginate-icon <?php if ($data->paginator->getPrevUrl()) {
                                                        } else {
                                                            echo 'act left';
                                                        } ?>"><a href="<?= $data->paginator->getPrevUrl(); ?>" class="page-link" aria-label="<?= l('global.pagination.previous') ?>">‹</a></li>
            <?php
            // endif; 
            ?>

            <?php foreach ($data->paginator->getPages() as $page) : ?>               
                <?php if ($page['url']) : ?>
                    <li class="page-item paginate-icon <?= $page['isCurrent'] ? 'active' : ''; ?>">                        
                        <a href="<?= $page['url']; ?>" class="page-link paginate-icon"><?= $page['num']?></a>                       
                    </li>
                <?php else : ?>
                    <li class="page-item disabled"><span class="page-link paginate-icon"><?= $page['num']; ?></span></li>
                <?php endif; ?>
            <?php endforeach; ?>


            <li <?php echo ($data->paginator->getNextUrl() == null) ? 'disabled' : ''; ?> class="page-item arrows <?php if (!$data->paginator->getNextUrl()) : ?>act right<?php endif; ?>">
                <a href="<?php echo (!$data->paginator->getNextUrl() == null) ? $data->paginator->getNextUrl() : '#' ?>" class="page-link paginate-icon" aria-label="<?= l('global.pagination.next') ?>">›</a>

            </li>

        </ul>
        
    </div>
   
</div>

<script>
    $(".paginate-icon").on("click", function(e) {    
        // e.preventDefault();  
        if (window.matchMedia('(max-width: 576.98px)').matches) {
            $("html, body").animate({
                scrollTop: 5000
            }, 400);
        } else {
            $("html, body").animate({
                scrollTop: 5000
            }, 50);
        }
    });

  
</script>