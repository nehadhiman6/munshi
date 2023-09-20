<template>
    <div>
        <div class="iw-horizontal-tabs">

            <div class="iw-inner-tab">
            <nav class="d-flex align-items-center justify-content-between">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-account-statement-tab" data-toggle="tab" href="#nav-account-statement" role="tab" aria-controls="nav-account-statement" aria-selected="true">  Account Statement</a>
                </div>
                <div class ="mb-1">
                    <input class="btn iw-btn iw-btn-submit" value='SAVE' @click.prevent ="submitForm" type="submit">
                </div>
            </nav>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-account-statement" role="tabpanel" aria-labelledby="nav-account-statement-tab">
                    <account-statement
                        :update_file_opening="update_file_opening"
                        :form='form'
                        :file_opening = "file_opening"
                        :file_opening_id="file_opening_id">
                    </account-statement>
                </div>
            </div>

            <div class ="mt-4">
                <input class="btn iw-btn iw-btn-submit" value='SAVE' @click.prevent ="submitForm" type="submit">
            </div>
        </div>

    </div>
</template>

<script>
function getNewForm(){
    return new Form({
        file_opening_id:0,
        date:'',
        account_statement:{
            id:0,
            file_opening_id:'',
            total_fees:'',
            hst:'',
            hst_disbursement_total:'',
            hst_disbursement_hst:'',
            non_hst_disbursement_total:'',
            total_fees_disbursement:'',
            total_hst:'',
            total_fees_disbursement_without_hst:'',
            account_statement_details:[
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

        resources:[]
    });
}
import FileUploadTab from '../Commission/FileUploadTab.vue';
import AccountStatement from './AccountStatement.vue';
export default {
    props:['file_opening_id','file_opening','update_file_opening'],
    components: {FileUploadTab, AccountStatement },
    data:function(){
        return {
            create_url:'account-statements',
            base_url:Munshi.base_url,
            form:getNewForm(),
        }
    },
    mounted:function(){
        var self = this;
        this.form.file_opening_id = this.file_opening_id;
        this.form.account_statement.file_opening_id = this.file_opening_id;


    },
    methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                       if(response.success){
                           self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                           var account_statement = response.account_statement;
                           var account_statement_details = response.account_statement_details;
                            Utilities.showToast(self,'success','Account Statement updated successfully',2200,true);
                            self.$emit('updateFileOpening','account_statement',account_statement);
                            self.$emit('updateFileOpening','account_statement_details',account_statement_details);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);
        }

    }

}
</script>

<style>
.iw-horizontal-tabs .nav-item .nav-link {
    padding-right: 40px;
}

.iw-horizontal-tabs span.iw-close-tab {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
