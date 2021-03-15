$(document).ready(function() {
    $(document).on('click', '.toggle-modal', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $target = $($this.attr('data-target'));
        var model = (typeof($this.data('model')) != 'undefined') ? $this.data('model') : null;
        $target.modal();

        // auto fill modal input
        var $params = $this.find('.modal-param');

        for (var i = 0; i < $params.length; i++) {
            var $param = $params.eq(i);
            var trigger = (typeof($param.data('trigger')) != 'undefined') ? $param.data('trigger') : '';
            var input_type = $param.attr('type');
            if (input_type == 'radio') {
                if (!$param.prop('checked')) {
                    continue;
                }
            }
            var key = $param.attr('name');
            var value = $param.val();
            var $target_input = $target.find('[name="' + key + '"]');
            var target_type = $target_input.attr('type');

            if (target_type == 'radio') {
                $target_input.each(function(idx, ele) {
                    if ($target_input.eq(idx).val() == value) {
                        $target_input.eq(idx).prop('checked', true);
                    }
                });
            } else {
                $target_input.val(value);
            }
            if (trigger != '') {
                if (trigger == 'changeselect2') {
                    $target_input.val(value.split(",")).change()
                } else {
                    $target_input.trigger(trigger);
                }
            }
        }

        var $param = [];
        if (model != null && typeof(eval('$_MODEL.' + model)) != 'undefined') {
            $param = eval('$_MODEL.' + model);
        }
        var trigger = [];

        for (var key in $param) {
            var value = $param[key];
            var $target_input = $target.find('[name="' + key + '"]');
            trigger.push($target_input);
            var target_type = $target_input.attr('type');
            if (target_type == 'radio') {
                $target_input.each(function(idx, ele) {
                    if ($target_input.eq(idx).val() == value) {
                        $target_input.eq(idx).prop('checked', true);
                    }
                });
            } else {
                $target_input.val(value);
            }
        }

        for (var i = 0; i < trigger.length; i++) {
            if (typeof(trigger[i].data('trigger')) != 'undefined') {
                trigger[i].trigger(trigger[i].data('trigger'));
            }
        }
    });

    $(document).on('shown.bs.modal', function(e) {
        var $modal = $(e.target);
        $(document).off('focusin.modal');
        $modal.find('[autofocus]').focus();
    });
});