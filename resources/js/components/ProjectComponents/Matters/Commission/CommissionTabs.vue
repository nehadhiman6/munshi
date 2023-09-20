<template>

    <div>

        <div class="iw-horizontal-tabs">
            <div class="iw-inner-tab">
            <nav class="d-flex align-items-center justify-content-between">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="comm" data-toggle="tab"  href="#commission" role="tab" aria-controls="commission" aria-selected="true">
                            Commission
                        </a>
                    </li>
                    <li class="nav-item">
                          <a class="nav-link" id="files" data-toggle="tab"  href="#file_upload" role="tab" aria-controls="file_upload" aria-selected="false">
                            File Uploads
                        </a>
                    </li>
                </ul>
                <div class ="mb-1">
                    <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'SAVE'" @click.prevent ="submitForm" type="submit">
                </div>
             </nav>
             </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane show active" id="commission"  role="tabpanel" aria-labelledby="comm">
                <commission-tab
                    :update_file_opening="update_file_opening"
                    :form="form"
                    :file_opening="file_opening"
                    :commission = 'form.commission'
                    :file_opening_id="file_opening_id">
                </commission-tab>
            </div>
            <div class="tab-pane " id="file_upload"  role="tabpanel" aria-labelledby="files">
                <file-upload-tab
                    target="commission"
                    :form="form"
                     :file_opening="file_opening"
                    :file_opening_id="file_opening_id">
                </file-upload-tab>
            </div>
        </div>
        <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'SAVE'" @click.prevent ="submitForm" type="submit">
        </div>

    </div>
</template>

<script>
import CommissionTab from './CommissionTab.vue'
import FileUploadTab from './FileUploadTab.vue'
function getAddress(){
    return {
            type:'',
            number:'',
            street:'',
            city_id:'',
            country:'',
            postal_code:'',
            province:'',
            addressable_type:'',
            addressable_id:'',
        };
}

function getNewForm(){
    return new Form({
        commission:{
            id:'0',
            file_opening_id:0,
            brokerage_id:'',
            total_commission:'',
            gst:'',
            total_commission_after_gst:'',
            less_deposit:'',
            commission_payable:'',
            excess_deposit_to_seller:'',
            agent_name:'',
            address:getAddress(),
            random:Utilities.getRandomNumber()
        },
        resources:[],
        file_opening_id:0,
    })
}
export default {
  components: { CommissionTab, FileUploadTab },
    props:['file_opening_id','file_opening','update_file_opening'],
    data:function(){
        return {
            base_url:Munshi.base_url,
            create_url:'commissions',
            form:getNewForm(),
        }
    },

    methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        submitForm:function(){
            var self = this;
            console.log(this.form);
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                        var commission = response.commission;
                        if(response.success){
                            Utilities.showToast(self,'success','Commission updated successfully',2200,true);
                            self.$emit('updateFileOpening','commission',commission);
                            self.$emit('closeTriggered');
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);
        },
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
.nav-tabs .nav-link {
    margin-bottom: -2px;
}
</style>
