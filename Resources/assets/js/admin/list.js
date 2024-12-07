$(function (){
    const createRulesListSortableInstances = () => {
        const nestedSortable = document.querySelectorAll('.rules-list-nav-nested-sortable');
        return Array.from(nestedSortable).map(
            (nestedSortable) =>
                new Sortable(nestedSortable, {
                    group: 'nested',
                    handle: '.sortable-handle',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onMove: (event) => {
                        const level = $(event.to).parents(
                            '.rules-list-nav-nested-sortable',
                        ).length;
                        const length = $(event.dragged).find(
                            '.rules-list-nav-nested-sortable > li',
                        ).length;
                        return !((length > 0 && level > 0) || level > 1);
                    },
                }),
        );
    };

    let sortablesRulesList = createRulesListSortableInstances();
    document
        .querySelector('.chrome-tabs')
        .addEventListener('contentRender', () => {
            sortablesRulesList = createRulesListSortableInstances();
        });
    $(document).on('click', '#saveRulesList', (e)=> {
        let orderedIds = getNestedOrder(sortablesRulesList);
        saveRulesOrder(orderedIds);

    });

    function getNestedOrder(sortables) {
        let order = [];
        sortables.forEach((sortable) => {
            let items = sortable.toArray();
            items.forEach((itemId, index) => {
                let element = document.getElementById(itemId);
                let parentSortable = element.closest('.rules-list-nav-nested-sortable');
                let parentId = parentSortable ? parentSortable.getAttribute('id') : null;
                order.push({ id: itemId, parentId: parentId, position: index});
            });
        });
        return order;
    }

    function saveRulesOrder(order) {
        let data = order.map((item) => ({
            id: item.id,
            parent_id: item.parentId,
            position: item.position + 1,
        }));

        fetch(u('admin/api/rules/save-order'), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                "x-csrf-token":document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
            body: JSON.stringify({ order: data }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.error) throw new Error(data.error);

                toast({
                    type: 'success',
                    message: data.success ?? translate('def.success')
                });
            })
            .catch((error) => {
                toast({
                    type: 'error',
                    message: error ?? translate('def.unknown_error')
                })
            });
    }

    $(document).on('click', '.rules_delete', async function () {
        let itemId = $(this).data('deleteitem');
        if (await asyncConfirm(translate('rules.admin.list.confirm_delete'))) {
            sendRequest({}, u('admin/api/rules/' + itemId), 'DELETE');
            // Удаление элемента из DOM
            $(this).closest('.draggable').remove();
        }
    });
});