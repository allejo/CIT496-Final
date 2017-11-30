$(document).ready(function() {
    // A 50% calculated score will be considered "weak"
    var WEAK_PASSWORD_THRESHOLD = 50;

    /**
     * Get a Bootstrap label class for using in a progress bar.
     *
     * @param {int} value A calculated scored based on 'zxcvbn'
     * @returns {string}
     */
    function getBootstrapClassification(value) {
        if (value <= WEAK_PASSWORD_THRESHOLD) {
            return 'danger';
        }

        if (value <= 75) {
            return 'warning';
        }

        return 'success';
    }

    $('#fos_user_registration_form_plainPassword_first').keyup(function () {
        var $this = $(this);
        var password = $this.val(),
            result = zxcvbn(password),
            score = Math.max(1, result.score * 25),
            message = ''
        ;

        if (result.feedback.warning) {
            message = result.feedback.warning;
        } else if (score <= WEAK_PASSWORD_THRESHOLD) {
            message = 'This password is weak';
        }

        // Get our elements
        var $strengthMsg = $("#strengthMsg");
        var $strengthBar = $("#strengthBar");

        // Set our information for the user to see
        $strengthMsg.html(message);
        $strengthBar
            .attr('class', 'progress-bar progress-bar-' + getBootstrapClassification(score))
            .attr('aria-valuenow', score)
            .css('width', score + '%')
        ;
    });
});
