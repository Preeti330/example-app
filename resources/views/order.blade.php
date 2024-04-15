<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <style>
        section {
            display: flex;
            align-items: flex-start;
            width: 90%;
            margin: 0 auto;
            margin-top: 20px;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .tittle {
            align-items: center;
            text-align: center;
            background-color: brown;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .content {
            margin: 1px 2px;
        }

        .details {
            align-items: center;

        }
        .btnstyle{
            text-align: center;
        }
        .formcontrol{
            margin: 5px 5px;
        }
    </style>
</head>
<body>
<div class="tittle">
        <h1>Wel Come shopping cart</h1>

    </div>
    <section>
        <div class="container">

            <form id="myform">
                <div class="row">
                    <div class="col-6">
                        <div class="details">
                            <div class="card">
                                <img src="$getCartdetails[0]->image_path" alt="{{$getCartdetails[0]->product_name}}">
                            </div>
                            <div class="content">
                                <h6 class="cardtittle">Product : <strong>{{$getCartdetails[0]->product_name}} </strong></h6>
                                <h6 class="cardtittle">Product Code : <strong>{{$getCartdetails[0]->product_code}}</strong></h6>
                                <div class="amt">
                                    <h6>Product Price : <strong>{{$getCartdetails[0]->price}}</strong></h6>
                                    <h6>Qty : <strong>{{$getCartdetails[0]->qty}}</strong></h6>
                                    <h6>Total  : <strong>{{$getCartdetails[0]->total_price}}</strong></h6>
                                   
                                </div>
                                
                            </div>
                            <div class="varition">
                            </div>
                            <div class="terms">
                                <strong>Terms & Conditions : </strong>
                                <p>{{$getCartdetails[0]->terms_and_conditions}}</p>
                            </div>
                            
                        </div>
                    
                    </div>
                    <div class="col-6">
                        <div class="details">
                            <h6>Please Enter User Info to continue with cart</h6>
                        </div>
                    <div class="formcontrol">
                            <label for="username" class="visually-hidden" style="color: black;">Enater Name</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter Name" value="{{$getCartdetails[0]->username}}" disabled>
                        </div>
                        <div class="formcontrol">
                            <label for="mobile" class="visually-hidden">Mobile</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile Number" value="{{$getCartdetails[0]->mobile}}" disabled>
                        </div>
                        <div class="formcontrol">
                            <label for="email" class="visually-hidden">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter Email">
                        </div>

                        <div class="formcontrol">
                                <label for="address" class="visually-hidden">Shipping Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Please add order delivery address">
                        </div>

                        <div class="formcontrol">
                                <label for="city" class="visually-hidden">City</label>
                                <input type="text" class="form-control" id="city" placeholder="Enter City">
                        </div>
                        <div class="formcontrol">
                                <label for="state" class="visually-hidden">State</label>
                                <input type="text" class="form-control" id="state" placeholder="Enter State">
                        </div>
                        <div class="formcontrol">
                                <label for="pincode" class="visually-hidden">Pincode</label>
                                <input type="text" class="form-control" id="pincode" placeholder="Enter Pincode">
                        </div>


                        <div class="formcontrol"><input type="hidden" id="cart_id" value="{{$getCartdetails[0]->cart_id}}"></div>
                        <!-- <div class="formcontrol">
                            <button type="submit" class="btn btn-primary mb-3">Confirm identity</button>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="btnstyle">
                            <!-- <a href="{{route('cart')}}" class="btn btn-primary" >View Product</a> -->
                            <a href="#" id="orders" class="btn btn-primary">Redeem</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        $(document).ready(function() {
            
            $('#orders').click(function() {
                // This code runs when the element with id 'addToCart' is clicked
                var address = document.getElementById('address').value; 
                var city = document.getElementById('city').value; 
                var state = document.getElementById('state').value; 
                var pincode = document.getElementById('pincode').value;
                var cart_id = document.getElementById('cart_id').value;

                if (address.trim() === ''  && city.trim() === ''  && state.trim() === '') {
                        // throw new Error('To continue with the cart, user details are mandatory.',422);
                        alert('To please order ,above details are mandatory.');
                        return;
                }
                if(!pincode){
                    alert('To please order ,above details are mandatory.');
                        return;
                }
                cartData={
                    'cart_id'  :cart_id,
                    'pincode'  :pincode,
                    'city'     :city,
                    'address'  :address,
                    'state'    :state,
                };


                fetch('/order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(cartData)
                    })
                    .then(response =>response.json()
                    //  {
                    //     if (!response.ok) {
                    //         throw new Error('Network response was not ok');
                    //     }
                    //     alert(response,"pppp")
                    // }
                )
                    .then(data => {
                        // console.log(data); // Handle success response
                        const responseData = data;
                        alert( data.message);
                       
                        window.location.href = data.url;
                        // console.log(responseData,"ppppp")
                     

                    })
                    .catch(error => {
                         console.error('There was an error with the fetch operation:', error.message);
                       // alert(error);
                    });
            });
        });
    </script>


</body>
</html>