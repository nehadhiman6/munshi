<template>
    <document-without-letter-head
    :file-name="'undertaking_and_warranty'+file_opening.file_no"
        caption="Undertaking and warranty"
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
            var sellers_arr = [];
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element,index) => {
                    sellers_arr.push(
                        new TextRun({
                            text: "____________________________________________________________________________________ ",
                            break:2
                        }),
                        new TextRun({
                            text: "Witness's Signature" +"\t\t\t\t["+element.name+']',
                            break:1
                        }),
                        new TextRun({
                            text: "________________________________ ",
                            break:1
                        }),
                        new TextRun({
                            text: "Witness's Printed Name",
                            break:1
                        }),
                        new TextRun({
                            text: "____________________________________________________________________________________ ",
                            break:2
                        })
                    );
                })
            }

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
                                    text: 'except for clearly shown changes.  Any changes not clearly shown are of no effect.',
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
                                    text: "VENDOR'S CLOSING CERTIFICATE",
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
                                    text: 'IN CONSIDERATION OF AND NOTWITHSTANDING THE CLOSING OF THIS TRANSACTION, THE VENDOR CERTIFIES TO THE PURCHASER THAT AS OF THE COMPLETION DATE:',
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
                                text: 'POSSESSION: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'Subject to the Agreement of Purchase and Sale ("Agreement") in this transaction, the Vendor shall deliver vacant possession of the Property and possession of any chattels included in the Agreement.',
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
                                text: 'KEYS: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: "If and as applicable, all keys, entry mechanisms, and access and alarm codes for the Property in the Vendor's control not included with the Requisite Deliveries shall be left on the Property.",
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
                                text: 'BILL OF SALE: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'The Vendor owns the chattels included in the Agreement, and conveys title to them to the Purchaser free and clear of all demands, claims, security interests, liens and encumbrances of any kind whatsoever.',
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
                                text: 'PROPERTY TAXES: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'The Vendor shall have paid the Property taxes and any local improvement rates and other charges included on the tax roll (and any interest and penalties thereon), as shown on the Statement of Adjustments.',
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
                                text: 'UTILITIES: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'The Vendor has paid or will pay on time any utility accounts to the Completion Date that may form a lien against the Property.',
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
                                text: 'FUEL: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'If the Vendor has adjusted for fuel oil, propane or condensed gas, the Vendor has filled the tank(s) to capacity, and paid for same in full.',
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
                                text: 'ADJUSTMENTS: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'If the Statement of Adjustments herein is or becomes inaccurate or incomplete in the Vendor’s favour, the Vendor shall readjust and make any appropriate payments forthwith, provided the Purchaser has delivered on closing a reciprocal undertaking.',
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
                                text: 'DIRECTION: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: "The Vendor authorizes and directs the Purchaser to pay the Balance Due on Closing as the Vendor's Lawyer in writing directs.",
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
                                text: 'DELETIONS FROM TITLE: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: "The Vendor shall pay all amounts and take all steps necessary to cause to be registered at the Vendor's expense a deletion from title of every encumbrance or instrument that the Vendor's Lawyer has agreed in writing to cause to be deleted from title.",
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
                                text: 'HST: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: "This transaction is not subject to HST as the Property is a personal use property or a used residential complex occupied by the Vendor or persons authorized by the Vendor, and is not a substantially renovated residential complex, under the Excise Tax Act of Canada.  The Vendor has not claimed and will not claim any input tax credit for the acquisition, improvement or renovation of the Property.",
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
                                text: 'FAMILY LAW: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: "The Transfer delivered in this transaction correctly shows each Vendor's spousal status and address for service.",
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
                                text: 'SURVEY: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: "If the Vendor has agreed in writing to deliver a plan or survey, then, to the best of my knowledge and belief, the building(s) and any other structures, fences and other boundary markers on the Property are accurately shown on the attached copy of the plan or survey prepared by , ",
                            }),
                            new TextRun({
                                text:'\t\t\tO.L.S., dated                 , except:',
                                break:1
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
                                text: 'CONDOMINIUM: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'If the Property is governed by the Condominium Act, 1998 of Ontario, the common expenses have been paid as shown on the Statement of Adjustments.  The Vendor has not made any material changes to the common elements other than those permitted by an agreement registered on title.  The Vendor has not received a notice convening a special or general meeting of the Condominium Corporation respecting; (a) the termination of the government of the condominium property; (b) any substantial alteration in or substantial addition to the common elements or the renovation thereof; or (c) any substantial change in the assets or liabilities of the Condominium Corporation.',
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
                                text: 'BINDING: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'All the statements in this Certificate are binding upon each Vendor and the heirs, successors and assigns (jointly and severally for multiple Vendors) of each Vendor, and are enforceable after closing.',
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
                                text: 'RELIANCE: ',
                                bold:true,
                            }),
                            new TextRun({
                                text: 'I make the above statements conscientiously believing each one to be true, and having the same force and effect as if made under oath or affirmation, and knowing that the Purchaser will be relying on them.',
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
                                text: "DATED ",
                                bold:true,
                                break:2
                            }),

                            new TextRun({
                                text: "at Brampton, this          day of "+moment().format('MMMM, YYYY')+".",
                            }),
                        ],
                    }),

                    new Paragraph({
                        children: sellers_arr,
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "I/We, the undersigned, HEREBY SOLEMNLY DECLARE that each Vendor is and will be on the closing date not a non-resident of Canada under s. 116 of the Income Tax Act of Canada, and I/we make this solemn declaration conscientiously believing it to be true, and knowing that it is of the same force and effect as if made under oath. ",
                                break:2,
                            }),


                        ],
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "(SEVERALLY) DECLARED before me	)",
                                break:2
                            }),
                            new TextRun({
                                text: "at                            , Ontario               	)",
                                break:1
                            }),
                            new TextRun({
                                text: "on                           , 20 ____   	              )",
                                break:1
                            }),
                            new TextRun({
                                text: "\t\t\t\t\t) 	_____________________________",
                                break:1
                            }),
                            new TextRun({
                                text: "\t\t\t\t\t) ",
                                break:1
                            }),
                            new TextRun({
                                text: "\t\t\t\t\t) ",
                                break:1
                            }),
                            new TextRun({
                                text: "\t\t\t\t\t) 	_____________________________",
                                break:1
                            }),
                            new PageBreak(),

                            new TextRun({
                                text: "_____________________________ 	)",
                                break:1
                            }),

                            new TextRun({
                                text: "A Commissioner, etc.\t\t\t)",
                                break:1
                            }),

                            new TextRun({
                                text: "\t\t\t\t\t) ",
                                break:1
                            }),

                            new TextRun({
                                text: "_____________________________ 	)",
                                break:1
                            }),
                            new TextRun({
                                text: "Commissioner’s Printed Name\t\t)",
                                break:1
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
