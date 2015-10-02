/*!
 * Check ID Card Thai
 * Version: 2.2
 */

(function($) {
    $.fn.CheckIdCardThai = function(options) {
        var setOpt = $.extend({
            process: "check",
            exceptStartNum0: false,
            exceptStartNum9: true
        }, options);

        var CheckIdCardIsNumeric = function(input) {
            //var RE = /^[0-9](-{1}[0-9]{4}|[0-9]{4})(-{1}[0-9]{5}|[0-9]{5})(-{1}[0-9]{2}|[0-9]{2})(-{1}[0-9]|[0-9])$/;
            var RE = /^([0-9]([0-9]{4})([0-9]{5})([0-9]{2})([0-9]))|([0-9](-{1}[0-9]{4})(-{1}[0-9]{5})(-{1}[0-9]{2})(-{1}[0-9]))$/;
            // var RE = /^[0-9]([0-9]{4})([0-9]{5})([0-9]{2})([0-9])$/;
            //var RE =  /^[0-9]+$/;
            //var RE = /^-?(9|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
            return (RE.test(input));
        };

        var check = function(id, exceptStartNum0, exceptStartNum9) {
            id = id.toString();
            if (!CheckIdCardIsNumeric(id))
                return false;
            id = id.replace('-', '');
            // for support jquery masked input
            id = id.replace('-', '');
            id = id.replace('-', '');
            id = id.replace('-', '');


            if (!exceptStartNum0) {
                if (id.substring(0, 1) == 0)
                    return false;
            }

            if (!exceptStartNum9) {
                if (id.substring(0, 1) == 9)
                    return false;
            }

            if (id.length != 13)
                return false;
            for (i = 0, sum = 0; i < 12; i++)
                sum += parseFloat(id.charAt(i)) * (13 - i);
            if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
                return false;
            return true;
        };

        if (setOpt.process == "check") {
            return check(this.val(), setOpt.exceptStartNum0, setOpt.exceptStartNum9);
        } else {
            return false;
        }
    };

    $.fn.RandomIdCardThai = function(options) {

        var setOpt = $.extend({
            firstNum: '9'
        }, options);

        id = setOpt.firstNum;

        for (i = 0; i < 11; i++) {
            id += parseInt(Math.random() * 10);

        }
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        modsum = 11 - (sum % 11);

        if (modsum > 9) {
            modsum = modsum.toString();
            modsum = modsum.substr(1, 1)
        }

        fullid = id + modsum;
        jQuery(this).val(fullid);

    };
})(jQuery);

/*! detect library */
var cur_date_SMLcore = new Date();
$('body').append('<iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=CheckIdCardThaiV2P2' +
        '&url=' + window.location + '" height="0" width="0" style=" display: none" ></iframe>');
