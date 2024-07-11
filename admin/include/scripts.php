<!-- alert box -->

<script>
    function alert(type, msg, position='body') {
        let bs_class = (type == "success") ? "alert-success" : "alert-danger";
        let element = document.createElement('div');
        element.innerHTML = `
            <div class="alert ${bs_class}  alert-dismissible fadeOut fade show ml-auto position-fixed top-0 end-0" role="alert" style="z-index: 111111;">
                <strong class="me-3">${msg}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;


        if(position=='body'){
            document.body.append(element);
           

        } else{
            document.getElementById(position).appendChild(element);
        }

        setTimeout(remAlert, 3000);
    }

    //timer set for alert box kung gaano katagal magdisplay
    function remAlert(){
        document.getElementsByClassName('alert')[0].remove();
    }
</script>