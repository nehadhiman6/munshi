<template>
    <document-without-letter-head
    :file-name="'Conflict_of_interest_acknowledgment_and_consent'+file_opening.file_no"
        caption="Conflict of interest acknowledgment and consent"
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
                                    text: "CONSENT TO ACT RE CONFLICT",
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
                                    text: "\t\t"+sellers+" Sale to",
                                }),
                                new TextRun({
                                    text: "\t\t"+purchasers,
                                    break:1
                                }),
                                new TextRun({
                                     text: "\t\t"+prop_addr +" ",
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
                                    text: 'We, the following parties, being '+sellers+', (collectively the "joint parties") hereby acknowledge being advised by you that you are representing all of us jointly, in the above transaction, and notwithstanding being so advised, the undersigned joint parties hereby expressly consent to you acting in this capacity.',
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
                                text: 'The undersigned joint parties further acknowledge being advised that all information received in connection with this transaction from any one of us cannot be treated as confidential insofar as the other joint parties are concerned, and that the rules of the Law Society of Upper Canada require that when law firms represent clients jointly, I must raise certain issues with each of the joint parties and obtain their consent as to the course to be followed in the future if a conflict arises. ',
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
                                text: "The undersigned further acknowledge having been advised that in the event of a material conflict between any one of us which cannot be resolved, you will advise us thereof, and it may be necessary for you to discontinue acting for either party in this matter.",
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
                                text: "NOTWITHSTANDING the foregoing, the undersigned hereby retain the Lawyer to act on the undersigned's behalf with respect to the above-noted Transaction and authorize and instruct the Lawyer to take all necessary steps in this regard. The undersigned release and forever discharge the Lawyer from any and all liability and claims arising out of the Lawyer concurrently acting for the undersigned and the Other Party.",
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
