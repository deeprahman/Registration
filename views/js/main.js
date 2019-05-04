jQuery(document).ready(function($){
    //Cache password

    let email =$("#input-email").keyup(()=>{setTimeout(emailFunction, 1000)});
    function emailFunction(){
        let cache_email = email.val();

        ajaxCall2(cache_email);
    }
    //Store the object of username input element
    let password =$("#input-name").keyup(()=>{setTimeout(passFunction, 1000)});
    function passFunction(){
        let cache_pass = password.val();

        ajaxCall(cache_pass);
    }


    function ajaxCall(cache_pass){
        //Minimizes the server request; Only call to the ajax function if there is a change in input
        if(ajaxCall.le === undefined){
            ajaxCall.le = 0;
        }
        if(ajaxCall.le !== cache_pass.length){
            ajaxCall.le = cache_pass.length;

            $.ajax({
                url:"./ajax/availability.php",
                dataType:"text",
                type:'post',
                data:{username:cache_pass},
                success:function (data) {
                    console.log(data);
                    if(data !== '1'){
                        $("#input-name+span").text("Username Not Available").css({'margin-bottom':'1rem','border-bottom':'2px solid lightgrey','display':'block','padding':'.2rem 0 .3rem .8rem'});
                    }else{
                        $("#input-name+span").text("Username Available").css({'margin-bottom':'1rem','border-bottom':'2px solid lightgrey','display':'block','padding':'.2rem 0 .3rem .8rem'});
                    }

                }
            });
        }
    }

    function ajaxCall2(cache_pass){
        //Minimizes the server request; Only call to the ajax function if there is a change in input
        if(ajaxCall.le === undefined){
            ajaxCall.le = 0;
        }
        if(ajaxCall.le !== cache_pass.length){
            ajaxCall.le = cache_pass.length;

            $.ajax({
                url:"./ajax/availability.php",
                dataType:"text",
                type:'post',
                data:{email:cache_pass},
                success:function (data) {
                    if(data !== '1'){

                        $("#input-email+span").text("Email Address Already Used").css({'margin-bottom':'1rem','border-bottom':'2px solid lightgrey','display':'block','padding':'.2rem 0 .3rem .8rem'});
                    }else{
                        $("#input-email+span").text("Email Address Not Used").css({'margin-bottom':'1rem','border-bottom':'2px solid lightgrey','display':'block','padding':'.2rem 0 .3rem .8rem'});
                    }

                }
            });
        }
    }


});