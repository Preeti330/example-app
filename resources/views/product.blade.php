<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <!-- bootstarp cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="tabstyle.css">
    <link rel="stylesheet" href="index.css">
    <style>
        aside {
    width: 200px;
    background-color: #333;
    color: #fff;
    padding: 20px;
   margin-top: 15px;

}
aside ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
aside ul li {
    margin-bottom: 10px;
}
aside ul li a {
    color: #fff;
    text-decoration: none;
}
.main-content {
    flex: 1;
    padding: 20px;
}

.tittle{
    align-items: center;
    text-align: center;
    background-color: brown;
    padding-top: 30px;
    padding-bottom: 30px;
}


section {
    display: flex;
    align-items: flex-start; /* Align items to the start (top) of the container */
    width: 90%; /* Set section width */
    margin: 0 auto; /* Center section horizontally */
    margin-top: 20px; /* Add margin from the top */
    background-color: #f0f0f0; /* Example background color */
    padding: 20px; /* Add padding for space inside the section */

}
.listprod {
    flex: 1; /* Take up remaining space */
    padding: 20px;
    background-color: #f0f0f0; /* Example background color */
}
.prod{
    margin-bottom: 15px;
}

.btnstyle{
    text-align: center;
}

</style>
</head>
<body>
    
    <div class="tittle">
        <h1>Wel Come shopping cart</h1>
    </div>
    <section>

        <aside >
                <h2>Filter</h2>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Products</a></li>
                </ul>
        </aside>
        <div class="listprod">
            <div class="container">

                <div class="row">
                    @foreach($product as $key=>$val)
                        <div class="col-4 prod">
                            <div class="details">
                                <div class="card">
                                    <img src="$val->image_path" alt="{{$val->product_name}}">
                                </div>
                            </div>
                            <div class="content">
                                <h6 class="cardtittle">{{$val->product_name}}</h6>
                                <div class="amt">
                                    <h5>Price : <strong>{{$val->points}}</strong></h5>
                                </div>
                            </div>
                            <!-- <div class="terms">
                                <strong>Description : </strong>
                                <p>{{$val->desc}}</p>
                            </div>
                            <div class="terms">
                                <strong>Terms & Conditions : </strong>
                                <p>{{$val->terms_and_conditions}}</p>
                            </div> -->

                            <div class="btnstyle">
                                
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> -->
                                <!-- Add To Cart</button> -->
                               <a href="{{route('productdetail', $val->id)}}" class="btn btn-primary" >View Product</a>
                            </div>
                          
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" >Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>