$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = 'php/upload.php';
    $('#upload_plaintext').fileupload({
        url: url,
        success: function (e, data) {
            if (e[0] != '1' && e[0] != '0')
            {
                Notifier.error(e);
            }
            else
            {
                Notifier.success('上传成功！');
                $('#plaintext').val(e);
            }
            setTimeout("$('#progressEnc .progress-bar').css('width', 0);", 2000);
        },
        error: function (e, data) {
            Notifier.error("上传出错！");
            setTimeout("$('#progressEnc .progress-bar').css('width', 0);", 2000);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressEnc .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#upload_cypertext').fileupload({
        url: url,
        success: function (e, data) {
            if (e[0] != '1' && e[0] != '0')
            {
                Notifier.error(e);
            }
            else
            {
                Notifier.success('上传成功！');
                $('#cypertext').val(e);
            }
            setTimeout("$('#progressDec .progress-bar').css('width', 0);", 2000);
        },
        error: function (e, data) {
            Notifier.error('上传出错！');
            setTimeout("$('#progressDec .progress-bar').css('width', 0);", 2000);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressDec .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});