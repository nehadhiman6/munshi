<template>
  <div>
         <div class="tab-content border-0" id="myTabContent">
            <div class="tab-pane fade show active" id="writ-execution" role="tabpanel" aria-labelledby="writ-execution-tab" v-if="file_opening">
                <writ-form :key="getRandomNumber()"
                    :lro="lro"
                    :cities="cities"
                    :permissions="permissions"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening">
                </writ-form>
            </div>
            <div class="tab-pane fade" id="writ-file-upload" role="tabpanel" aria-labelledby="writ-file-upload-tab" v-if="file_opening">
                <writ-file-upload-tab
                    :form="form"
                    :file_opening_id="file_opening_id"
                    :file_opening="file_opening">
                </writ-file-upload-tab>
            </div>
        </div>
  </div>
</template>

<script>
import FileUploadTab from '../Commission/FileUploadTab.vue';
import WritFileUploadTab from './WritFileUploadTab.vue';
import WritForm from './WritForm.vue';
function getNewForm(){
    return new Form({
        form_id:0,
        file_opening_id:0,
        execution_docs:[]
    })
};
export default {
  components: { WritForm, FileUploadTab, WritFileUploadTab },
    props:['file_opening_id','author','permissions','lro','cities'],
    data:function(){
        return {
            form:getNewForm(),
            file_opening:null,
            base_url:Munshi.base_url
        }
    },
    mounted:function(){
        this.getFileOpening();
    },
    methods:{
        isComponentDirty:function(){
            return this.form.isDirty();
        },
        getRandomNumber(){
            return Utilities.getRandomNumber()
        },


         getFileOpening:function(){
            var self = this;
            self.show=false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                if(response.data.success){
                    self.file_opening = response.data.file_opening;
                    self.form.execution_docs = response.data.file_opening.execution_docs;
                    self.form.file_opening_id = response.data.file_opening.id;
                    self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                }
            })
            .then(function() {
                self.show_documents = true;
            })
            .catch(function(error){
                console.log(error);
            });
        },
    }
}
</script>

<style>

</style>
