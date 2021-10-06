<?php
/**
 * Template Name: Stripe Payment
 * This template will be used to take custom payments using Stripe API's
 */
get_header();
if(class_exists('Stripe_Controller')){
    if(isset($_POST['stripeToken'])){
        $arrReturn = Stripe_Controller::handlePaymentPost($_POST);
    }
}
?>

<?php get_template_part('templates/gtheme','wp_page');?>
    <div class="container stripe-container">
        <form id="payment-stripe" method ="post">
            <div class="row">
                <!--First Name-->
                <div class="col-md-5">
                    <label>First Name <span class="stripe-required">*<span></label>
                    <input type="text" required="required" placeholder="Write First Name" name="first_name" class="form-control input-text">
                </div>
                <!--Last Name-->
                <div class="col-md-5">
                    <label>Last Name <span class="stripe-required">*<span></label>
                    <input type="text" required="required" placeholder="Write Last Name" name="last_name" class="form-control input-text">
                </div>
                <!--Amount-->
                <div class="col-md-2">
                <label>Amount<span class="stripe-required">*<span></label>
                    <input type="number" placeholder="Amount" name="amount" class="form-control input-text">
                </div>
            </div>

            <p class="spacer"></p>
            
            <div class="row">
                <!--Email-->
                <div class="col-md-6">
                    <label>Email<span class="stripe-required">*<span></label>
                    <input type="email" placeholder="Your email to get receipt" name="email" class="form-control input-text">
                </div>
                <!--Phone-->
                <div class="col-md-6">
                    <label>Phone</label>
                    <input type="tel" name="phone" placeholder="Your Phone Number" class="form-control input-text">
                </div>
            </div>

            <p class="spacer"></p>
            
            <div class="row">
                <div class="col-md-12">
                    <!--Stripe Card Element-->
                    <div id="card-element"></div>
                </div>
            </div>

            <!--Submit Button and Errors-->
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn-block btn btn-primary btn-theme">SUBMIT</button>
                    <p class="spacer"></p>
                    <div id="card-errors"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php get_footer();?>