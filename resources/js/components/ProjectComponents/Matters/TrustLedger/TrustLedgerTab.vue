<template>

        <div class="form-horizontal">
            <div class="card-header bg-white">
                <div class="text-right">
                    <button class="btn iw-btn iw-refresh-btn" @click="getTrustLedger"><span class="mdi mdi-refresh"></span> Refresh</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Particulars</th>
                            <th scope="col" width="220">Payable</th>
                            <th scope="col" width="220">Receivable </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(trust,index) in form.trust_ledgers" :key="trust.random">
                            <td >
                                <span v-if="trust.fix_var == 'F'" v-text="trust.particulars"></span>
                                <span v-else>
                                    <span v-if="trust.custom == 'Y'" class="iw-edit-icon" @click.prevent="editTransaction(index)" title="edit" ><span class="mdi mdi-pencil"></span> </span>
                                    <span v-if="trust.custom == 'Y'" class="iw-remove-icon" @click.prevent="removeTransaction(index)" title="delete"><span class="mdi mdi-delete"></span> </span>
                                    <span> {{trust.particulars}}</span>
                                </span>
                            </td>

                            <td>
                                 <currency-input  v-if="trust.custom == 'Y' && trust.type == 'payable'" v-model="trust.amount" :disabled="true"></currency-input>
                                <span v-else>
                                    <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                             <currency-input  v-if="trust.type == 'payable' && trust.target_field !='derived_total'" v-model="trust.amount"></currency-input>
                                        </div>
                                        <div class="input-group-append">
                                            <button  class="btn btn-primary" v-if="trust.type == 'payable' && trust.target_field !='derived_total' && trust.fix_var == 'F'"  @click.prevent="getSourceData(trust)">Source</button>
                                        </div>
                                    </div>


                                    <currency-input  v-if=" trust.target_field =='derived_total'" :disabled="true" v-model="total"></currency-input>
                                </span>
                            </td>
                            <td>
                                <currency-input  v-if="trust.custom == 'Y' && trust.type == 'receivable'" v-model="trust.amount" :disabled="true"></currency-input>
                                <span v-else>
                                    <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                                             <currency-input  v-if="trust.type == 'receivable' && trust.target_field !='derived_total'" v-model="trust.amount"></currency-input>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" v-if="trust.type == 'receivable' && trust.target_field !='derived_total' && trust.fix_var == 'F'"  @click.prevent="getSourceData(trust)" >Source</button>
                                        </div>
                                    </div>


                                </span>
                            </td>


<!--
                            <td>
                                <span v-if="ledger.type =='payable'">
                                      <currency-input  v-if="ledger.custom == false" v-model="ledger.amount"></currency-input>
                                    <span v-else v-text="'$' +ledger.amount"></span>
                                </span>
                            </td>
                            <td><span v-if="ledger.type =='receivable'">
                                  <currency-input  v-if="ledger.custom == false" v-model="ledger.amount"></currency-input>
                                <span v-else v-text="'$' +ledger.amount"></span></span>
                            </td> -->
                        </tr>
                        <tr>
                            <td> Total Amount</td>
                            <td>
                                <currency-input  :disabled="true" v-model="total_payable"></currency-input>
                            </td>
                            <td>
                                <currency-input  :disabled="true" v-model="total_receivable"></currency-input>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="card-body">
                <fieldset>
                    <legend><span v-if="ledger_form.edit_index >= 0">Edit</span><span v-else>Add</span> Transaction</legend>
                    <div >
                        <div class = "form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="type" class="in-label-title">Type</label>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': ledger_form.errors.get('type') }" aria-placeholder="Select"  v-model ="ledger_form.type">
                                        <option value="receivable">Receivable</option>
                                        <option value="payable">Payable</option>
                                    </select>
                                    <span id="basic-msg" v-if="ledger_form.errors.get('type')" class="invalid-feedback">{{ ledger_form.errors.get('type') }}</span>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="particulars" class="in-label-title">Particulars</label>
                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': ledger_form.errors.get('particulars') }"  v-model ="ledger_form.particulars">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="amount" class="in-label-title">Total Amount</label>
                                    <currency-input  v-bind:class="{ 'is-invalid': ledger_form.errors.get('amount') }" v-model ="ledger_form.amount"></currency-input>
                                <span id="basic-msg" v-if="ledger_form.errors.get('amount')" class="invalid-feedback">{{ ledger_form.errors.get('amount') }}</span>
                                </div>
                            </div>
                        </div>
                        <button class='btn btn-primary' @click.prevent='addLedgerForm'><span class="mdi mdi-plus"></span> Add</button>
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
        type:'payable',
        custom:'Y',
        fix_var:'V',
        amount:'',
        random:Utilities.getRandomNumber()
    });
}

