<template>
    <div class="form-horizontal">
        <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1">
            <div class="card-title mb-0"><h5 class="mb-0">File Upload/Attachments</h5></div>
            <div class ="float-right">
                <input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
            </div>
        </div>
        <div class="card-body">
            <simple-file-upload
                :commission_id="commission_id"
                :allow-multiple="true"
                :initialexecution_docs="form.execution_docs"
                @updateFiles="updateFiles">
            </simple-file-upload>
            <document-attachment
                v-if="form.execution_docs.length > 0"
                :show-description="true"
                :show-remove = "true"
                :imagesArr= "form.execution_docs"
                :initial-id ="previewImageId"
                id-label="attachment_id"
                path-thumbnail = "attachments-thumbnail"
                path = "attachments"
                @removeAttachment= "removeAttachment">
            </document-attachment>
        </div>

    </div>
</template>

<script>

function getAttachment(){
    return{
        id:0,
        attachment_id:0,
        doc_type:'0',
        doc_description:'',
        random:Utilities.getRandomNumber()
    }
}


import SimpleFileUpload from '../../../BasicComponents/SimpleFileUpload.vue'
export default {
  components: { SimpleFileUpload },
    props:['file_opening_id','form','file_opening'],
    data:function(){
        return{
            create_url:'execution-file-uploads',
            base_url:Munshi.base_url,
            // form:getNewForm(),
            commission_id:0,
            previewImageId:0
        }
    },
    mounted:function(){
        this.form.file_opening_id = this.file_opening_id;
        this.getTarget();
    },
    methods:{
        getTarget:function(){
            var self = this;
            this.show = false;
            var target =self.file_opening;
            if(target){
                self.form.execution_docs = target.execution_docs;
            }
            self.$nextTick(() => {
                self.show = true;
            });
        },
        updateFiles:function(saved=true,target_id,fileArr){
            var  self = this;
            var file = getAttachment();
            file.attachment_id = target_id;
            self.form.execution_docs.push(file);
        },

         removeAttachment:function(index){
            this.form.execution_docs.splice(index,1);
        },

        submitForm:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                            Utilities.showToast(self,'success','Files updated successfully',2200,true);
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

</style>
