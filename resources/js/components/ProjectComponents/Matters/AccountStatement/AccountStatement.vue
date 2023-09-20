<template>
        <div class="form-horizontal">
            <div class="card-body">
                <table class="table">
                    <!-- <thead>
                        <tr>
                            <th scope="col">Particulars</th>
                            <th scope="col" width="220">Purchaser Credit</th>
                            <th scope="col" width="220">Seller Credit</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <tr>
                            <td>My FEES</td>
                            <td>
                                 <currency-input  v-bind:class="{ 'is-invalid': form.errors.get('account_statement.total_fees') }" v-model="form.account_statement.total_fees"></currency-input>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Fees </td>
                            <td></td>
                            <td>$ {{form.account_statement.total_fees}}</td>
                        </tr>
                         <tr>
                            <td>HST(13%) </td>
                            <td></td>
                            <td>$ {{getRound(hst)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><h4>DISBURSMENT</h4></td>
                        </tr>

                        <tr>
                            <td colspan="2"><h6>Subject to HST</h6> <button class="btn btn-primary float-right" @click.prevent="addTransaction('subject_to_hst')">Add</button></td>
                        </tr>
                        <tr v-for="with_hst in subject_to_hst" :key="with_hst.random">
                            <td><span v-if="with_hst.editable == false">{{with_hst.particulars}}</span><input v-else class="form-control" v-model="with_hst.particulars" placeholder="particulars"/></td>
                            <td>
                                 <currency-input   v-model="with_hst.amount"></currency-input>
                            </td>
                            <td></td>
                        </tr>
                        <tr v-if="subject_to_hst.length>0">
                            <td>Total</td>
                            <td></td>
                            <td>$ {{hst_disbursement_total}}</td>
                        </tr>
                        <tr v-if="subject_to_hst.length>0">
                            <td>HST (13%)</td>
                            <td></td>
                            <td>$ {{hst_disbursement_hst}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><h6>Not Subject to HST (Agency)</h6>
                             <button class="btn btn-primary float-right" @click.prevent="addTransaction('not_subject_to_hst')">Add</button></td>
                        </tr>
                        <tr v-for="not_with_hst in not_subject_to_hst" :key="not_with_hst.random">
                            <td><span v-if="not_with_hst.editable == false">{{not_with_hst.particulars}}</span><input v-else class="form-control" v-model="not_with_hst.particulars" placeholder="particulars"/></td>
                            <td> <currency-input   v-model="not_with_hst.amount"></currency-input></td>
                            <td></td>
                        </tr>
                        <tr v-if="not_subject_to_hst.length>0">
                            <td>Total</td>
                            <td></td>
                            <td> $ {{non_hst_disbursement_total}}</td>
                        </tr>

                        <tr>
                            <td >TOTAL FEES AND DISBURSEMENTS</td>
                            <td></td>
                            <td>$ {{total_fees_disbursement}}</td>
                        </tr>
                        <tr>
                            <td>Total HST</td>
                            <td>$ {{total_hst}}</td>
                        </tr>
                        <input type="hidden"  v-model="form.total_fees_disbursement_without_hst">
                    </tbody>
                </table>

            </div>
        </div>

</template>

<script>


function getNewDetail(type='subject_to_hst'){
    return{
        id:0,
        account_statement_id :'',
        type :'disbursement',
        sub_type :type,
        particulars :'',
        amount :'',
        editable:true,
        random:Utilities.getRandomNumber()
    }

}

export default
{
    props:['file_opening_id','form','file_opening','update_file_opening'],
    data:function(){
        return {
            create_url:'account-statements',
            base_url:Munshi.base_url,
               show:true
        }
    },

    watch:{
        update_file_opening:{
            handler: function(newValue) {
                this.getStatementAdjustment();
            },
        }
    },

    computed:{
        hst:function(){
            var hst = 0;
            if(this.form.account_statement.total_fees >0) {
                hst =this.form.account_statement.total_fees * (13/100);
            }
            this.form.account_statement.hst= Utilities.round(hst);
            return hst;
        },

        subject_to_hst:function(){
            return this.form.account_statement.account_statement_details.filter(o => o.sub_type === 'subject_to_hst');
        },

        not_subject_to_hst:function(){
            return this.form.account_statement.account_statement_details.filter(o => o.sub_type === 'not_subject_to_hst');
        },

        hst_disbursement_total:function(){
            var tot = 0;
            this.subject_to_hst.forEach(element => {
                tot += Utilities.round(element.amount);
            });
            tot = Utilities.round(tot);

            this.form.account_statement.hst_disbursement_total = tot;
            return tot;
        },

        hst_disbursement_hst:function(){
            var hst = 0;
            if(this.hst_disbursement_total >0) {
                hst =this.hst_disbursement_total * (13/100);
            }
            hst = Utilities.round(hst);
            this.form.account_statement.hst_disbursement_hst= hst;
            return hst;
        },

        non_hst_disbursement_total:function(){
            var tot = 0;
            this.not_subject_to_hst.forEach(element => {
                tot += Utilities.round(element.amount);
            });
            tot = Utilities.round(tot);

            this.form.account_statement.non_hst_disbursement_total = tot;
            return tot;
        },

        total_fees_disbursement:function(){
            var total_fees_disbursement= Utilities.round(this.form.account_statement.total_fees);
            total_fees_disbursement += Utilities.round(this.form.account_statement.hst);
            total_fees_disbursement += Utilities.round(this.form.account_statement.hst_disbursement_total);
            total_fees_disbursement += Utilities.round(this.form.account_statement.hst_disbursement_hst);
            total_fees_disbursement += Utilities.round(this.form.account_statement.non_hst_disbursement_total);
            total_fees_disbursement= Utilities.round(total_fees_disbursement);
            this.form.account_statement.total_fees_disbursement = total_fees_disbursement;
            return total_fees_disbursement;
        },

        total_hst:function(){
            var total_hst = Utilities.round(this.form.account_statement.hst) + Utilities.round(this.form.account_statement.hst_disbursement_hst);
            total_hst = Utilities.round(total_hst);
            this.form.account_statement.total_hst = total_hst;
            return total_hst;
        },

        total_fees_disbursement_without_hst:function(){
            var tot =  Utilities.round(this.total_fees_disbursement - this.total_hst);
            this.form.account_statement.total_fees_disbursement_without_hst = tot;
            return tot;

        }

    },

    mounted:function(){
        this.show = true;
        this.form.file_opening_id = this.file_opening_id;
        this.form.account_statement.file_opening_id = this.file_opening_id;
        this.getStatementAdjustment();
    },
    methods:{
        getStatementAdjustment:function(){
            var self = this;
            var account_statement = self.file_opening.account_statement;
            var account_statement_details = self.file_opening.account_statement ? self.file_opening.account_statement.account_statement_details:[];
            var file_opening = self.file_opening;
            self.form.date = file_opening.closing_date;
            self.form.file_opening_id = self.file_opening_id;
            if(account_statement){
                self.form.account_statement = account_statement;
                self.form.account_statement.file_opening_id = self.file_opening_id;
                self.form.account_statement.account_statement_details = self.getDefaultDetails();
            }

            account_statement_details.forEach(element => {
                var account_statement_transaction = getNewDetail();
                Utilities.copyProperties(element,account_statement_transaction);
                var found = self.form.account_statement.account_statement_details.some(el => el.particulars === account_statement_transaction.particulars);
                if(!found){
                    self.form.account_statement.account_statement_details.push(account_statement_transaction);
                }
                else{
                    var ind = self.form.account_statement.account_statement_details.findIndex(x => x.particulars === element.particulars);
                    if(ind >=0){
                        Utilities.copyProperties(element,self.form.account_statement.account_statement_details[ind]);
                    }
                }
            });
            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
        },


        addTransaction(type='subject_to_hst'){
            console.log("Insdie")
            this.form.account_statement.account_statement_details.push(getNewDetail(type));
        },

        removeTransaction(type){
            this.form.account_statement.account_statement_details.splice(index,1);
        },

        getDefaultDetails:function(){
            return [
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'subject_to_hst',
                    particulars :'Photocopies',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                 {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'subject_to_hst',
                    particulars :'Postage',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'subject_to_hst',
                    particulars :'Fax transmissions',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'subject_to_hst',
                    particulars :'Couriers',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                  {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'subject_to_hst',
                    particulars :'Software expense',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'subject_to_hst',
                    particulars :'Transaction Levy Surcharge',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'not_subject_to_hst',
                    particulars :'Not Subject to HST (Agency)',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'not_subject_to_hst',
                    particulars :'Register Discharge of Mortgage',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'not_subject_to_hst',
                    particulars :'Writ of Execution',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },
                {
                    id:0,
                    editable:false,
                    account_statement_id :0,
                    type :'disbursement',
                    sub_type :'not_subject_to_hst',
                    particulars :'Bank Charges',
                    amount :'',
                    random:Utilities.getRandomNumber()
                },


            ]
        },
        getRound:function(amt){
            return Utilities.round(amt);
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
