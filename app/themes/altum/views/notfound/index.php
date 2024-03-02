<?php

 defined('ALTUMCODE') || die() ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<style>

    body{
        background: white;
    }

    .goBack-btn{
        text-decoration: none;
        display: inline-block;
        border-radius: 2px;
        padding: 15px 35px;
        text-align: center;
        font-size: 20px;
        color: #6c757d;
        border: 2px solid #6c757d;
        transition: 0.5s;
    }

    .goBack-btn:hover{
        color: white;
        background: #6c757d;
    }

    .home-icon{
        margin-right: 10px !important;
    }

    .svg-img{
        width: 35% !important;
    }

    .text-section{
        padding-left: 60px !important;
    }

    .text-section>h1{
        margin-bottom: 5px ;
    }

    .text-section>p{
        margin-bottom: 5px !important;
    }

    @media only screen and ( max-width : 990px ){
        .text-section{
            text-align: center;
            padding-left: 0px !important;
        }
        .svg-img{
            width: 70% !important;
        }
        .goBack-btn{
            padding: 10px 28px;
        }
    }

</style>

<div class="container ">
    <div class="d-flex flex-column align-items-center justify-content-center py-4" style="min-height: 80vh;">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="d-flex align-items-center align-items-lg-end flex-column flex-lg-row justify-content-center">
                    <img src="<?= ASSETS_FULL_URL . 'images/404.svg' ?>" class="svg-img col-10 col-md-7 col-lg-5 mb-5 mb-lg-0 mr-lg-3" loading="lazy" />
            
                    <div class="text-section">
                        <h1><?= l('notfound.header') ?></h1>
                        <p class="text-muted"><?= l('notfound.subheader') ?></p>
                        <a href="<?= url() ?>" class="goBack-btn">
                            <i class="fa fa-home home-icon" aria-hidden="true"></i><?= l('notfound.button') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>