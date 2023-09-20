<template>
    <div>
        <div class="iw-horizontal-tabs">

            <div class="iw-inner-tab">
            <nav class="d-flex align-items-center justify-content-between">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-direction-fund-tab" data-toggle="tab" href="#nav-direction-fund" role="tab" aria-controls="nav-direction-fund" aria-selected="true">Re Direction Fund</a>
                    <!-- <a class="nav-item nav-link" id="nav-file-upload-tab" data-toggle="tab" href="#nav-file-upload" role="tab" aria-controls="nav-file-upload" aria-selected="false">File Uploads</a> -->
                </div>
                <div class ="mb-1">
                    <input class="btn iw-btn iw-btn-submit"  :disabled="isdisabled" value='SAVE' @click.prevent ="submitForm" type="submit">
                </div>
            </nav>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-direction-fund" role="tabpanel" aria-labelledby="nav-direction-fund-tab">
                    <re-direction-fund
                        :update_file_opening="update_file_opening"
                        :file_opening="file_opening"
                        :permissions="permissions"
                        :form='form'
                        :file_opening_id="file_opening_id">
                    </re-direction-fund>
                </div>
            </div>
            <div class ="mt-4">
                <input class="btn iw-btn iw-btn-submit" value='SAVE'   :disabled="isdisabled" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
    </div>
</template>

<script>
function getNewForm(file_opening_id){
    return new Form({
        file_opening_id:0,
         redirection_funds:[
        ],
        resources:[],
    });
}
import ReDirectionFund from './ReDirectionFund.vue';
export default {
    props:['file_opening_id','permissions','file_opening','update_file_opening'],
    components: {
        ReDirectionFund,
     },
    data:function(){
        return {
            base_url:Munshi.base_url,
            create_url:'redirection-funds',
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
             self.isdisabled = true;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                       if(response.success){
                           self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            self.form.redirection_funds = response.redirection_funds;
                            self.$emit('updateFileOpening','redirection_funds',response.redirection_funds);
                            Utilities.showToast(self,'success','Redirection Funds updated successfully',2200,true);
                            self.$emit('closeTriggered');
                            self.isdisabled = false;
                        }
                    })
                    .catch(function(error){
                         self.isdisabled = false;
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
#nav-direction-fund .table tr td {
    white-space: normal;
}
</style>
