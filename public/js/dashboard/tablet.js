Tablet = {
    init: function(modalId, closeButtonId) {
        this.closeTabletModal = $(modalId);
        this.closeTabletButton = $(closeButtonId);
        
        this.bindEvents();
    },
    bindEvents: function() {
        this.closeTabletButton.on('click', this, this.showCloseModal);
    },
    showCloseModal: function(event) {
        var self = event.data;
        self.closeTabletModal.modal('show');
    }
};