function getNewTransaction(file_opening_id){
    return{
        id:0,
        file_opening_id:file_opening_id,
        particulars:'',
        type:'',
        amount:'',
        target_type:'',
        target_field:'',
        target_id:'',
        custom:'N',
        random:Utilities.getRandomNumber()
    }

}

export default
{
    props:['file_opening_id','form','permissions','file_opening','update_file_opening'],
    data:function(){
        return {
            create_url:'trust-ledgers',
            base_url:Munshi.base_url,
            credit_types:[],
            ledger_form:getTransactionForm(),
            show:true,
        }
    },

    watch:{
        update_file_opening:{
            handler: function(newValue) {
                this.getTrustLedger();
            },
        }
    },

    computed:{

        total:function(){
            var net = 0;
            var net_receive = 0;
            var net_pay = 0;

            this.form.trust_ledgers.forEach(function(ele){
                    if(ele.type == 'receivable' &&  ele.target_field != 'derived_total')
                    {
                        net_receive += Utilities.round(ele.amount);
                    }
                    else if(ele.type == 'payable' &&  ele.target_field != 'derived_total')
                    {
                        net_pay += Utilities.round(ele.amount);
                    }
            });
            net = Utilities.round(net_receive- net_pay);
            var index = this.form.trust_ledgers.findIndex(el =>el.target_type == 'derived_total' && el.target_field == 'derived_total');


            if(index >=0){
                 this.form.trust_ledgers[index].amount =net;
            }
            return net;
        },

        total_payable:function(){
            var tot = 0;
            this.form.trust_ledgers.forEach(function(ele){
                if(ele.type == 'payable')
                tot += Utilities.round(ele.amount);
            });
            return Utilities.round(tot);
        },
        total_receivable:function(){
        var tot = 0;
            this.form.trust_ledgers.forEach(function(ele){
                if(ele.type == 'receivable')
                tot += Utilities.round(ele.amount);
            });
            return Utilities.round(tot);
        }

    },
    mounted:function(){
        this.show = true;
        this.form.file_opening_id = this.file_opening_id;
        this.getTrustLedger();
    },
    methods:{
        getTrustLedger:function(){
            var self = this;
            var trust_ledgers = self.file_opening.trust_ledgers;
            var file_opening = self.file_opening;
            self.form.file_opening_id = self.file_opening_id;

            var fixed_trust_ledgers = trust_ledgers.filter(val => val.fix_var == 'F');
            var variable_trust_ledgers = trust_ledgers.filter(val => val.fix_var == 'V');

            self.form.trust_ledgers = [];

            // derive First Transaction Data
            var purchase_transaction = self.getPurchaseTransaction(file_opening,fixed_trust_ledgers);
            self.form.trust_ledgers.push(purchase_transaction);
            // end first Transaction;

                // derive secomd Transaction Data
            var mortgage_transactions = self.getMortgageTransactions(file_opening,fixed_trust_ledgers);
            self.form.trust_ledgers = self.form.trust_ledgers.concat(mortgage_transactions);
            // end second Transaction;

                // derive third Transaction Data
            var commission_transaction = self.getCommissionTransaction(file_opening,fixed_trust_ledgers);
            self.form.trust_ledgers.push(commission_transaction);
            // end third Transaction;

            // derive fourth Transaction Data
            var paid_legal_fees_disbursment = self.getDisbursmentTransaction(file_opening,fixed_trust_ledgers);
                self.form.trust_ledgers.push(paid_legal_fees_disbursment);
            // end third Transaction;

            // derive middle Transactions Transaction Data

            self.form.trust_ledgers = self.form.trust_ledgers.concat(self.getDefaultDetails());
            variable_trust_ledgers.forEach(element => {
                var transaction = getNewTransaction(self.file_opening_id);
                Utilities.copyProperties(element,transaction);
                var found = self.form.trust_ledgers.some(el => el.particulars === element.particulars);
                if(!found){
                    self.form.trust_ledgers.push(transaction);
                }
                else{
                    var ind = self.form.trust_ledgers.findIndex(x => x.particulars === element.particulars);
                    if(ind >=0){
                        Utilities.copyProperties(element,self.form.trust_ledgers[ind]);
                    }
                }
            });
            // end derive middle Transactions

            // derive second Last Transaction Data
            var paid_hst = self.getHstTransaction(file_opening,fixed_trust_ledgers);
            self.form.trust_ledgers.push(paid_hst);
            // end third Transaction;


            // derive last Transaction
            var paid_to_seller = self.getPaidToSellerTransaction(file_opening,fixed_trust_ledgers);
            self.form.trust_ledgers.push(paid_to_seller);
            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
        },

        getPurchaseTransaction:function(file_opening,fixed_trust_ledgers){
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.fix_var = 'F';
            transaction_fixed.type = 'receivable';
            var purchasers = file_opening.purchasers;
            var purchasers_names ='';
            purchasers.forEach((element,index) => {
                if(element.salutation == 'Corporation'){
                    purchasers_names += element.company_name + ' ';
                }
                else{
                    purchasers_names += element.first_name ? element.first_name + ' ' :' ';
                    purchasers_names += element.middle_name ? element.middle_name +' ' :'';
                    purchasers_names += element.last_name ? element.last_name+' ' :'' ;
                }
                if(index < purchasers.length-1){
                    purchasers_names += ',' ;
                }
                purchasers_names += ' ' ;

            });
            transaction_fixed.particulars ='Received from Purchaser on Closing -  '+ purchasers_names ;
            var  purchasers_data = fixed_trust_ledgers.find(el => el.target_id === file_opening.statement_adjustment.id && el.target_type == 'statement_adjustment' && el.target_field == 'balance_due');


            if(purchasers_data){
                Utilities.copyProperties(purchasers_data,transaction_fixed);
                transaction_fixed.amount = purchasers_data.amount;
                transaction_fixed.original_amount =  file_opening.statement_adjustment.balance_due ? file_opening.statement_adjustment.balance_due:0;
            }
            else{
                transaction_fixed.amount = file_opening.statement_adjustment.balance_due ? file_opening.statement_adjustment.balance_due:0;
                transaction_fixed.original_amount =  file_opening.statement_adjustment.balance_due ? file_opening.statement_adjustment.balance_due:0;
                transaction_fixed.target_field = 'balance_due';
                transaction_fixed.target_type = 'statement_adjustment';
                transaction_fixed.target_id = file_opening.statement_adjustment.id;
            }
            console.log("purchase_transaction");
            console.log(transaction_fixed)
            return transaction_fixed;

        },

        getMortgageTransactions:function(file_opening,fixed_trust_ledgers){
            var self = this;
            var arr= [];
            var mortgages = file_opening.mortgages;

            mortgages.forEach((element,index) => {
                var mortgage_name ='';
                var transaction_fixed = getNewTransaction(self.file_opening_id);
                transaction_fixed.type = 'payable';
                transaction_fixed.fix_var = 'F';
                if(element.mortgagee){
                    mortgage_name += element.mortgagee.first_name && element.mortgagee.first_name !='' ? element.mortgagee.first_name + ' ':'';
                    mortgage_name += element.mortgagee.middle_name && element.mortgagee.middle_name  !=''? element.mortgagee.middle_name + ' ':'';
                    mortgage_name += element.mortgagee.last_name && element.mortgagee.last_name != ''? element.mortgagee.last_name + ' ':'';
                    if(mortgage_name == ''){
                          mortgage_name += element.mortgagee.company_name ? element.mortgagee.company_name + ' ':'';
                    }
                }
                transaction_fixed.particulars ='Paid to discharge existing mortgage - '+ mortgage_name;

                var  mortgage_data = fixed_trust_ledgers.find(el => el.target_id === element.id && el.target_type == 'mortgage' && el.target_field == 'total_mortgage_payable_discharge');

                if(mortgage_data){
                    Utilities.copyProperties(mortgage_data,transaction_fixed);
                    transaction_fixed.amount = mortgage_data.amount;
                    transaction_fixed.original_amount = element.total_mortgage_payable_discharge;
                }
                else{
                    transaction_fixed.amount = element.total_mortgage_payable_discharge;
                    transaction_fixed.original_amount = element.total_mortgage_payable_discharge;
                    transaction_fixed.target_field = 'total_mortgage_payable_discharge';
                    transaction_fixed.target_type = 'mortgage';
                    transaction_fixed.target_id =  element.id;
                }
                arr.push(transaction_fixed);
            });
            return arr;
        },

        getCommissionTransaction:function(file_opening,fixed_trust_ledgers){
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.fix_var = 'F';
            transaction_fixed.type = 'payable';
            var commission = file_opening.commission;
            if(commission && commission.brokerage)
            var  real_estate_broker =commission.brokerage.name;
            transaction_fixed.particulars ='Paid to Real Estate Commission -  '+ real_estate_broker ;

            var paid_real_estate_commission =  file_opening.commission ? file_opening.commission.commission_payable:0;

            var commission_data = fixed_trust_ledgers.find(el => file_opening.commission && el.target_id === file_opening.commission.id && el.target_type == 'commission' && el.target_field == 'commission_payable');

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

        getDisbursmentTransaction:function(file_opening,fixed_trust_ledgers){
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.fix_var = 'F';
            transaction_fixed.type = 'payable';
            var sellers_lawyer = '';
            if(file_opening.solicitor){
                sellers_lawyer +=file_opening.solicitor.first_name ?file_opening.solicitor.first_name + ' ' :' ';
                sellers_lawyer +=file_opening.solicitor.middle_name ?file_opening.solicitor.middle_name +' ' :'';
                sellers_lawyer +=file_opening.solicitor.last_name ?file_opening.solicitor.last_name+' ' :'' ;
            }
            transaction_fixed.particulars ='Paid Legal Fee, Disbursement and HST - ' +sellers_lawyer;

            var total_fees_disbursement_without_hst =  file_opening.account_statement ? file_opening.account_statement.total_fees_disbursement_without_hst:0;

            var  total_fees_disbursement_without_hst_data = fixed_trust_ledgers.find(el => el.target_id === file_opening.account_statement.id && el.target_type == 'account_statement' && el.target_field == 'total_fees_disbursement_without_hst');
            if(total_fees_disbursement_without_hst_data){
                Utilities.copyProperties(total_fees_disbursement_without_hst_data,transaction_fixed);
                transaction_fixed.amount = total_fees_disbursement_without_hst_data.amount;
                transaction_fixed.original_amount = total_fees_disbursement_without_hst;
            }
            else{
                transaction_fixed.amount = total_fees_disbursement_without_hst;
                transaction_fixed.original_amount =  total_fees_disbursement_without_hst;
                transaction_fixed.target_field = 'total_fees_disbursement_without_hst';
                transaction_fixed.target_type = 'account_statement';
                transaction_fixed.target_id = file_opening.account_statement.id;
            }
            return transaction_fixed;
        },

        getHstTransaction:function(file_opening,fixed_trust_ledgers){
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.type = 'payable';
            transaction_fixed.fix_var = 'F';
            transaction_fixed.particulars ='Paid  HST';
            var paid_hst =  file_opening.account_statement ? file_opening.account_statement.total_hst:0;

            var  hst_data = fixed_trust_ledgers.find(el => el.target_id === file_opening.account_statement.id && el.target_type == 'account_statement' && el.target_field == 'total_hst');
            if(hst_data){
                Utilities.copyProperties(hst_data,transaction_fixed);
                transaction_fixed.original_amount = paid_hst;
            }
            else{
                transaction_fixed.amount = paid_hst;
                transaction_fixed.original_amount =  paid_hst;
                transaction_fixed.target_field = 'total_hst';
                transaction_fixed.target_type = 'account_statement';
                transaction_fixed.target_id = file_opening.account_statement ? file_opening.account_statement.id : 0;
            }
            return transaction_fixed;
        },

        getPaidToSellerTransaction:function(file_opening,fixed_trust_ledgers){
            var transaction_fixed = getNewTransaction(this.file_opening_id);
            transaction_fixed.type = 'payable';
            transaction_fixed.fix_var = 'F';
            var sellers = file_opening.sellers;
            var sellers_names = '';
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

            transaction_fixed.particulars ='Paid to Seller after closing- ' +sellers_names;

            var  derived_data = fixed_trust_ledgers.find(el => el.target_id === 0 && el.target_type == 'derived_total' && el.target_field == 'derived_total');
            if(derived_data){
                Utilities.copyProperties(derived_data,transaction_fixed);
                transaction_fixed.original_amount = derived_data.amount;
            }
            else{
                transaction_fixed.target_field = 'derived_total';
                transaction_fixed.target_type = 'derived_total';
                transaction_fixed.target_id =0;
            }
            return transaction_fixed;
        },

        addLedgerForm:function(){
            var errors = false;
            var erors_object  = {};
            if(this.ledger_form.type ==''){
                erors_object.type = ["type is required"];
                errors = true;
            }
             if(this.ledger_form.amount ==''){
                 erors_object.amount = ["amount required"];
                errors = true;
            }
            if(this.ledger_form['particulars'] ==''){
                 erors_object['particulars'] = ["particulars required"];
                errors = true;
            }

            this.ledger_form.errors.record(erors_object);


            if(errors == true){
                return;
            }
            var self = this;

            var tl = this.form.trust_ledgers.find(ele => ele.random == self.ledger_form.random);
            var new_trn = false;

            if(tl == undefined) {
                tl = getNewTransaction();
                tl.fix_var = 'V';
                new_trn = true;
            }

            // var detail = getNewTransaction();
            // var is_index = this.ledger_form.edit_index;
            // this.ledger_form.edit_index = -1;
            Utilities.copyProperties(this.ledger_form, tl);
            // if(is_index >=0){
            //      this.form.trust_ledgers[is_index] = detail;
            // }
            // else{
                // this.form.trust_ledgers.push(detail);
            if(new_trn) {
                this.form.trust_ledgers.splice(this.form.trust_ledgers.length-2, 0,tl);
            }
            this.ledger_form = getTransactionForm();
        },


        removeTransaction:function(index){
            this.form.trust_ledgers.splice(index,1);
        },

        editTransaction:function(index){
            var self = this;
            this.ledger_form = getTransactionForm();
            this.ledger_form.edit_index = index;
            this.show = false;
            Utilities.copyProperties(this.form.trust_ledgers[index],this.ledger_form);
        },

        getDefaultDetails:function(){
            return [
                {
                    id:0,
                    file_opening_id:this.file_opening_id,
                    particulars:'Paid outstanding property Taxes',
                    type:'payable',
                    amount:'',
                    fix_var:'V',
                    custom:'N',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    file_opening_id:this.file_opening_id,
                    particulars:'Paid for the outstanding Utilities',
                    type:'payable',
                    amount:'',
                    fix_var:'V',
                    custom:'N',
                    random:Utilities.getRandomNumber()
                },


            ]
        },

        getSourceData:function(trust){
            trust.amount = trust.original_amount;
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
.iw-refresh-btn {
    background: #3490dc;
    color: #fff;
}

.iw-refresh-btn:hover {
    background: #207fce;
    color: #fff;
}
</style>
