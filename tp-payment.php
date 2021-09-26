<?php
/**
 * Template Name: Stripe Payment
 * This template will be used to take custom payments using Stripe API's
 */
get_header();
if(class_exists('Stripe_Controller')){
    if(isset($_POST)){
        $arrReturn = Stripe_Controller::handlePaymentPost($_POST);
    }
}
?>

<?php get_template_part('templates/gtheme','wp_page');?>
    <div class="container stripe-container">
        <form id="payment-stripe" method ="post">
            <div class="row">
                <div class="col-md-5">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control">
                </div>
                <div class="col-md-5">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control">
                </div>
                <div class="col-md-2">
                <label>Amount</label>
                    <input type="number" name="stripeAmount" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="card-element"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <div id="card-errors"></div>
        </form>
    </div>
</div>
<script>
   
</script>
<?php get_footer();?>