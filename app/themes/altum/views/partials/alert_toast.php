<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" id="alert-toast">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="alert_msg"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast()" aria-label="Close"></button>
    </div>
  </div>
</div>

<script>
  const toastLive = document.getElementById('liveToast')
  const toastContainer = document.getElementById('alert-toast');
  const toastMsg = document.getElementById('alert_msg');
  const toast = new bootstrap.Toast(toastLive,{delay:5000});

  //Alert Call Function
  function show_alert(mode,msg){
    toastMsg.innerText = msg;
    switch (mode) {
      case 'error':
        toastLive.style.background = "#fe4256";
        toastLive.style.color = "white";
        break;
      case 'success':
        toastLive.style.background = "#27be5c";
        toastLive.style.color = "white";
        break;
    }
    toastContainer.style.zIndex = 9999;
    toast.show()
  }

  function hideToast(){
    toast.hide();
    toastContainer.style.zIndex = -999;
  }

  function onClassChange(node, callback) {
    let lastClassString = node.classList.toString();

    const mutationObserver = new MutationObserver((mutationList) => {
      for (const item of mutationList) {
        if (item.attributeName === "class") {
          const classString = node.classList.toString();
          if (classString !== lastClassString) {
            callback(mutationObserver);
            lastClassString = classString;
            break;
          }
        }
      }
    });

    mutationObserver.observe(node, { attributes: true });

    return mutationObserver;
  }

  onClassChange(toastLive,()=>{
    if(toastLive.classList.contains('hide')){
      toastContainer.style.zIndex = -999;
    }
  });
</script>