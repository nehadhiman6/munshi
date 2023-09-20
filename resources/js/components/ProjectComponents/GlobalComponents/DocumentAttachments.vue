<template>
    <div>
        <!-- FOR image preview Only -->
        <fieldset class="image-fieldset">
            <div :id="'aniimated-thumbnials'+random" class="row">
                <div class="iw-attached-img-area col-md-3 col-sm-4" v-for="(element,index) in imagesArr" :key="element.attachment_id">

                    <a class="iw-thumbnail-gallery" v-if="isIFrame(element)" data-iframe="true" id="open-iframe-data" :data-src="base_url+'/'+path+'/'+element[idLabel]">
                        <figure>
                            <img :src="base_url+'/'+pathThumbnail+'/'+element[idLabel]" />
                            <figcaption  class="text-center" ><span v-if="element.attachment" v-text="getFileName(element.attachment.file_name)"></span></figcaption>
                        </figure>
                    </a>
                    <a class="iw-thumbnail-gallery" v-else :href="getFileUrl(element)" >
                        <figure>
                            <img :src="base_url+'/'+pathThumbnail+'/'+element[idLabel]" />
                            <figcaption  class="text-center" ><span v-if="element.attachment" v-text="getFileName(element.attachment.file_name)"></span></figcaption>
                        </figure>
                    </a>
                    <a :href="base_url+'/'+path+'/'+element[idLabel]"> Download</a>
                    <textarea class="form-control"  v-if="showDescription"  v-model="element.doc_description"></textarea>
                    <select class="form-control" v-if="docTypes.length >0" v-model="element.doc_type" placeholder="type">
                        <option v-for="(type,index) in docTypes" :value="type.id" :key="index+100">{{type.value}}</option>
                    </select>
                    <div v-if='showRemove' class="topright bg-danger text-white iw-remove-upload-btn" @click.prevent="$emit('removeAttachment',index)"><span class="mdi mdi-delete"></span> REMOVE</div>
                </div>
            </div>
        </fieldset>

    </div>
</template>
<script>
export default {
    props:{
        imagesArr:{ type:Array, default:[] },
        idLabel:{type:String,default:'id'},
        path:String,
        pathThumbnail:String,
        type:{ type:String, default:'single'},
        initialId:{ type:[String,Number],default:0},
        loop:{type:Boolean,default:true},
        showDescription:{type:Boolean,default:false},
        docTypes:{type:Array,default:function(){return []}},
        showRemove:{type:Boolean,default:false}
    },
    data:function() {
        return {
            data:[],
            startIndex:0,
            base_url:window[appname]['base_url'],
            random:Math.floor(Math.random() * 100000)+'M'+Math.floor(Math.random() * 1000000)
        }
    },
    mounted:function () {
        var self = this;
        self.launchGallery();
    },
    methods:{
        launchGallery:function() {
            var self = this;
            var lightgallery = $('#aniimated-thumbnials'+this.random).lightGallery({
                selector: '.iw-thumbnail-gallery',
                videojs: true,
                index:4,
                escKey: true,
                addClass: 'iw-lightbox',
                showThumbByDefault: false,
                share: false,
                loop:self.loop,
                index:self.startIndex,
            }).on('onBeforeClose.lg',function(event, index, fromTouch, fromThumb){
                self.$emit('resetImageArr');
            });

        },

        getFileName:function(str){
            if(str.length > 12){
                var str = str.substring(0,8) +'.....'+ str.substring(str.length-4, str.length);
            }
            return str;
        },

        isIFrame:function(element){
            var mime_arr  = ['APPLICATION/PDF']
            if(mime_arr.includes(element.attachment && element.attachment.mime_type.toUpperCase())){
                return true;
            }
            return false;
        },
        getFileUrl:function(element){
            var mime_arr  = ["APPLICATION/VND.OPENXMLFORMATS-OFFICEDOCUMENT.WORDPROCESSINGML.DOCUMENT","APPLICATION/MSWORD"]
            if(mime_arr.includes(element.attachment && element.attachment.mime_type.toUpperCase())){
                return this.base_url+'/'+this.pathThumbnail+'/'+element[this.idLabel];
            }
            return this.base_url+'/'+this.path+'/'+element[this.idLabel];
        }
    },
}
</script>

<style>

div.lg-backdrop {
  background-color: rgba(0, 0, 0, .7);
}

div.iw-lightbox.lg-outer {
  z-index: 1061 ;
}
div.iw-lightbox.lg-outer {
  z-index: 9999 ;
}

div.lg-toolbar {
    background-color: #000;
    height: 60px;
   /* z-index: -1; */
}

div.lg-backdrop.in {
    opacity: 1;
    z-index: 1059 !important;
}

.filepond--file{
    cursor: pointer
}
.iw-attached-img-area figure {
    display: block;
    position: relative;
}

.iw-thumbnail-gallery img{
    width: 100%;
    height: 130px;
    padding: 1px;
    object-fit: contain;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

.image-fieldset{
    border: none;
    padding: 11px;
    margin: 10px 0;
    padding:0
}
#aniimated-thumbnials {
    display: flex;
    flex-wrap: wrap;
}

div#aniimated-thumbnials .topright {
    text-align: center;
}
.iw-attached-img-area {
    position: relative;
}
div#aniimated-thumbnials .topright {
    text-align: center;
    position: absolute;
    padding: 2px 10px;
    top: 0;
    right: 4px;
    cursor: pointer;
}
.iw-remove-upload-btn {
    display: table;
    padding: 5px 10px;
    margin: 10px auto;
    font-size: 13px;
    cursor: pointer;
}

.iw-remove-upload-btn > span.mdi {
    display: inline-block;
    margin-right: 5px;
    font-size: 15px;
}
</style>
