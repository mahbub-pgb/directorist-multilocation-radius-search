jQuery(function ($) {

    function copyText(text, callback) {

        /* Modern API */
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(callback);
            return;
        }

        /* Fallback */
        const $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
        callback();
    }

    function ensureCopyButton() {

        // alert( 'tset' );

        $('.directorist-form-address-field input#address').each(function () {

            const $input = $(this);

            /* If already wrapped, skip */
            if ($input.closest('.address-copy-wrapper').length) {
                return;
            }

            /* Wrap input */
            $input.wrap('<div class="address-copy-wrapper"></div>');

            /* Create button */
            const $btn = $('<button>', {
                type: 'button',
                class: 'copy-address-btn',
                html: '📋',
                title: 'Copy address'
            });

            /* Create message */
            const $msg = $('<span>', {
                class: 'copy-message',
                text: 'Copied!'
            });

            /* Insert */
            $input.after($btn);
            $input.closest('.directorist-form-address-field').append($msg);

            /* Click handler (bound once) */
            $btn.on('click', function () {
                const value = $input.val();
                if (!value) return;

                copyText(value, function () {
                    $msg.stop(true, true).fadeIn(150);
                    setTimeout(() => $msg.fadeOut(300), 1500);
                });
            });

        });
    }

    /* 🔁 Watch every 500ms */
    setInterval(ensureCopyButton, 500);

});
