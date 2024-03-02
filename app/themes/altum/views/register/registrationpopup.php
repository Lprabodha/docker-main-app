<?php defined('ALTUMCODE') || die() ?>

<?= \Altum\Alerts::output_alerts() ?>

<style>
    .separator {
  display: flex;
  align-items: center;
  text-align: center;
}

.separator::before,
.separator::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #CDD1E0;
}

.separator:not(:empty)::before {
  margin-right: 1em;
}

.separator:not(:empty)::after {
  margin-left: 1em;
}

</style>

<?php if (settings()->google->is_enabled) : ?>
                <div class="mt-2">
                    <a href="<?= url('login/google-initiate') ?>" class="btn btn-light btn-block google-login">
                        <img src="<?= ASSETS_FULL_URL . 'images/google.svg' ?>" class="mr-1" />
                        <span><?= l('login.display.google-up') ?></span>
                    </a>
                </div>
                <div class="separator mt-3">o</div>    
            <?php endif ?>
            

<form action="<?php echo SITE_URL ; ?>/register?redirect=qr?step=1&lang=<?php echo \Altum\Language::$code ; ?>" method="post" class="" role="form" id="reg_form">
   <!-- <div class="form-group">
        <label for="name"><?= l('register.form.name') ?></label>
        <input id="name" type="text" name="name" class="form-control <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->values['name'] ?>" maxlength="32" required="required" autofocus="autofocus" />
        <?= \Altum\Alerts::output_field_error('name') ?>
    </div> -->

    <div class="form-group">
        <label for="email"><?= l('register.form.email') ?></label>
        <input id="regEmail" type="email" name="email" class="form-control regEmail <?= \Altum\Alerts::has_field_errors('email') ? 'is-invalid' : null ?>" value="<?= $data->values['email'] ?>" maxlength="128" autofocus="autofocus" />
        <?= \Altum\Alerts::output_field_error('email') ?>
    </div>

    <div class="form-group">
        <label for="password"><?= l('register.form.password') ?></label>
        <input id="password" type="password" name="password" class="form-control <?= \Altum\Alerts::has_field_errors('password') ? 'is-invalid' : null ?>" value="<?= $data->values['password'] ?>"  />
        <?= \Altum\Alerts::output_field_error('password') ?>
    </div>

    <?php if (settings()->captcha->register_is_enabled) : ?>
        <div class="form-group">
            <?php $data->captcha->display() ?>
        </div>
    <?php endif ?>

    <div class="form-group">
        <label>
            <?= sprintf(
                l('register.form.accept'),
                '<a href="' . settings()->main->terms_and_conditions_url . '" target="_blank">Terms and Conditions</a>',
                '<a href="' . settings()->main->privacy_policy_url . '" target="_blank">Privacy Policy</a>'
            ) ?>
        </label>
    </div>    

    <div class="form-group mt-1">
        <button id="registerButton" type="submit" name="submit" class="btn btn-primary btn-block"><?= l('register.form.register') ?></button>
    </div>  
    
    <div class="form-group text-center">
        <small class="text-muted">
            <?= sprintf(l('register.display.login'),'<a data-toggle="modal" id="sign-up" class="font-weight-bold" data-target="#loginModal" style="cursor: pointer; color: #ff9b06;" >' . l('register.display.login_help') . '</a>')  ?>
        </small>
    </div>

    <?php if (settings()->facebook->is_enabled || settings()->google->is_enabled || settings()->twitter->is_enabled || settings()->discord->is_enabled) : ?>
        <!-- <hr class="border-gray-100 my-3" /> -->

        <div class="">
            <?php if (settings()->facebook->is_enabled) : ?>
                <div class="mt-2">
                    <a href="<?= url('login/facebook-initiate') ?>" class="btn btn-light btn-block">
                        <img src="<?= ASSETS_FULL_URL . 'images/facebook.svg' ?>" class="mr-1" />
                        <?= l('login.display.facebook') ?>
                    </a>
                </div>
            <?php endif ?>
            
            <?php if (settings()->twitter->is_enabled) : ?>
                <div class="mt-2">
                    <a href="<?= url('login/twitter-initiate') ?>" class="btn btn-light btn-block">
                        <img src="<?= ASSETS_FULL_URL . 'images/twitter.svg' ?>" class="mr-1" />
                        <?= l('login.display.twitter') ?>
                    </a>
                </div>
            <?php endif ?>
            <?php if (settings()->discord->is_enabled) : ?>
                <div class="mt-2">
                    <a href="<?= url('login/discord-initiate') ?>" class="btn btn-light btn-block">
                        <img src="<?= ASSETS_FULL_URL . 'images/discord.svg' ?>" class="mr-1" />
                        <?= l('login.display.discord') ?>
                    </a>
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
</form>




<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>


<script>
    $(document).ready(function() {
        $('#regEmail').focus();
    });

        
    $("#reg_form").validate({
        rules:{
            email : {
                required : true,
                remote: {
                    url: "<?php echo url('api/ajax_new') ?>",
                    method:'POST',
                    type: 'POST',
                    data: {
                        action : 'check_duplicate_email',
                        email: function() {
							return $("#regEmail").val();
						}
                    }
                },
            },
            password : {
                required : true
            }
        },
        messages:{
            email : {
                required : "Email required"
            },
            password : {
                required : "Password required"
            }
        },
        errorClass:"error",
        errorPlacement: function(error, element)
        {
            if(element.attr("name") == "categoryId")
            {
                error.appendTo($('#category-Err'))
            }
            else if(element.attr("name") == "subcategoryId")
            {
                error.appendTo($('#subcategory-Err'))
            }
            else
            {
                error.insertAfter(element);
            }
            
        }   
    })



        
        $(".close").on("click" ,function(){
            $(".modal-backdrop").removeClass("modal-backdrop");
        })
        $("#sign-up").on( "click", function (){
            $("#registerModal").hide();
            $("#registerModal").removeClass("show");
            $("#registerModal").attr("aria-hidden","true"); 
            $("#registerModal").removeAttr('aria-modal');
            $("#registerModal").removeAttr('role');

            $(".modal-backdrop").removeClass("modal-backdrop");
        })
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>