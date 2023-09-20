
<template>
<!--
// For gallery type view
// mainly for common file component in whole project
//Designed By neha Dhiman-->
    <div>
        <div class="modal fade iw-attachment-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10">
                             <div class="iw-modal-body-background">
                               <div class="filter-area d-flex justify-content-end">
                                   <!-- <div class="iw-multiple-select">
                                        <div class="dropdown show iw-filter-select">
                                            <a class="iw-filter-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="iw-filter-label">Sort By:</span> {{sort_by_text}}
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <label class="iw-filter-container">latest (Default)
                                                    <input type="radio" name="sort_by" value="latest" v-model="sort_by">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                <label class="iw-filter-container">name (asc A-Z)
                                                    <input type="radio"  name="sort_by" value="name_asc" v-model="sort_by">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                 <label class="iw-filter-container">name (desc Z-A)
                                                    <input type="radio" name="sort_by" value="name_desc" v-model="sort_by">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                 <label class="iw-filter-container">size (low to high)
                                                    <input type="radio" name="sort_by" value="size_lh" v-model="sort_by">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                <label class="iw-filter-container">size (high to low)
                                                    <input type="radio" name="sort_by" value="size_hl" v-model="sort_by">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="iw-image-search-byname">
                                        <input type ="text" placeholder="Search name" v-model="search_name" @keyup="SearchByNameImage()">
                                    </div>
                                    <div class="iw-multiple-select">
                                        <div class="dropdown show iw-filter-select">
                                            <button class="iw-filter-btn" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="iw-filter-label">Filter by:</span> {{filter_by_text}} <span class="mdi mdi-filter"></span>
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <label class="iw-filter-container">All
                                                    <input type="checkbox" name ="checkfilter"  checked @change.prevent="changeFilter($event,'all')">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                <label class="iw-filter-container">Images Only
                                                    <input type="checkbox"  name ="checkfilter" checked @change.prevent="changeFilter($event,'images')">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                <label class="iw-filter-container">Videos
                                                    <input type="checkbox"  name ="checkfilter" checked @change.prevent="changeFilter($event,'videos')">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                <label class="iw-filter-container">Pdf
                                                    <input type="checkbox"  name ="checkfilter" checked @change.prevent="changeFilter($event,'pdf')">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                                <label class="iw-filter-container">Others
                                                    <input type="checkbox"  name ="checkfilter" checked @change.prevent="changeFilter($event,'others')">
                                                    <span class="iw-checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <!-- accepted-file-types = "image/jpeg, image/png,video/3gpp,video/x-msvideo" -->
                                <div class="iw-file-pond-wrapper">
                                    <file-pond
                                        ref="pond"
                                        class="custom-filepond"
                                        :image-preview-max-height="120"
                                        :image-preview-height= '120'
                                        :max-file-size = "maxFileSize"
                                        :instant-upload = "instantUpload"
                                        :style-panel-layout= "stylePanelLayout"
                                        :label-max-file-size= "labelMaxFileSize"
                                        :label-max-file-size-exceeded= "labelMaxFileSizeExceeded"

                                        label-idle = '<span class="filepond--label-action" style="font-size: 80px; line-height:1">+</span>'
                                        v-bind:server="{
                                            url: base_url,
                                            timeout: 70000,
                                            process: {
                                                url: '/attachments',
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN':token
                                                },
                                                withCredentials: false,
                                                onload: onResponse,

                                            },
                                        //   revert: '/attachments/'+form.attachment_id // or null
                                        revert: null
                                        }"
                                        >
                                    </file-pond>
                                    <div class="iw-upload-wrapper d-inline-block " :class="getClass(attachment)" v-for="attachment in allFiles" :key="attachment.id"
                                        @click="selectAttachment($event,attachment.id)" @dblclick.prevent="previewSelectedFile($event,attachment.id)" >
                                        <img :class="'iw-uploaded-images'+attachment.id" :src="getSource(attachment)"/>
                                        <br><h6>{{getAttachmentName(attachment)}}</h6>
                                        <!-- <a  @click.prevent="copyLink(attachment.id)">copy link</a> -->
                                    </div>
                                    <div class ="col-md-12  d-flex justify-content-center" v-if="showLoader">
                                        <img :src="getLoaderImageLink()" style="width:80px">
                                    </div>
                                </div>

                                </div>
                            </div>
                            <div class="col-md-2">
                               <!-- <button class="btn btn-primary" @click.prevent="saveSelectedAttachment">Upload</button>-->
                                <div class="iw-modal-rightsidebar">
                                    <div class="modal_sidebar-content" v-for="sel_image in selected_image" :key="sel_image.id" >
                                        <h3>Attachment Details</h3>
                                        <p class="image-name">{{sel_image.file_name}}</p><p class="upload-date">April 7, 2019</p>
                                        <p class="image-size">350 by 350 pixels</p>
                                        <!-- <a class="edit-image" href="#">Edit image</a> -->
                                        <a class="copy-link" @click="copySelectedLink">Copy link</a>
                                        <!-- del-image class for delete -->
                                        <div class="iw-image-sidebar-preview">
                                            <img :src="getSource(sel_image)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <vue-pagination
                            :pagination="files"
                            @paginate="getExistingFiles()"
                            :offset="4">
                        </vue-pagination>
                    </div> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" @click.prevent="saveSelectedAttachment">Upload</button>
                    </div>
                </div>
            </div>
        </div>

        <image-preview v-if="allFiles.length > 0 && previewImageId > 0"
            :imagesArr= "allFiles"
            :initial-id ="previewImageId"
            path = "attachments"
            :loop = "loopPreview"
            @resetImageArr="resetImageArr">
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
    },
    data:function () {
        return {
            token : $('meta[name="csrf-token"]').attr('content'),
            base_url:window[appname]['base_url'],
            allFiles:[],
            current_page:1,
            last_page:0,
            selectedAttachments:[],
            previewImageId:'0',
            sort_by:'latest',
            filter_by:['all','images','pdf','videos','others'],
            showLoader:false,
            search_name:''
        }
    },
    watch:{
        sort_by:function(){
            this.getExistingFiles();
        }
    },
    mounted:function () {
        var self= this;
        this.getExistingFiles();
        $('.iw-attachment-modal').on('hidden.bs.modal', function () {
            self.$emit('removeModal');
        });
        $('.iw-attachment-modal').modal('show');
        $('.iw-filter-select .dropdown-menu').on('click', function(event){ event.stopPropagation(); });

        $('.modal-dialog-scrollable .modal-body').on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                if(self.allFiles.length != 0 && (self.last_page > self.current_page)){
                    self.current_page++;
                    self.getExistingFiles();
                }
            }
        });
    },
    computed:{
        filter_by_text:function(){
            var text = '';
            var index =  this.filter_by.indexOf('all');
            if(index >=0){
                return 'All';
            }
            this.filter_by.forEach((element,index) => {
                text+= index >0 ?',':'';
                text+= Utilities.capitalizeFirstLetter(element);
            });
            return text;
        },
        sort_by_text:function(){
            if(this.sort_by=='latest')
                return "Latest"
            else if(this.sort_by == 'name_asc')
                return "Name(Asc)"
            else if(this.sort_by == 'name_desc')
                return "Name(Desc)"
            else if(this.sort_by == 'size_lh')
                return "Size(Low to high)"
            else if(this.sort_by == 'size_hl')
                return "Size(High to low)"
        },
        selected_image:function(){
            var self = this;
            if(this.allowMultiple == false){
                if(this.selectedAttachments.length == 1){
                    return this.allFiles.filter(function (e) {
                        return e.id == self.selectedAttachments[0];
                    });
                }
            }
            return [];
        },
    },
    methods:{
        getExistingFiles:function () {
            var self = this;
            this.showLoader = true;
            LMS.block_loading = false;
            axios.post(this.base_url+'/'+'attachments/list',{
                'filter_by':self.filter_by,
                'sort_by':self.sort_by,
                'page':self.current_page,
                'search_name':self.search_name
            })
            .then(function (response) {
                var attachments= response.data.attachments;
                self.allFiles=  self.allFiles.concat(attachments.data);
                self.current_page = attachments.current_page;
                self.last_page = attachments.last_page;
                self.showLoader = false;
                LMS.block_loading = true;
            })
            .catch(function (error) {
                self.showLoader = false;
                LMS.block_loading = true;
            });
        },
        selectAttachment:function (event,id) {
            console.log("SELECT ATTACHMENT: " + id);
            var self = this;
            // if(event.target.tagName.toUpperCase() == 'IMG'){
                var targetHasClass = $(event.target).hasClass('iw-selected-img');
                console.log("Target Has Class :"+ targetHasClass);
                var controlPressed = event.ctrlKey;
                console.log("aaaaaaaaaaaaaaaaaaaaaaaa");
                if(this.allowMultiple == false){
                     console.log("bbbbbbbbbbbbbbbb");
                    if(targetHasClass == true){
                        console.log("dddddddddddddddddddddd");

                        $(event.target).closest('img').toggleClass('iw-selected-img');
                        $(event.target).closest('img').parent().toggleClass('iw-selected-parent');
                        self.blankSelectedAttachment();
                    }
                    else{
                        console.log("eeeeeeeeeeeeeeeeeeeeeeeeeeeee");

                        self.removeTargetClass($("img"),"iw-selected-img");
                        self.removeTargetClass($('.iw-upload-wrapper'),"iw-selected-parent");
                        self.addTargetClass($(event.target).closest('img'),'iw-selected-img');
                        self.addTargetClass($(event.target).closest('img').parent(),'iw-selected-parent');
                        self.setSelectedAttachment(id);
                    }
                }
                else{
                    console.log("cccccccccccccccccccccccccc");

                    if(targetHasClass == true){
                         console.log("ffffffffffffffffffffffffffffff");
                        $(event.target).toggleClass('iw-selected-img');
                        if(!controlPressed){
                            self.blankSelectedAttachment();
                            self.removeTargetClass($("img").not(event.target),"iw-selected-img");
                        }
                        else{
                            self.removeSingleAttachment(id);
                        }
                    }
                    else{
                         console.log("ggggggggggggggggggggggggggggggggggg");
                        if(!controlPressed){
                            self.blankSelectedAttachment();
                            self.removeTargetClass($("img"),"iw-selected-img");
                        }
                        self.setSelectedAttachment(id);
                        self.addTargetClass($(event.target),'iw-selected-img');
                    }

                // }
            }
        },
        onResponse:function (res) {
            var self = this;
            var response = JSON.parse(res);
            if(response.success == true){
                var attachment = response.attachment;
                self.allFiles.unshift(attachment);
                self.$refs.pond.removeFiles();
                self.setSelectedAttachment(attachment.id);
                self.$nextTick(function (params) {
                    self.removeTargetClass($("img"),"iw-selected-img");
                    self.addTargetClass( $('.iw-uploaded-images'+attachment.id),'iw-selected-img');
                    self.addTargetClass( $('.iw-uploaded-images'+attachment.id).parent(),'iw-selected-parent');
                });
            }
        },
        setSelectedAttachment:function (id) {
            console.log("setSelectedAttachment "+id);
            if(this.allowMultiple == false){
                this.blankSelectedAttachment();
            }
            this.selectedAttachments.push(id);
        },

        blankSelectedAttachment:function () {
            this.selectedAttachments = [];
        },

        removeTargetClass(target,classname){
            target.removeClass(classname);
        },

        removeSingleAttachment:function (id) {
            var indexOfId = this.selectedAttachments.indexOf(id);
            if(indexOfId >= 0){
                this.selectedAttachments.splice(indexOfId,1);
            }
        },

        addTargetClass(target,classname){
            target.addClass(classname);
        },
        saveSelectedAttachment:function () {
            this.$emit('addAttachment',this.selectedAttachments);
            $('.iw-attachment-modal').modal('hide');
        },
        getAttachmentName:function (attachment) {
            var name = attachment.file_name;
            if(name.length > 15){
                name = name.substring(0, 10);
                name+='.....'+attachment.file_extension;
            }
            return name;
        },

        previewSelectedFile:function (event,id) {
            this.previewImageId = id;
        },

        resetImageArr:function () {
            this.previewImageId = 0;
        },

        getSource:function (attachment) {
            var video = ['video/mp4','video/x-ms-wmv','video/x-msvideo' ,'video/quicktime','video/3gpp','video/x-flv'];
            if(video.indexOf(attachment.mime_type) >=0){
                return this.base_url+'/images/videoicon1.png';
            }
            return this.base_url+'/attachments/'+attachment.id;
        },

        changeFilter:function(event,value){
            var checked = event.target.checked;
            if(value == 'all' && checked==true){
                $("input[name='checkfilter']").each(function (index, obj) {
                    $("input[name='checkfilter']")[index].checked = true;

                });
                this.filter_by = ['all','images','pdf','videos','others'];
            }
            else if(value == 'all' && checked==false){
                 $("input[name='checkfilter']").each(function (index, obj) {
                    $("input[name='checkfilter']")[index].checked = false;
                });
                this.filter_by = [];
            }
            else{
                var index= this.filter_by.indexOf(value);
                if(index< 0 && checked == true){
                    this.filter_by.push(value);
                    if(this.filter_by.length >= 4){
                        $("input[name='checkfilter']")[0].checked = true;
                        this.filter_by.push('all');
                    }
                }
                else if(checked == false && index >=0){
                    this.filter_by.splice(index,1);
                    $("input[name='checkfilter']")[0].checked = false;
                    var all_index= this.filter_by.indexOf('all');
                    if(all_index >=0){
                        this.filter_by.splice(all_index,1);
                    }
                }
            }
            this.current_page = 1;
            this.last_page = 0;
            this.allFiles = [];
            this.getExistingFiles();

        },
        getClass:function(attachment){
            if(attachment.file_extension == 'mov'){
                return "iw-video-clip";
            }
            return '';
        },

        copySelectedLink:function(){
           if(this.selectedAttachments.length ==1){
               this.copyLink(this.selectedAttachments[0]);
           }
        },

        copyLink:function(id){
            var aux = document.createElement("div");
            aux.setAttribute("contentEditable", true);
            aux.innerHTML = LMS.base_url+'/attachments/'+id;
            aux.setAttribute("onfocus", "document.execCommand('selectAll',false,null)");
            document.body.appendChild(aux);
            aux.focus();
            document.execCommand("copy");
            document.body.removeChild(aux);
            Utilities.growlUIMessage("Link Copied!",5000);
        },

        getLoaderImageLink:function(){
            return LMS.base_url+'/images/loader1.gif';
        },

        SearchByNameImage:function(){
            this.current_page = 1;
            this.last_page = 0;
            this.allFiles = [];
            this.getExistingFiles();
        },

         getRandomKey:function(id){
            return Math.floor(Math.random() * 100000) +id;
        }

    }
}
</script>

