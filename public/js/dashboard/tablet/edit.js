if (typeof Tablet === 'undefined') {
    Tablet = {};
}

Tablet.Expense.Edit = {
    flagCell: false,
    type: null,
    init: function() {
        this.cellPredictionValue = $('.prediction-value');
        this.cellExpenseValue = $('.expense-value');
        this.bindEvents();
    },
    bindEvents: function() {
        this.cellPredictionValue.on('click', this, this.makeEditable);
        this.cellExpenseValue.on('click', this, this.makeEditable);
    },
    makeEditable: function(event) {
        var self = event.data;

        if (self.flagCell === false) {
            var td = $(this);
            self.setType(td);
            self.prevSelectedValue = td.text();
            var row = td.parent();
            td.html('<input class="form-control" type="text" value="' + self.prevSelectedValue + '">');
            self.showActionButtons(row);
        }
        self.flagCell = true;
    },
    setType: function(elemObj) {
        if (elemObj.hasClass('prediction-value')) {
            this.type = 'prediction';
        }

        if (elemObj.hasClass('expense-value')) {
            this.type = 'expense';
        }
    },
    showActionButtons: function(row) {
        row.append('<td><a class="action-button-save" href="#"><span class="glyphicon glyphicon-ok"></span></a></td>');
        row.append('<td><a class="action-button-cancel" href="#"><span class="glyphicon glyphicon-remove"></span></a></td>');
        var self = this;
        $('.action-button-save').on('click', function() {
            alert('save');
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
        if (this.isPredictionType()) {
            row.find('.prediction-value').text(this.prevSelectedValue);
        }
        if (this.isExpenseType()) {
            row.find('.expense-value').text(this.prevSelectedValue);
        }
    },
    isPredictionType: function() {
        if (this.getEditType() === 'prediction') {
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
    getEditType: function() {
        return this.type;
    }
};

var edit = Tablet.Expense.Edit.init();