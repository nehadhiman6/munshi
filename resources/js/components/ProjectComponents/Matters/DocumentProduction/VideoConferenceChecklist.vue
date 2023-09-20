<template>
    <tr>
        <td>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1"></label>
        </div>
        </td>
        <td>Video Conference Checklist</td>
        <td></td>
        <td>
            <document-generator
                :key="1"
                caption="video_conference_checklist.docx"
                :fileName="'video_conference_checklist_'+file_opening.file_no"
                :creator="author"
                :content="undertaking_content">
            </document-generator>
        </td>
    </tr>
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
  TextRun,
  Table,
  TableRow,
  TableCell,
  PageBreak,
  PageNumber,
  NumberFormat
} from "docx";
import DocumentGenerator from '../../GlobalComponents/DocumentGenerator.vue';
export default {
    components: { DocumentGenerator },
    props: ['file_opening', 'author'],
    data() {
        return {
            undertaking_content:null,
        }
    },
    mounted() {
        this.setContentData();
    },
    methods: {

        setContentData:function(){
            var self = this;
            var content = [];
            var section1 = [];




            section1.push({

                    children: [
                        new Paragraph({
                            heading: HeadingLevel.HEADING_2,
                            alignment: AlignmentType.CENTER,
                            allCaps: true,
                            children: [
                                new TextRun(
                                {
                                    text: "Video Conference Checklist",
                                    allCaps: true,
                                    bold:true,
                                    color:'000000'
                                }),
                            ],
                            spacing: {
                                after: 500,
                            }
                        }),


                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Date and Time: ",
                                    }),
                                    new TextRun({
                                        text: "\t\t\t______________________________________________",

                                    }),

                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                }
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Medium for Meeting: ",
                                    }),
                                    new TextRun({
                                        text: "\t\t______________________________________________",

                                    }),

                                ],

                                spacing: {
                                    after: 200,
                                    before:200
                                }
                        }),

                        new Paragraph({
                            children: [
                                new TextRun({
                                        text: "File Number:",
                                    }),
                                    new TextRun({
                                        text: "\t\t\t "+self.file_opening.file_no,
                                    }),

                                ],

                                spacing: {
                                    after: 200,
                                    before:200
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Names of the client attending Meeting: ",
                                    }),
                                    new TextRun({
                                        text: " _____________________________________________________________",
                                        break:2

                                    }),

                                ],

                                spacing: {
                                    after: 200,
                                    before:200
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Before Meeting:",
                                        underline:'SINGLE'
                                    }),

                                ],
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Send documents to client as instructed ",
                                    }),
                                ],
                                spacing: {
                                    before:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Send client meeting link or code and password ",
                                    }),
                                ],
                                spacing: {
                                    before:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Test sound and video quality ",
                                    }),
                                ],
                                spacing: {
                                    before:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Have the client scan the room to ensure no one else is present. ",
                                    }),
                                ],
                                spacing: {
                                    before:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: " If any other parties are present, identify and ask reason for presence:",
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: " ________________________________________________________________________",
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                }
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: " __",
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                }
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: " ________________________________________________________________________",
                                        break:1
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                }
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: " __",
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                }
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: " Ask Client:",

                                    }),
                                    new TextRun({
                                        text: " To not mute their audio or turn their camera off at any time during the meeting",
                                        break:2
                                    }),
                                    new TextRun({
                                        text: " To hold an ID to the camera that was previously provided and confirm identity",
                                        break:2
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Documents",
                                        underline:'SINGLE'
                                    }),

                                ],
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Confirm the client has received and printed the following documents: [INCLUDE LIST OF DOCUMENTS SENT TO CLIENTS]",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Review and explain each document ",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Confirm client’s understanding of the documents and provide sufficient opportunity for client to ask questions ",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Have client angle camera, if required, when signing so signing of documents can be witnessed",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Have client hold documents to camera after signing to ensure signed correctly.",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "After all clients have signed any affidavits ask them (and obtain an affirmative response from all signatories):",
                                    }),
                                    new TextRun({
                                        text: " If sworn: “Do you swear that the contents of this affidavit as subscribed by you are true, so help you God?” or",
                                        break:2,
                                    }),
                                    new TextRun({
                                        text: " If affirmed: “Do you solemnly affirm and declare that the contents of this affidavit as subscribed by you are true?”",
                                        break:2
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "After all clients have signed any statutory declaration ask them (and obtain an affirmative response from all signatories):",
                                    }),
                                    new TextRun({
                                        text: "“Do you make this solemn declaration conscientiously believing it to be true, and knowing that it is of the same force and effect as if made under oath?” ",
                                        break:2
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Provide the client with a unique phrase or code to write in a particular place on each document.",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Unique phrase / code given to clients: ____________________",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "End of Meeting",
                                        underline:'SINGLE'
                                    }),

                                ],
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Confirm how the client will be returning documents",
                                    }),
                                    new TextRun({
                                        text: "Scan and email",
                                        break:2
                                    }),
                                    new TextRun({
                                        text: "Courier",
                                        break:2
                                    }),
                                    new TextRun({
                                        text: "Mail",
                                        break:2
                                    }),
                                    new TextRun({
                                        text: "Other:________________________",
                                        break:2
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Remind client to remove electronic copies of emailed",
                                    })
                                ],
                                spacing: {
                                    before:200,
                                    after:200
                                },
                                bullet: {
                                    level: 0
                                },
                        }),
                    ],
            });
            self.undertaking_content = section1;
        },
    }
};
</script>