<style scoped>
    .custom-filepond {
        display: inline-block;
    }
    .custom-filepond .filepond--root {
        width:160px;
        border: 5px dashed #459eec73;
        /* border: 2px dashed #777; */
        margin: 7px;
        border-radius: 10px;
        min-height: 160px;
        position: relative;
        /* margin: 0 auto; */
    }
    .filepond--label-action {
        text-decoration: none;
    }

    .iw-upload-wrapper img{
        cursor: pointer;
        width: 100%;
        height:120px;
        /* border: 4px solid #6b757d38; */
        border: none;
    }

    .iw-upload-wrapper img:hover{
        border-color: #3a90dc;
    }

    .iw-upload-wrapper img.iw-selected-img{
        border-color:#3a90dc;
    }

    /* .lg-backdrop.in {
        z-index: 1060;
    } */





.iw-modal-rightsidebar {
    position: sticky;
    /* width: 100%;
    height: 100%;
    left: 0; */
    top: 0;
    /* padding-right: 15px; */
}

.modal_sidebar-content h3 {
    font-size: 16px;
}

.modal_sidebar-content p {
    font-size: 14px;
    color: #777;
}

.modal_sidebar-content p.image-name {
    color: #000;
}

.modal_sidebar-content a.del-image {
    color: crimson;
}

