<template>
    <div class="form-horizontal">
        <div class="card-body">
            <simple-file-upload
                :commission_id="commission_id"
                :allow-multiple="true"
                :initialResources="form.resources"
                @updateFiles="updateFiles">
            </simple-file-upload>
            <document-attachment
                v-if="form.resources.length > 0"
                :show-description="true"
                :show-remove = "true"
                :imagesArr= "form.resources"
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
    props:['file_opening_id','form','target','file_opening'],
    data:function(){
        return{
            create_url:'commission-file-uploads',
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
            var target =self.file_opening[self.target];
            if(target){
                self.form.resources = target.resources;
            }
            self.$nextTick(() => {
                self.show = true;
            });
        },
        updateFiles:function(saved=true,target_id,fileArr){
            var  self = this;
            var file = getAttachment();
            file.attachment_id = target_id;
            self.form.resources.push(file);
        },

        saveFiles:function(){
            var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        if(response.success){
                            Utilities.showToast(self,'success','Files updated successfully',2200,true);
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },true,false);
        },

         removeAttachment:function(index){
            this.form.resources.splice(index,1);
        }
    }
}
</script>

<style>

</style>
