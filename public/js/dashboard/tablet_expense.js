if (typeof Tablet === 'undefined') {
    Tablet = {};
}

Tablet.Expense = {
    init: function(modalId, buttonId, totalsId) {
        this.addExpenseModal = $(modalId);
        this.addExpenseButton = $(buttonId);
        this.totalsTable = $(totalsId);

        this.totalAmountTd = this.totalsTable.find('#total-amount');
        this.totalExpensesTd = this.totalsTable.find('#total-expenses');
        this.currentSumTd = this.totalsTable.find('#current-sum');
        this.economiesTd = this.totalsTable.find('#tablet-economies');

        this.balanceValueSpan = $('#balance-value');

        this.saveExpenseButton = this.addExpenseModal.find('#expense-save');
        this.predictionIdInput = this.addExpenseModal.find('select[name="prediction_id"]');
        this.expenseValueInput = this.addExpenseModal.find('input[name="expense_value"]');

        this.bindEvents();
    },
    bindEvents: function() {
        this.addExpenseButton.on('click', this, this.showExpenseModal);
        this.saveExpenseButton.on('click', this, this.saveExpense);
        this.predictionIdInput.on('change', this, this.removeInputError);
        this.expenseValueInput.on('change', this, this.removeInputError);
        this.addExpenseModal.on('hidden.bs.modal', this, this.clearModal);
    },
    showExpenseModal: function(event) {
        var self = event.data;
        self.addExpenseModal.modal('show');
    },
    hideExpenseModal: function() {
        this.addExpenseModal.modal('hide');
    },
    saveExpense: function(event) {
        var self = event.data;
        var saveButton = $(this);
        var predictionId = self.predictionIdInput.val();
        var expenseValue = self.expenseValueInput.val();
        saveButton.attr('disabled', 'disabled');

        var initialExpenseValue = $('.prediction-id-checkbox[value="' + predictionId + '"]')
                .parent()
                .siblings('.expense-value')
                .text();

        var initialPredictionValue = $('.prediction-id-checkbox[value="' + predictionId + '"]')
                .parent()
                .siblings('.prediction-value')
                .text();

        var initialTotalExpensesValue = self.totalExpensesTd.text();

        var totalAmountValue = self.totalAmountTd.text();

        var totalEconomiesValue = self.economiesTd.text();

        var initialBalanceValue = self.balanceValueSpan.text();

        $.post('/expense/create',
                {predictionId: predictionId, value: expenseValue},
        function(response) {
            if (response.success) {
                self.hideExpenseModal();

                var newExpenseValue = parseFloat(initialExpenseValue) + parseFloat(expenseValue);
                $('.prediction-id-checkbox[value="' + predictionId + '"]')
                        .parent()
                        .siblings('.expense-value')
                        .text(newExpenseValue.toFixed(2));

                var newPredictionValue = parseFloat(initialPredictionValue) - parseFloat(expenseValue);
                $('.prediction-id-checkbox[value="' + predictionId + '"]')
                        .parent()
                        .siblings('.prediction-value')
                        .text(newPredictionValue.toFixed(2));

                if (newPredictionValue < 0) {
                    $('.prediction-id-checkbox[value="' + predictionId + '"]')
                            .parents('tr').addClass('danger');
                } else {
                    $('.prediction-id-checkbox[value="' + predictionId + '"]')
                            .parents('tr').removeClass('danger');
                }

                var newTotalExpensesValue = parseFloat(initialTotalExpensesValue) + parseFloat(expenseValue);
                self.totalExpensesTd.text(newTotalExpensesValue.toFixed(2));

                var newCurrentSumValue = parseFloat(totalAmountValue) - parseFloat(newTotalExpensesValue);
                self.currentSumTd.text(newCurrentSumValue.toFixed(2));

                var predictions = $('.prediction-value');
                var predictionsSum = 0;

                $.each(predictions, function(key, value) {
                    predictionVal = parseFloat($(value).text());
                    if (predictionVal > 0) {
                        predictionsSum = predictionsSum + predictionVal;
                    }
                });

                var newBalanceValue = parseFloat(newCurrentSumValue) - parseFloat(predictionsSum);
                self.balanceValueSpan.text(newBalanceValue.toFixed(2));

                if (newBalanceValue < 0) {
                    self.balanceValueSpan.addClass('text-danger');
                } else {
                    self.balanceValueSpan.removeClass('text-danger');
                }

            } else {
                saveButton.removeAttr('disabled');
                if (response.predictionMsg) {
                    self.predictionIdInput.closest('.form-group').addClass('has-error');
                    self.predictionIdInput.parent().next('.help-block').text(response.predictionMsg);
                }

                if (response.valueMsg) {
                    self.expenseValueInput.closest('.form-group').addClass('has-error');
                    self.expenseValueInput.parent().next('.help-block').text(response.valueMsg);
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
        self.saveExpenseButton.removeAttr('disabled');
        self.predictionIdInput.prop('selectedIndex', 0);
        self.expenseValueInput.val('');
        self.predictionIdInput.parent().next('.help-block').text('');
        self.predictionIdInput.parents('.form-group').removeClass('has-error');
        self.expenseValueInput.parent().next('.help-block').text('');
        self.expenseValueInput.parents('.form-group').removeClass('has-error');
    }
};