if (typeof Tablet === 'undefined') {
    Tablet = {};
}

Tablet.Economy = {
    init: function(modalId, buttonId, totalsId) {
        this.addEconomyModal = $(modalId);
        this.addEconomyButton = $(buttonId);
        this.totalsTable = $(totalsId);
        this.tabletIdInput = $('input[name="tablet_id"]');

        this.economyValueInput = this.addEconomyModal.find('input[name="economy_value"]');
        this.saveEconomyButton = this.addEconomyModal.find('#economy-save');

        this.currentSumTd = this.totalsTable.find('#current-sum');
        this.economiesTd = this.totalsTable.find('#tablet-economies');
        
        this.balanceValueSpan = $('#balance-value');

        this.bindEvents();
    },
    bindEvents: function() {
        this.addEconomyButton.on('click', this, this.showEconomyModal);
        this.saveEconomyButton.on('click', this, this.saveEconomy);
    },
    showEconomyModal: function(event) {
        var self = event.data;
        self.addEconomyModal.modal('show');
    },
    hideEconomyModal: function() {
        this.addEconomyModal.modal('hide');
    },
    saveEconomy: function(event) {
        var self = event.data;

        var tabletId = self.tabletIdInput.val();
        var economyValue = self.economyValueInput.val();

        var initialCurrentSumValue = self.currentSumTd.text();
        var initialEconomiesValue = self.economiesTd.text();
        
        var initialBalanceValue = self.balanceValueSpan.text();

        $.post('/economy/create',
                {economyValue: economyValue, tabletId: tabletId},
        function(response) {
            if (response.success) {
                self.hideEconomyModal();
                
                var newCurrentSumValue = parseFloat(initialCurrentSumValue) - parseFloat(economyValue);
                self.currentSumTd.text(newCurrentSumValue.toFixed(2));
                
                var newEconomiesValue = parseFloat(initialEconomiesValue) + parseFloat(economyValue);
                self.economiesTd.text(newEconomiesValue.toFixed(2));
                
                var newBalanceValue = parseFloat(initialBalanceValue) - parseFloat(economyValue);
                self.balanceValueSpan.text(newBalanceValue.toFixed(2));

            } else {
                //
            }
        },
                'json'
                );

    }
};
