<template>
<div>
    <div class=" card-header d-flex flex-wrap align-items-center justify-content-between  py-1 mt-1">
        <div class="card-title mb-0"><span><strong>File Documents/Attachments</strong></span></div>
        <div class ="float-right">
            <input class="btn iw-btn iw-btn-submit py-1" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="submitForm" type="submit">
        </div>
    </div>
    <div class="form-horizontal">

        <div class="card-body">
            <file-document v-for="(document,index) in form.documents" :key="document.random"
                :form="form"
                :index="index"
                :document="document"
                :show-description="true"
                :show-remove = "true"
                id-label="attachment_id"
                path-thumbnail = "attachments-thumbnail"
                path = "attachments"
                @removeAttachment= "removeAttachment">
            </file-document>
            <simple-file-upload
                :allow-multiple="true"
                @updateFiles="updateFiles">
            </simple-file-upload>
        <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" value="SAVE" @click.prevent ="submitForm" type="submit">
        </div>

        </div>

    </div>
    </div>
</template>

<script>


function getDocument(){
    return{
        'id':0,
        'file_opening_id':'',
        'document_date':'',
        'doc_type':'',
        'subject':'',
        'remarks':'',
        'resource':getAttachment(),
        random:Utilities.getRandomNumber()
    }
}


function getNewForm(){
    return new Form({
        file_opening_id:0,
        documents:[]
    })
}

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
import ComplianceForm from '../Compliance/ComplianceForm.vue'
import FileDocument from './FileDocument.vue'
export default {
  components: { SimpleFileUpload, FileDocument, ComplianceForm },
    props:['file_opening_id'],
    data:function(){
        return{
            create_url:'file-documents',
            base_url:Munshi.base_url,
            form:getNewForm(),
        }
    },
    mounted:function(){
        this.form.file_opening_id = this.file_opening_id;
        this.getDocuments();
        var self = this;
        window.onbeforeunload = function (event) {
            var is_dirty = self.form.isDirty();
            if(is_dirty){
                return "You currently have unsaved changes!!";
                return "<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this Tab’ to exit without saving changes.\nChoose ‘Stay on this Tab’ to return.</h6>";
            }

        }
    },
    methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },

        getDocuments :function(){
            var self = this;
            this.show = false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                console.log(response);
                if(response.data.success){
                    var target = response.data.file_opening['documents'];
                    if(target){
                        self.form.documents = target;
                    }
                }
                self.show = true;
                self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
            })
            .catch(function(error){
                console.log(error);
            });
        },
        updateFiles:function(saved=true,target_id,fileArr){
            var  self = this;
            var file = getDocument();
            file.resource.attachment_id = target_id;
            self.form.documents.push(file);
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

         removeAttachment:function(index){
            this.form.documents.splice(index,1);
        }
    }
}
</script>

<style>

</style>
