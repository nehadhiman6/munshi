<template>
    <div>
        <div class="iw-sider-card-wrap m-box p-0 mb-2">
            <div class="card-body">
                <button
                    class="btn iw-btn-add"
                    v-if="showPaymentDetails == false"
                    @click.prevent="showPaymentDetails = true"
                >
                    Update Card Details
                </button>
                <fieldset class="fieldset" v-if="showPaymentDetails">
                    <legend>Update Card Details</legend>
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="in-label-title"
                                    >Name on Card</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="payment_form.card_name"
                                    v-bind:class="{
                                        'is-invalid': payment_form.errors.get(
                                            'card_name'
                                        )
                                    }"
                                />
                                <span
                                    id="basic-msg"
                                    v-if="form.errors.get('card_name')"
                                    class="invalid-feedback"
                                    >{{ form.errors.get("card_name") }}</span
                                >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="card_no" class="in-label-title"
                                    >Credit Card Number</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="payment_form.card_no"
                                    v-bind:class="{
                                        'is-invalid': payment_form.errors.get(
                                            'card_no'
                                        )
                                    }"
                                />
                                <span
                                    id="basic-msg"
                                    v-if="form.errors.get('card_no')"
                                    class="invalid-feedback"
                                    >{{ form.errors.get("card_no") }}</span
                                >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cvc" class="in-label-title"
                                    >CVC</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="payment_form.cvc"
                                    v-bind:class="{
                                        'is-invalid': payment_form.errors.get(
                                            'cvc'
                                        )
                                    }"
                                />
                                <span
                                    id="basic-msg"
                                    v-if="payment_form.errors.get('cvc')"
                                    class="invalid-feedback"
                                    >{{ payment_form.errors.get("cvc") }}</span
                                >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cvc" class="in-label-title"
                                    >Expiry Date</label
                                >

                                <input
                                    type="month"
                                    id="start"
                                    name="start"
                                    v-model="payment_form.expiry"
                                    class="form-control"
                                />

                                <span
                                    id="basic-msg"
                                    v-if="payment_form.errors.get('expiry')"
                                    class="invalid-feedback"
                                    >{{
                                        payment_form.errors.get("expiry")
                                    }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <input
                            class="btn iw-btn iw-btn-submit"
                            :value="form.form_id > 0 ? 'Update' : 'Save'"
                            @click.prevent="submitForm"
                            type="submit"
                        />
                        <input
                            class="btn iw-btn iw-btn-cancel"
                            value="Cancel"
                            @click.prevent="resetPaymentForm"
                            type="submit"
                        />
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="iw-sider-card-wrap m-box p-0 w-50">
            <div class="card-header">
                <strong>Payment</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="d-flex align-items-center flex-wrap my-2">
                        <label for="name" class="in-label-title"
                            >Name on Card</label
                        >
                        <input
                            class="form-control"
                            type="text"
                            v-model="form.card_name"
                            v-bind:class="{
                                'is-invalid': form.errors.get('card_name')
                            }"
                        />
                        <span
                            id="basic-msg"
                            v-if="form.errors.get('card_name')"
                            class="invalid-feedback"
                            >{{ form.errors.get("card_name") }}</span
                        >
                        <span
                            id="basic-msg"
                            v-if="form.errors.get('gen_msg')"
                            class="invalid-feedback"
                            >{{ form.errors.get("gen_msg") }}</span
                        >
                    </div>
                    <div class="d-flex align-items-center flex-wrap my-2">
                        <label for="amount" class="in-label-title"
                            >Amount</label
                        >
                        <input
                            class="form-control"
                            type="text"
                            v-model="form.amount"
                            v-bind:class="{
                                'is-invalid': form.errors.get('amount')
                            }"
                        />
                        <span
                            id="basic-msg"
                            v-if="form.errors.get('amount')"
                            class="invalid-feedback"
                            >{{ form.errors.get("amount") }}</span
                        >
                    </div>
                    <div id="card-element"></div>
                </div>
                <input
                    type="submit"
                    class="iw-form-submit-btn"
                    value="Pay"
                    @click.prevent="makePayment"
                />
            </div>
        </div>
    </div>
</template>

