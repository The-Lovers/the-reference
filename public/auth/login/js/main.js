(function ($) {
    "use strict";

    let form = $('#loginForm');
    let passwordInput = $('input[name="password"]');
    let loginBtn = $('#loginBtn');

    // ===== PASSWORD LIVE CHECK =====
    passwordInput.on('keyup', function () {
        let val = $(this).val();

        toggleRule('length', val.length >= 8);
        toggleRule('uppercase', /[A-Z]/.test(val));
        toggleRule('lowercase', /[a-z]/.test(val));
        toggleRule('number', /[0-9]/.test(val));
        toggleRule('special', /[@$!%*#?&]/.test(val));
    });

    function toggleRule(rule, valid) {
        let el = $('.password-rules p[data-rule="' + rule + '"]');
        el.toggleClass('valid', valid);
        el.html((valid ? '✅' : '❌') + ' ' + el.text().replace(/^✅ |^❌ /, ''));
    }

    // ===== FORM SUBMIT =====
    form.on('submit', function (e) {
        e.preventDefault();

        if (loginBtn.prop('disabled')) return;

        $('.error').text('');
        $('.alert-validate').removeClass('alert-validate');

        loginBtn.prop('disabled', true);
        $('.btn-text').text('Connexion...');
        $('.btn-loader').show();

        $.ajax({
            url: form.attr('action'),
            method: "POST",
            data: form.serialize(),
            success: function (response) {
                window.location.href = response.redirect;
            },
            error: function (xhr) {
                loginBtn.prop('disabled', false);
                $('.btn-text').text('Login');
                $('.btn-loader').hide();

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        $('input[name="' + key + '"]')
                            .closest('.wrap-input100')
                            .addClass('alert-validate')
                            .find('.error')
                            .text(value[0]);
                    });
                }
            }
        });
    });

})(jQuery);
