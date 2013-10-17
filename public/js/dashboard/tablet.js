Tablet = {
    init: function(modalId, closeButtonId) {
        this.closeTabletModal = $(modalId);
        this.closeTabletButton = $(closeButtonId);
        this.tabletIdInput = $('input[name="tablet_id"]');
        this.confirmTabletCloseButton = this.closeTabletModal.find('#confirm-tablet-close');

        this.bindEvents();
    },
    bindEvents: function() {
        this.closeTabletButton.on('click', this, this.showCloseModal);
        this.confirmTabletCloseButton.on('click', this, this.closeTablet);
    },
    showCloseModal: function(event) {
        var self = event.data;
        self.closeTabletModal.modal('show');
    },
    hideCloseModal: function() {
        this.closeTabletModal.modal('hide');
    },
    closeTablet: function(event) {
        var self = event.data;
        var tabletId = self.tabletIdInput.val();

        $.post('/tablet/close',
                {tabletId: tabletId},
        function(response) {
            if (response.success) {
                self.hideCloseModal();
            }
        },
                'json'
                );
    }
};
