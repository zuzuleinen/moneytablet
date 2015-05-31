if (typeof Tablet === 'undefined') {
    Tablet = {};
}


Tablet.Prediction = {
    flagCell: false,
    init: function(modalId, buttonId, totalsId) {
        this.addPredictionModal = $(modalId);
        this.addPredictionButton = $(buttonId);
        this.addExpenseButton = $('#add-new-expense-button');
        this.deletePredictionsButton = $('#delete-predictions');
        this.totalsTable = $(totalsId);
        this.tablePredictionExpense = $('#table-prediction-expense');
        this.tabletIdInput = $('input[name="tablet_id"]');

        this.savePredictionButton = this.addPredictionModal.find('#prediction-save');
        this.predictionNameInput = this.addPredictionModal.find("input[name='name']");
        this.predictionValueInput = this.addPredictionModal.find("input[name='value']");

        this.totalExpensesTd = this.totalsTable.find('#total-expenses');
        this.currentSumTd = this.totalsTable.find('#current-sum');
        this.balanceValueSpan = $('#balance-value');

        this.selectAllPredictionsCheckbox = $('#prediction-all-checkbox');
        this.singlePredictionCheckbox = $('.prediction-id-checkbox');

        this.initAutocomplete();
        this.bindEvents();
    },
    bindEvents: function() {
        this.addPredictionButton.on('click', this, this.showPredictionModal);
        this.savePredictionButton.on('click', this, this.savePrediction);
        this.predictionNameInput.on('change', this, this.removeInputError);
        this.predictionValueInput.on('change', this, this.removeInputError);
        this.addPredictionModal.on('hidden.bs.modal', this, this.clearModal);
        this.selectAllPredictionsCheckbox.on('change', this, this.toogleSelectAllPredictions);
        this.singlePredictionCheckbox.on('change', this, this.afterSinglePredictionClick);
        this.deletePredictionsButton.on('click', this, this.deletePredictions);
    },
    initAutocomplete: function() {
        this.predictionNameInput.autocomplete({
            minLength: 3,
            source: '/prediction/automcomplete'
        });
    },
    deletePredictions: function(event) {
        var self = event.data;
        var checkedPredictions = $('.prediction-id-checkbox:checked');
        var predictionIds = '';

        var initialTotalExpenses = self.totalExpensesTd.text();
        var initialCurrentMoney = self.currentSumTd.text();
        var initialBalanceValue = self.balanceValueSpan.text();

        var checkedExpensesSum = 0;
        var checkedPredictionsSum = 0;

        //we add the . as a separator for prediction ids
        checkedPredictions.each(function(key, value) {
            element = $(value);
            predictionValue = element.parent().siblings('.prediction-value').text();
            expenseValue = element.parent().siblings('.expense-value').text();

            checkedExpensesSum = checkedExpensesSum + parseFloat(expenseValue);
            checkedPredictionsSum = checkedPredictionsSum + parseFloat(predictionValue);

            predictionIds = predictionIds + element.val() + '.';
        });

        $.post(
                '/prediction/delete',
                {predictionIds: predictionIds},
        function(response) {
            if (response.success) {
                checkedPredictions.parents('tr').remove();

                //update new totals values
                var newTotalExpensesValue = parseFloat(initialTotalExpenses) - checkedExpensesSum;
                var newCurrentMoneyValue = parseFloat(initialCurrentMoney) + checkedExpensesSum;
                var newBalanceValue = parseFloat(initialBalanceValue) + checkedPredictionsSum + checkedExpensesSum;

                self.totalExpensesTd.text(newTotalExpensesValue.toFixed(2));
                self.currentSumTd.text(newCurrentMoneyValue.toFixed(2));
                self.balanceValueSpan.text(newBalanceValue.toFixed(2));

                if (newBalanceValue < 0) {
                    self.balanceValueSpan.addClass('text-danger');
                } else {
                    self.balanceValueSpan.removeClass('text-danger');
                }
            }
        },
                'json'
                );

    },
    toogleSelectAllPredictions: function(event) {
        var self = event.data;

        if (this.checked) {
            self.singlePredictionCheckbox.each(function(key, value) {
                $(value).prop('checked', true);
            });
            self.deletePredictionsButton.show();
        } else {
            self.singlePredictionCheckbox.each(function(key, value) {
                $(value).prop('checked', false);
            });
            self.deletePredictionsButton.hide();
        }
    },
    afterSinglePredictionClick: function(event) {
        var self = event.data;
        var currentElementValue = $(this).val();
        var otherPredictionsAreChecked = false;

        self.singlePredictionCheckbox.each(function(key, value) {
            element = $(value);
            if (element.is(':checked') && (currentElementValue !== element.val())) {
                otherPredictionsAreChecked = true;
            }
        });

        if (this.checked) {
            self.deletePredictionsButton.show();
        } else {
            if (!otherPredictionsAreChecked) {
                self.selectAllPredictionsCheckbox.prop('checked', false);
                self.deletePredictionsButton.hide();
            }
        }
    },
    showPredictionModal: function(event) {
        var self = event.data;
        self.addPredictionModal.modal('show');
    },
    savePrediction: function(event) {
        var saveButton = $(this);
        var self = event.data;
        var tabletId = self.tabletIdInput.val();

        var predictionName = self.predictionNameInput.val();
        var predictionValue = self.predictionValueInput.val();

        var initialBalanceValue = self.balanceValueSpan.text();

        saveButton.attr('disabled', 'disabled');

        $.post(
                '/prediction/create',
                {prediction: predictionName, value: predictionValue, tabletId: tabletId},
        function(response) {
            if (response.success) {
                self.addExpenseButton.show();
                self.tablePredictionExpense.show();
                self.addPredictionModal.modal('hide');
                var lineHtml = '<tr><td><input class="prediction-id-checkbox" type="checkbox" value="'
                        + response.predictionId + '"></td><td class="prediction-name">'
                        + predictionName
                        + '</td><td class="prediction-value">'
                        + predictionValue
                        + '</td><td class="expense-value">0</td></tr>';

                self.tablePredictionExpense.children('tbody').append(lineHtml);

                var optionHtml = '<option value="'
                        + response.predictionId
                        + '">' + predictionName + '</option>';
                $('select[name="prediction_id"]').append(optionHtml);

                var newBalanceValue = parseFloat(initialBalanceValue) - parseFloat(predictionValue);
                self.balanceValueSpan.text(newBalanceValue.toFixed(2));

                if (newBalanceValue < 0) {
                    self.balanceValueSpan.addClass('text-danger');
                }

                self.singlePredictionCheckbox = $('.prediction-id-checkbox');
            } else {
                saveButton.removeAttr('disabled');
                if (response.predictionMsg) {
                    self.predictionNameInput.closest('.form-group').addClass('has-error');
                    self.predictionNameInput.parent().next('.help-block').text(response.predictionMsg);
                }

                if (response.valueMsg) {
                    self.predictionValueInput.closest('.form-group').addClass('has-error');
                    self.predictionValueInput.parent().next('.help-block').text(response.valueMsg);
                }
            }
        },
                'json'
                );

    },
    removeInputError: function(event) {
        var element = jQuery(this);
        element.parent().next('.help-block').text('');
        element.parents('.form-group').removeClass('has-error');
    },
    clearModal: function(event) {
        var self = event.data;

        self.savePredictionButton.removeAttr('disabled');
        self.predictionNameInput.val('');
        self.predictionValueInput.val('');
        self.predictionNameInput.closest('.form-group').removeClass('has-error');
        self.predictionNameInput.parent().next('.help-block').text('');
        self.predictionValueInput.closest('.form-group').removeClass('has-error');
        self.predictionValueInput.parent().next('.help-block').text('');
    }
};