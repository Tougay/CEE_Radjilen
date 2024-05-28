function ($) {
    "use strict";

   function initializeClock(id, endtime) {
        var daysSpan = $('.days');
        var hoursSpan = $('.hours');
        var minutesSpan = $('.minutes');
        var secondsSpan = $('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);

            daysSpan.html(t.days);
            hoursSpan.html(('0' + t.hours).slice(-2));
            minutesSpan.html(('0' + t.minutes).slice(-2));
            secondsSpan.html(('0' + t.seconds).slice(-2))

            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

    var examTimeLimit = parseInt('<?php echo $selExamTimeLimit; ?>') * 60 * 1000; // Convertir en millisecondes
    var deadline = Date.now() + examTimeLimit;
    initializeClock('clockdiv', deadline);

