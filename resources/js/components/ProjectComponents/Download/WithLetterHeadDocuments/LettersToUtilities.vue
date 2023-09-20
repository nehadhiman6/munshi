<template>
    <component :is="componentInstance"
        caption="Letters to Utilities"
        :file-name="'letters_to_utilities'+file_opening.file_no"
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
      computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
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

            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            var dept = self.file_opening.property && self.file_opening.property.city && self.file_opening.property.city.departments.length > 0 ? self.file_opening.property.city.departments[0]:null;


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
                                    text: dept ? dept.department_name:'',
                                    break:2
                                }),
                                new TextRun({
                                    text: "Attention:  "+(dept ? dept.department_type+' Department' : ''),
                                    break:1
                                }),
                                new TextRun({
                                    text: dept ? dept.addr_line1:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: dept ? dept.addr_line2:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: "Dear Sir or Madam:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t '+purchaser1,
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
                                    text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021.",
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
                                    text: "Kindly arrange for the "+(dept ? dept.deprtment_type:'')+" meter to be read on the said closing date.",
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
                                    text: "Thank you for your co-operation.",
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
                            new PageBreak(),
                        ],
                    }),

                    // 2nd page
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: "Alectra Utilities",
                                    break:2
                                }),
                                new TextRun({
                                    text: "Attention: Hydro Department",
                                    break:1
                                }),
                                new TextRun({
                                    text: "175 Sandalwood Pkwy W",
                                    break:1
                                }),
                                new TextRun({
                                    text: "Brampton, ON L7A 1E8",
                                    break:1
                                }),
                                new TextRun({
                                    text: "Dear Sir or Madam:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t purchase from',
                                }),
                                new TextRun({
                                    text: '\t 1090 Peter Robertson Blvd, Brampton',
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Closing Date: November 9, 2021',
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t My File No.: ' + ' 11-303',
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
                                    text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021.",
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
                                    text: "Kindly arrange for the hydro meter to be read on the said closing date.",
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
                                    text: "Thank you for your co-operation.",
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
                                text: "Yours very truly,",
                                break:2
                            }),

                            new TextRun({
                                text: self.client_name,
                                break:3
                            }),

                            new TextRun({
                                text: acronym,
                                break:2
                            }),
                            new PageBreak(),
                        ],
                    }),

                    // 3rd page
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: "Enbridge Gas Distribution Inc.",
                                    break:2
                                }),
                                new TextRun({
                                    text: "Attention: Gas Department",
                                    break:1
                                }),
                                new TextRun({
                                    text: "50 Keil Dr N",
                                    break:1
                                }),
                                new TextRun({
                                    text: "PO Box 2001",
                                    break:1
                                }),
                                new TextRun({
                                    text: "Chatham, ON N7M 5M1",
                                    break:1
                                }),
                                new TextRun({
                                    text: "Dear Sir or Madam:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t purchase from',
                                }),
                                new TextRun({
                                    text: '\t 1090 Peter Robertson Blvd, Brampton',
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Closing Date: November 9, 2021',
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t My File No.: ' + ' 11-303',
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
                                    text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021.",
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
                                    text: "Kindly arrange for the gas meter to be read on the said closing date.",
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
                                    text: "Thank you for your co-operation.",
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
                            // new PageBreak(),
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
