<template>
<div>
    <!-- FOR image preview Only -->
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
        loop:{type:Boolean,default:true}
    },
    data:function() {
        return {
            data:[],
            startIndex:0
        }
    },
    mounted:function () {
        var self = this;
        self.imagesArr.forEach((element,index) => {
            if(this.initialId > 0 && this.initialId == element[self.idLabel]){
                this.startIndex = index;
            }
            //filter of extension
            if(element[self.idLabel]){

                if(element.attachment && element.attachment.mime_type == 'application/pdf'){
                    self.data.push({
                        'src':window[appname]['base_url']+'/'+self.path+'/'+element[self.idLabel],
                        "iframe": "true",
                        'thumb':window[appname]['base_url']+'/'+self.pathThumbnail+'/'+element[self.idLabel],
                        'subHtml': "<a href="+window[appname]['base_url']+'/'+self.path+'/'+element[self.idLabel]+" target='_blank'>Open</a>",
                        'downloadUrl':window[appname]['base_url']+'/'+self.path+'/'+element[self.idLabel]
                    });
                }
                else{
                    self.data.push({
                        'src':window[appname]['base_url']+'/'+self.pathThumbnail+'/'+element[self.idLabel],
                        'thumb':window[appname]['base_url']+'/'+self.pathThumbnail+'/'+element[self.idLabel],
                        'subHtml': "<a href="+window[appname]['base_url']+'/'+self.path+'/'+element[self.idLabel]+" target='_blank'>Open</a>",
                        'downloadUrl':window[appname]['base_url']+'/'+self.path+'/'+element[self.idLabel]
                    });
                }
            }

        });

        self.launchGallery();
    },
    methods:{
        launchGallery:function() {
            var self = this;
            var lightgallery = $(this).lightGallery({
                videojs: true,
                dynamic: true,
                index:4,
                dynamicEl: self.data,
                addClass: 'iw-lightbox',
                escKey: true,
                share: false,
                loop:self.loop,
                index:self.startIndex,
            }).on('onBeforeClose.lg',function(event, index, fromTouch, fromThumb){
                self.$emit('resetImageArr');
            });

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

</style>
