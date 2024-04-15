<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You </title>
    <style>
        /* Additional styles */
        .container {
            margin-top: 50px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            align-items: center;
            text-align: center;
            background: aquamarine;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Order Placed Successfully</div>
                    <div class="card-body">
                        <p>Your order has been successfully placed. Thank you for shopping with us!</p>
                    </div>
                    <div class="continue">
                    <a href="{{route('product')}}" class="btn btn-primary" >Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>