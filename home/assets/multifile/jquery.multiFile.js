/********************************************************************************
 * jQuery multi-file upload plug-in.
 * ------------------------------------------------------------------------------
 * by Kelli Shaver (kelli@kellishaver.com)
 * ------------------------------------------------------------------------------
 * License: CC-Attrib: http://creativecommons.org/licenses/by/3.0/deed.en_US
 *******************************************************************************/

$.fn.multiFile = function(options) {
    var settings = $.extend({
        maxUploads:10,
        allowedFiletypes:['jpg', 'jpeg', 'gif', 'png', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'pdf', 'mp3', 'mp4', 'wmv', 'avi'],
        parentForm:"upload-form"
    },options);

    var $form = $(this);

    $form.each(function() {
        var $elem = $(this);
        $elem.after('<ul></ul>');

        $elem.delegate('input[type=file]', 'change', function(e) {
            var $input = $(this);
            var $parent = $input.parent();
            var $fileList = $parent.next();
            var newInput = $('<input>').attr({
                "type":"file",
                "name":"files[]"
            });

            var fileName = $input.val().split('/').pop();
            var fileName = fileName.split('\\').pop(); // windows
            var fileExtension = fileName.split('.').pop();
            var elementCount = $('input[type=file]', $elem).length;

            if(elementCount > settings.maxUploads) {
                e.preventDefault
                alert("Anda telah mencapai had maksimum fail yang dibenarkan.");
                $input.remove();
                $elem.append(newInput);
            } else if($.inArray(fileExtension, settings.allowedFiletypes) < 0) {
                e.preventDefault();
                alert("Format file yang dibenarkan ialah :\n" + settings.allowedFiletypes.join(', '));
                $input.remove();
                $elem.append(newInput);
            } else {
                // The delay is purely cosmetic.
                setTimeout(function() {
                    $input.css({
                        position:"absolute",
                        left:"-9999px",
                        top:"-9999px"
                    });
                    $fileList.append('<li><label><input type="checkbox" name="file-list[]" value="' + $input.val() + '" checked="checked">' + fileName + '</label></li>');
                    $parent.append(newInput);
                }, 300);
            }
            $fileList.delegate('input', 'click', function(e) {
                e.stopImmediatePropagation();
                if(confirm("Anda pasti untuk keluarkan fail ini?")) {
                    $listItem = $(this).parent().parent();
                    inputBox = $(this).val();
                    fileBoxes = $('input[type=file]', $elem);
                    $(fileBoxes).each(function() {
                        if($(this).val() == inputBox) {
                            $listItem.remove();
                            $(this).remove();
                        }
                    });
                    if($('input[type=file]', $elem).length === 0) {
                        $elem.append(newInput);
                    }
                } else {
                    e.preventDefault();
                }
            });
        });
    });

    $('#' + settings.parentForm).submit(function(e) {
        $('input[type=file]', $form).each(function() {
            if($(this).val() === undefined || $(this).val() == '') {
                $(this).remove();
            }
        })
    });

}
