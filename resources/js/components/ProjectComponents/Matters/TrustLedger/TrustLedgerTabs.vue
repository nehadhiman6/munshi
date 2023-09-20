<template>
    <div>
        <div class="iw-horizontal-tabs">

            <div class="iw-inner-tab">
            <nav class="d-flex align-items-center justify-content-between">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-trust-ledger-tab" data-toggle="tab" href="#nav-trust-ledger" role="tab" aria-controls="nav-trust-ledger" aria-selected="true">  Trust Ledger</a>
                    <!-- <a class="nav-item nav-link" id="nav-file-upload-tab" data-toggle="tab" href="#nav-file-upload" role="tab" aria-controls="nav-file-upload" aria-selected="false">File Uploads</a> -->
                </div>
                <div class ="mb-1">
                <input class="btn iw-btn iw-btn-submit" value='SAVE'   :disabled="isdisabled" @click.prevent ="submitForm" type="submit">
            </div>
            </nav>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-trust-ledger" role="tabpanel" aria-labelledby="nav-trust-ledger-tab">
                    <trust-ledger-tab
                        :update_file_opening="update_file_opening"
                        :file_opening="file_opening"
                        :permissions="permissions"
                        :form='form'
                        :file_opening_id="file_opening_id">
                    </trust-ledger-tab>
                </div>
                <!-- <div class="tab-pane fade" id="nav-file-upload" role="tabpanel" aria-labelledby="nav-file-upload-tab">
                    <file-upload-tab
                        target="statement_adjustment"
                        :form="form"
                        :file_opening_id="file_opening_id">
                    </file-upload-tab>
                </div> -->
            </div>

            <div class ="mt-4">
                <input class="btn iw-btn iw-btn-submit" value='SAVE' :disabled="isdisabled" @click.prevent ="submitForm" type="submit">
            </div>
        </div>

    </div>
</template>

<script>
function getNewForm(file_opening_id){
    return new Form({
        file_opening_id:0,
        trust_ledgers:[
            {
                id:0,
                file_opening_id:file_opening_id,
                particulars:'Paid outstanding property Taxes',
                type:'payable',
                amount:'',
                var_fix:'V',
                custom:'N',
                random:Utilities.getRandomNumber()
            },
            {
                id:0,
                file_opening_id:file_opening_id,
                particulars:'Paid for the outstanding Utilities',
                type:'payable',
                amount:'',
                var_fix:'V',
                custom:'N',
                random:Utilities.getRandomNumber()
            },

        ],
        resources:[]
    });
}
import FileUploadTab from '../Commission/FileUploadTab.vue';
import TrustLedgerTab from './TrustLedgerTab.vue';
export default {
    props:['file_opening_id','permissions','file_opening','update_file_opening'],
    components: {
        TrustLedgerTab,
         FileUploadTab
     },
    data:function(){
        return {
            create_url:'trust-ledgers',
            base_url:Munshi.base_url,
            form:getNewForm(this.file_opening_id),
            isdisabled:false
        }
    },
    mounted:function(){
        var self= this;
        this.form.file_opening_id = this.file_opening_id;

    },
    methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        submitForm:function(){
            var self = this;
            this.isdisabled = true;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                       if(response.success){
                           self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                           var trust_ledgers =  response.trust_ledgers;
                           self.form.trust_ledgers = response.trust_ledgers;
                            Utilities.showToast(self,'success','Trust Ledger updated successfully',2200,true);
                            self.$emit('updateFileOpening','trust_ledgers',trust_ledgers);
                            self.$emit('closeTriggered');
                            self.isdisabled = false;
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                        self.isdisabled = false;
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
