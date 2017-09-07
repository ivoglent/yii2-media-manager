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
                var options = $(this).data();
                self.dialog.show(options);
            });
            $(document).on('click', '.yii2-media-item', function () {
                $('.yii2-media-item.selected').removeClass('selected');
                $(this).addClass('selected');
            });
        });
    };

    Media.prototype.upload = function (input, success, progress) {
        var fd = new FormData();
        fd.append( 'file', input.files[0] );
        console.log(fd);
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        if (progress) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            progress(percentComplete);
                        }
                    }
                }, false);

                return xhr;
            },
            url: this.configs.baseUrl + '/media/manager/upload',
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function(result) {
                if (success) {
                    success(result);
                }
            }
        });
    }
    Media.prototype.dialog = {
        options : {
            selected : {}
        },
        dialogUrl : function () {
            return yii.media.configs.baseUrl + '/media/manager/dialog'
        },
        init : function () {
            var self = this;

            $(document).on('mediaselected', function (e, data) {
                console.log(data);
                if (self.options.target) {
                    $(self.options.target).val(self.options.selected.url);
                }
                if (self.options.showImage) {
                    var image = $('<img>', {
                        src : self.options.selected.thumburl,
                        class : 'yii-media-thumb'
                    });
                    $(self.options.showImage).html(image);
                }
            });
            $(document).on('click', '.yii2-media-item', function () {
                var data = $(this).data();
                self.options.selected = data;
            });
            $(document).on('click', '#media-manager-apply', function () {
                var event = $.Event('mediaselected', {});
                $(document).trigger(event, self.options );
                self.hide();
            });
            return this;
        },
        show : function (options) {
            this.options = $.extend(options, this.options);
            var dialog = $('#media-manager-dialog');
            if (dialog.length) {
                dialog.modal('show');
            } else {
                this.init().load().then(function (response) {
                    if (response) {
                        $('body').append(response);
                        setTimeout(function () {
                            self.loading.hide();
                            dialog = $('#media-manager-dialog');
                            dialog.modal('show');
                            jQuery(document).pjax("#yii2-media-items a", {"push":false,"replace":false,"timeout":10000,"scrollTo":false,"container":"#yii2-media-items"});
                            jQuery(document).on("submit", "#yii2-media-items form[data-pjax]", function (event) {jQuery.pjax.submit(event, {"push":false,"replace":false,"timeout":10000,"scrollTo":false,"container":"#yii2-media-items"});});
                        }, 250);
                    }
                });
            }

        },
        hide : function (options) {
            var dialog = $('#media-manager-dialog');
            if (dialog.length) {
                dialog.modal('hide');
            }
        },
        load : function () {
            return $.ajax({
                type : 'GET',
                url : this.dialogUrl(),
                success : function (response) {
                    return response;
                }
            });
        },
        reloadItems : function (options) {
            $('.nav-tabs a[href="#media-manager-list"]').tab('show');
            $.pjax.reload({
                container : '#yii2-media-items',
                url : this.dialogUrl(),
                push : false,
                replace : false,
                pushState : false,
                timeout : 10000
            })
        }
    }
    /*Media.prototype.openManagerDialog = function () {
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

    }*/

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