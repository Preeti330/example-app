<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
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
            /* Align items to the start (top) of the container */
            width: 90%;
            /* Set section width */
            margin: 0 auto;
            /* Center section horizontally */
            margin-top: 20px;
            /* Add margin from the top */
            background-color: #f0f0f0;
            /* Example background color */
            padding: 20px;
            /* Add padding for space inside the section */

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
                                <img src="$productDetails[0]->image_path" alt="{{$productDetails[0]->product_name}}">
                            </div>
                            <div class="content">
                                <h6 class="cardtittle">{{$productDetails[0]->product_name}}</h6>
                                <div class="amt">
                                    <h6>Price : <strong>{{$productDetails[0]->price}}</strong></h6>
                                    <h6>Qty : <strong>1</strong></h6>
                                </div>
                            </div>
                            <div class="varition">
                            </div>
                            <div class="terms">
                                <strong>Description : </strong>
                                <p>{{$productDetails[0]->desc}}</p>
                            </div>
                            <div class="terms">
                                <strong>Terms & Conditions : </strong>
                                <p>{{$productDetails[0]->terms_and_conditions}}</p>
                            </div>
                            
                        </div>
                    
                    </div>
                    <div class="col-6">
                        <div class="details">
                            <h6>Please Enter User Info to continue with cart</h6>
                        </div>
                    <div class="formcontrol">
                            <label for="username" class="visually-hidden" style="color: black;">Enater Name</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter Name">
                        </div>
                        <div class="formcontrol">
                            <label for="mobile" class="visually-hidden">Mobile</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile Number">
                        </div>
                        <div class="formcontrol">
                            <label for="email" class="visually-hidden">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter Email">
                        </div>
                        <div class="formcontrol"><input type="hidden" id="product_id" value="{{$productDetails[0]->product_id}}"></div>
                        <!-- <div class="formcontrol">
                            <button type="submit" class="btn btn-primary mb-3">Confirm identity</button>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="btnstyle">
                            <!-- <a href="{{route('cart')}}" class="btn btn-primary" >View Product</a> -->
                            <a href="#" id="addToCart" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        </div>



    </section>

<!--user details -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        $(document).ready(function() {
            
            $('#addToCart').click(function() {
                // This code runs when the element with id 'addToCart' is clicked
                var username = document.getElementById('username').value; 
                var mobile = document.getElementById('mobile').value; 
                var email = document.getElementById('email').value; 
                var product_id = document.getElementById('product_id').value;

                if (username.trim() === '' && mobile.trim() === '') {
                        // throw new Error('To continue with the cart, user details are mandatory.',422);
                        alert('To continue with the cart, user details are mandatory.');
                        return;
                }
                productData={
                    'product_id':product_id,
                    'username'  :username,
                    'email'     :email,
                    'mobile'    :mobile,
                };


                fetch('/cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(productData)
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
                        // alert("Cart ID: " + data.cart_id + ", User ID: " + data.user_id);
                       
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