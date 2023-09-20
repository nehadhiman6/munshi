<template>
       <component :is="componentInstance"
        caption="Extension letter"
        :file-name="'extension_letter'+file_opening.file_no"
        :content="content"    :client_name="client_name"
        :client_sub_title="client_sub_title"
        :client_address="client_address"
        :client_phone="client_phone"
        :client_email="client_email">
     </component>

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
export default {
      props:[
        'client_name',
        'client_sub_title',
        'client_address',
        'client_phone',
        'client_email',
        'file_opening_id',
        'file_opening'
    ],
    data:function(){
        return {
            content:''
        }
    },
      computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
    },
   mounted:function(){
        this.getContent();
    },
    methods:{

        getContent:function(){
            var self = this;
            var section = [];

            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';

            section.push({

                children:
                [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:'',
                                    break:2
                                }),
                                new TextRun({
                                    text: "Barrister & Solicitor",
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.address.addr_line1:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.address.addr_line2:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: "Attention:  "+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:''),
                                    break:2,
                                    underline:true
                                }),
                                new TextRun({
                                    text: "Dear Sir/Madam:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t '+seller1+' to '+purchaser1,
                                }),
                                new TextRun({
                                    text: '\t '+firm_addr1+' '+firm_addr2,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Closing Date:' + '\t ' + closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Our File No:' + '\t ' +self.file_opening.file_no,
                                    break:1
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
                                    text: "With reference to you email of September 1, 2021, requesting extension to the closing date till December 21, 2021, please be advised that our client had instructed us to extend the closing on the following terms:",
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
                                    text: "A further, and additional deposit through a certified cheque of the value of $_________ to LAKWHINDER GILL in trust no later than 11:00 AM tomorrow, Sunday, September 11, 2021. The extension will be deemed Null and Void if this condition is not fulfilled.",
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
                                    text: "Legal fees, payable to (Name of Seller’s Lawyer), for the extension, in the amount of $00.00 plus HST = $00.00, as agreed in the last extension.",
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
                                    text: "The Buyers will be liable to pay all Utilities, Hot water (if any) and Home insurance and will pay to the Seller if there is any cost for reinstatement of his Insurance.",
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
                                    text: "The purchaser agrees that their original deposit of $   and this new second deposit $  ( total $000,000.00) becomes non-refundable and will be released to the vendor immediately.",
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
                                    text: "The purchaser agrees to direct the (Name of real estate Brokerage) so that the deposit is released to the vendor. In case the broker needs any more documents for releasing the deposit, the purchaser agrees to provide these to the best of his ability.",
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
                                    text: "Pursuant to DRA, hold closing documents and lock box code in escrow, delivered to your office.",
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
                                    text: "Time is the essence and the Statement of Adjustments will remain as is.",
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
                                    text: "All other terms of the Agreement of Purchase and Sale between our clients remain the same; ",
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
                                    text: "You/Your clients agree to waive tender effective December 21, 2021.",
                                }),
                            new PageBreak()
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
                                    text: "In a situation where your client is not able to close by (extended closing date), for whatsoever reason(s), our client will consider the Agreement of Purchase and Sale to have lapsed, resulting in all deposits to be forfeited as liquidated damages.",
                                }),
                                new TextRun({
                                    text: "TEMRS OF THIS LETTER ARE NON-NEGOTIABLE AS PER THE VENDOR’S DIRECTION AND THE VENDOR’S FURTHER COMMITMENTS BASED ON THE CLOSING ON (original closing date), AND RECEIVING THE BALANCE ON CLOSING.",
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
                                text: "NO FURTHER EXTENSION WILL BE GRANTED.",
                                bold:true,
                                break:1
                            }),

                            new TextRun({
                                text: "Please sign a copy of this letter in the space indicated below. Once executed, kindly return the document to me, to confirm your client’s(s’) agreement to extension of the closing date.",
                                break:2
                            }),

                            new TextRun({
                                text: "Yours very truly,",
                                break:2
                            }),

                            new TextRun({
                                text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'',
                                break:3
                            }),

                            new TextRun({
                                text: acronym,
                                break:2
                            }),
                            new TextRun({
                                text: "On behalf of my clients I hereby agree to the above.",
                                break:2
                            }),
                            new TextRun({
                                text: "DATED at                                this           day of "+moment().format('MMMM, YYYY')+".",
                                break:2
                            }),
                        ],
                    }),
                    new Paragraph({
                        alignment: AlignmentType.RIGHT,
                        children: [
                            new TextRun({
                                text: "Per: __________________________",
                                break:2
                            }),
                            new TextRun({
                                text: "("+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:'')+")",
                                break:1
                            }),
                            new TextRun({
                                text: "Barrister & solicitor",
                                break:1
                            }),
                            ],

                            tabStops: [
                                {
                                    type: TabStopType.RIGHT,
                                    // position: TabStopPosition.MAX,
                                    position: 1000,
                                },
                            ],
                            spacing: {
                                after: 200,
                            },

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
