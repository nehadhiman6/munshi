<template>
    <div class="btn btn-link text-primary p-0" @click.prevent="getImageContent">
        <!-- <i class="far fa-file-word"></i> -->
        <span v-text="caption"></span>
    </div>
</template>

<script>
import {
    BorderStyle,
    AlignmentType,
    Document,
    HeadingLevel,
    Packer,
    Paragraph,
    TabStopPosition,
    TabStopType,
    Table,
    TextRun,
    ImageRun,
    TableRow,
    TableCell,
    WidthType,
    ShadingType,
    Header

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

    data:function(){
        return {
            image_exists:true
        }
    },

    methods:{
        imageExists:function(url, callback) {
            var img = new Image();
            img.onload = function() { callback(true); };
            img.onerror = function() { callback(false); };
            img.src = url;
        },


        getImageContent:function(){
            var self = this;
            const getBase64FromUrl = async (url) => {
            const data = await fetch(url);
            const blob = await data.blob();
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = () => {

                const base64data = reader.result;
                 resolve(base64data);
                }
            });
            }

            var image_url = Munshi.base_url+'/assets/img/fax-img.png';

            this.imageExists(image_url, function(exists) {
                console.log('RESULT: url=' + image_url + ', exists=' + exists);
                self.image_exists = exists;
                getBase64FromUrl(image_url).then(function(url){
                    self.getDoc(url.replace(/^data:image\/(png|jpg);base64,/, ""));
                });
            });



        },
        getDoc:function(image_url){
            var self= this;
            var child =
            self.image_exists ?
            [
                new TableCell({
                    // width: {
                    //     size: 100,
                    //     type: WidthType.PERCENTAGE
                    // },
                    borders: {
                        top: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        bottom: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        left: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        right: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        },
                    children: [
                        new Paragraph({
                            alignment: AlignmentType.LEFT,
                            children: [
                                new ImageRun({
                                data: Buffer.from(image_url, "base64"),
                                transformation: {
                                    width: 100,
                                    height: 100,
                                },
                            }),
                            ]
                        }),

                    ],
                }),

                new TableCell({
                    // width: {
                    //     size: 100,
                    //     type: WidthType.PERCENTAGE
                    // },
                    borders: {
                        top: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        bottom: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        left: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        right: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        },
                    children: [
                       new Paragraph({
                        children: [
                             new TextRun({
                                    text: "From:",
                                    break:1
                            }),
                            new TextRun({
                                    text: " \tAddress:",
                                    break:1
                            }),
                            new TextRun({
                                    text: " \tCity:",
                                    break:1
                            }),

                            new TextRun({
                                    text: " \tPhone:",
                                    break:1
                            }),
                            new TextRun({
                                    text: " \tE-mail:",
                                    break:1
                            }),

                            new TextRun({
                                    text: " \tDate:",
                                    break:3
                            }),
                            new TextRun({
                                    text: " To:",
                                    break:3
                            }),
                            new TextRun({
                                    text: " \tAddress:",
                                    break:1
                            }),
                            new TextRun({
                                    text: " \tCity:",
                                    break:1
                            }),
                            new TextRun({
                                    text: " \tProvince:",
                                    break:1
                            }),

                            new TextRun({
                                    text: " \tPhone:",
                                    break:1
                            }),
                            new TextRun({
                                    text: " \tFax:",
                                    break:1
                            }),


                            ],
                            spacing: {
                                after: 200,
                            },
                    })

                    ],
                }),
                new TableCell({
                    // width: {
                    //     size: 100,
                    //     type: WidthType.PERCENTAGE
                    // },
                    borders: {
                        top: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        bottom: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        left: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        right: {style: BorderStyle.NONE, size: 0, color: "FFFFFF"},
                        },
                    children: [
                       new Paragraph({
                              alignment: AlignmentType.RIGHT,
                        children: [
                            new TextRun({
                                    text: "",
                                    break:1
                            }),
                            new TextRun({
                                    text: "Province:",
                                    break:1
                            }),

                            new TextRun({
                                    text: "Postal code:",
                                    break:1
                            }),
                            new TextRun({
                                    text: "Fax:",
                                    break:1
                            }),
                            new TextRun({
                                    text: "Postal Code:",
                                    break:10
                            }),


                            ],
                            spacing: {
                                after: 200,
                            },
                    })

                    ],
                }),


            ]
            :
             [

            ];
            const table = new Table({
                width: {
                    size: 100,
                    type: WidthType.PERCENTAGE
                },
                rows:[
                    new TableRow({
                        children:child
                    })

                    // ****
                ],

            });
            var header = {
                children: [
                    table,
                ],
            };
            if(self.content.length > 0){
                self.content[0].children.unshift(table);
            }
            else{
                self.content.unshift(header);
            }
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
                },

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
