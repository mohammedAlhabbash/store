// console.log('');

// const { data } = require("alpinejs");

$('.item-quantity').on('change', function (e) {
    $.ajax({
        url: '/carts/' + $(this).data('id'),
        method: 'put',
        data: {
            quantity: $(this).val(),
            _token: token_csrf
        },
        // success: function (data) {
            // var test = JSON.stringify(data);
            // var result = JSON.parse(test);
            // alert(data.data);
            // let text = localStorage.getItem("testJSON");
            // let obj = JSON.parse(text);
        // },
    })
});
$('.remove-item').on('click', function (e) {
    let id = $(this).data('id')
    $.ajax({
        url: '/carts/' + id,
        method: 'delete',
        data: {
            _token: token_csrf
        },
        success: response => {
            $(`#${id}`).remove();
        }
    });
});

