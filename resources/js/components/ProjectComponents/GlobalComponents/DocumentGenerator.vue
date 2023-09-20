<template>
    <div class="btn btn-link text-primary float-right" @click.prevent="getDoc">
        <i class="far fa-file-word"></i>
        <span v-text="caption"></span>
    </div>
</template>

<script>
import {
  AlignmentType,
  Document,
  HeadingLevel,
  Packer,
  Paragraph,
  TabStopPosition,
  TabStopType,
  TextRun
} from "docx";
export default {
    props:{
        creator:{
            default:'',
        },

        description:{
            default:'example',
        },

        title:{
            default: "My Document",
        },

        background:{
            default:function(){
                return {
                    color: "FFFFFF"
                }
            },
        },
        caption:{
             default: "Genereate.docx",
        },

        content:{
            default:function(){
                return [{
                        properties: {
                            type: docx.SectionType.CONTINUOUS,
                        },
                        children: [
                            new Paragraph({
                                children: [new TextRun("Lorem Ipsum Foo Bar"), new TextRun("Hello World")],
                            }),
                        ],
                    }];

            }
        },

        fileName:{
            default:'example',
        },

    },
    methods:{
        getDoc:function(){
            var self= this;
                // Add paragraph in the document
           var doc = new docx.Document({
                creator: self.creator,
                description: self.description,
                title:self.title,
                background: self.background,
                sections:self.content,
                numbering: {
                    config: [
                        {
                        reference: "my-custom-numbering",
                        levels: [
                            {
                                level: 0,
                                format: "upperRoman",
                                text: "%1",
                                alignment: AlignmentType.START,
                                style: {
                                    paragraph: {
                                    indent: { left: 720, hanging: 260 }
                                    }
                                }
                            },
                            {
                                level: 1,
                                format: "decimal",
                                text: "%2.",
                                alignment: AlignmentType.START,
                                style: {
                                    paragraph: {
                                    indent: { left: 1440, hanging: 980 }
                                    }
                                }
                            },
                            {
                                level: 2,
                                format: "lowerLetter",
                                text: "%3)",
                                alignment: AlignmentType.START,
                                style: {
                                    paragraph: {
                                    indent: { left: 2160, hanging: 1700 }
                                    }
                                }
                            },
                            {
                                level: 3,
                                format: "upperLetter",
                                text: "%4)",
                                alignment: AlignmentType.START,
                                style: {
                                    paragraph: {
                                    indent: { left: 2880, hanging: 2420 }
                                    }
                                }
                            }
                        ]
                        }
                    ]
                }
            });

            Packer.toBlob(doc).then((blob) => {
                // saveAs from FileSaver will download the file
                FileSaver.saveAs(blob, self.fileName+".docx");
            });




        }
    }
}
</script>

<style>

</style>
