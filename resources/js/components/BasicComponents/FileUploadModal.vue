<template>
<!-- For click on button type -->
  <div id="imageUpload" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                 <div class="modal-header">
                     <h6>Upload Images</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body file-upload">
                    <file-pond
                        ref="pond"
                        class="custom-modal-filepond"
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
                        :image-preview-max-height="120"
                        :image-preview-height= '120'
                        :max-file-size = "maxFileSize"
                        :instant-upload = "instantUpload"
                        :style-panel-layout= "stylePanelLayout"
                        :label-max-file-size= "labelMaxFileSize"
                        :label-max-file-size-exceeded= "labelMaxFileSizeExceeded"
                        @removefile = "removefile">
                    </file-pond>
                </div>
                 <div class="modal-footer">
                    <button id="save" @click="saveImages" class="btn btn-primary save-details" type="button" name="save-details">Save</button>
                </div>
            </div>
        </div>
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
        showInitial:{
            type:Boolean,
            default:false
        }
    },
    mounted:function() {
        var self = this;
        $('#imageUpload').modal('show');
        $('#imageUpload').on('hidden.bs.modal', function () {
             self.$emit('updateFiles',false,0,[]);
        });
        if(this.targetId > 0 && this.showInitial == true ){
            this.getInitialFiles();
        }
    },
    data:function(){
        return {
            base_url :Munshi.base_url,
            initialFiles:[],
            token : $('meta[name="csrf-token"]').attr('content'),
        }
    },
    methods:{

        getInitialFiles:function () {
            var self = this;
            axios.get('attachments/'+this.targetType+'/'+this.targetId)
            .then(function (response) {
                var attachments= response.data.attachments;
                if(attachments.length > 0){
                    attachments.forEach(function (file) {
                        self.initialFiles.push({
                            source:self.base_url+'/attachments/'+file.id,
                            options:{
                                type:'local',
                                file: {
                                    name: file.original_name,
                                    type: file.mime_type,
                                    serverId:file.id
                                },
                                metadata: {
                                    poster: self.base_url+'/attachments/'+file.id
                                },
                            },

                        });
                    });
                }
            });
        },

        getFiles:function() {
            var self = this;
            return self.$refs['pond'].getFiles();
        },

        onResponse:function(response){
            if(response){
                // necessary to return response to add server id in File Object which we needed to delete
                var response = JSON.parse(response);
                return response.attachment.id;
            }
        },

        removefile:function (file) {
            var self = this;
        },
        saveImages:function(){
            var self = this;
            var files = self.getFiles();
            var fileArr =[];
            files.forEach(element => {
                if(isNaN(element.serverId)){
                    if(element.file.serverId){
                        fileArr.push(element.file.serverId);
                    }
                }
                else{
                    fileArr.push(element.serverId);
                }
            });
            console.log(fileArr);
            self.$emit('updateFiles',true,self.targetId,fileArr);
            $('#imageUpload').modal('hide');
        }
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
