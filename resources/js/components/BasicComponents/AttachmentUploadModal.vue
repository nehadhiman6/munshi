<template>
<!-- For click on button type -->
  <div id="imageUpload" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" :class="getModalSizeClass()">
            <div class="modal-content">
                 <div class="modal-header">
                     <h6><slot>Upload Attachments</slot></h6>
                    <button  type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body file-upload">
                    <div class="row" v-for="(resource,index) in resources" :key="index">
                        <div class="col-md-1 align-self-center" v-if="numberAttachments != 1">
                            {{index+1}} <span v-if="numberAttachments == 0 && editable"><a hrer="#" @click="removeResource(index)"><span class="fe fe-x-circle"></span></a></span>
                        </div>
                        <div class="col-md-3" v-if="docTypes.length > 0">
                            <select class="form-control" :disabled ="!editable" v-model="resource.doc_type" placeholder="type" v-bind:class="{ 'is-invalid':errors.errors && errors.errors['resources.'+index+'.doc_type'] }" >
                                <option v-for="(type,index) in docTypes" :value="type.id" :key="index+100">{{type.value}}</option>
                            </select>
                             <span id="basic-msg" v-if=" errors.errors && errors.errors['resources.'+index+'.doc_type']" class="invalid-feedback">{{  errors.errors && errors.errors['resources.'+index+'.doc_type'][0] }}</span>
                        </div>
                        <div class="col-md-4"  v-if="showRemarks == true">
                            <textarea class="form-control" :disabled ="!editable" placeholder="document description" v-model="resource.doc_description" v-bind:class="{ 'is-invalid': errors.errors && errors.errors['resources.'+index+'.doc_description'] }" ></textarea>
                            <span id="basic-msg" v-if=" errors.errors && errors.errors['resources.'+index+'.doc_description']" class="invalid-feedback">{{  errors.errors && errors.errors['resources.'+index+'.doc_description'][0] }}</span>
                        </div>
                        <div :class="'col-md-'+getColumnSize() ">
                            <pond
                                :key="resource.random"
                                :index="index"
                                :resource="resource"
                                :editable="editable"
                                :instant-upload= "instantUpload"
                                :style-panel-layout= "stylePanelLayout"
                                :max-file-size= "maxFileSize"
                                :label-max-file-size= "labelMaxFileSize"
                                :label-max-file-size-exceeded= "labelMaxFileSizeExceeded"
                                :initial-files= "initialResources"
                                :one-by-one-server-upload ="oneByOneServerUpload"
                                :strict-fixed-numbers = "strictFixedNumbers"
                                :accepted-file-types="acceptedFileTypes"
                                @setSelectedFile="setSelectedFile"
                                >
                            </pond>
                            <div  v-bind:class="{ 'is-invalid':  errors.errors && errors.errors['resources.'+index+'.attachment_id'] }">
                                <span id="basic-msg" v-if=" errors && errors.errors['resources.'+index+'.attachment_id']" class="invalid-feedback">{{errors && errors.errors['resources.'+index+'.attachment_id'][0]}}</span>
                            </div>
                        </div>
                    </div>
                    <div class = "form-row align-items-center" v-if="showAddButton && editable">
                        <div class ="col mt-4">
                            <button class="btn iw-btn-add" @click="addNewFile">Add New</button>
                        </div>
                    </div>
                </div>
                 <div class="modal-footer" v-if="editable">
                    <button id="save" @click="saveImages" class="btn iw-btn-submit" type="button" name="save-details">Save</button>
                </div>
                <image-preview v-if="resources.length > 0 && previewImageId > 0"
                    :imagesArr= "resources"
                    :initial-id ="previewImageId"
                     path-thumbnail = "attachments-thumbnail"
                     path = "attachments"
                    :loop = "loopPreview"
                     idLabel = 'attachment_id'
                    @resetImageArr="setSelectedFile"
                    :key="getRandomNumber()">
                </image-preview>
            </div>
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
import Pond from './Pond.vue';
export default {
    components:{
        Pond
    },
    props:{
        instantUpload:{                 // if you want to upload  to server/ attachment table immediately after upload
            type:Boolean,
            default:true
        },
        stylePanelLayout:{
            type:[String,Object],
            default:null           // can be: compact, compact integrated, circle, compact circle
        },
        maxFileSize:{
            default:'50MB'         // Maximum file size
        },
        labelMaxFileSize:{              // label for maximum filke size
            type:String,
            default:'maximum 50MB'
        },
        labelMaxFileSizeExceeded:{       // error to show when max file exceed
            type:String,
            default:'Exceed Size'
        },
        acceptedFileTypes:{
            type:Array,                  // array of doc tyoes 'image/png', 'image/jpeg'
            default:function(){            //Array of accepted file types. Can be mime types or wild cards. For instance ['image/*'] will accept all images.
                 return [];
            }
        },
        docTypes:{
            type:Array,                  // array of document Types with id and value object
            default:function(){
                 return [];
            }
        },
        initialResources:{             // for edit case array of inital images just pass resources  array in prop
            type:Array,
            default:function(){
                return [];
            }
        },
        showRemarks:{              // remarks textarea field visibility
            type:Boolean,
            default:true
        },
        numberAttachments:{        //Number of maximum attachments
            type:[Number,String],
            default:0
        },
        oneByOneServerUpload:{     // if you want to preview file thumbnail and only want to upload on server by upside aerrow click on file
            type:[Boolean],
            default:true
        },
        loopPreview:{            // if ypu want loop preview of images/ pdfs in all modal
            type:Boolean,       //loop means after last file first will be shown if false then it will stop to last image/pdf
            default:false
        },
        strictFixedNumbers:{      // strict number of attachments needed to upload
            type:Boolean,       // number of upload images would be shown initally without add button click
            default:false
        },
        saveFormOnSaveClicked:{      // this would not close modal on save clicked
            type:Boolean,       // modal will will be closed from parent after saving files so that we can run our logic to save attachments
            default:false       // immediately after save clicked in parent // can show validation errors on modal
        },
        editable:{      // this would not allow user  to delete or add new attachments
            type:Boolean,       // for view purpose only if set to false
            default:true       // false if you don't want the  user to add new or update existing attachments
        },
        errors:{      // error object
            type:Object,
            default:function(){
                return { 'errors':{}};
            }
        }

    },
    data:function(){
        return {
            base_url :Munshi.base_url,
            resources:[],
            token : $('meta[name="csrf-token"]').attr('content'),
            previewImageId:0
        }
    },
    computed:{
        showAddButton(){
            if(this.numberAttachments == 0)
                return true;
            if(this.strictFixedNumbers == true ||  this.resources.length >= this.numberAttachments)
                return false;
            else
                return true;
        }
    },
    mounted:function() {
        var self = this;
        $('#imageUpload').modal('show');
        $('#imageUpload').on('hidden.bs.modal', function () {
            self.$emit('updateResources',false);
        });
        this.resources =  JSON.parse(JSON.stringify(this.initialResources));
        var i = this.resources.length;
        if(this.resources.length == 0){
            do{
                this.resources.push(getAttachment());
                i++;
                if(this.strictFixedNumbers == false){
                    break;
                }
            }while(i < this.numberAttachments)
        }
    },


    methods:{
        saveImages:function(){
            var self = this;
            self.$emit('updateResources',true,this.resources);
            if(this.saveFormOnSaveClicked ==false)
            {
                $('#imageUpload').modal('hide');
            }

        },

        getColumnSize:function(){
            var self = this;
            var cols = 12;
            if(self.numberAttachments == 0 || self.numberAttachments > 1 ){
                cols = cols-1;
            }
            if(self.docTypes.length >  0 ){
                cols = cols-3;
            }
            if( self.showRemarks){
                cols = cols-4;
            }
             return cols;

        },
        getModalSizeClass:function(){
            if(this.getColumnSize() >10){
                return 'modal-sm';
            }
            else if(this.getColumnSize() <=10 && this.getColumnSize() > 5){
                 return '';
            }
            else if(this.getColumnSize()<= 5){
                return 'modal-lg';
            }
        },
        addNewFile:function(){
            this.resources.push(getAttachment());
        },
        removeResource:function(index){
            this.resources.splice(index,1);
        },
        setSelectedFile:function(id=0){
            this.previewImageId = id;
        },
        getRandomNumber:function(){
            return Utilities.getRandomNumber()
        }
    }
}
</script>

<style >


</style>
