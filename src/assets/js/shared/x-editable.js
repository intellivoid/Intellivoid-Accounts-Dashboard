(function($) {
  'use strict';
  $(function() {
    if ($('#editable-form').length) {
      $.fn.editable.defaults.mode = 'inline';
      $.fn.editableform.buttons =
        '<button type="submit" class="btn btn-primary btn-sm editable-submit">' +
        '<i class="mdi mdi-check"></i>' +
        '</button>' +
        '<button type="button" class="btn btn-default btn-sm editable-cancel">' +
        '<i class="mdi mdi-close"></i>' +
        '</button>';
      $('#username').editable({
        type: 'text',
        pk: 1,
        name: 'username',
        title: 'Enter username'
      });

      $('#firstname').editable({
        validate: function(value) {
          if ($.trim(value) === '') $('#firstname').addClass('border-danger');
        }
      });

    }
  });
})(jQuery);