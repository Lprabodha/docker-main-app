<script>
    let gtmId = '<?= GTM ?>';
    let gtagId = '<?= GTAG ?>';
    let gadsId = '<?= GADS ?>';
</script>


<!-- <script>
  var unique_id = '<?= (isset($user_session) ? $user_session->unique_id : (isset($this->user->user_id) ? $this->user->unique_id  :  null)) ?>';

    if (!unique_id) {
        setTimeout(() => {
            unique_id = '<?= isset($_COOKIE['unique_id']) &&  $_COOKIE['unique_id'] != '' ? $_COOKIE['unique_id'] : ''?>';
            // Push to dataLayer after setting the unique_id
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                unique_id: unique_id,
                userId: '<?= isset($this->user->user_id) ? ($this->user->type !== 2 ? $this->user->user_id : null)  : null ?>',
            });
        }, 5000);
    } else {
        // Push to dataLayer immediately if unique_id is already set
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            unique_id: unique_id,
            userId: '<?= isset($this->user->user_id) ? ($this->user->type !== 2 ? $this->user->user_id : null)  : null ?>',
        });
    }

</script> -->

<!-- Google Tag Manager -->
<script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', gtmId);
</script>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('set', {
        cookie_flags: 'SameSite=None;Secure'
    });
    gtag('config', gtagId);
    // gtag('config', gadsId,  {'allow_enhanced_conversions':true});
</script>
<!-- End Google Tag Manager -->