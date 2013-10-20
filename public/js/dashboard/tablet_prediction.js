if (typeof Tablet === 'undefined') {
    Tablet = {};
}


Tablet.Prediction = {
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

        this.balanceValueSpan = $('#balance-value');

        this.selectAllPredictionsCheckbox = $('#prediction-all-checkbox');
        this.singlePredictionCheckbox = $('.prediction-id-checkbox');

        this.bindEvents();
    },
    bindEvents: function() {
        this.addPredictionButton.on('click', this, this.showPredictionModal);
        this.savePredictionButton.on('click', this, this.savePrediction);
        this.predictionNameInput.on('change', this, this.removeInputError);
        this.predictionValueInput.on('change', this, this.removeInputError);
        this.addPredictionModal.on('hidden.bs.modal', this, this.clearModal);
        this.selectAllPredictionsCheckbox.on('change', this, this.toogleSelectAllPredictions);
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
    showPredictionModal: function(event) {
        var self = event.data;
        self.addPredictionModal.modal('show');
    },
    savePrediction: function(event) {
        var self = event.data;
        var tabletId = self.tabletIdInput.val();

        var predictionName = self.predictionNameInput.val();
        var predictionValue = self.predictionValueInput.val();

        var initialBalanceValue = self.balanceValueSpan.text();

        $.post(
                '/prediction/create',
                {prediction: predictionName, value: predictionValue, tabletId: tabletId},
        function(response) {
            if (response.success) {
                self.addExpenseButton.show();
                self.tablePredictionExpense.show();
                self.addPredictionModal.modal('hide');
                var lineHtml = '<tr><td><input class="form-control prediction-id-checkbox" type="checkbox" value="'
                        + response.predictionId + '"></td><td>'
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
            } else {
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

        self.predictionNameInput.val('');
        self.predictionValueInput.val('');
        self.predictionNameInput.closest('.form-group').removeClass('has-error');
        self.predictionNameInput.parent().next('.help-block').text('');
        self.predictionValueInput.closest('.form-group').removeClass('has-error');
        self.predictionValueInput.parent().next('.help-block').text('');
    }
};