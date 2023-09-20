<template>

        <div class="form-horizontal">
            <div class="card-header bg-white">
                <div class="text-right">
                    <button class="btn iw-btn iw-refresh-btn" @click="getDirectionFund"><span class="mdi mdi-refresh"></span> Refresh</button>
                </div>
            </div>
            <div class="card-body">
                <fieldset class="fieldset">
                    <table>
                         <tr>
                            <td>To :</td>
                            <td><span v-text='to'></span></td>
                        </tr>
                        <tr>
                            <td>And To :</td>
                            <td><span v-text='and_to'></span></td>
                        </tr>
                        <tr>
                            <td>RE :</td>
                            <td><span v-text='re'></span></td>
                        </tr>
                        <tr>
                            <td>Date :</td>
                            <td></td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset class="fieldset">
                    <table class="table">
                        <!-- <thead>
                            <tr>
                            <th scope="col">Particulars</th>
                            <th scope="col" width="220">Receivable</th>
                            </tr>
                        </thead> -->
                        <tbody>
                            <tr>
                                <td colspan="2">This is to direct you and shall constitute your good and sufficient authority to make certified cheques for
                                    the proceeds of sale in the above transaction payable as follows:
                                </td>
                            </tr>
                             <tr v-for="(redirection_fund,index) in form.redirection_funds" :key="redirection_fund.random">
                                <td>
                                    <span v-if="redirection_fund.custom == 'Y'" class="iw-edit-icon" @click.prevent="editTransaction(index)" title="edit" ><span class="mdi mdi-pencil"></span> </span>
                                    <span v-if="redirection_fund.custom == 'Y'" class="iw-remove-icon" @click.prevent="removeTransaction(index)" title="delete"><span class="mdi mdi-delete"></span> </span>
                                    {{redirection_fund.particulars}}</td>
                                <td>
                                     <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                             <currency-input v-if="redirection_fund.target_field != 'sellers'" v-model ="redirection_fund.amount"></currency-input>
                                             <currency-input disabled v-if="redirection_fund.target_field == 'sellers'" v-model ="get_balance_amt"></currency-input>
                                        </div>
                                        <div class="input-group-append" v-if="redirection_fund.custom == 'N'" >
                                            <button  class="btn btn-primary" v-if="redirection_fund.target_field != 'sellers'" @click.prevent="getSourceData(redirection_fund)">Source</button>
                                        </div>
                                    </div>


                                </td>
                            </tr>
                            <tr>
                                  <td >Total</td>
                                  <td>
                                     <currency-input  :disabled="true" v-model ="total"></currency-input>
                                  </td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>


            </div>
             <div class="card-body">
                <fieldset>
                    <legend><span v-if="redirection_fund_form.edit_index >= 0">Edit</span><span v-else>Add</span> Transaction</legend>
                    <div >
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group">

                                    <label for="particulars" class="in-label-title">Particulars</label>

                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': redirection_fund_form.errors.get('particulars') }"  v-model ="redirection_fund_form.particulars">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="amount" class="in-label-title">Total Amount</label>
                                    <currency-input  v-bind:class="{ 'is-invalid': redirection_fund_form.errors.get('amount') }" v-model ="redirection_fund_form.amount"></currency-input>
                                <span id="basic-msg" v-if="redirection_fund_form.errors.get('amount')" class="invalid-feedback">{{ redirection_fund_form.errors.get('amount') }}</span>
                                </div>
                            </div>
                        </div>
                        <button class='btn btn-primary' @click.prevent='addRedirectionForm'><span class="mdi mdi-plus"></span> Add</button>
                        </div>
                </fieldset>
            </div>
        </div>

</template>

<script>

function getTransactionForm(file_opening_id){
    return new Form({
        id:0,
        file_opening_id:file_opening_id,
        edit_index:-1,
        particulars:'',
        custom:'Y',
        fix_var:'V',
        amount:'',
    });
}

function getNewTransaction(file_opening_id){
    return{
        id:0,
        file_opening_id:file_opening_id,
        particulars:'',
        amount:'',
        original_amount:0,
        target_type:'',
        target_field:'',
        target_id:'',
        custom:'N',
        fix_var:'F',
        random:Utilities.getRandomNumber()
    }

}




