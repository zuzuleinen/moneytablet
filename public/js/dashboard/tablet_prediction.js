if (typeof Tablet === 'undefined') {
    Tablet = {};
}


Tablet.Prediction = {
    init: function(config) {
        this.initFields(config);
        this.bindEvents();
    },
    initFields: function(config) {
        this.tabletId = config.tabletId.val();
        this.addPredictionButton = config.addNewPredictionButton;
        this.addPredictionModal = config.addPredictionModal;
        this.addPredictionForm = config.addPredictionForm;
        this.savePredictionButton = config.savePredictionButton;
        this.predictionNameInput = this.addPredictionForm.find("input[name='name']");
        this.predictionValueInput = this.addPredictionForm.find("input[name='value']");
        this.tablePredictionExpense = config.tablePredictionExpense;
        this.balanceValueSpan = $('#balance-value');

    },
    bindEvents: function() {
        this.addPredictionButton.on('click', this, this.showPredictionModal);
        this.savePredictionButton.on('click', this, this.savePrediction);
        this.predictionNameInput.on('change', this, this.removeInputError);
        this.predictionValueInput.on('change', this, this.removeInputError);
        this.addPredictionModal.on('hidden.bs.modal', this, this.clearModal);
    },
    showPredictionModal: function(event) {
        var self = event.data;
        self.addPredictionModal.modal('show');
    },
    savePrediction: function(event) {
        var self = event.data;
        var predictionName = self.predictionNameInput.val();
        var predictionValue = self.predictionValueInput.val();

        var initialBalanceValue = self.balanceValueSpan.text();

        $.post(
                '/prediction/create',
                {prediction: predictionName, value: predictionValue, tabletId: self.tabletId},
        function(response) {
            if (response.success) {
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