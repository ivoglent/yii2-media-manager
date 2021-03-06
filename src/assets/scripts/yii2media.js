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
                $(this).children('i').first().removeClass('fa-plus').addClass('fa-spinner fa-spin')
                var _self = this;
                self.dialog.show(options, function(){
                    $(_self).children('i').first().removeClass('fa-spinner fa-spin').addClass('fa-plus')
                });


            });
            $(document).on('click', '.yii2-media-item', function () {
                var self = this;
                $('.yii2-media-item.selected').removeClass('selected');
                $(this).addClass('selected');
                $('.selected-item-count').each(function (i, e) {
                    $(e).html(1);
                    $(e).data('id', $(self).data('id'));
                });
            });
            $(document).on('hidden.bs.modal', '#media-manager-dialog', function () {
                self.dialog.reset();
            });
            $(document).on('click', '#yii-media-delete', function (e) {
               e.stopPropagation();
               e.preventDefault();
               var deleteItem = $(this).children('.selected-item-count').first();
               if (deleteItem) {
                   if (confirm('Do you want to delete this item?')) {
                       var id = deleteItem.data('id');
                       self.dialog.deleteItem(id);
                   }
               }
            });
        });
    };

    Media.prototype.upload = function (input, success, progress) {
        var fd = new FormData();
        fd.append( 'file', input.files[0] );
        var options = $(input).closest('form').serializeArray();
        for (var key in options){
            var option = options[key];
            fd.append( 'options[' + option.name + ']', option.value);
        };

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
        callback : function (url) {
            console.log(url);
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
                } else {
                    self.callback(self.options.selected.url);
                }
                if (self.options.showImage) {
                    var image = $('<img>', {
                        src : self.options.selected.thumburl,
                        class : 'yii-media-thumb'
                    });
                    $(self.options.showImage).html(image).removeClass('btn btn-primary').addClass('selected');
                    $(self.options.showImage).append('<div class="media-selected-hover"><i class="fa fa-pencil"></i> Change</div>')
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
        select : function (id) {
            var item = $('.yii2-media-item[data-id="' +id + '"]').first();
            if (item) {
                $(item).addClass('selected');
                var data = $(item).data();
                this.options.selected = data;
            }
        },
        show : function (options, callback) {
            var _self = this;
            this.options = options;
            var dialog = $('#media-manager-dialog');
            if (callback) {
                this.callback = callback;
            }
            if (dialog.length) {
                dialog.remove();
            }
            this.init().load().then(function (response) {
                if (response) {
                    $('body').append(response);
                    setTimeout(function () {
                        //self.loading.hide();
                        dialog = $('#media-manager-dialog');
                        dialog.modal('show');
                        jQuery(document).pjax("#yii2-media-items a", {"push":false,"replace":false,"timeout":10000,"scrollTo":false,"container":"#yii2-media-items"});
                        jQuery(document).on("submit", "#yii2-media-items form[data-pjax]", function (event) {jQuery.pjax.submit(event, {"push":false,"replace":false,"timeout":10000,"scrollTo":false,"container":"#yii2-media-items"});});

                    }, 250);
                }
            });

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
        },
        reset : function () {
            $('#yii2-media-upload-progress .progress-bar').css({ width : '0%'});
            $('#yii2-media-upload-progress').hide();
            $('.media-file').prop('disabled', false);
            $('#yii2-media-upload-error').hide();
            $('#yii2-media-upload-preview').attr('src', 'about:blank');
        },
        deleteItem : function (id) {
            $.ajax({
                type : 'POST',
                url  : yii.media.configs.baseUrl + '/media/manager/delete',
                data : {
                    id : id,
                    _crsf : yii.getCsrfToken()
                },
                success : function (response) {
                    if (response.code == 200) {
                        yii.media.dialog.reloadItems();
                    } else {
                        alert('An error occurred while processing your request. Please try again later!');
                    }
                },
                error : function (e) {
                    alert('An error occurred while processing your request. Please try again later!');
                }
            });
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