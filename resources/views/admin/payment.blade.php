<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Payment Gateway</title>
  </head>
  <body>

    <div class="container">
        <div class="header mt-2 px-5 text-center bg-primary py-5 text-white">
            <h1>Pay for services</h1>
        </div>
        <div class="main">
            <form id="makePaymentForm">
                @csrf
               <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required placeholder="Enter full name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required placeholder="Enter email">
                       </div>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount">
                       </div>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="number">Phone Number</label>
                        <input type="number" name="number" id="number" class="form-control" placeholder="Enter Phone Number">
                       </div>

                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary" id="start-payment-button">Pay Now</button>
                </div>



               </div>
              </form>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://checkout.flutterwave.com/v3.js"></script>

    <script>
        $(function () {
            $("#makePaymentForm").submit(function (e) {
                e.preventDefault();

                var name = $("#name").val();
                var email = $("#email").val();
                var phone = $("#number").val();
                var amount = $("#amount").val();
                //make payment
                makePayment(amount,email,phone,name);

            });
        });

      function makePayment(amount,email,phone_number,name) {
        FlutterwaveCheckout({
          public_key: "FLWPUBK_TEST-0c2fb20b097ff5551ce4a6d635d6f9ae-X",
          tx_ref: "RX1_{{substr(rand(0,time()),0,7)}}",
          amount,
          currency: "NGN",
          payment_options: "card, banktransfer, ussd",


          customer: {
            email,
            phone_number,
            name,
          },
          callback: function(data) {
            var transaction_id = data.transaction_id
           // console.log(transaction_id);

           //Make ajax request
           var _token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                url: "{{URL::to('verify-payment')}}",
                data: {
                    transaction_id,
                    _token
                },
                success: function(reponse) {
                    console.log(reponse);

                }
            });

          },
          onclose: function() {

          },
          customizations: {
            title: "The Titanic Store",
            description: "Payment for an awesome cruise",
            logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
          },
        });
      }
    </script>
  </body>
</html>
