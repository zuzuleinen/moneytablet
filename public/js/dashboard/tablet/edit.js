if (typeof Tablet === 'undefined') {
    Tablet = {};
}

Tablet.Expense.Edit = {
    flagCell: false,
    type: null,
    init: function() {
        this.cellCategoryName = $('.prediction-name');
        this.cellPredictionValue = $('.prediction-value');
        this.cellEconomiesValue = $('#tablet-economies');

        this.cellExpenseValue = $('.expense-value');
        this.bindEvents();
    },
    bindEvents: function() {
        this.cellCategoryName.on('click', this, this.makeEditable);
        this.cellPredictionValue.on('click', this, this.makeEditable);
        this.cellEconomiesValue.on('click', this, this.makeEditable);
        //disable for now expense editing
        //this.cellExpenseValue.on('click', this, this.makeEditable);
    },
    makeEditable: function(event) {
        var self = event.data;

        if (self.flagCell === false) {
            var td = $(this);
            self.setType(td);
            self.prevSelectedValue = td.text();
            var row = td.parent();
            var type = 'number';

            if (td.attr('class') === 'prediction-name') {
                type = 'text';
            }

            td.html('<input class="form-control edit-value" type="' + type + '" value="' + self.prevSelectedValue + '">');
            self.showActionButtons(row);
        }
        self.flagCell = true;
    },
    setType: function(elemObj) {
        if (elemObj.hasClass('prediction-name')) {
            this.type = 'category';
        }

        if (elemObj.hasClass('prediction-value')) {
            this.type = 'prediction';
        }

        if (elemObj.hasClass('expense-value')) {
            this.type = 'expense';
        }

        if (elemObj.attr('id') === 'tablet-economies') {
            this.type = 'economy';
        }
    },
    showActionButtons: function(row) {
        row.append('<td class="action-button"><a class="action-button-save" href="#"><span class="glyphicon glyphicon-ok"></span></a></td>');
        row.append('<td class="action-button"><a class="action-button-cancel" href="#"><span class="glyphicon glyphicon-remove"></span></a></td>');
        var self = this;

        $('.action-button-save').on('click', function() {
            var predictionId = row.find('.prediction-id-checkbox').val();

            if (self.isCategoryType()) {
                var categoryName = row.find('.edit-value').val();
                $.post(
                        '/prediction/edit',
                        {predictionId: predictionId, predictionName: categoryName},
                function(response) {
                    if (response.success) {
                        row.find('.prediction-name').text(categoryName);
                        self.removeActionButtons(row);
                    }
                },
                        'json'
                        );
            }

            if (self.isPredictionType()) {
                var predictionValue = row.find('.edit-value').val();
                $.post(
                        '/prediction/edit',
                        {predictionId: predictionId, predictionValue: predictionValue},
                function(response) {
                    if (response.success) {
                        row.find('.prediction-value').text(predictionValue);
                        self.removeActionButtons(row);
                        $('#balance-value').text(response.balanceValue);

                        if (predictionValue < 0) {
                            row.addClass('danger');
                        } else {
                            row.removeClass('danger');
                        }

                        if (response.balanceValue < 0) {
                            $('#balance-value').addClass('text-danger');
                        } else {
                            $('#balance-value').removeClass('text-danger');
                        }
                    }
                },
                        'json'
                        );
            }

            if (self.isEconomyType()) {
                var economyValue = row.find('.edit-value').val();
                $.post(
                        '/economy/edit',
                        {economyValue: economyValue},
                function(response) {
                    if (response.success) {
                        row.find('#tablet-economies').text(economyValue);
                        self.removeActionButtons(row);
                    }
                },
                        'json'
                        );
            }
        });

        $('.action-button-cancel').on('click', function() {
            self.removeActionButtons(row);
            self.restorePreviousValue(row);
        });
    },
    removeActionButtons: function(row) {
        row.find('.action-button-save').parent().remove();
        row.find('.action-button-cancel').parent().remove();
        this.flagCell = false;
    },
    restorePreviousValue: function(row) {
        if (this.isCategoryType()) {
            row.find('.prediction-name').text(this.prevSelectedValue);
        }
        if (this.isPredictionType()) {
            row.find('.prediction-value').text(this.prevSelectedValue);
        }
        if (this.isExpenseType()) {
            row.find('.expense-value').text(this.prevSelectedValue);
        }
        if (this.isEconomyType()) {
            row.find('#tablet-economies').text(this.prevSelectedValue);
        }
    },
    isPredictionType: function() {
        if (this.getEditType() === 'prediction') {
            return true;
        }
        return false;
    },
    isCategoryType: function() {
        if (this.getEditType() === 'category') {
            return true;
        }
        return false;
    },
    isExpenseType: function() {
        if (this.getEditType() === 'expense') {
            return true;
        }
        return false;
    },
    isEconomyType: function() {
        if (this.getEditType() === 'economy') {
            return true;
        }
        return false;
    },
    getEditType: function() {
        return this.type;
    }
};

var edit = Tablet.Expense.Edit.init();