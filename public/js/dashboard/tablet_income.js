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
                //
            }
        },
                'json'
                );

    }
};
