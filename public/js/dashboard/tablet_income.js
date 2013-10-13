if (typeof Tablet === 'undefined') {
    Tablet = {};
}

Tablet.Income = {
    init: function(modalId, buttonId, totalsId) {
        this.addIncomeModal = $(modalId);
        this.addIncomeButton = $(buttonId);
        this.totalsTable = $(totalsId);
        this.tabletIdInput = $('input[name="tablet_id"]');

        this.totalAmountTd = this.totalsTable.find('#total-amount');
        this.currentSumTd = this.totalsTable.find('#current-sum');

        this.balanceValueSpan = $('#balance-value');

        this.incomeValueInput = this.addIncomeModal.find('input[name="income_value"]');
        this.saveIncomeButton = this.addIncomeModal.find('#income-save');

        this.bindEvents();
    },
    bindEvents: function() {
        this.addIncomeButton.on('click', this, this.showIncomeModal);
        this.saveIncomeButton.on('click', this, this.saveIncome);
        this.addIncomeModal.on('hidden.bs.modal', this, this.clearModal);
        this.incomeValueInput.on('change', this, this.removeInputError);
    },
    showIncomeModal: function(event) {
        var self = event.data;
        self.addIncomeModal.modal('show');
    },
    hideIncomeModal: function() {
        this.addIncomeModal.modal('hide');
    },
    saveIncome: function(event) {
        var self = event.data;

        var tabletId = self.tabletIdInput.val();
        var incomeValue = self.incomeValueInput.val();

        var initialTotalAmountValue = self.totalAmountTd.text();
        var initialCurrentSumValue = self.currentSumTd.text();
        var initialBalanceValue = self.balanceValueSpan.text();

        $.post('/income/create',
                {incomeValue: incomeValue, tabletId: tabletId},
        function(response) {
            if (response.success) {
                self.hideIncomeModal();

                var newTotalAmountValue = parseFloat(initialTotalAmountValue) + parseFloat(incomeValue);
                self.totalAmountTd.text(newTotalAmountValue.toFixed(2));

                var newCurrentSumValue = parseFloat(initialCurrentSumValue) + parseFloat(incomeValue);
                self.currentSumTd.text(newCurrentSumValue.toFixed(2));

                var newBalanceValue = parseFloat(initialBalanceValue) + parseFloat(incomeValue);
                self.balanceValueSpan.text(newBalanceValue.toFixed(2));

            } else {
                if (response.incomeValueMsg) {
                    self.incomeValueInput.closest('.form-group').addClass('has-error');
                    self.incomeValueInput.parent().next('.help-block').text(response.incomeValueMsg);
                }

                if (response.tabletMsg) {
                    self.incomeValueInput.closest('.form-group').addClass('has-error');
                    self.incomeValueInput.parent().next('.help-block').text(response.tabletMsg);
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
        self.incomeValueInput.val('');
        self.incomeValueInput.parent().next('.help-block').text('');
        self.incomeValueInput.parents('.form-group').removeClass('has-error');
    }
};