export default
{
    props:['file_opening_id','permissions','form','file_opening','update_file_opening'],
    data:function(){
        return {
            create_url:'trust-ledgers',
            base_url:Munshi.base_url,
            to:'',
            and_to:'',
            re:'',
            total_fees_disbursement_without_hst:0,
            paid_hst:0,
            trust_ledgers:[],
            redirection_fund_form:getTransactionForm(this.getTransactionForm),
            amt_other_than_seller: 0
        }
    },


    watch:{
        update_file_opening:{
            handler: function(newValue) {
                this.getDirectionFund();
            },
        }
    },


    mounted:function(){
        this.form.file_opening_id = this.file_opening_id;
        this.getDirectionFund();
    },
    computed: {
        get_balance_amt() {
            var self = this;
            var amt = 0;
            self.form.redirection_funds.forEach(function(rf, index) {
                console.log('rf: ', rf);
                if(rf.target_field != "sellers") {
                    // amt += Utilities.round(rf.amount);
                // } else {
                    amt += Utilities.round(rf.amount);
                }
            });

            var sellers = self.form.redirection_funds.find(ele => ele.target_field == 'sellers');
            if(sellers != undefined && sellers) {
                sellers.amount = self.amt_other_than_seller - amt;
            }

            return Utilities.round(self.amt_other_than_seller - amt);
        },
         total:function(){
            var tot = 0;
            this.form.redirection_funds.forEach(function(ele){
                    tot += Utilities.round(ele.amount);
            });
            return tot;
        },
    },
    methods:{
        getDirectionFund:function(){
            var self = this;
            var file_opening = self.file_opening;
            var redirection_funds = file_opening.redirection_funds;
            var trust_ledgers = file_opening.trust_ledgers;
            self.trust_ledgers = trust_ledgers;
            self.paid_hst =  file_opening.account_statement ? file_opening.account_statement.total_hst:0;
            self.total_fees_disbursement_without_hst =  file_opening.account_statement ? file_opening.account_statement.total_fees_disbursement_without_hst:0;
            self.form.redirection_funds = [];


                // derive First Transaction Data
            var seller_lawyer_transaction = self.getSellerLawyerTransaction(file_opening,redirection_funds);
            self.form.redirection_funds.push(seller_lawyer_transaction);
            // end first Transaction;

                // derive second Transaction Data
            var mortgagee_transactions= self.getMortgageeTransaction(file_opening,redirection_funds);
                self.form.redirection_funds = self.form.redirection_funds.concat(mortgagee_transactions);
            // end second Transaction;

                // derive third Transaction Data
            var commission_transaction = self.getCommissionTransaction(file_opening,redirection_funds);
                self.form.redirection_funds.push(commission_transaction);
            // end third Transaction;



                // derive last Transaction Data
            var seller_transaction = self.getSellerTransaction(file_opening,redirection_funds);
                self.form.redirection_funds.push(seller_transaction);
            // end last Transaction;


            // cUSTOM vALUES
            var variable_redirection_funds = redirection_funds.filter(val => val.fix_var == 'V');
            variable_redirection_funds.forEach(element => {
                var transaction = getNewTransaction(self.file_opening_id);
                Utilities.copyProperties(element,transaction);
                var found = self.form.redirection_funds.some(el => el.particulars === element.particulars);
                if(!found){
                    self.form.redirection_funds.push(transaction);
                }
                else{
                    var ind = self.form.redirection_funds.findIndex(x => x.particulars === element.particulars);
                    if(ind >=0){
                        Utilities.copyProperties(element,self.form.redirection_funds[ind]);
                    }
                }
            });
            // END cUSTOM Values

            // TOP SECTION
            var purchasers = file_opening.purchasers;
            self.to ='';
            purchasers.forEach((element,index) => {
                if(element.salutation == 'Corporation'){

                    self.to += element.company_name + ' ';
                }
                else{
                    self.to += element.first_name ? element.first_name + ' ' :' ';
                    self.to += element.middle_name ? element.middle_name +' ' :'';
                    self.to += element.last_name ? element.last_name+' ' :'' ;
                }
                if(index < purchasers.length-1){
                    self.to += ',' ;
                }
                self.to += ' ' ;

            });

            var purchaser_solicitor =file_opening.purchaser_solicitor;
            if(purchaser_solicitor && purchaser_solicitor.law_firm && purchaser_solicitor.law_firm.firm_name)
            {
                    self.and_to = purchaser_solicitor.law_firm.firm_name;
            }

            var property = file_opening.property;
            if(property){
                self.re = '';
                self.re += property.number ? property.number +', ':'' ;
                self.re += property.street ? property.street +', ':'' ;
                self.re += property.city ? property.city.city_name +', ':'' ;
                self.re += property.country ? property.country +', ':'' ;
                self.re += property.postal_code ? property.postal_code +', ':'' ;
                self.re += property.province ? property.province:'' ;
            }

            self.amt_other_than_seller = 0;
            self.form.redirection_funds.forEach(function(rf, index) {
                console.log('rf: ', rf);
                self.amt_other_than_seller += Utilities.round(rf.amount);
            });
            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));

        },

        getSellerLawyerTransaction:function(file_opening,redirection_funds){
            var self = this;
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.fix_var = 'F';
            var sellers_lawyer = '';

            if(file_opening.solicitor){
                sellers_lawyer = '';
                sellers_lawyer +=file_opening.solicitor.first_name ? file_opening.solicitor.first_name + ' ':' ';
                sellers_lawyer +=file_opening.solicitor.middle_name ? file_opening.solicitor.middle_name +' ' :'';
                sellers_lawyer +=file_opening.solicitor.last_name ? file_opening.solicitor.last_name+' ' :'' ;
            }
            transaction_fixed.particulars =sellers_lawyer + ' ,in Trust' ;
            var  seller_lawyer_data = redirection_funds.find(el => el.target_id === 0 && el.target_type == 'derived' && el.target_field == 'seller_lawyer');
            console.log("seller_lawyer_data");
            console.log(seller_lawyer_data);

            var amount =  this.getLawyerInTrust();
            if(seller_lawyer_data){
                Utilities.copyProperties(seller_lawyer_data,transaction_fixed);
                transaction_fixed.amount = seller_lawyer_data.amount;
                transaction_fixed.original_amount = amount;
            }
            else{
                transaction_fixed.amount =amount;
                transaction_fixed.original_amount = amount;
                transaction_fixed.target_field = 'seller_lawyer';
                transaction_fixed.target_type = 'derived';
                transaction_fixed.target_id = 0;
            }
            return transaction_fixed;
        },

        getLawyerInTrust:function(){
            var self = this;
            var tot = 0;
            tot += Utilities.round(this.total_fees_disbursement_without_hst);
            tot += Utilities.round(this.paid_hst);


            this.trust_ledgers.forEach(function(ele){
                if (ele.target_field != 'derived_total' && ele.fix_var == 'V'){
                    if(ele.type == 'receivable')
                    {
                        tot -= Utilities.round(ele.amount);

                    }
                    else if(ele.type == 'payable')
                    {
                        tot += Utilities.round(ele.amount);
                    }
                }
            });

            console.log("end");

            return  Utilities.round(tot);

        },

        getMortgageeTransaction:function(file_opening,redirection_funds){
            var self = this;
            var arr= [];
            var mortgages = file_opening.mortgages;

            mortgages.forEach((element,index) => {
                var mortgage_name ='';
                var transaction_fixed = getNewTransaction(self.file_opening_id);
                transaction_fixed.fix_var = 'F';
                if(element.mortgagee){
                    mortgage_name += element.mortgagee.first_name && element.mortgagee.first_name !='' ? element.mortgagee.first_name + ' ':'';
                    mortgage_name += element.mortgagee.middle_name && element.mortgagee.middle_name  !=''? element.mortgagee.middle_name + ' ':'';
                    mortgage_name += element.mortgagee.last_name && element.mortgagee.last_name != ''? element.mortgagee.last_name + ' ':'';
                    if(mortgage_name == ''){
                          mortgage_name += element.mortgagee.company_name ? element.mortgagee.company_name + ' ':'';
                    }
                }
                transaction_fixed.particulars =mortgage_name;

                var  mortgage_data = redirection_funds.find(el => el.target_id === element.id && el.target_type == 'mortgage' && el.target_field == 'total_mortgage_payable_discharge');
                if(mortgage_data){
                    Utilities.copyProperties(mortgage_data,transaction_fixed);
                    transaction_fixed.amount = mortgage_data.amount;
                    transaction_fixed.original_amount = element.total_mortgage_payable_discharge;
                }
                else{
                    transaction_fixed.amount = element.total_mortgage_payable_discharge;
                    transaction_fixed.original_amount = element.total_mortgage_payable_discharge;
                }
                transaction_fixed.target_field = 'total_mortgage_payable_discharge';
                transaction_fixed.target_type = 'mortgage';
                transaction_fixed.target_id =  element.id;
                arr.push(transaction_fixed);
            });
            return arr;
        },

        getCommissionTransaction:function(file_opening,redirection_funds){
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.fix_var = 'F';
            var commission =file_opening.commission;
            if(commission && commission.brokerage)
            var  real_estate_broker =commission.brokerage.name;
            transaction_fixed.particulars =real_estate_broker ;

            var paid_real_estate_commission =  file_opening.commission ? file_opening.commission.commission_payable:0;

            var  commission_data = redirection_funds.find(el => file_opening.commission && el.target_id === file_opening.commission.id && el.target_type == 'commission' && el.target_field == 'commission_payable');
            if(commission_data){
                Utilities.copyProperties(commission_data,transaction_fixed);
                transaction_fixed.amount = commission_data.amount;
                transaction_fixed.original_amount = paid_real_estate_commission;
            }
            else{
                transaction_fixed.amount = paid_real_estate_commission;
                transaction_fixed.original_amount =  paid_real_estate_commission;
                transaction_fixed.target_field = 'commission_payable';
                transaction_fixed.target_type = 'commission';
                transaction_fixed.target_id = file_opening.commission ? file_opening.commission.id : 0;
            }
            return transaction_fixed;
        },

        getSellerTransaction:function(file_opening,redirection_funds){
            var self = this;
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.fix_var = 'F';
            var sellers_names = '';

            var sellers = file_opening.sellers;
            sellers.forEach((element,index) => {
                if(element.salutation == 'Corporation'){

                    sellers_names += element.company_name  ? element.company_name + ' ':'';
                }
                else{
                    sellers_names += element.first_name ? element.first_name + ' ' :' ';
                    sellers_names += element.middle_name ? element.middle_name +' ' :'';
                    sellers_names += element.last_name ? element.last_name+' ' :'' ;
                }
                if(index < sellers.length-1){
                    sellers_names += ',' ;
                }
                sellers_names += ' ' ;
            });


            transaction_fixed.particulars =sellers_names;
            var  seller_data = redirection_funds.find(el => el.target_id === 0 && el.target_type == 'derived' && el.target_field == 'sellers');

            var amount =  this.getSellerTransactionAmount();
            if(seller_data){
                Utilities.copyProperties(seller_data,transaction_fixed);
                transaction_fixed.amount = seller_data.amount;
                transaction_fixed.original_amount = amount;
            }
            else{
                transaction_fixed.amount = amount;
                transaction_fixed.original_amount =  amount;
                transaction_fixed.target_field = 'sellers';
                transaction_fixed.target_type = 'derived';
                transaction_fixed.target_id = 0;
            }
            console.log(transaction_fixed)
            return transaction_fixed;
        },

        getSellerTransactionAmount:function(){
             var net = 0;
            var net_receive = 0;
            var net_pay = 0;

            this.trust_ledgers.forEach(function(ele){
                    if(ele.type == 'receivable' &&  ele.target_field != 'derived_total')
                    {
                        net_receive += Utilities.round(ele.amount);
                        console.log("net receieve + "+ele.amount);
                    }
                    else if(ele.type == 'payable' &&  ele.target_field != 'derived_total')
                    {
                        net_pay += Utilities.round(ele.amount);
                        console.log(" net_pay + "+ele.amount);
                    }
            });
            console.log("net ")
            net = Utilities.round(net_receive- net_pay);
            console.log(net);
            return net;
        },

        getSourceData:function(redirection_fund){
            redirection_fund.amount = redirection_fund.original_amount;
        },


        addRedirectionForm:function(){
            var errors = false;
            var erors_object  = {};
             if(this.redirection_fund_form.amount ==''){
                 erors_object.amount = ["amount required"];
                errors = true;
            }
            if(this.redirection_fund_form['particulars'] ==''){
                 erors_object['particulars'] = ["particulars required"];
                errors = true;
            }

            this.redirection_fund_form.errors.record(erors_object);


            if(errors == true){
                return;
            }
            var self = this;
            var detail = getNewTransaction();
            var is_index = this.redirection_fund_form.edit_index;
            this.redirection_fund_form.edit_index = -1;
            Utilities.copyProperties(this.redirection_fund_form,detail);
            if(is_index >=0){
                this.form.redirection_funds[is_index] = detail;
            }
            else{
                // this.form.redirection_funds.splice(this.form.redirection_funds.length-2, 0,detail);
                this.form.redirection_funds.push(detail);
            }
            this.redirection_fund_form = getTransactionForm(this.file_opening_id);
        },


        removeTransaction:function(index){
            this.form.redirection_funds.splice(index,1);
        },

        editTransaction:function(index){
            console.log("index"+index);
            var self = this;
            this.redirection_fund_form = getTransactionForm(this.file_opening_id);
            this.redirection_fund_form.edit_index =index;
            this.show = false;
            Utilities.copyProperties(this.form.redirection_funds[index],this.redirection_fund_form);
        },

    }
}
</script>
