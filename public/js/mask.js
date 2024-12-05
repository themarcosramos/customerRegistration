var mascaras = (function () {

    return {

        init: function () {

            var CpfCnpjMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
                },
                cpfCnpjpOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
                    }
                };

            $('.cnpjCpfMask').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);

            $('.cpfMask').mask('999.999.999-99');
            $('.cnpjMask').mask('99.999.999/9999-99');
            $('.telefoneMask').mask('(99) 9999-9999');
            $('.celularMask').mask('(99) 99999-9999');
            $('.cepMask').mask('99999-999');

        }

    }

})(jQuery);