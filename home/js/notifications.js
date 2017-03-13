/**
 * Created by fauzi on 9/14/14.
 */
$(document).ready(function() {

    $('.viewAllNotice').click(function(){
        //alert($('#cmd').val());
        $.ajax({
            type: "POST",
            url: "process_notice.php",
            async: true, /* If set to non-async, browser shows page as "Loading.."*/
            cache: false,
            success: function(data){ /* called when request to barge.php completes */

            }
        });
    });

    waitForMsg(); /* Start the inital request */
    retrieveList();
});
function addmsg(type, msg){
    /* Simple helper to add a div.
     type is the name of a CSS class (old/new/error).
     msg is the contents of the div */
    //alert(msg);
    if(type=="count"){

        $(".badge").html(msg);

        if(msg > 0){
            $(".yellow").html('Anda mempunyai '+msg+' notis baru.');
        }else{
            $(".yellow").html('Anda tidak mempunyai notis baru.');
        }
    }

    if(type=="list"){
        $(".listNotice").html(msg);
    }

}
function retrieveList(){
    $.ajax({
        type: "POST",
        url: "listnotification.php",
        async: true, /* If set to non-async, browser shows page as "Loading.."*/
        cache: false,
        timeout:50000, /* Timeout in ms */

        success: function(data){ /* called when request to barge.php completes */
            addmsg("list", data); /* Add response to a .msg div (with the "new" class)*/
            setTimeout(
                retrieveList, /* Request next message */
                50000 /* ..after 5 seconds */
            );
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            addmsg("error", textStatus + " (" + errorThrown + ")");
            setTimeout(
                retrieveList, /* Try again after.. */
                150000); /* milliseconds (15seconds) */
        }
    });
}
function waitForMsg(){
    /* This requests the url "msgsrv.php"
     When it complete (or errors)*/
    $.ajax({
        type: "POST",
        url: "notification.php",
        async: true, /* If set to non-async, browser shows page as "Loading.."*/
        cache: false,
        timeout:300000, /* Timeout in ms */

        success: function(data){ /* called when request to barge.php completes */
            addmsg("count", data); /* Add response to a .msg div (with the "new" class)*/
            setTimeout(
                waitForMsg, /* Request next message */
                300000 /* ..after 5000 = 5 seconds 300k = 5 minit */
            );
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            addmsg("error", textStatus + " (" + errorThrown + ")");
            setTimeout(
                waitForMsg, /* Try again after.. */
                420000); /* milliseconds (15seconds) */
        }
    });
}