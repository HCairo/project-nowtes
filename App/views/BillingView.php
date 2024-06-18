<?php
namespace Views;

class BillingView {
    
    public function renderBillingType($plans) {
        echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Stripe Payment Form</title>
                <link rel="stylesheet" href="path/to/your/main.css">
                <script src="https://js.stripe.com/v3/"></script>
            </head>
            <body>
                <h1>Choose Your Plan</h1>';
                
                foreach ($plans as $plan) {
                    echo '<div class="subscription-column">
                            <h2>' . htmlspecialchars($plan['bills']) . '</h2>
                            <p>' . htmlspecialchars($plan['description']) . '</p>
                            <p>Price: $' . htmlspecialchars($plan['price']) . '</p>
                            <button class="select-plan" data-plan-id="' . htmlspecialchars($plan['id']) . '" data-plan-name="' . htmlspecialchars($plan['bills']) . '">Select</button>
                          </div>';
                }

        echo '
                <h2 id="selected-plan">No plan selected</h2>

                <h1>Stripe Payment Form</h1>

                <form id="payment-form" action="process_payment.php" method="POST">
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>

                    <!-- Hidden input fields to send data to the server -->
                    <input type="hidden" name="stripeToken" id="stripeToken">
                    <input type="hidden" name="planId" id="planId">

                    <button id="submit-button" disabled>Submit Payment</button>
                </form>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        fetch("public_key.php")
                            .then(response => response.json())
                            .then(data => {
                                var stripe = Stripe(data.publicKey); // Use the public key from the backend
                                var elements = stripe.elements();

                                // Create an instance of the card Element
                                var card = elements.create("card");

                                // Add an instance of the card Element into the `card-element` <div>
                                card.mount("#card-element");

                                // Handle real-time validation errors from the card Element
                                card.on("change", function(event) {
                                    var displayError = document.getElementById("card-errors");
                                    if (event.error) {
                                        displayError.textContent = event.error.message;
                                    } else {
                                        displayError.textContent = "";
                                    }
                                });

                                // Handle form submission
                                var form = document.getElementById("payment-form");
                                form.addEventListener("submit", function(event) {
                                    event.preventDefault();

                                    stripe.createToken(card).then(function(result) {
                                        if (result.error) {
                                            // Inform the user if there was an error
                                            var errorElement = document.getElementById("card-errors");
                                            errorElement.textContent = result.error.message;
                                        } else {
                                            // Send the token to your server
                                            stripeTokenHandler(result.token);
                                        }
                                    });
                                });

                                // Handle plan selection
                                var planButtons = document.getElementsByClassName("select-plan");
                                Array.from(planButtons).forEach(function(button) {
                                    button.addEventListener("click", function() {
                                        var planId = this.getAttribute("data-plan-id");
                                        var planName = this.getAttribute("data-plan-name");
                                        document.getElementById("planId").value = planId;
                                        document.getElementById("selected-plan").textContent = "Selected Plan: " + planName;
                                        document.getElementById("submit-button").disabled = false;
                                    });
                                });

                                // Submit the form with the Stripe token
                                function stripeTokenHandler(token) {
                                    var form = document.getElementById("payment-form");
                                    var hiddenInput = document.createElement("input");
                                    hiddenInput.setAttribute("type", "hidden");
                                    hiddenInput.setAttribute("name", "stripeToken");
                                    hiddenInput.setAttribute("value", token.id);
                                    form.appendChild(hiddenInput);

                                    // Submit the form
                                    form.submit();
                                }
                            })
                            .catch(error => console.error("Error fetching public key:", error));
                    });
                </script>
            </body>
            </html>';
    }
}