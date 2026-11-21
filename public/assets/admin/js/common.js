/**
 * Generates the notification on activity
 *
 * @param {str}  message    The message
 * @param {str}  alertType  The alert type
 */
function jGrowlAlert(message, alertType) {

    var header_msg = alertType == 'success' ? 'Success!' : 'Oh Snap!';
    $.jGrowl(message, {
        header: header_msg,
        theme: 'bg-' + alertType
    });
}

/**
 * Selects/deselects all the checkboxes
 *
 * @param {obj}  obj  The checkbox object
 */
function select_all(obj) {

    if (obj.checked) {
        $(".checkbox").each(function() {
            $(this).prop("checked", "checked");
            $(this).parent().addClass("checked");
        });
    } else {
        $('.checkbox').each(function() {
            this.checked = false;
            $(this).parent().removeClass("checked");
        });
    }
}

/**
 * Enables Drag and Drop reordering on table tbody
 *
 * @param {string} tableSelector
 * @param {string} reorderUrl
 */
function makeTableSortable(tableSelector, reorderUrl) {
    var $tbody = $(tableSelector).find('tbody');
    if (!$tbody.length) return;

    $tbody.sortable({
        handle: '.drag-handle',
        items: 'tr.sortable-row',
        axis: 'y',
        cursor: 'move',
        placeholder: 'ui-sortable-placeholder',
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },
        start: function(e, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(event, ui) {
            var order = [];
            $tbody.find('tr.sortable-row').each(function(index) {
                var id = $(this).data('id');
                if (id) {
                    order.push({
                        id: id,
                        sort_order: index + 1
                    });
                    $(this).find('.sort-order-badge').text(index + 1);
                }
            });

            $.ajax({
                url: reorderUrl,
                type: 'POST',
                data: {
                    order: order,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        jGrowlAlert(response.message || 'Ordering updated successfully.', 'success');
                    } else {
                        jGrowlAlert(response.message || 'Failed to update order.', 'danger');
                    }
                },
                error: function(xhr) {
                    jGrowlAlert('An error occurred while updating order.', 'danger');
                }
            });
        }
    });
}
