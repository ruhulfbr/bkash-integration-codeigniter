<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Merchant</title>
    <meta name="viewport" content="width=device-width" ,="" initial-scale="1.0/">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrom=1">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script id = "myScript" src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
 
</head>

<body>

    <center>
        <h1 style="margin-top: 200px;">Please wait......</h1>
    </center>

<button id="bKash_button" style="display: none;">Pay With bKash</button>

<script type="text/javascript">

    var accessToken = '<?php echo $bkash_token; ?>';
    $(document).ready(function(){

        var paymentConfig = {
            createCheckoutURL: "<?php echo $create_url; ?>",
            executeCheckoutURL:"<?php echo $execute_url; ?>",
        };

        var paymentRequest = { amount: 500, intent:'sale'};

        bKash.init({
            paymentMode: 'checkout',
            paymentRequest: paymentRequest,
            createRequest: function(request){                
                $.ajax({
                    url: paymentConfig.createCheckoutURL,
                    type:'POST',
                    contentType: 'application/json',
                    success: function(data) {                        
                        var response = JSON.parse(data);
                        var obj = response.data;
                        
                        if(data && response.status == 'success' && obj.paymentID != null){
                            paymentID = obj.paymentID;
                            bKash.create().onSuccess(obj);
                        }
                        else {
                            console.log('error');
                            bKash.create().onError();
                            alert('Initialization failed')
                        }
                    },
                    error: function(){
                        console.log('error');
                        bKash.create().onError();
                        alert('Initialization failed')
                    }
                });
            },            
            executeRequestOnAuthorization: function(){
                $.ajax({
                    url: paymentConfig.executeCheckoutURL+"&paymentID="+paymentID,
                    type: 'POST',
                    contentType:'application/json',
                    success: function(data){                        
                        let response = JSON.parse(data);
                        let obj = response.data;
                        if(data && response.status == 'success' && data.paymentID != null){
                            alert('Payment success')                       
                        }
                        else {
                            bKash.execute().onError();
                            alert('Payment Failed') 
                        }
                    },
                    error: function(){
                        bKash.execute().onError();
                        alert('Payment Failed') 
                    }
                });
            },
            onClose: function () {
                alert('Payment Cancelled') 
            }
        });
        
        clickPayButton();
    });
  
  function callReconfigure(val){
        bKash.reconfigure(val);
    }

    function clickPayButton(){
        $("#bKash_button").trigger('click');
    }
</script>
    
</body>
</html>