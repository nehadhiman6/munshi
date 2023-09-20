<template>
    <div>
        <!-- FOR image preview Only -->
        <fieldset class="image-fieldset">
            <div :id="'aniimated-thumbnials'+random">
                <div class="iw-attached-img-area" v-for="(element,index) in imagesArr" :key="element.attachment_id">
                    <a class="iw-thumbnail-gallery" :href="base_url+'/'+path+'/'+element[idLabel]" >
                        <figure>
                            <img :src="base_url+'/'+pathThumbnail+'/'+element[idLabel]" />
                            <figcaption  class="text-center" ><span v-if="element.attachment" v-text="getFileName(element.attachment.file_name)"></span></figcaption>
                        </figure>
                    </a>
                    <div v-if='showRemove' class="topright bg-danger text-white" @click.prevent="$emit('removeAttachment',index)"><i class="fa fa-trash"></i> </div>
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

.iw-thumbnail-gallery img{
    width: 187px;
    height: 126.144px;
    padding: 1px;
}

.image-fieldset{
    border: 1px solid #0000004d;
    padding: 11px;
    margin: 10px;
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

</style>
