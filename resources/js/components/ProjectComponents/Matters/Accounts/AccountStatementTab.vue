<template>

        <div class="form-horizontal">
            <div class="card-body">
                <div class = "form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date" class="in-label-title "> Adjustment Date</label>
                            <input class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('date') }" type="text" v-model ="form.date">
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
                            <td><input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('sale_price') }" type="text" v-model ="form.account_statement.sale_price"></td>
                        </tr>
                        <tr>
                            <td>Deposit </td>
                            <td><input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('deposit') }" type="text" v-model ="form.account_statement.deposit"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Property Taxes
                                <select class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('property_tax') }" aria-placeholder="Select"  v-model ="form.account_statement.property_tax">
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
                                 <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('total_taxes') }" type="text"  v-model ="form.account_statement.total_taxes">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Taxes Paid
                                  <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('taxes_paid') }" type="text"  v-model ="form.account_statement.taxes_paid">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Seller share
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('seller_share') }" type="text"  v-model ="seller_share" disabled>
                            </td>
                            <td>
                                <span>&nbsp;</span>
                                <input class="form-control"  type="text"  v-model ="purchaser_credit" disabled>
                            </td>
                            <td>
                                <span>&nbsp;</span>
                                <input type="text" disabled class="form-control"    v-model ="seller_credit">
                            </td>
                        </tr>
                         <!-- <tr>
                            <th scope="col">Additional Credit</th>
                        </tr> -->
                        <tr v-for="(statement,index) in form.account_statement_transactions" :key='statement.random'>
                            <td >
                                <span><strong>{{statement.additional_credit_type}}</strong></span>
                                <span class="iw-edit-icon" @click.prevent="editTransaction(index)" title="edit" ><span class="mdi mdi-pencil"></span> </span>
                                <span class="iw-remove-icon" @click.prevent="removeTransaction()" title="delete"><span class="mdi mdi-delete"></span> </span>
                                <p class="my-1">{{statement.remarks}}</p>
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
                            <td><input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('purchaser_total') }" type="text"  v-model ="purchaser_total" disabled></td>
                            <td><input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('seller_total') }" type="text"  v-model ="seller_total" disabled></td>
                        </tr>
                         <tr>
                            <td>Balance on Closing </td>
                            <td>
                                <input type="text" class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('balance_due') }" v-if="balance_due < 0" v-model ="balance_payable">
                            </td>
                            <td>
                                <input type="text" class="form-control" disabled v-bind:class="{ 'is-invalid': form.errors.get('balance_due') }" v-if="balance_due >= 0" v-model ="balance_payable">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="d-flex align-items-center">
                                <span class="mr-2">Remarks</span>
                                <input type="text" class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('remarks') }"  v-model ="form.account_statement.remarks">
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
                                    <credit-type-select   v-if="show" :initials="initialCreditType" :selected="selectedCreditType" :string-value ="true" v-bind:class="{ 'is-invalid': additional_form.errors.get('additional_credit_type') }" aria-placeholder="Select"  v-model ="additional_form.additional_credit_type"></credit-type-select>
                                    <!-- <select class="form-control" v-bind:class="{ 'is-invalid': additional_form.errors.get('additional_credit_type') }" aria-placeholder="Select"  v-model ="additional_form.additional_credit_type"> -->
                                        <!-- <option  v-for="credit in credit_types" :key='credit.id' :value='credit.type_name'>{{credit.type_name}}</option>
                                    </select> -->
                                    <span id="basic-msg" v-if="additional_form.errors.get('additional_credit_type')" class="invalid-feedback">{{ additional_form.errors.get('additional_credit_type') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class = "form-row align-items-end">
                            <div class="col">
                                <div class="form-group">
                                    <label for="total_amount" class="in-label-title">Total Amount</label>
                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': additional_form.errors.get('total_amount') }" aria-placeholder="Select"  v-model ="additional_form.total_amount">
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
                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': additional_form.errors.get('additional_credit_amount') }" aria-placeholder="Select"  v-model ="additional_form.additional_credit_amount">
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
            </div>
        </div>

</template>

<script>

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
        account_statement:{
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
        account_statement_transactions:[
        ]
    });
}
export default
{
    props:['file_opening_id','form'],
    data:function(){
        return {
            create_url:'account-statements',
            base_url:Munshi.base_url,
            credit_types:[],
            additional_form:getTransactionForm(),
            initialCreditType:[],
            selectedCreditType:[],
            show:true
        }
    },
    computed:{
        seller_share:function(){
            var share = this.form.account_statement.property_tax == 'previous' ? this.form.account_statement.total_taxes : 0;
            if(this.form.account_statement.total_taxes != '' && this.one_day_share  > 0 && this.form.account_statement.property_tax != 'previous'){
                var share = Utilities.round(this.one_day_share * this.taxes_days);
            }
            this.form.account_statement.seller_share = share;
            return share;
        },

        total_amount:function(){
            var amt = Utilities.round(Utilities.round(this.form.account_statement.sale_price)
                        -Utilities.round(this.form.account_statement.deposit)
                        );
            return Utilities.round(amt - this.tax_to_be_paid);
        },

        tax_to_be_paid:function(){
            if(Utilities.round(this.form.account_statement.seller_share) == 0 )
            {
                return 0;
            }
            return  Utilities.round(Utilities.round(this.form.account_statement.seller_share) - Utilities.round(this.form.account_statement.taxes_paid))
        },

        purchaser_credit:function(){
            if((this.form.account_statement.seller_share - this.form.account_statement.taxes_paid) > 0){
                return Utilities.round(this.form.account_statement.seller_share - this.form.account_statement.taxes_paid);
            }
            return 0;
            // if(this.total_amount < 0){
            //     return -this.total_amount;
            // }
            // return 0;
        },

        seller_credit:function(){
            if((this.form.account_statement.seller_share - this.form.account_statement.taxes_paid) < 0){
                return - Utilities.round(this.form.account_statement.seller_share - this.form.account_statement.taxes_paid);
            }
            return 0;
            //   if(this.total_amount > 0){
            //     return this.total_amount;
            // }
            // return 0;
        },


        taxes_days:function(){
            var days = 0;
            if(this.form.date){
                // var today = moment(new Date());
                var first_day = moment( new Date().setFullYear(new Date().getFullYear(), 0, 1));
                var closing_date =moment(new Date(this.form.date));
                days = closing_date.diff(first_day, 'days')   // =1
            }
            return days;

        },

        one_day_share:function(){
            var one_day_share = 0;
            if(this.form.account_statement.total_taxes != ''){
                one_day_share = Utilities.round(Utilities.round(this.form.account_statement.total_taxes)/365);
            }
            return one_day_share;
        },

        purchaser_total:function(){
            var self = this;
            var total =  Utilities.round( Utilities.round(this.purchaser_credit) +  Utilities.round(this.form.account_statement.deposit));
            this.form.account_statement_transactions.forEach(element => {
                if(element.additional_credit_to == 'purchaser'){
                    total+=Utilities.round(element.additional_credit_amount);
                }
            });
            return Utilities.round(total);
        },

        seller_total:function(){
             var self = this;
            var total =   Utilities.round(Utilities.round(this.seller_credit) + Utilities.round(this.form.account_statement.sale_price));
            console.log("now total is "+ total);
            this.form.account_statement_transactions.forEach(element => {
                if(element.additional_credit_to == 'seller'){
                    total+=Utilities.round(element.additional_credit_amount);
                }
            });
            return Utilities.round(total);

        },

        balance_due:function(){
            var bal =  this.purchaser_total -  this.seller_total;
            this.form.account_statement.balance_due = bal;
            return Utilities.round(bal);
        },

        balance_payable() {
            return Math.abs(this.balance_due);
        }

    },
    mounted:function(){
        this.show = true;
        this.form.file_opening_id = this.file_opening_id;
        this.form.account_statement.file_opening_id = this.file_opening_id;
        this.getAccountStatement();
    },
    methods:{
        getAccountStatement:function(){
            var self = this;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                if(response.data.success){
                    // self.form = getNewForm();
                    var account_statement = response.data.file_opening.account_statement;
                    console.log(account_statement);
                    self.credit_types = response.data.credit_types;
                    var account_statement_transactions = response.data.file_opening.account_statement_transactions;
                    var file_opening = response.data.file_opening;
                    self.form.date = file_opening.closing_date;
                    self.form.file_opening_id = self.file_opening_id;
                    if(account_statement){
                        self.form.account_statement = account_statement;
                        self.form.account_statement.file_opening_id = self.file_opening_id;
                    }

                    account_statement_transactions.forEach(element => {
                        var account_statement_transaction = getNewTransaction();
                        Utilities.copyProperties(element,account_statement_transaction);
                        self.form.account_statement_transactions.push(account_statement_transaction);
                    });
                }
            })
            .catch(function(error){
                console.log(error.response);
            });
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

        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                       if(response.success){
                            Utilities.showToast(self,'success','Account Statement updated successfully',2200,true);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);

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
            var detail = getNewTransaction();
            var is_index = this.additional_form.edit_index;
            this.additional_form.edit_index = -1;
            Utilities.copyProperties(this.additional_form,detail);
            console.log("is_index");
            console.log(is_index);
            if(is_index >=0){
                 this.form.account_statement_transactions[is_index] = detail;
            }
            else{
                this.form.account_statement_transactions.push(detail);
            }
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
            this.form.account_statement_transactions.forEach((element,ind) => {
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
            this.form.account_statement_transactions.forEach((element,ind) => {
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
            this.form.account_statement_transactions.splice(index,1);
        },

        editTransaction:function(index){
            var self = this;
            this.additional_form = getTransactionForm();
            this.additional_form.edit_index =index;
            this.show = false;
            Utilities.copyProperties(this.form.account_statement_transactions[index],this.additional_form);
            this.initialCreditType = [{'text':this.form.account_statement_transactions[index].additional_credit_type,'id':0}];
            this.selectedCreditType = [0];
            setTimeout(function(){
                self.show = true;
            },200)
;        }
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
