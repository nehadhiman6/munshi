<template>
<div>
    <div class="card-header py-1">
        <span><strong>Signing</strong></span>
    </div>
    <div class="form-horizontal">
        <div class="card-body">
              <fieldset class="fieldset">
                   <div class="row">
                <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Template Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Word Document</th>
                    </tr>
                    </thead>
                    <tbody>
                        <client-instructions v-if="show_documents"
                            :file_opening="file_opening"
                            :author="author"
                        ></client-instructions>
                        <lawyer-instructions v-if="show_documents"
                            :file_opening="file_opening"
                            :author="author"
                        ></lawyer-instructions>
                        <video-conference-checklist v-if="show_documents"
                            :file_opening="file_opening"
                            :author="author"
                        ></video-conference-checklist>

                    </tbody>
                </table>
                </div>
            </div>

                    <div class="form-row">
                        <div class="col-md-4 user">
                            <file-pond
                                ref="pond"
                                :imagePreviewMaxHeight="50"
                                labelIdle =  'Drag & drop your document here'
                                style-panel-layout="compact"
                                accepted-file-types = "image/jpeg, image/png"
                                v-bind:server="{
                                    url: base_url+'/',
                                    timeout: 7000,
                                    process: {
                                        url: 'attachments',
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN':token
                                        },
                                        withCredentials: false,
                                        onload: onResponse,
                                    },
                                    revert: null
                                }"
                                :files="myFiles"
                                @removefile ="removedFile"
                                >
                            </file-pond>
                            <!-- <a :href="#" v-if="seller_id.resources.length>0 && seller_id.resources[0].attachment_id > 0">Download</a> -->
                        </div>
                    </div>
                </fieldset>
        </div>
    </div>
    </div>
</template>

<script>
import VideoConferenceChecklist from "../DocumentProduction/VideoConferenceChecklist.vue";
import LawyerInstructions from "../DocumentProduction/LawyerInstructions.vue";
import ClientInstructions from "../DocumentProduction/ClientInstructions.vue";

export default{
    props:['file_opening_id','author','permissions'],
  components: { ClientInstructions,VideoConferenceChecklist,LawyerInstructions },
    data() {
        return {
            base_url:Munshi.base_url,
            token : $('meta[name="csrf-token"]').attr('content'),
            myFiles:[],
            file_opening:null,
            show_documents:false

        };
    },

    mounted:function(){
        this.getFileOpening();
    },

    methods: {
        onResponse:function(r) {

        },
        removedFile:function () {
        },

        isComponentDirty:function(){
            return false;
        },

        getFileOpening:function(){
            var self = this;
            self.show=false;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                if(response.data.success){
                    self.file_opening = response.data.file_opening;
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
