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
        this.addEconomyModal.on('hidden.bs.modal', this, this.clearModal);
        this.economyValueInput.on('change', this, this.removeInputError);
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
        var saveButton = $(this);
        var tabletId = self.tabletIdInput.val();
        var economyValue = self.economyValueInput.val();
        
        saveButton.attr('disabled', 'disabled');

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
                saveButton.removeAttr('disabled');
                if (response.economyValueMsg) {
                    self.economyValueInput.closest('.form-group').addClass('has-error');
                    self.economyValueInput.parent().next('.help-block').text(response.economyValueMsg);
                }

                if (response.tabletMsg) {
                    self.economyValueInput.closest('.form-group').addClass('has-error');
                    self.economyValueInput.parent().next('.help-block').text(response.tabletMsg);
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
        self.saveEconomyButton.removeAttr('disabled');
        self.economyValueInput.val('');
        self.economyValueInput.parent().next('.help-block').text('');
        self.economyValueInput.parents('.form-group').removeClass('has-error');
    }
};
