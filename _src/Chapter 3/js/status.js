$(document).ready(function ($)
{    

var Status = {
    
    post: function () {
        var myname = 'M A Hossain Tonu', myimage = 'images/user/tonu.jpg';
        var loadingHtml = '<img src="images/ajaxload.gif" alt="loadin.."  border="0" >';
        var successMsg = 'Status Posted Successfully ...';
        var statusTxt = $('#status_box').val(), postStatus = $('#postStatus'); 

        if ((statusTxt.trim() !== '' && statusTxt !== 'Write your status here' 
            && statusTxt.length < 500) === false) return;

        postStatus.html(loadingHtml).fadeIn('slow');

        $.ajax({
            data: $('form').serialize(),
            url: 'index.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {

                if (response.success === true) {
                    
                    postStatus.html('<strong>'+successMsg+'</strong>');
                    
                    $('#status_box').val('');
                    
                    var statusHtml = $('#statusTemplate').html();
                    statusHtml = statusHtml
                                    .replace('#SRC', myimage)
                                    .replace('#NAME', myname)
                                    .replace('#STATUS', statusTxt)
                                    .replace('#TIME', Status.getLocalTimeStr());
                    
                    $('#container ul').prepend(statusHtml);
                    
                } else {
                    postStatus.html('<strong>' + response.error + '</strong>').fadeIn("slow");
                }

            },
            error: function () {}
        });
    },
    showLocalTime: function () {
        var spans = $('span.localtime[data-timestamp]');
        
        spans.each( function () {
            var localTimeStr  = Status.getLocalTimeStr( $(this).attr('data-timestamp') );
            $(this).html(localTimeStr);
        });
    },
    /**
     * returns time from unix timestamp
     */
    currentTime: function (timestamp) {
        
        if (typeof timestamp !== 'undefined' && timestamp !== '')
            var currentTime = new Date(timestamp * 1000);
        else
            var currentTime = new Date();
            
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var timeStr = '';
        if (minutes < 10) {
            minutes = "0" + minutes
        }
        timeStr = ((hours > 12) ? (hours - 12) : hours) + ":" + minutes + ' ';
        if (hours > 11) {
            timeStr += "PM";
        } else {
            timeStr += "AM";
        }
        return timeStr;
    },
    /**
     * returns date from unix timestamp
     */
    currentDate: function (timestamp) {
        var m_names = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        
        if (typeof timestamp !== 'undefined' && timestamp !== '')
            var d = new Date(timestamp * 1000);
        else
            var d = new Date();
            

        var curr_date = d.getDate();
        var curr_month = d.getMonth();
        var curr_year = d.getFullYear();
        var sup = "";
        if (curr_date === 1 || curr_date === 21 || curr_date === 31)
        {
            sup = "st";
        }
        else if (curr_date === 2 || curr_date === 22)
        {
            sup = "nd";
        }
        else if (curr_date === 3 || curr_date === 23)
        {
            sup = "rd";
        }
        else
        {
            sup = "th";
        }

        return m_names[curr_month] + ' ' + curr_date + sup + ', ' + curr_year;

    },
    /**
     * returns formatted local time date from timestamp
     */
    getLocalTimeStr: function (gmtTimestampInSec) {
        return 'at ' + this.currentTime(gmtTimestampInSec) 
            + ' on ' + this.currentDate(gmtTimestampInSec);
    }
};


$('#submit').click(function () {
    Status.post();
    return false;
});

Status.showLocalTime();

});