require('./bootstrap');

$(function() {
    $('.toggle_wish').on('click', function(event) {
        event.preventDefault()
        const element_a = $(event.target).closest('a')
        const product_id = element_a.data('product-id')
        const wished = element_a.data('wished')

        axios({
            method: wished ? 'delete' : 'post',
            url: '/wish_products/'+product_id
        }).then(function(response) {
            if (!response.data.success) {
                return
            }

            if (wished) {
                element_a.data('wished', false)
                element_a.find('i').removeClass('fas')
                element_a.find('i').addClass('far')
            } else {
                element_a.data('wished', true)
                element_a.find('i').removeClass('far')
                element_a.find('i').addClass('fas')
            }
        }).catch((error) => {
            console.log('catch:', error)
        });
    });
});