.modal_sidebar-content a {
    display: block;
}

.modal_sidebar-content a.edit-image,.modal_sidebar-content a.copy-link,a.copy-link{
    color: #2196F3;
    cursor: pointer;
}

.filter-area .fliter-select ul {
    margin: 0;
    text-align: center;
    padding: 5px;
}

.filter-area .fliter-select ul li {
    display: block;
}

.filter-area .fliter-select ul li a {
    color: #000;
    padding: 5px 20px;
    font-size: 14px;
    text-transform: uppercase;
    display: block;
}

.filter-area ul li.active {
    background: #2196F3;
}

.filter-area ul li.active a {
    color: #fff;
}

.fliter-select {
    position: absolute;
    right: 0;
    background: #fff;
    width: 10rem;
    box-shadow: 0 0 6px #ccc;
    top: 100%;
    /* display: none; */
}

.filter-btn {
    display: inline-block;
    font-size: 16px;
    position: relative;
    padding: 0 20px;
    cursor: pointer;
}

.filter-area {
    text-align: right;
    border-bottom: 1px solid #ccc;
    margin-bottom: 10px;
}

.filter-btn:before {content: "";position: absolute;width: 0;height: 0;border: 5px solid transparent;border-top-color: #2d2d2d;right: 0;top: 50%;transform: translateY(-50%);}

.iw-multiple-select {
    position: relative;
    display: inline-block;
}

.iw-upload-wrapper {
    width: 160px;
    border: 10px solid #fff;
    margin: 7px;
    border-radius: 10px;
    min-height: 160px;
    position: relative;
}


.iw-upload-wrapper h6 {
  background: #fff;
    padding: 10px 4px 1px 4px;
    margin: 0;
    text-transform: capitalize;
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
}

.iw-modal-body-background {
   background: #0000000d;
   height:auto;
   padding:20px
}

.iw-upload-wrapper img {
   width: 100%;
}
.iw-filter-btn {
    color: #000;
    display: inline-block;
    padding: 0 0 0 10px;
    border:none;
    background:none
}
/* .iw-modal-body-background .custom-filepond {
    border: 2px dashed #777;
    border-radius:8px
} */

.iw-modal-body-background .custom-filepond .filepond--root.filepond--hopper {
    height: 150px!important;
    margin: 8px;
}
.iw-modal-body-background .filepond--root .filepond--drop-label {
    height: 90%;
}

.filepond--drop-label.filepond--drop-label label span.filepond--label-action:focus {
    outline: 0;
}
.iw-file-pond-wrapper {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.iw-filter-select label.iw-filter-container {
    display: block;
    position: relative;
    padding-left: 30px;
}

.iw-filter-select label.iw-filter-container input {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    opacity: 0;
}

.iw-filter-select label.iw-filter-container span.iw-checkmark {
    position: absolute;
    width: 20px;
    height: 20px;
    background: #e8e8e8;
    left: 5px;
    top: 0;
}

.iw-filter-select label.iw-filter-container input:checked ~ span.iw-checkmark {
    background: #3490dc;
}
.iw-filter-select label.iw-filter-container input:checked ~ span.iw-checkmark:after {content: "";position: absolute;left: 7px;top: 3px;width: 7px;height: 12px;border: solid white;border-width: 0 3px 3px 0;-webkit-transform: rotate(45deg);-ms-transform: rotate(45deg);transform: rotate(45deg);}
.iw-filter-select label.iw-filter-container input[type=radio]:checked ~ span.iw-checkmark:after { content: ""; position: absolute; left: 5px; top: 5px; width: 10px; height: 10px; background: white; transform: none; }
.iw-upload-wrapper.iw-video-clip:before {
    content: "\F567";
    font: normal normal normal 24px/1 "Material Design Icons";
    position: absolute;
    left: 50%;
    top: 40%;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: black;
    text-align: center;
    line-height: 40px;
    z-index: 1;
    -webkit-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    color: #fff;
}
.iw-filter-select span.iw-filter-label {
    font-weight: 600;
}
.iw-upload-wrapper.iw-video-clip img {
    display: none;
}
.iw-upload-wrapper a.copy-link {
    display: block;
    background: #000;
    text-align: center;
    position: absolute;
    width: 100%;
    bottom: 28px;
    color: #fff;
}
.iw-image-sidebar-preview img {
    max-width: 165px;
    padding: 0px;
}


/* .iw-upload-wrapper {
    width: 160px;
    border: 10px solid #fff;
    margin: 5px;
    margin:10px;
    border-radius: 10px;
    min-height: 160px;
    position: relative;
    overflow: hidden;
 } */
 .iw-upload-wrapper.iw-selected-parent {
    /* border: 5px solid #2196F3; */
    box-shadow: 0 0 5px 4px rgba(0, 140, 186, 0.5);
    position: relative;
 }

 .iw-upload-wrapper.iw-selected-parent:before {content: "";position: absolute;background: rgba(0, 0, 0, 0.5);width: 100%;height: 100%;}

 .iw-upload-wrapper.iw-selected-parent:after {
    content: "";
    position: absolute;
    left: 50%;
    top: 28%;
    width: 11px;
    height: 25px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
 }
</style>
