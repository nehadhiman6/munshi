<template>
    <div>
        <!-- <file-upload-component v-if="showFile"
            :allow-multiple="false"
            @addAttachment="addAttachment">
        </file-upload-component> -->
        <vue-editor :key="random" :id="'quill-container_'+random" :value="value"  ref="editor" useCustomImageHandler @image-added="handleImageAdded"
         @focus="toggleFocus($event)"  @editor-change="recordCursorLocation"  :editorOptions="editorSettings" @input="onEditorInput"  :disabled ="disabled" :editor-toolbar="customToolbar"></vue-editor>
    </div>
</template>

<script>

import { VueEditor } from "vue2-editor";

import ImageResize from "quill-image-resize-module";
Quill.register("modules/imageResize", ImageResize);

import { htmlEditButton } from "quill-html-edit-button";
Quill.register("modules/htmlEditButton", htmlEditButton);

var Bold = Quill.import('formats/bold');
Bold.tagName = 'B';   // Quill uses <strong> by default
Quill.register(Bold, true);

var Italic = Quill.import('formats/italic');
Italic.tagName = 'I';   // Quill uses <em> by default
Quill.register(Italic, true);

// var Syntax = Quill.import('attributors/style/syntax');
// Quill.register(Syntax, true);

var AlignStyle = Quill.import('attributors/style/align');
Quill.register(AlignStyle, true);

let ColorStyle = Quill.import('attributors/style/color');
Quill.register(ColorStyle, true);

var Direction = Quill.import('attributors/style/direction');
Quill.register(Direction, true);

var FontStyle = Quill.import('attributors/style/font');
Quill.register(FontStyle, true);

var Size = Quill.import("attributors/style/size");
Size.whitelist = ["8px","10px","12px","14px","16px","18px","20px","22px","24px","26px","28px","30px","32px","34px"];
Quill.register(Size, true);



function withoutMediaButtons(){
    return [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block','code'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' },{ 'list': "check" }],
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'align': [] }],
    ];
}
function withMediaButtons(){
    return[
        [{'size': [false,"8px","10px","12px","14px","16px","18px","20px","22px","24px","26px","28px","30px","32px","34px"]}],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block','code'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' },{ 'list': "check" }],
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        ["image","video","link"],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],
        [{ 'font': [] }],
        [{ 'align': [] }],

        // [{ 'size': [] }],  // custom dropdown
        // ['clean']                                         // remove formatting button
    ];
}
export default {
    props:{
        imageButton:{
            type:Boolean,
            default:true
        },
        value: {
            type:[String,Text],
            default:''
        },
        disabled:{
            type:[Boolean],
            default:false
        }
    },
    data:function () {
        return {
            // showFile:false,
            files:[],
            editorSettings: {
                modules: {
                    imageResize: {},
                    htmlEditButton:{
                        debug: true, // logging, default:false
                        msg: "Edit the content in HTML format", //Custom message to display in the editor, default: Edit HTML here, when you click "OK" the quill editor's contents will be replaced
                        okText: "OK", // Text to display in the OK button, default: Ok,
                        cancelText: "Cancel" // Text to display in the cancel button, default: Cancel
                    }
                }
            },
            random:Utilities.getRandomNumber(),
            customToolbar :[],
            quill:null,
            currentCursorLoc: null
        }

    },
    created:function() {
        // console.log("created");
        this.customToolbar = this.imageButton == true ? withMediaButtons() : withoutMediaButtons();
    },
    components:{
        VueEditor
    },
    methods:{
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
        // An example of using FormData
        // NOTE: Your key could be different such as:
        // formData.append('file', file)
            var formData = new FormData();
            formData.append("filepond", file);
                axios({
                url: Munshi.base_url+'/attachments',
                method: "POST",
                data: formData
            })
            .then(result => {
                if(result.data.attachment){
                    let url = Munshi.base_url+'/attachments/'+result.data.attachment.id;
                    // let url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                }
                else{
                    alert("This image can not be uploaded");
                }
            })
            .catch(err => {
                alert("This image can not be uploaded");
            });
        },

        onEditorInput:function(text){
            this.$emit('input',text);
        },
        toggleFocus:function(event, id, focused = true){
            this.quill = focused ? event : {};
        },
        recordCursorLocation() {
            console.log('selection: ', this.quill.getSelection());
            var loc = this.quill.getSelection();
            if(loc) {
                this.currentCursorLoc = this.quill.getSelection();
            }
        }

    }
}
</script>

<style>
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="8px"]::before  {content: '8'; font-size: 8px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="10px"]::before  {content: '10'; font-size: 10px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="14px"]::before  {content: '14'; font-size: 14px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="12px"]::before  {content: '12'; font-size: 12px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="16px"]::before  {content: '16'; font-size: 16px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="18px"]::before  {content: '18'; font-size: 18px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="20px"]::before  {content: '20'; font-size: 20px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="22px"]::before  {content: '22'; font-size: 22px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="24px"]::before  {content: '24'; font-size: 24px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="26px"]::before  {content: '26'; font-size: 26px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="28px"]::before  {content: '28'; font-size: 28px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="30px"]::before  {content: '30'; font-size: 30px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="32px"]::before  {content: '32'; font-size: 32px !important;}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="34px"]::before  {content: '34'; font-size: 34px !important;}
</style>
