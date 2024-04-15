$(document).ready(function() {
    $('#addToCart').click(function(e) {
        e.preventDefault(); // Prevent the default anchor tag behavior

        // Example product data
        var productData = {
            product_id: 35
            // Add more product data as needed
        };

        // Send AJAX POST request
        $.ajax({
            url: '/cart/addcart',
            type: 'POST',
            data: productData,
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
            }
        });
    });
});
