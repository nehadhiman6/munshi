<template>
    <tr>
        <td>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1"></label>
        </div>
        </td>
        <td>Instructions for Lawyer</td>
        <td></td>
        <td>
            <document-generator
                :key="1"
                caption="instructions_for_lawyer.docx"
                :fileName="'instructions_for_lawyer_'+file_opening.file_no"
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
                            alignment: AlignmentType.LEFT,
                            allCaps: true,
                            children: [
                                new TextRun(
                                {
                                    text: "Instructions for: ",
                                    color:'000000',
                                    allCaps: true,
                                }),
                                new TextRun(
                                {
                                    text: "Lawyer",
                                    allCaps: true,
                                    bold:true,
                                    color:'000000'
                                }),
                            ],
                        }),


                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Schedule a meeting: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " Discuss an appropriate time to meet with your client.  We recommend at least 48 hours prior to the closing.",

                                    }),

                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Delivery of documents to Client: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: "When discussing a time to meet, also discuss how the documents should be sent to the client.",

                                    }),

                                ],
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "\t\tWhether it is by courier or email",
                                    }),

                                ],
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "\t\t a) if by email, verify the client has access to a printer",
                                    }),

                                ],
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "\t\t b) Verify if the client has access to scanner (Adobe Scan/Cam Scanner Apps) ",
                                    }),

                                ],
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Appropriate Video Conference Program: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " Ensure you have the agreed upon video conferencing capability. (e.g., Zoom/Teams)",

                                    }),
                                ],
                                spacing: {
                                    before:200
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "\t\tOne that can also be used on a cell phone, to ensure a video camera. ",
                                    }),

                                ],
                                spacing: {
                                    after:200
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Preparation of documents: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " Prepare required documents.",

                                    }),
                                ],
                                spacing: {
                                    before:200
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "\t\tWe also recommend preparing a list for the client, which states the documents they need to "+ "\t\thave during the meeting. This allows the client to confirm they have the required documents. ",

                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Setting up for the meeting: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: "Set up the meeting and send the link to your client. Ensure you have scanned copies of identification, if required. Make sure you can also access the documents. ",

                                    }),

                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Have the following in front of you at the meeting: ",
                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [

                                    new TextRun({
                                        text: "\t\ti) Video Conferencing Checklist ",

                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                        }),
                        new Paragraph({
                            children: [

                                    new TextRun({
                                        text: "\t\tii) Client IDs ",

                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                        }),

                    ],
            });
            self.undertaking_content = section1;
        },
    }
};
</script>
