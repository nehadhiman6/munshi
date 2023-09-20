<template>
    <document-without-letter-head
    :file-name="'joint_retainer'+file_opening.file_no"
        caption="Conflict of interest joint retainer and consent to act"
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
                                    text: "CONSENT TO JOINT RETAINER",
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
                                    text: '\t\t'+ def_solicitor,
                                }),
                                new TextRun({
                                    text: '\t\tBarrister & Solicitor (the "Firm")',
                                    break:1
                                }),
                                new TextRun({
                                    text: "RE:",
                                    bold:true,
                                    break:2
                                }),

                                new TextRun({
                                    text: "\t\t"+sellers+' sale to ',
                                }),
                                new TextRun({
                                    text: "\t\t"+purchasers,
                                    break:1
                                }),
                                new TextRun({
                                     text: "\t\t"+prop_addr,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t\tClosing Date:  '+closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t\tMy File No.: '+self.file_opening.file_no,
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
                                    text: 'All of the undersigned, being '+sellers+', Two, (collectively the "undersigned parties"), hereby acknowledge and confirm that:',
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
                                text: 'The Firm has been requested to act for each of the undersigned parties in connection with the above-noted transaction (the "Transaction");',
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
                                text: "that a conflict of interest may arise between the undersigned and the other Parties during the course of completion of the Transaction;",
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
                                text: "The Firm has recommended that each of the undersigned parties obtain Independent Legal Advice about jointly retaining the Firm in connection with the Transaction;",
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
                                text: "In acting for the undersigned parties, no information received by the Firm from either party in connection with the Transaction can be treated as confidential insofar as the other parties are concerned;",
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
                                text: "If a conflict of interest should arise which cannot be reasonably resolved, arbitrated or settled, the Firm cannot continue to act for the undersigned, and in such case the Firm may have to withdraw completely from the Transaction;",
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
                                text: "Notwithstanding the foregoing, the undersigned confirm that the undersigned want the Lawyer to continue to act on the undersigned's behalf with respect to the Transaction and authorize and instruct the Lawyer to take all necessary steps in this regard. In addition, the undersigned release and forever discharge the Lawyer from any and all liability and claims arising as a result of the Lawyer concurrently acting for the Parties.",
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
