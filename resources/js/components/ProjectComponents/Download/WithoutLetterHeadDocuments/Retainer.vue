<template>
    <document-without-letter-head
        :file-name="'retainer'+file_opening.file_no"
        caption="Retainer"
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
            var prop_addr = self.file_opening.property ? self.file_opening.property.addr_line1+' '+self.file_opening.property.addr_line2 : '';
            var sellers_arr = [];
            var sellers = '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element,index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.name;
                    sellers_arr.push(
                        new TextRun({
                            text: "_______________________ ",
                            break:3
                        }),
                        new TextRun({
                            text: element.name+"\t\t",
                            break:1
                        }),
                    );
                })
            }
            var purchasers_arr = [];
            var purchasers = '';
            if(self.file_opening.purchasers && self.file_opening.purchasers.length > 0){
                self.file_opening.purchasers.forEach((element, index) => {
                    purchasers += (purchasers == '') ? '':' and ';
                    purchasers += element.name;
                    purchasers_arr.push(element.name);
                })
            }

            section.push({

                children: [
                    new Paragraph({
                        heading: HeadingLevel.HEADING_2,
                        alignment: AlignmentType.CENTER,
                        children: [
                                new TextRun({
                                    text: "RETAINER AGREEMENT",
                                    bold:true,
                                    underline:true,
                                    color:'black'
                                }),

                            ],
                            spacing: {
                                after: 200,
                            },
                    }),


                    new Paragraph({
                        children: [
                            new TextRun({
                                    text: "TO:",
                                    bold:true,
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t\t' +def_solicitor,
                                }),
                                new TextRun({
                                    text: "RE:",
                                    bold:true,
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t\t' + sellers,
                                }),
                                new TextRun({
                                    text: '\t\t'+prop_addr,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t\tClosing Date:  '+closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t\tYour File No.:  '+self.file_opening.file_no,
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
                                    text: "Further to the initial communication and in Consideration of terms and conditions of this retainer letter, the undersigned, "+sellers+", do hereby retain our lawyer to provide legal services available in matters relating to my/our sale of the property municipally known as "+prop_addr+" and hereby agree as follows:",
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
                                text: "1. RETAINER",
                                bold:true
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
                                text: "To pay ////////000.00 plus G.S.T plus disbursements for Final Closing to the lawyer of "+def_solicitor+" Law Office.  To pay ________ plus G.S.T to "+def_solicitor+" Law Office, if we require to work on for any extension request.  To pay ________ plus G.S.T. per hour if any work required for the closing of this transaction.  The above fees have been quoted to you on the understanding that unusual difficulties will not be encountered in the completion of the transaction or extensions of the closing date.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "In the event that unexpected difficulties or extensions arises as a result of matters beyond the control of your lawyer of "+def_solicitor+" Law Office, then our law Office reserves the right to increase the fees to reflect any additional time expended in the completion of the transaction.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "This agreement reserve the lawyer’s availability for employement by client and in no way prevent the lawyer from performing the work of other clients.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "In addition to the professional fee of our lawyer to pay  the disbursements incurred by our  law office in carrying out the terms of this retainer including government and third party charges, long distance  telephone tolls, postage, courier expenses and the like.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "To pay Goods and Services tax (GST) or any other taxes on the fees and disbursements payable to "+def_solicitor+" Law Office as applicable.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: this.client_name+" Law Office may issue statements of account on a periodic basis as services are performed, each statement to reflect services rendered and disbursements incurred and it is agreed that factors not taken into account into interim billings may be reflected in the final billings. All accounts are due and payable on receipt.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "It is understood that if I/we think that any account of "+def_solicitor+" Law Office is excessive it may be requested that it be reviewed by the taxing in any court in Ontario who will decide whether the account is reasonable.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "Either the undersigned or "+def_solicitor+" Law Office may terminate this retained at any time, in which case the undersigned will pay to "+def_solicitor+" Law Office the fees, disbursement and GST in respect of services rendered up to the time of termination of this retained in accordance with this agreement.",
                            }),

                        ],
                        spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 2
                            }
                    }),

                    new Paragraph({
                        children: [
                            new PageBreak(),
                            new TextRun({
                                text: "2. E-Mails Communication",
                                bold:true,
                            }),
                            new TextRun({
                                text: "In general, our firm discourages the use of Email as a system for correspondence due to the risks involved with email communications. E-mail dangers are important to understand and be aware of.",
                                break:2
                            }),
                            new TextRun({
                                text: "Scams",
                                style: "Hyperlink",
                            }),
                            new TextRun({
                                text: ", ",
                            }),
                            new TextRun({
                                text: "phishing schemes",
                                style: "Hyperlink",
                            }),
                            new TextRun({
                                text: ", ",
                            }),
                            new TextRun({
                                text: "viruses",
                                style: "Hyperlink",
                            }),
                            new TextRun({
                                text: ", ",
                            }),
                            new TextRun({
                                text: "hoaxes",
                                style: "Hyperlink",
                            }),
                            new TextRun({
                                text: " and ",
                            }),
                            new TextRun({
                                text: "Access by third parties ",
                                style: "Hyperlink",
                            }),
                            new TextRun({
                                text: "are some of the words that represent the many dangers facing the usage of e-mail today. Anyone can use features of email to launch malware (a term that covers viruses, worms, trojan horses, and other harmful programs. In certain circumstances, communication through e-mail can be accessed by third party which may result in a breach of the confidentiality and privilege that we wish to maintain with you.",
                            }),

                            new TextRun({
                                text: "If you prefer to communicate through an e-mail please sign the enclosed consent of assumption of risk. We put you on notice that you may not be able to claim privilege over the information and communication if a third party gains access to the email communications.  In such an event, we will also not be liable for breach of confidentiality.",
                                break:2
                            }),


                        ],
                        spacing: {
                            after: 200,
                            before:200
                        },
                    }),

                    new Paragraph({
                        children:[
                            new TextRun({
                                text: "3. Communication With Third Party (Bank Or Insurance Company)",
                            }),
                            new TextRun({
                                text: "You hereby authorize our office that once we receive written confirmation and request from you, our office can send your information to your Financial Institute in order for them to work on your mortgage and provide us with mortgage documents to do your closing on time.  You also authorize us to write and provide your information once we receive written confirmation and request from you to your Home Insurance Provider via fax and/or email.",
                                break:2
                            }),
                        ]
                    }),

                    new Paragraph({
                        children:[
                            new TextRun({
                                text: "4. Confidentiality",
                                bold:true,
                            }),
                            new TextRun({
                                text: "The client understands that the lawyer has and will have the information related to the subject transaction, included but not limited to exisiting mortgage, taxes, identifications and that it no way use that information for personal benefit.",
                                break:2
                            }),
                        ]
                    }),

                    new Paragraph({
                        children:[
                            new TextRun({
                                text: "5. Termination",
                                bold:true,
                            }),
                            new TextRun({
                                text: "This agreement shall terminate upon completion by the lawyer, of the services required under this agreement.",
                                break:2
                            }),
                        ]
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
                        alignment:AlignmentType.RIGHT,
                        children: sellers_arr,
                        // children: [

                        //     new TextRun({
                        //         text: "_______________________ ",
                        //         break:3

                        //     }),

                        //     new TextRun({
                        //         text: seller1+"\t\t",
                        //         break:1
                        //     }),

                        //     new TextRun({
                        //         text: "_______________________ ",
                        //         break:3

                        //     }),

                        //     new TextRun({
                        //         text: seller2+"\t\t",
                        //         break:1
                        //     }),
                        // ],

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
