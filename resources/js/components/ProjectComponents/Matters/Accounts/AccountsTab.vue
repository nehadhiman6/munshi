<template>
    <div>
        <div class="iw-horizontal-tabs">

            <div class="iw-inner-tab">
            <nav class="d-flex align-items-center justify-content-between">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-account-adjustment-tab" data-toggle="tab" href="#nav-account-adjustment" role="tab" aria-controls="nav-account-adjustment" aria-selected="true">  Statement of Adjustment</a>
                    <a class="nav-item nav-link" id="nav-file-upload-tab" data-toggle="tab" href="#nav-file-upload" role="tab" aria-controls="nav-file-upload" aria-selected="false">File Uploads</a>
                </div>
                <div class ="mb-1">
                <input class="btn iw-btn iw-btn-submit" value='SAVE' @click.prevent ="submitForm" type="submit">
            </div>
            </nav>

            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-account-adjustment" role="tabpanel" aria-labelledby="nav-account-adjustment-tab">
                    <account-adjustment-tab
                        :update_file_opening="update_file_opening"
                        :permissions="permissions"
                        :form='form'
                        :file_opening_id="file_opening_id"
                        :file_opening="file_opening"
                        @updateFileOpening="$emit('updateFileOpening')">
                    </account-adjustment-tab>
                </div>
                <div class="tab-pane fade" id="nav-file-upload" role="tabpanel" aria-labelledby="nav-file-upload-tab">
                    <file-upload-tab
                        :file_opening="file_opening"
                        target="statement_adjustment"
                        :form="form"
                        :file_opening_id="file_opening_id">
                    </file-upload-tab>
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
        ],
        resources:[]
    });
}
import AccountAdjustmentTab from './AccountAdjustmentTab.vue';
import FileUploadTab from '../Commission/FileUploadTab.vue';
export default {
    props:['file_opening_id','permissions','file_opening','update_file_opening'],
    components: { AccountAdjustmentTab,FileUploadTab },
    data:function(){
        return {
            create_url:'statement-adjustments',
            base_url:Munshi.base_url,
            form:getNewForm(),
        }
    },
    mounted:function(){
        var self = this;
        this.form.file_opening_id = this.file_opening_id;
        this.form.statement_adjustment.file_opening_id = this.file_opening_id;

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
                           var statement_adjustment = response.statement_adjustment;
                           var statement_adjustment_details= response.statement_adjustment_details;
                            Utilities.showToast(self,'success','Account Statement updated successfully',2200,true);
                            self.$emit('updateFileOpening','statement_adjustment',statement_adjustment);
                            self.$emit('updateFileOpening','statement_adjustment_details',statement_adjustment_details);
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
.iw-inner-tab{
    margin:10px 0 0
}
.iw-inner-tab nav a.nav-link.active {
    background: #fdfdfd!important;
    color: #555!important;
    border: 1px solid #cecece;
    border-bottom: 0;
}

.iw-inner-tab nav a.nav-link.active:after {
    border-color: transparent;
}
</style>
