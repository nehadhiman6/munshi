<template>
    <document-without-letter-head
    :file-name="'client_affidavit_execution'+file_opening.file_no"
        caption="Client affidavit execution"
        :content="content">
    </document-without-letter-head>

</template>

<script>
import {
  AlignmentType,
  Document,
  ImageRun,
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
import DocumentWithoutLetterHead from '../DocumentWithoutLetterHead.vue'
export default {
       props:[
        'client_name',
        'client_sub_title',
        'client_address',
        'file_opening_id',
        'file_opening'
    ],
    components: {
        DocumentWithoutLetterHead,
    },
    data:function(){
        return {
            content:''
        }
    },
    mounted:function(){
        this.getContent();
    },
    methods:{
        getContent:function(){
            var self = this;
            var section = [];
             var client_address_array = [];
            var client_add = this.client_address.split('/');


            client_add.forEach(element => {
                client_address_array.push(
                    new TextRun({
                        text:element,
                        break:1,
                        color:'gray'
                    }),
                )
            });

            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            var def_solicitor = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'';


            section.push({

                children: [
                    new Paragraph({
                        heading:HeadingLevel.HEADING_3,
                        alignment:AlignmentType.CENTER,
                        children: [
                                new TextRun({
                                    text: 'THE LAND TITLES ACT, ',
                                    bold:true,
                                    italics:true,
                                    underline:true,
                                    color:"Black"
                                }),
                                new TextRun({
                                    text: 'Section 137 ',
                                    bold:true,
                                    underline:true,
                                    color:"Black"
                                }),
                                new TextRun({
                                    text: 'AFFIDAVIT AS TO WRITS OF EXECUTION ',
                                    bold:true,
                                    underline:true,
                                    break:1,
                                    color:"Black"
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),


                    // new Paragraph({
                    //     children: [
                    //         new TextRun({
                    //                 text: "TO:",
                    //                 bold:true,
                    //                 break:2
                    //             }),

                    //             new TextRun({
                    //                 text: '\t\t'+ seller1+ " and "+ seller2,
                    //             }),
                    //             new TextRun({
                    //                 text: '\t\t Barrister & Solicitor (the "Firm")',
                    //                 break:1
                    //             }),
                    //             new TextRun({
                    //                 text: "RE:",
                    //                 bold:true,
                    //                 break:2
                    //             }),

                    //             new TextRun({
                    //                 text: "\t\t "+seller1+"and "+seller2+" (the 'Vendor') s/t "+to,
                    //             }),
                    //             new TextRun({
                    //                  text: "\t\t "+re +" ",
                    //                 break:1
                    //             }),
                    //             new TextRun({
                    //                 text: '\t\t Closing Date:  '+closing_date,
                    //                 break:1
                    //             }),
                    //             new TextRun({
                    //                 text: '\t\t My File No.: '+self.file_opening.file_no,
                    //                 break:1
                    //             }),

                    //         ],
                    //         spacing: {
                    //             after: 200,
                    //             before:200
                    //         },
                    // }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "IN THE MATTER OF:",
                                    bold:true,
                                    break:2
                                }),
                                new TextRun({
                                    text: "IN THE REGISTER FOR:",
                                    bold:true,
                                    break:1
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
                                    text: 'AND IN THE MATTER OF: ',
                                    bold:true,
                                    break:1
                                }),
                                new TextRun({
                                    text: 'certain Writs of Execution in the hands of the Sheriff of the Regional Municipality of Peel, copies of which have been filed in the Peel Land Registry (NO. 43) as Number(s): 19-0000000',
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
                                text: 'I, abc Sira Singh, make oath and say as follows:',
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
                                text: "I am a registered owner of the lands entered as ,",
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
                                text: 'I am not the same person as Satnam Singh Gothra, the judgment debtor named in Writ of Execution Number 19-0000000 wherein Royal Bank of Canada, as Plaintiff, was awarded the sum of $30601.05 plus costs of $nil.',
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
                                text: 'The abc Sira Singh shall indemnify and save harmless '+def_solicitor+', Barrister and Solicitor from and against any, all actions, proceedings claims, demands, obligations or liabilities against the abc Sira SIngh if he/she is found one and the same person, and hit covenant shall survive the closing of this transaction.',
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
                                text: "Sworn before me at the \t\t\t }",
                                break:2
                            }),
                            new TextRun({
                                text: "City of Brampton \t\t\t }",
                                break:1
                            }),
                            new TextRun({
                                text: "in the Regional Municipality \t\t }",
                                break:1
                            }),
                            new TextRun({
                                text: "of Peel \t\t\t\t\t } 	_____________________________",
                                break:1
                            }),
                            new TextRun({
                                text: "this          day of "+moment().format('MMMM, YYYY')+".\t\t } " + "  \t"+seller1,
                                break:1
                            }),
                            new TextRun({
                                text: "\t\t\t\t\t }",
                                break:1
                            }),


                            new TextRun({
                                text: "A COMMISSIONER, ETC.",
                                break:3
                            }),
                        ],
                    }),

                    // new Paragraph({
                    //     alignment:AlignmentType.RIGHT,
                    //     children: [

                    //         new TextRun({
                    //             text: "_______________________ ",
                    //             break:3

                    //         }),

                    //         new TextRun({
                    //             text: seller1+"\t\t",
                    //             break:1
                    //         }),

                    //         new TextRun({
                    //             text: "_______________________ ",
                    //             break:3

                    //         }),

                    //         new TextRun({
                    //             text: seller2+"\t\t",
                    //             break:1
                    //         }),
                    //     ],

                    // }),


                ],
            });
            console.log(section);
            self.content = section;
        }
    }

}
</script>

<style>

</style>
