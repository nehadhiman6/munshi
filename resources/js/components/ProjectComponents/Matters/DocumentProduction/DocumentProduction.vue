<template>
<div>
    <div class="card-header py-1">
        <span><strong>Closing Documents</strong></span>
    </div>
    <div class="form-horizontal">
        <div class="card-body">
        <!-- <div class ="mt-4">
            <input class="btn iw-btn iw-btn-submit" value="SAVE" @click.prevent ="submitForm" type="submit">
        </div> -->
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
                        <sale-closing v-if="show_documents"
                            :file_opening="file_opening"
                            :author="author"
                        ></sale-closing>

                        <direction-declaration v-if="show_documents"
                            :file_opening="file_opening"
                            :author="author"
                        ></direction-declaration>
                        <!-- <client-instructions v-if="show_documents"
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
                        ></video-conference-checklist> -->
                        <!-- <tr>
                            <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>
                            </td>
                            <td>Sale Closing</td>
                            <td>Undertaking file</td>
                            <td>
                                <document-generator :key="1"
                                    caption="sale_closing.docx"
                                    :fileName="'sale_closing_'+file_opening.file_no"
                                    :creator="author"
                                    :content="undertaking_content">
                                </document-generator>
                            </td>
                        </tr> -->
                         <!-- <tr>
                            <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                <label class="custom-control-label" for="customCheck2"></label>
                            </div>
                            </td>
                            <td>Directions and Declarations</td>
                            <td></td>
                            <td>
                                <document-generator :key="1"
                                    caption="director and declaration.docx"
                                    :creator="author"
                                    :content="director_and_declaration_content">
                                </document-generator>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import SaleClosing from './SaleClosing.vue'
import DirectionDeclaration from './DirectionDeclaration.vue'
import ClientInstructions from './ClientInstructions.vue'
import LawyerInstructions from './LawyerInstructions.vue'
import VideoConferenceChecklist from './VideoConferenceChecklist.vue'
export default {
    components: { SaleClosing , DirectionDeclaration,ClientInstructions,LawyerInstructions,VideoConferenceChecklist },
    props:['file_opening_id','author'],
    data:function(){
        return{
            base_url:Munshi.base_url,
            director_and_declaration_content:null,
            file_opening:null,
            show_documents: false
        }
    },

    mounted:function(){
        this.getFileOpening();
    },
    methods:{
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
