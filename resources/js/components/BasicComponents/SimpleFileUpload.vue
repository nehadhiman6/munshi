<template>
<!-- For click on button type -->
        <div class="file-upload">
            <file-pond
                ref="simple-pond"
                class="custom-full-filepond"
                v-bind:server="{
                    url: base_url,
                    timeout: 7000,
                    process: {
                        url: '/attachments',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN':token
                        },
                        withCredentials: false,
                        onload: onResponse
                    },
                    revert: {
                        url: '/attachments/delete',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN':token
                        },
                        withCredentials: false,
                        onload: onResponse,
                    },
                    //   revert: '/attachments/'+form.attachment_id // or null
                    // revert: null
                }"
                :allow-multiple="allowMultiple"
                :image-preview-max-height="120"
                :image-preview-height= '120'
                :max-file-size = "maxFileSize"
                :instant-upload = "instantUpload"
                :style-panel-layout= "stylePanelLayout"
                :label-max-file-size= "labelMaxFileSize"
                :label-max-file-size-exceeded= "labelMaxFileSizeExceeded"
                @removefile = "removefile"
                @activatefile="onActivateFile">
            </file-pond>

             <!-- <div class ="mt-4">
                <input class="btn iw-btn iw-btn-submit" value="Upload" @click.prevent ="saveImages" type="submit">
            </div> -->
            <image-preview v-if="initialResources.length > 0 && previewImageId > 0"
                :imagesArr= "initialResources"
                :initial-id ="previewImageId"
                path-thumbnail = "attachments-thumbnail"
                path = "attachments"
                :loop = "loopPreview"
                idLabel = 'attachment_id'
                @resetImageArr="setSelectedFile"
                :key="getRandomNumber()">
            </image-preview>
        </div>
</template>

<script>
export default {
     props:{
        instantUpload:{
            type:Boolean,
            default:true
        },
        allowMultiple:{
            type:Boolean,
            default:false
        },
        stylePanelLayout:{
            type:[String,Object],
            default:null // can be: compact, compact integrated, circle, compact circle
        },
        maxFileSize:{
            default:'50MB'
        },
        labelMaxFileSize:{
            type:String,
            default:'maximum 50MB'
        },
        labelMaxFileSizeExceeded:{
            type:String,
            default:'Exceed Size'
        },
        loopPreview:{
            type:Boolean,
            default:false
        },
        initialResources:{             // for edit case array of inital images just pass resources  array in prop
            type:Array,
            default:function(){
                return [];
            }
        },
        types:{
            type:Array,
            default:function(){
                return [];
            }
        },
        showRemarks:{
            type:Boolean,
            default:false
        },

    },
    mounted:function() {
        var self = this;
    },
    data:function(){
        return {
            base_url :Munshi.base_url,
            initialFiles:[],
            token : $('meta[name="csrf-token"]').attr('content'),
            previewImageId :0
        }
    },
    computed:{
        initial_files(){
            var arr=[];
            var self= this;

            self.initialResources.forEach(element => {
                    if(element.attachment_id > 0){
                        arr.push({
                            source:self.base_url+'/attachments-thumbnail/'+element.attachment_id,
                            // source:element.attachment_id,
                            options:{
                                type:'local',
                                file: {
                                    serverId:element.attachment_id,
                                },
                                metadata: {
                                    poster: self.base_url+'/attachments-thumbnail/'+element.attachment_id
                                },
                            },
                        });
                }
            });

            return arr;
        }
    },
    methods:{


        getFiles:function() {
            var self = this;
            return self.$refs['simple-pond'].getFiles();
        },

        onResponse:function(response){
            if(response){
                // necessary to return response to add server id in File Object which we needed to delete
                var response = JSON.parse(response);
                this.$refs['simple-pond'].removeFiles();
                this.$emit('updateFiles',true,response.attachment);
                return response.attachment;
            }
        },

        removefile:function (file) {
            var self = this;
        },

        onActivateFile:function(file){
            if(isNaN(file.serverId)){
                if(file.file.serverId){
                    this.previewImageId = file.file.serverId;
                }
            }
            else{
                    this.previewImageId = file.file.serverId;
            }
        },
        getRandomNumber:function(){
            return Utilities.getRandomNumber();
        },

        setSelectedFile:function(id=0){
            this.previewImageId = id;
        },
    }
}
</script>

<style scoped>
/* .custom-modal-filepond .filepond--root {
    width: auto;
}
.custom-modal-filepond .file-upload .filepond--item {
    width: calc(50% - .5em);
}
@media (min-width: 30em) {
   .custom-modal-filepond  .file-upload .filepond--item {
        width: calc(50% - .5em);
    }
}

@media (min-width: 50em) {
    .custom-modal-filepond .file-upload .filepond--item {
        width: calc(33.33% - .5em);
    }
} */


</style>
