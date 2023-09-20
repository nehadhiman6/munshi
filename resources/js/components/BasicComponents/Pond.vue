<template>
    <file-pond :key="resource.random"
        ref="pond"
        class="resource-modal-filepond "
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
               url: '/attachments/'+resource.attachment_id,
               method: 'DELETE',
               headers: {
                   'X-CSRF-TOKEN':token
               },
            withCredentials: false,
               onload: onResponse,
           },
        //   revert: '/attachments/'+form.attachment_id // or null
            //revert: null
        }"
        :files="initial_file"
        :image-preview-max-height="maxheight"
        :image-preview-height= 'size'
        :max-file-size = "maxFileSize"
        :instant-upload = "instantUpload"
        :style-panel-layout= "stylePanelLayout"
        :label-max-file-size= "labelMaxFileSize"
        :label-max-file-size-exceeded= "labelMaxFileSizeExceeded"
        :allow-drop = "editable"
        :allow-browse = "editable"
        :allow-revert = "editable"
         @addfile ="saveAttachments"
        @removefile = "removefile"
        @activatefile="onActivateFile"
        >
    </file-pond>


</template>

<script>
export default {
    props:{
        instantUpload:{
            type:Boolean,
            default:true  //how upload should save  on server intsantly true for immediately on  upload false for user click on upload on file
        },
        stylePanelLayout:{
            type:[String,Object],
            default:null // can be: compact, compact integrated, circle, compact circle
        },
        maxFileSize:{
            default:'50MB'  //size of the file
        },
        labelMaxFileSize:{
            type:String,
            default:'maximum 50MB'  // label for file is size
        },
        labelMaxFileSizeExceeded:{
            type:String,
            default:'Exceed Size'  // label for file is exceedeing
        },
        resource:{              // one file in array
            type:[String,Object],
            default:null
        },
        index:{             // index of our attachments array
            type:[String,Number],
            default:-1
        },
        oneByOneServerUpload:{
            type:[Boolean],
            default:true
        },
        editable:{      // this would not allow user  to delete or add new attachments
            type:Boolean,
            default:true
        },

    },
    data:function(){
        return {
            base_url :Munshi.base_url,
            token : $('meta[name="csrf-token"]').attr('content'),
            size:100,
            maxheight:20
        }
    },
    computed:{
        initial_file(){
            var arr=[];
            var self= this;
            if(this.resource.id > 0){
                arr.push({
                    source:self.base_url+'/attachments-thumbnail/'+self.resource.attachment_id,
                    // source:self.resource.attachment_id,
                    options:{
                        type:'local',
                        file: {
                            name: self.resource.attachment ? self.resource.attachment.file_name:'',
                            type:  self.resource.attachment ? self.resource.attachment.mime_type:'',
                            serverId:self.resource.attachment_id,
                        },
                        metadata: {
                            poster: self.base_url+'/attachments-thumbnail/'+self.resource.attachment_id
                        },
                    },
                });
            }
            return arr;
        }
    },
    methods:{
        getFiles:function() {
            var self = this;
            return self.$refs['pond'].getFiles();
        },

        onResponse:function(response){
            var self= this;
            if(response){
                // necessary to return response to add server id in File Object which we needed to delete
                var response = JSON.parse(response);
                self.resource.attachment_id =  response.attachment;
                return response.attachment;
            }
        },

        removefile:function (file) {
            var self = this;
            console.log(file);
        },
        saveAttachments:function(){
            return;
            var self = this;
            var files = self.getFiles();
            var fileArr =[];
            // files.forEach(element => {
            //     if(isNaN(element.serverId)){
            //         if(element.file.serverId){
            //             fileArr.push(element.file.serverId);
            //         }
            //     }
            //     else{
            //         fileArr.push(element.serverId);
            //     }
            // });
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
            self.$emit('updateFiles',fileArr);
        },

        onActivateFile:function(file){
            if(isNaN(file.serverId)){
                if(file.file.serverId){
                    this.$emit('setSelectedFile',file.file.serverId);
                }
            }
            else{
                  this.$emit('setSelectedFile', file.serverId);
            }
        }
    }
}
</script>

<style>
.resource-modal-filepond .filepond--root {
    width: auto;
}
/*
.file-upload .filepond--item {
    width: calc(50% - .5em);
}
@media (min-width: 30em) {
    .file-upload .filepond--item {
        width: calc(50% - .5em);
    }
}

@media (min-width: 50em) {
    .file-upload .filepond--item {
        width: calc(33.33% - .5em);
    }
} */

</style>