<script>
var form;
var stripe;
var elements;
var card;
function getNewForm() {
    return new Form({
        form_id: 0,
        amount: "",
        card_name: "",
        payment_result: ""
    });
}
function getPaymentDetail() {
    return new Form({
        form_id: 0,
        card_name: "",
        card_no: "",
        expiry: "",
        cvc: ""
    });
}
export default {
    data: function() {
        return {
            form: getNewForm(),
            payment_form: getPaymentDetail(),
            showPaymentDetails: false
        };
    },
    mounted: function() {
        this.setPaymentData();
    },
    methods: {
        setPaymentData: function() {
            stripe = Stripe(Munshi.payment_key);
            elements = stripe.elements();

            var style = {
                base: {
                    color: "#32325d"
                }
            };

            card = elements.create("card", {
                style: style,
                hidePostalCode: true
            });
            card.mount("#card-element");

            card.addEventListener("change", function(event) {
                var displayError = document.getElementById("card-errors");
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = "";
                }
            });
            this.getPaymentRecord();
        },

        makePayment: function() {
            var self = this;
            Swal.fire({
                position: "center",
                html:
                    "Please do not refresh the page and wait while we are processing your payment.",
                showConfirmButton: false,
                backdrop: true,
                allowOutsideClick: false
            });
            Swal.showLoading();
            this.form["postForm"](Munshi.base_url + "/payments")
                .then(function(response) {
                    if (response.success) {
                        self.intent = response.intent;
                        self.makeStripePayment(self.intent.client_secret);
                    }
                })
                .catch(function(error) {
                    Swal.close();
                    console.log(error.response);
                    if (
                        error &&
                        error.response &&
                        error.response.status == 422
                    ) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: error.response.data.errors.custom_error[0],
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
        },

        makeStripePayment: function(client_secret) {
            var self = this;
            stripe
                .confirmCardPayment(client_secret, {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: self.form.card_name
                        }
                    }
                })
                .then(function(result) {
                    Swal.close();
                    if (result.error) {
                        Swal.fire({
                            position: "center",
                            backdrop: true,
                            allowOutsideClick: false,
                            icon: "error",
                            html: "Sorry! " + result.error.message,
                            title: "Payment Unsuccessful"
                            // timer: 3000
                        });
                    } else {
                        // The payment has been processed!
                        self.form.payment_result = result.paymentIntent;
                        self.savePaymentRecord();
                        // Show a success message to your customer
                        // There's a risk of the customer closing the window before callback
                        // execution. Set up a webhook or plugin to listen for the
                        // payment_intent.succeeded event that handles any business critical
                        // post-payment actions.
                    }
                })
                .catch(function(error) {
                    console.log(error);
                    $.unblockUI();
                });
        },

        savePaymentRecord: function() {
            var self = this;
            this.form["postForm"](Munshi.base_url + "/payments/set-record")
                .then(function(response) {
                    var msg = "";
                    var status,
                        title = "";
                    if (response.payment_status == "succeeded") {
                        status = "success";
                        title = "PAYMENT SUCCESS";
                        msg = "Thank you! Your transaction has been successful";
                    } else {
                        status = "error";
                        title = "PAYMENT FAILED";
                        msg = "Sorry! Your transaction has been failed";
                    }
                    Swal.fire({
                        position: "center",
                        backdrop: true,
                        allowOutsideClick: false,
                        icon: status,
                        html: msg,
                        title: title
                    });
                    self.form = getNewForm();
                    card.clear();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },

        resetPaymentForm: function() {
            this.payment_form = getPaymentDetail();
            this.showPaymentDetails = false;
        },

        getPaymentRecord: function() {
            var self = this;
            axios
                .get(Munshi.base_url + "/card-details")
                .then(function(response) {
                    console.log(response);
                    var card_det = response.data.card_detail;
                    Utilities.copyProperties(card_det, self.payment_form);
                    self.payment_form.expiry = card_det.expiry
                        ? card_det.expiry.substring(0, 7)
                        : "";
                    if (card_det) {
                        $("input[name=cardnumber]").value = card_det.card_no;
                        $("input[name=exp-date]").value = card_det.expiry;
                        $("input[name=cvc]").value = card_det.cvc;
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        },

        submitForm: function() {
            var self = this;
            Utilities.showConfirmationPopMessage(
                "Do you want to save the changes?",
                function(save) {
                    if (save == true) {
                        self.payment_form["postForm"](
                            Munshi.base_url + "/card-details"
                        )
                            .then(function(response) {
                                if (response.success) {
                                    Utilities.showToast(
                                        self,
                                        "success",
                                        "Card Details updated successfully",
                                        2200,
                                        true
                                    );
                                    self.showPaymentDetails = false;
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }
                },
                true,
                false
            );
        }
    }
};
</script>

<style></style>
