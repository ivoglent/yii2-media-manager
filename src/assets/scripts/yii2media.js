/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 */
;(function ($) {
    var yii = window.yii || {};

    function Media(options) {
        this.configs = $.extend({
            baseUrl : '/'
        }, options);
    }
    Media.prototype.init = function () {
        var self = this;
        $(document).ready(function(){
            $(document).on('click', '[data-media-dialog]', function () {
                self.openManagerDialog();
            });
        });
    };
    Media.prototype.openManagerDialog = function () {
        this.loading.show();
        var self = this;
        var dialog = $('#media-manager-dialog');
        if (dialog.length) {
            dialog.modal('show');
        } else {
            $.ajax({
                type : 'GET',
                url : this.configs.baseUrl + '/media/manager/dialog',
                success : function (response) {
                    if (response) {
                        $('body').append(response);
                        setTimeout(function () {
                            self.loading.hide();
                            dialog = $('#media-manager-dialog');
                            dialog.modal('show');
                        }, 250);
                    }
                }
            });
        }

    }

    Media.prototype.loading = {
        show : function () {
            
        },
        hide : function () {
            
        }
    };
    var options = window.mediaOptions || {};
    yii.media = new Media(options);

    window.yii = yii;
    window.yii.media.init();
})(jQuery);