var getCurrencySymbol = $('#getCurrencySymbol').val();
var allCurrency = JSON.parse($('#allCurrency').val());

(function ($) {
    "use strict";
    $(document).on('click', '.edit', function (e) {
        commonAjax('GET', $('#getInfoRoute').val(), getDataEditRes, getDataEditRes, {'id': $(this).data('id')});
    });
    $('.add-currency').on('click', function (e) {
        var html = '';
        html += '<div class="input-group mb-3 currency-conversation-rate">' +
            '<select name="currency[]" class="form-control currency" required>';
        Object.entries(allCurrency).forEach((currency) => {
            html += '<option value="' + currency[0] + '">' + currency[1] + '</option>';
        });
        html += '</select>' +
            '<span class="input-group-text">1  ' + getCurrencySymbol + ' = </span>' +
            '<input type="number" step="any" min="0" name="conversion_rate[]" value="" class="form-control" required>' +
            '<input type="hidden" step="any" min="0" name="currency_id[]" value="" class="form-control" required>' +
            '<span class="input-group-text append_currency"></span>' +
            '<button type="button" class="bg-white border-0 font-24 mr-5 ms-3 removedItem text-danger bg-fafafa border-0" title="Remove"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"/></svg></button>' +
            '</div>';
        $('#currencyConversionRateSection').append(html);
        $('.currency').trigger("change");
    })

    $(document).on('click', '.removedItem', function () {
        $(this).closest('.currency-conversation-rate').remove();
    });

    $(document).on('change', '.currency', function () {
        $(this).closest('.currency-conversation-rate').find('.append_currency').text($(this).val())
    });

    // Bank
    $('.add-bank').on('click', function () {
        $('.bank-div-append').append(addBank());
        $('.bank-div-append').find('.sf-select-without-search').niceSelect();
    });

    $(document).on('click', '.remove-bank', function () {
        $(this).closest('.multi-bank').remove()
    });


    window.getDataEditRes = function(response) {
        console.log(response);
        const selector = $('#editModal');
        selector.find('.gateway-input').removeClass('d-none');
        selector.modal('show')
        selector.find('.is-invalid').removeClass('is-invalid');
        selector.find('.error-message').remove();
        $('#id').val(response.data.gateway.id)
        selector.find('.image').attr('src', response.data.image)
        selector.find('.title').val(response.data.gateway.title)
        selector.find('.slug').val(response.data.gateway.slug)

        selector.find('select[name=status]').val(response.data.gateway.status)
        selector.find('select[name=mode]').val(response.data.gateway.mode)
        selector.find('input[name=key]').val(response.data.gateway.key)

        $('.sf-select-without-search').niceSelect('update');

        var gatewaySettings = JSON.parse($('#gatewaySettings').val());
        let currentGateway = gatewaySettings[response.data.gateway.slug];

        if (typeof currentGateway == 'undefined') {
            currentGateway = [];
        } else {
            selector.find('.gateway-input').addClass('d-none');
        }

        currentGateway.forEach(option => {
            if (option.name == 'url' && option.is_show == 1) {
                selector.find('input[name=url]').parent().find('.label-text-title').text(option.label);
                $('#gateway-url').removeClass('d-none');
            } else if (option.name == 'key' && option.is_show == 1) {
                selector.find('input[name=key]').parent().find('.label-text-title').text(option.label);
                $('#gateway-key').removeClass('d-none');
            } else if (option.name == 'secret' && option.is_show == 1) {
                selector.find('input[name=secret]').parent().find('.label-text-title').text(option.label);
                $('#gateway-secret').removeClass('d-none');
            }
        });


        selector.find('input[name=secret]').val(response.data.gateway.secret)
        selector.find('input[name=url]').val(response.data.gateway.url)

        if (response.data.gateway.slug == 'bank') {
            selector.find('.mode-div').hide();
            selector.find('.url-div').hide();
            selector.find('.key-secret-div').hide();
            selector.find('.bank-div').show();
            var banks = response.data.banks;
            var bankHtml = '';
            if (banks.length > 0) {
                Object.entries(banks).map(function (bank) {
                    var isSelected = '';
                    if (bank[1].status == 1) {
                        isSelected = 'selected';
                    } else {
                        isSelected = '';
                    }
                    bankHtml += `<div class="multi-bank bg-white radius-4 theme-border pb-0 mb-25">
                                    <div class="row">
                                        <div class="col-6">
                                         <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                            <input type="hidden" name="bank[id][]" value="${bank[1].id}">
                                            <label for="name" class="label-text-title color-heading font-medium mb-2 form-label">Baaank Name</label>
                                            <input type="text" name="bank[name][]" class="primary-form-control bank-name" id="name" placeholder="Bank Name" value="${bank[1].name}">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                            <label for="name" class="label-text-title color-heading font-medium mb-2 form-label">Status</label>
                                            <select name="bank[status][]" class="sf-select-without-search primary-form-control p-0" id="status">
                                                <option value="1" ${bank[1].status == 1 ? 'selected' : ''}>Active</option>
                                                <option value="0" ${bank[1].status == 0 ? 'selected' : ''}>Deactive</option>
                                            </select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-20">
                                        <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                            <label for="name" class="label-text-title color-heading font-medium mb-2 form-label">Bank Details</label>
                                            <textarea name="bank[details][]" id="bank_details" class="primary-form-control">${bank[1].details}</textarea>
                                            </div>
                                            </div>
                                        </div>
                                        <div class=" col-md-12 text-end">
                                            <button type="button" class="red-color bd-ra-12 border-0 btn btn-danger fs-15 fw-500 lh-25 ml-10 px-17 py-3 remove-bank" title="Remove">Remove</button>
                                        </div>
                                    </div>
                                </div>`

                });
            } else {
                bankHtml += `<div class="multi-bank bg-white radius-4 theme-border pb-0 mb-25">
                <div class="row">
                    <div class="col-6">
                        <input type="hidden" name="bank[id][]" value="">
                        <label for="name" class="label-text-title color-heading font-medium mb-2">Bank Name</label>
                        <input type="text" name="bank[name][]" class="form-control bank-name" id="name" placeholder="Bank Name" value="">
                    </div>
                    <div class="col-6">
                        <label for="name" class="label-text-title color-heading font-medium mb-2">Status</label>
                        <select name="bank[status][]" class="form-control bank-status" id="status">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>
                    <div class="col-12 mb-20">
                        <label for="name" class="label-text-title color-heading font-medium mb-2">Bank Details</label>
                        <textarea name="bank[details][]" id="bank_details" class="form-control"></textarea>
                    </div>
                </div>
            </div>`
            }

            $('.bank-div-append').html(bankHtml);
            $('.bank-div-append').find('.sf-select-without-search').niceSelect();
        } else {
            selector.find('.mode-div').show();
            selector.find('.url-div').show();
            selector.find('.key-secret-div').show();
            selector.find('.bank-div').hide();
        }
        var html = '';
        response.data.currencies.map(function (data) {
            html += '<div class="input-group mb-3 currency-conversation-rate">' +
                '<select name="currency[]" class="form-control currency" required>';
            Object.entries(allCurrency).forEach((currency) => {
                if (currency[0] == data.currency) {
                    html += '<option value="' + currency[0] + '" selected>' + currency[1] + '</option>';
                } else {
                    html += '<option value="' + currency[0] + '">' + currency[1] + '</option>';
                }
            });
            html += '</select>' +
                '<span class="input-group-text">1  ' + getCurrencySymbol + ' = </span>' +
                '<input type="number" step="any" min="0" name="conversion_rate[]" value="' + data.conversion_rate + '" class="form-control" required>' +
                '<input type="hidden" step="any" min="0" name="currency_id[]" value="' + data.id + '" class="form-control" required>' +
                '<span class="input-group-text append_currency">' + data.currency + '</span>' +
                '<button type="button" class="bg-white border-0 font-24 mr-5 ms-3 removedItem text-danger" title="Remove"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"/></svg></button>' +
                '</div>';
        });
        $('#currencyConversionRateSection').html(html);
    }

    window.addBank = function() {
        return `<div class="multi-bank bg-white radius-4 theme-border pb-0 mb-25">
                    <div class="row rg-15">
                        <div class="col-6">
                        <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                            <input type="hidden" name="bank[id][]" value="">
                            <label for="name" class="label-text-title color-heading font-medium mb-2 form-label">Bank Name</label>
                            <input type="text" name="bank[name][]" class="primary-form-control bank-name" id="name" placeholder="Bank Name" value="">
                            </div>
                            </div>
                        </div>
                        <div class="col-6">
                        <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                            <label for="name" class="label-text-title color-heading font-medium mb-2 form-label">Status</label>
                            <select name="bank[status][]" class="sf-select-without-search primary-form-control p-0" id="status">
                                <option value="1">Active</option>
                                <option value="0">Deactivate</option>
                            </select>
                            </div>
                            </div>
                        </div>

                        <div class="col-12">
                        <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                            <label for="name" class="label-text-title color-heading font-medium mb-2 form-label">Bank Details</label>
                            <textarea name="bank[details][]" id="bank_details" class="primary-form-control"></textarea>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="button" class="bd-ra-12 border-0 btn btn-danger fs-15 fw-500 lh-25 ml-10 px-17 py-3 remove-bank" title="Remove">Remove</button>
                        </div>
                    </div>
                </div>`;
    }

    window.responseOnGatewaStore = function(response) {
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message'])

            setTimeout(() => {
                location.reload()
            }, 1000);


        } else {
            commonHandler(response)
        }

    }


})(jQuery);
