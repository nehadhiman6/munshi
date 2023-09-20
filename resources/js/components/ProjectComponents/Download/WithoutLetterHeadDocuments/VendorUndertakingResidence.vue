<template>
    <document-without-letter-head
    :file-name="'vendor_undertaking_residence'+file_opening.file_no"
        caption="Vendor Undertaking Residence"
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

            section.push({

                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: 'This Document is in the Form approved by the WORKING GROUP ON LAWYERS AND REAL ESTATE (http://www.lawyersworkinggroup.com/) on ',
                                }),
                                new TextRun({
                                    text: closing_date+',',
                                    bold:true
                                }),
                                new TextRun({
                                    text: ' except for clearly shown changes.  Any changes not clearly shown are of no effect.',
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        heading: HeadingLevel.HEADING_2,
                        alignment: AlignmentType.CENTER,
                        children: [
                                new TextRun({
                                    text: "UNDERTAKING (NON-RESIDENCY)",
                                    bold:true,
                                    underline:true,
                                    color:'black',
                                    break:1
                                }),

                            ],
                            spacing: {
                                after: 200,
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
                                    text: "VENDOR:",
                                    break:2
                                }),
                                new TextRun({
                                    text: seller1,
                                    bold: true,
                                }),
                                new TextRun({
                                    text: "VENDOR’S LAWYER:",
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'',
                                    bold:true
                                }),
                                new TextRun({
                                    text: "PURCHASER:",
                                    break:1
                                }),
                                new TextRun({
                                    text: purchaser1,
                                    bold:true
                                }),

                                new TextRun({
                                    text: "PURCHASER’S LAYWER:",
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:'',
                                    bold:true
                                }),

                                new TextRun({
                                    text: "PROPERTY:",
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.property ? self.file_opening.property.addr_line1+' '+self.file_opening.property.addr_line2 : '',
                                    bold:true
                                }),

                                new TextRun({
                                    text: "COMPLETION DATE:",
                                    break:1
                                }),
                                new TextRun({
                                    text: closing_date,
                                    bold:true
                                }),

                            ],
                            border: {
                                bottom: {
                                    color: "auto",
                                    space: 5,
                                    value: "single",
                                    size: 7,
                                },
                            },
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: 'In consideration of the closing of the above-noted transaction, I/we undertake:',
                                    break:2
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
                                text: 'to retain the sum of $ ____________________ , representing 25% [or 50% for property referred to in subsection 116(5.2)] of the purchase price for the subject property, ',
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
                                text: "to remit such amount to Canada Revenue Agency (“CRA”) on the 30th day following the last day of the month of the Completion Date unless extended by agreement with CRA, and to remit such amount to CRA within any such extended time allowed by CRA, in order to obtain the prescribed Certificate under Section 116 of the",
                            }),
                            new TextRun({
                                text:' Income Tax Act,',
                                italics:true
                            })

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
                                text: 'to forward copy of proof of payment to CRA or any receipt by CRA to the Vendor’s Lawyer shortly after payment is made, and',
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
                                text: 'to forward the prescribed Section 116 Certificate to the Vendor’s Lawyer upon receipt.',
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
                                text: "DATED at, this          day of "+moment().format('MMMM, YYYY')+".",
                            }),
                        ],
                    }),

                    new Paragraph({
                        alignment:AlignmentType.CENTER,
                        children: [

                            new TextRun({
                                text: "LAW FIRM:"+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.law_firm ? self.file_opening.purchaser_solicitor.law_firm.firm_name:''),
                                break:1
                            }),
                        ],
                    }),
                    new Paragraph({
                        alignment:AlignmentType.RIGHT,
                        children: [

                            new TextRun({
                                text: "Per: ________________________________ ",
                                break:1
                            }),

                            new TextRun({
                                text: "Purchaser’s Lawyer’s Name:"+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:''),
                                break:1
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "Note: for full particulars please refer to Revenue Canada Income Tax Information Circular IC72-17R6 ",
                                break:2
                            }),
                        ],
                    }),



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
