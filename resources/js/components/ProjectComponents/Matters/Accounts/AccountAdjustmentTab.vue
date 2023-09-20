<template>

        <div class="form-horizontal">
            <div class="card-body">
                <div class = "form-row">
                    <div class="col-md-3">
                        <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('date') }">
                            <label for="date" class="in-label-title "> Adjustment Date</label>
                            <input class="form-control" disabled  type="text" v-model ="form.date">
                            <span id="basic-msg" v-if="form.errors.get('date')" class="invalid-feedback">{{ form.errors.get('date') }}</span>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Particulars</th>
                        <th scope="col" width="220">Purchaser Credit</th>
                        <th scope="col" width="220">Seller Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sale Price</td>
                            <td></td>
                            <td>
                                <currency-input   v-bind:class="{ 'is-invalid': form.errors.get('sale_price') }"   v-model="form.statement_adjustment.sale_price"></currency-input>
                            </td>
                        </tr>
                        <tr>
                            <td>Deposit </td>
                            <td>
                                <currency-input   v-bind:class="{ 'is-invalid': form.errors.get('deposit') }"  v-model ="form.statement_adjustment.deposit"></currency-input>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Property Taxes
                                <select class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property_tax') }" aria-placeholder="Select"  v-model ="form.statement_adjustment.property_tax">
                                    <option value="final">Final</option>
                                    <option value="interim">Interim</option>
                                    <option value="previous">Previous</option>
                                </select>
                            </td>
                            <td>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Taxes
                                   <currency-input   v-bind:class="{ 'is-invalid': form.errors.get('total_taxes') }"  v-model ="form.statement_adjustment.total_taxes"></currency-input>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Taxes Paid
                                 <currency-input   v-bind:class="{ 'is-invalid': form.errors.get('taxes_paid') }"  v-model ="form.statement_adjustment.taxes_paid"></currency-input>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Seller share
                                   <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('seller_share') }" disabled="true" v-model ="seller_share"></currency-input>
                            </td>
                            <td>
                                <span>&nbsp;</span>
                                <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('purchaser_credit') }" disabled="true" v-model ="purchaser_credit"></currency-input>
                            </td>
                            <td>
                                <span>&nbsp;</span>
                                <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('seller_credit') }" disabled="true" v-model ="seller_credit"></currency-input>
                            </td>
                        </tr>
                         <!-- <tr>
                            <th scope="col">Additional Credit</th>
                        </tr> -->
                        <tr v-for="(statement,index) in form.statement_adjustment_details" :key='statement.random'>
                            <td >
                                <span><strong>{{statement.additional_credit_type}}</strong></span>
                                <span class="iw-edit-icon" @click.prevent="editTransaction(index)" title="edit" ><span class="mdi mdi-pencil"></span> </span>
                                <span class="iw-remove-icon" @click.prevent="removeTransaction(index)" title="delete"><span class="mdi mdi-delete"></span> </span>
                                <p class="my-1">{{statement.remarks}}</p>
                                <div  v-bind:class="{ 'is-invalid': form.errors.get('statement_adjustment_details.'+index+'.to_date') }">
                                    <span id="basic-msg" v-if="form.errors.get('statement_adjustment_details.'+index+'.to_date') " class="invalid-feedback">
                                        {{ form.errors.get('statement_adjustment_details.'+index+'.to_date')  }}
                                    </span>
                                </div>
                                  <div  v-bind:class="{ 'is-invalid': form.errors.get('statement_adjustment_details.'+index+'.additional_credit_to') }">
                                    <span id="basic-msg" v-if="form.errors.get('statement_adjustment_details.'+index+'.additional_credit_to') " class="invalid-feedback">
                                        {{ form.errors.get('statement_adjustment_details.'+index+'.additional_credit_to')  }}
                                    </span>
                                </div>
                                  <div  v-bind:class="{ 'is-invalid': form.errors.get('statement_adjustment_details.'+index+'.from_date') }">
                                    <span id="basic-msg" v-if="form.errors.get('statement_adjustment_details.'+index+'.from_date') " class="invalid-feedback">
                                        {{ form.errors.get('statement_adjustment_details.'+index+'.from_date')  }}
                                    </span>
                                </div>
                            </td>
                            <td><input class="form-control" type="text"  :value =" getPurchaserCredit(statement,index)" disabled></td>
                            <td><input class="form-control" type="text"  :value =" getSellerCredit(statement,index)" disabled></td>
                        </tr>

                        <tr>
                            <td>
                                <strong>
                                Total
                                </strong>
                            </td>
                            <td>
                                <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('purchaser_total') }" disabled="true" v-model ="purchaser_total"></currency-input>
                            </td>
                            <td><currency-input   v-bind:class="{ 'is-invalid': form.errors.get('seller_total') }"  disabled="true" v-model ="seller_total"></currency-input></td>
                        </tr>
                         <tr>
                            <td>Balance on Closing </td>
                            <td>
                                <currency-input   v-bind:class="{ 'is-invalid': form.errors.get('balance_due') }"  disabled="true"  v-if="balance_due < 0" v-model ="balance_payable"></currency-input>
                            </td>
                            <td>
                                <currency-input   v-bind:class="{ 'is-invalid': form.errors.get('balance_due') }"  disabled="true" v-model ="balance_due"  v-if="balance_due >= 0" ></currency-input>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="d-flex align-items-center">
                                <span class="mr-2">Remarks</span>
                                <input type="text" class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('remarks') }"  v-model ="form.statement_adjustment.remarks">
                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="card-body">
                <fieldset>
                    <legend>Additional Credit</legend>
                    <div >
                        <div class = "form-row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="from_date" class="in-label-title">From date</label>
                                    <input type="hidden" v-bind:class="{ 'is-invalid': additional_form.errors.get('from_date') }">
                                    <date-picker :class-name="additional_form.errors.get('from_date') ? 'from_date is-invalid':'from_date'" v-model ="additional_form.from_date"></date-picker>
                                    <span id="basic-msg" v-if="additional_form.errors.get('from_date')" class="invalid-feedback">{{ additional_form.errors.get('from_date') }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="to_date" class="in-label-title">To date</label>
                                    <input type="hidden" v-bind:class="{ 'is-invalid': additional_form.errors.get('to_date') }">
                                    <date-picker  :class-name="additional_form.errors.get('to_date') ? 'to_date is-invalid':'to_date'" v-model ="additional_form.to_date"></date-picker>
                                    <span id="basic-msg" v-if="additional_form.errors.get('to_date')" class="invalid-feedback">{{ additional_form.errors.get('to_date') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="additional_credit_to" class="in-label-title">Additional Credit to</label>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': additional_form.errors.get('additional_credit_to') }" aria-placeholder="Select"  v-model ="additional_form.additional_credit_to">
                                        <option value="purchaser">Purchaser</option>
                                        <option value="seller">Seller</option>
                                    </select>
                                    <span id="basic-msg" v-if="additional_form.errors.get('additional_credit_to')" class="invalid-feedback">{{ additional_form.errors.get('additional_credit_to') }}</span>
                                </div>

                            </div>

                            <div class="col">
                                <div class="form-group">
                                <label for="additional_credit_type" class="in-label-title">Credit Type</label>
                                <div class="input-group flex-nowrap mb-3">
                                    <div class="w-100">
                                           <credit-type-select   v-if="show" :initials="initialCreditType" :selected="selectedCreditType" :string-value ="true" v-bind:class="{ 'is-invalid': additional_form.errors.get('additional_credit_type') }" aria-placeholder="Select"  v-model ="additional_form.additional_credit_type"></credit-type-select>
                                    </div>
                                    <div class="input-group-append" v-if="permissions['transaction-type-modify'] == 'transaction-type-modify'">
                                        <button class="btn iw-add-new-btn" @click.prevent="addCreditType()" ><span class="mdi mdi-plus"></span></button>
                                    </div>
                                </div>
                                <span id="basic-msg" v-if="additional_form.errors.get('additional_credit_type')" class="invalid-feedback">{{ additional_form.errors.get('additional_credit_type') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class = "form-row align-items-end">
                            <div class="col">
                                <div class="form-group">
                                    <label for="total_amount" class="in-label-title">Total Amount</label>
                                    <currency-input  v-bind:class="{ 'is-invalid': additional_form.errors.get('total_amount') }"  v-model ="additional_form.total_amount" ></currency-input>
                                <span id="basic-msg" v-if="additional_form.errors.get('total_amount')" class="invalid-feedback">{{ additional_form.errors.get('total_amount') }}</span>
                                </div>
                            </div>
                                <div class="col">
                                    <div class="form-group text-right">
                                    <button class="btn btn-primary" @click.prevent="calculateCreditAmount()">Calculate</button>
                                    </div>
                                </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="additional_credit_amount" class="in-label-title">Additional Credit Amount</label>
                                    <currency-input v-bind:class="{ 'is-invalid': additional_form.errors.get('additional_credit_amount') }"   v-model ="additional_form.additional_credit_amount" ></currency-input>
                                    <!-- <input type="text" class="form-control" aria-placeholder="Select"  v-model ="additional_form.additional_credit_amount"> -->
                                    <span id="basic-msg" v-if="additional_form.errors.get('additional_credit_amount')" class="invalid-feedback">{{ additional_form.errors.get('additional_credit_amount') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="re" class="in-label-title">Remarks</label>
                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': additional_form.errors.get('remarks') }"  v-model ="additional_form.remarks">
                                </div>
                            </div>
                        </div>
                        <button class='btn btn-primary' @click.prevent='addAdditionalForm'><span class="mdi mdi-plus"></span> Add</button>
                        </div>
                </fieldset>
                <transaction-form v-if='crediType ==true'
                    @closeTriggered="crediType = false"
                    :form-id="0">
                </transaction-form>
            </div>
        </div>

</template>

<script>
import TransactionForm from '../../Masters/TransactionType/TransactionForm.vue';

function getTransactionForm(){
    return new Form({
        id:0,
        edit_index:-1,
        additional_credit_to:'',
        additional_credit_type:'',
        additional_credit_amount:'',
        total_amount:'',
        from_date:'',
        to_date:'',
        remarks:'',
        random: Utilities.getRandomNumber()
    });
}

function getNewTransaction(){
    return{
        id:0,
        additional_credit_to:'',
        additional_credit_type:'',
        additional_credit_amount:'',
        total_amount:'',
        from_date:'',
        to_date:'',
        remarks:'',
        random:Utilities.getRandomNumber()
    }

}
function getNewForm(){
    return new Form({
        file_opening_id:0,
        date:'',
        statement_adjustment:{
            id:0,
            file_opening_id:'',
            sale_price:'',
            deposit:'',
            property_tax:'',
            total_taxes:'',
            taxes_paid:'',
            seller_share:'',
            total:'',
            remarks:'',
            balance_due:'',
            seller_credit:'0.00'
        },
        statement_adjustment_details:[
        ]
    });
}
export default
{
  components: { TransactionForm },
    props:['file_opening_id','form','permissions','file_opening','update_file_opening'],
    data:function(){
        return {
            create_url:'statement-adjustments',
            base_url:Munshi.base_url,
            additional_form:getTransactionForm(),
            initialCreditType:[],
            selectedCreditType:[],
            show:true,
            crediType:false
        }
    },
    computed:{
        seller_share:function(){
            var share = 0;
            if(this.form.statement_adjustment.property_tax != "previous" && this.form.statement_adjustment.total_taxes != '' && this.one_day_share  > 0){
                var share = Utilities.round(this.one_day_share * this.taxes_days);
            }

            if(this.form.statement_adjustment.property_tax == "previous") {
                share = this.form.statement_adjustment.total_taxes;
            }

            this.form.statement_adjustment.seller_share = share;
            return share;
        },

        total_amount:function(){
            var amt = Utilities.round(Utilities.round(this.form.statement_adjustment.sale_price)
                        -Utilities.round(this.form.statement_adjustment.deposit)
                        );
            return Utilities.round(amt - this.tax_to_be_paid);
        },

        tax_to_be_paid:function(){
            if(Utilities.round(this.form.statement_adjustment.seller_share) == 0 )
            {
                return 0;
            }
            return  Utilities.round(Utilities.round(this.form.statement_adjustment.seller_share) - Utilities.round(this.form.statement_adjustment.taxes_paid))
        },

        purchaser_credit:function(){
            if((this.form.statement_adjustment.seller_share - this.form.statement_adjustment.taxes_paid) > 0){
                return Utilities.round(this.form.statement_adjustment.seller_share - this.form.statement_adjustment.taxes_paid);
            }
            return 0;
        },

        seller_credit:function(){
            if((this.form.statement_adjustment.seller_share - this.form.statement_adjustment.taxes_paid) < 0){
                return - Utilities.round(this.form.statement_adjustment.seller_share - this.form.statement_adjustment.taxes_paid);
            }
            return 0;
        },


        taxes_days:function(){
            var days = 0;
            if(this.form.date){
                var first_day = moment().startOf('year');
                var closing_date =moment(new Date(this.form.date));
                days = closing_date.diff(first_day, 'days')   // =1
            }
            return days;

        },

        one_day_share:function(){
            var one_day_share = 0;
            if(this.form.statement_adjustment.total_taxes != ''){
                one_day_share = this.form.statement_adjustment.total_taxes/365;
            }
            return one_day_share;
        },

        purchaser_total:function(){
            var self = this;
            var total =  Utilities.round( Utilities.round(this.purchaser_credit) +  Utilities.round(this.form.statement_adjustment.deposit));
            this.form.statement_adjustment_details.forEach(element => {
                if(element.additional_credit_to == 'purchaser'){
                    total+=Utilities.round(element.additional_credit_amount);
                }
            });
            return Utilities.round(total);
        },

        seller_total:function(){
             var self = this;
            var total =   Utilities.round(Utilities.round(this.seller_credit) + Utilities.round(this.form.statement_adjustment.sale_price));
            console.log("now total is "+ total);
            this.form.statement_adjustment_details.forEach(element => {
                if(element.additional_credit_to == 'seller'){
                    total+=Utilities.round(element.additional_credit_amount);
                }
            });
            return Utilities.round(total);

        },

        balance_due:function(){
            var bal = this.seller_total - this.purchaser_total;
            this.form.statement_adjustment.balance_due = bal;
            return Utilities.round(bal);
        },

        balance_payable() {
            return Math.abs(this.balance_due);
        }

    },

    watch:{
        update_file_opening:{
            handler: function(newValue) {
                this.getStatementAdjustment();
            },
        }
    },

    mounted:function(){
        this.show = true;
        this.form.file_opening_id = this.file_opening_id;
        this.form.statement_adjustment.file_opening_id = this.file_opening_id;
        this.getStatementAdjustment();
    },
    methods:{
        getStatementAdjustment:function(){
            var self = this;
            var statement_adjustment = self.file_opening.statement_adjustment;
            var statement_adjustment_details = self.file_opening.statement_adjustment_details ? self.file_opening.statement_adjustment_details :[];
            var file_opening = self.file_opening;
            self.form.date = file_opening.closing_date;
            self.form.file_opening_id = self.file_opening_id;
            if(statement_adjustment){
                self.form.statement_adjustment = statement_adjustment;
                self.form.statement_adjustment.file_opening_id = self.file_opening_id;
            }


            statement_adjustment_details.forEach(element => {
                var account_statement_transaction = getNewTransaction();
                Utilities.copyProperties(element,account_statement_transaction);
                self.form.statement_adjustment_details.push(account_statement_transaction);
            });

            self.form.resources = self.file_opening.statement_adjustment.resources;
            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
        },

        calculateCreditAmount:function(){

            var self= this;
            var from_date = moment(this.additional_form.from_date, 'MM-DD-YYYY');
            var to_date = moment(this.additional_form.to_date, 'MM-DD-YYYY');
            var closing_date = moment(this.form.date,'MM-DD-YYYY');
            var amount_days = to_date.diff(from_date, 'days');
            var per_day_amount = Utilities.round(this.additional_form.total_amount /amount_days);
            var before_closing_days =  closing_date.diff(from_date, 'days');
            var after_closing_days =  to_date.diff(closing_date, 'days');
            if (closing_date.isBefore(from_date) || closing_date.isAfter(to_date)) {
                self.additional_form.additional_credit_amount =this.additional_form.total_amount;
                return;
            }

            if(self.additional_form.additional_credit_to == 'purchaser'){
                self.additional_form.additional_credit_amount = Utilities.round(after_closing_days * per_day_amount);
            }
            else if(self.additional_form.additional_credit_to == 'seller'){
                self.additional_form.additional_credit_amount = Utilities.round(before_closing_days * per_day_amount);
            }

        },

        addAdditionalForm:function(){
            var errors = false;
            var erors_object  = {};
            if(this.additional_form.additional_credit_type ==''){
                erors_object.additional_credit_type = ["credit type required"];
                errors = true;
            }
             if(this.additional_form.additional_credit_amount ==''){
                 erors_object.additional_credit_amount = ["additional credit amount required"];
                errors = true;
            }
            if(this.additional_form.from_date ==''){
                 erors_object.from_date = ["from date is required"];
                errors = true;
            }

            if(this.additional_form.additional_credit_to == ''){
                   erors_object.additional_credit_to = ["credit to is required"];
                errors = true;
            }

            if(this.additional_form.to_date ==''){
                 erors_object.to_date = ["To date is required"];
                errors = true;
            }
            if( moment(this.additional_form.from_date,'MM-DD-YYYY').isAfter(moment(this.additional_form.to_date,'MM-DD-YYYY'))){
                erors_object.to_date = ["To date should be greater than from date"];
                errors = true;
            }

            this.additional_form.errors.record(erors_object);


            if(errors == true){
                return;
            }
            var self = this;

            var sd = this.form.statement_adjustment_details.find(ele => ele.random == self.additional_form.random);
            var new_trn = false;

            if(sd == undefined) {
                sd = getNewTransaction();
                new_trn = true;
            }
            // var detail = getNewTransaction();
            // var is_index = this.additional_form.edit_index;
            // this.additional_form.edit_index = -1;
            Utilities.copyProperties(this.additional_form, sd);
            // console.log("is_index");
            // console.log(is_index);
            // if(is_index >= 0){
            //      this.form.statement_adjustment_details[is_index] = detail;
            // }
            // else{
            if(new_trn) {
                this.form.statement_adjustment_details.push(sd);
            }
            // }
            this.additional_form = getTransactionForm();
            this.initialCreditType = [];
            this.selectedCreditType = [];
        },

        getPurchaserCredit:function(statement,index){
            if(statement.additional_credit_to == 'purchaser')
            {
                return statement.additional_credit_amount;
            }
            else{
                return 0;
            }

            //*************************old below */

            var self = this;
            var total = this.purchaser_credit;
            this.form.statement_adjustment_details.forEach((element,ind) => {
                if(element.additional_credit_to == 'purchaser' && ind <= index){
                    total+= Utilities.round(element.additional_credit_amount);
                }
            });
            return Utilities.round(total);
        },

        getSellerCredit:function(statement,index){
             if(statement.additional_credit_to == 'seller')
            {
                return statement.additional_credit_amount;
            }
            else{
                return 0;
            }
             //*************************old below */

             var self = this;
            var total = this.seller_credit;
            this.form.statement_adjustment_details.forEach((element,ind) => {
                if(element.additional_credit_to == 'seller'  && ind <= index){
                    console.log("element is");
                    console.log(element);
                     console.log("ind : " +ind);
                console.log("index : " +index);
                    total += Utilities.round(element.additional_credit_amount);
                    console.log("amount added in total "+element.additional_credit_amount);
                    console.log(" Now  TOtal is  " +total);
                }
            });
            return Utilities.round(total);
        },

        removeTransaction:function(index){
            this.form.statement_adjustment_details.splice(index,1);
        },

        editTransaction:function(index){
            var self = this;
            this.additional_form = getTransactionForm();
            this.additional_form.edit_index = index;
            this.show = false;
            Utilities.copyProperties(this.form.statement_adjustment_details[index],this.additional_form);
            this.initialCreditType = [{'text':this.form.statement_adjustment_details[index].additional_credit_type,'id':0}];
            this.selectedCreditType = [0];
            setTimeout(function(){
                self.show = true;
            },200)
       },

        addCreditType:function(){
            this.crediType = true;
        }
    }
}
</script>

<style>
.iw-remove-btn {
    display: table;
    margin: 10px;
    background: #f44336;
    color: #fff;
    padding: 5px 20px;
    margin-left: auto;
    cursor: pointer;
}
span.iw-edit-icon {
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    display: inline-block;
    border: 1px solid #03a9f4;
    margin: 0 2px;
    color: #fff;
    background: #03a9f4;
    border-radius: 3px;
    cursor: pointer;
}
span.iw-remove-icon {
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    display: inline-block;
    border: 1px solid #f44336;
    margin: 0 2px;
    color: #fff;
    background: #f44336;
    border-radius: 3px;
    cursor: pointer;
}
</style>
