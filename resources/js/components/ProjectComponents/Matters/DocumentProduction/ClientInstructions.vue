<template>
    <tr>
        <td>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1"></label>
        </div>
        </td>
        <td>Instructions For Client</td>
        <td></td>
        <td>
            <document-generator
                :key="1"
                caption="instructions_for_client.docx"
                :fileName="'instructions_for_client_'+file_opening.file_no"
                :creator="author"
                :content="client_instruction_content">
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
            client_instruction_content:null,
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

              var seller1= '';
            if(self.file_opening.sellers.length > 0){
                seller1 += self.file_opening.sellers[0].first_name ? self.file_opening.sellers[0].first_name + ' ' :'';
                seller1 += self.file_opening.sellers[0].middle_name ? self.file_opening.sellers[0].middle_name +' ' :'';
                seller1 += self.file_opening.sellers[0].last_name ? self.file_opening.sellers[0].last_name+' ' :'' ;
                if(seller1 == ''){
                    seller1 = 'Seller 1';
                }
            }
            var seller2= '';
            if(self.file_opening.sellers.length > 1){
                seller2 += self.file_opening.sellers[1].first_name ? self.file_opening.sellers[1].first_name + ' ' :'';
                seller2 += self.file_opening.sellers[1].middle_name ? self.file_opening.sellers[1].middle_name +' ' :'';
                seller2 += self.file_opening.sellers[1].last_name ? self.file_opening.sellers[1].last_name+' ' :'' ;
                if(seller2 == ''){
                    seller2 = 'Seller 2';
                }
            }


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
                                    text: seller1 +" and "+seller2,
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
                                        text: " Discuss an appropriate time to meet with your lawyer virtually. Make sure to provide your email and phone number.",

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
                                        text: "Appropriate Video Conference Program: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: "Ensure you have the required video conferencing capability (e.g., Zoom/Teams). ",

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
                                        text: "\t\t(it is recommended that you use a desktop or laptop computer, but tablets and smartphones " + "\t\tcan also be used.)",
                                    }),

                                ],
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "\t\tPlease familiarize yourself with the agreed App and test it on your device. ",
                                        italics:true,
                                    }),

                                ],
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Test Meeting: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " test your equipment well in advance to be sure your device functions properly. Check your audio and video prior to the meeting. Guarantee the lawyer will have a clear view of you and your surroundings, also that the lawyer is able to hear you and vice versa.",

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
                                        text: "\t\tIf possible, please use headphones with a microphone to ensure good audio quality.",
                                        italics:true,
                                    }),

                                ],
                                spacing: {
                                    after:200
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Scanning and Transmission: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " You should have access to a reliable document scanning capability in order to upload documents (via mobile phone apps such as Adobe Scanner/ Cam Scanner) and transmit them to the lawyer.",

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
                                        text: "\t\tMake sure to delete the documents once lawyer confirm receipt of the documents through " + "\t\temail.",
                                        italics:true

                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "Prepare for the meeting: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: "Make sure you have the required documents and your IDs ready. The documents will either be delivered to you or emailed. If emailed to you, make sure you have a hard copy in front of you. Also verify the documents and make sure you have exactly what you need. ",

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
                                        text: "Start of meeting: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: 'Once you receive the link from your lawyer, log onto the meeting. Ensure there is no one else in the room.',

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
                                        text: "\t\tRemember that you are not allowed to  make any recording of the meeting and shall not take " + "\t\tphotos or screen shots.",
                                        italics:true

                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                        }),

                    ],
            });
            self.client_instruction_content = section1;
        },
    }
};
</script>
