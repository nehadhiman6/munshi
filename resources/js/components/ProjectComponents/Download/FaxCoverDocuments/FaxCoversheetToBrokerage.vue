<template>
       <component :is="componentInstance"
        caption="Fax Coversheet to brokerage"
        :file-name='"Fax cover brokerage"'
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
  NumberFormat,
  ShadingType,
  BorderStyle,
  WidthType
} from "docx";

import FaxCoverDocument from '../FaxCoverDocument.vue'
export default {
      props:[
        'client_name',
        'client_sub_title',
        'client_address',
        'file_opening_id',
        'client_phone',
        'client_email',
        'file_opening',
        'departments'
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
            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var prop_addr1 = self.file_opening.property ? self.file_opening.property.addr_line1 : '';
            var prop_addr2 = self.file_opening.property ? self.file_opening.property.addr_line2 : '';
            var def_solicitor = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'';
            var broker = self.file_opening.commission && self.file_opening.commission.brokerage ? self.file_opening.commission.brokerage:null;
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            var sellers = '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element,index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.name;
                })
            }
            var purchasers = '';
            if(self.file_opening.purchasers && self.file_opening.purchasers.length > 0){
                self.file_opening.purchasers.forEach((element, index) => {
                    purchasers += (purchasers == '') ? '':' and ';
                    purchasers += element.name;
                })
            }

            var section = [];
            section.push({

                children: [
                    new Paragraph({
                        heading:HeadingLevel.HEADING_1,
                        children: [
                            new TextRun({
                                text: "FAX COVER SHEET",
                                break:1,
                                bold:true,
                                color:'black',
                            }),
                        ],
                        spacing: {
                            before: 200,
                            after: 200,
                        },
                    }),
                    new Paragraph({
                        alignment: AlignmentType.RIGHT,
                        children: [
                            new TextRun({
                                text: 'Date : '+current_date,
                                bold:true,
                                color:'black'
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [
                            new TextRun({
                                text: 'From:',
                                bold: true,
                                break:1,
                            }),
                            new TextRun({
                                text: 'Contact Name: '+def_solicitor,
                                break:1,
                            }),
                            new TextRun({
                                text: 'Direct Line: '+(self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.work_phone:''),
                                break:1,
                            }),
                            new TextRun({
                                text: 'Email: '+(self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.email:''),
                                break:1,
                            }),
                            new TextRun({
                                text: 'To:',
                                bold: true,
                                break:2,
                            }),
                            new TextRun({
                                text: broker ? broker.name:'',
                                break:1,
                            }),
                            new TextRun({
                                text: 'Address: '+(broker && broker.address ? broker.address.addr_line1+' '+broker.address.addr_line2:''),
                                break:1,
                            }),
                            new TextRun({
                                text: 'Fax: '+(broker ? broker.fax:''),
                                break:1,
                            }),
                        ],
                        spacing: {
                            before: 200,
                            after: 200,
                        },
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: '\t\tSubject:',
                                bold: true,
                                break:1,
                            }),
                            new TextRun({
                                text: '\t\t'+sellers+' Sale to ',
                            }),
                            new TextRun({
                                text: '\t\t\t\t'+purchasers,
                                break:1,
                            }),
                            new TextRun({
                                text: '\t\t\t\t'+prop_addr1+' '+prop_addr2,
                                break:1,
                            }),
                            new TextRun({
                                text: '\t\t\t\tClosing Date:' + '\t ' + closing_date,
                                break:1
                            }),
                            new TextRun({
                                text:  '\t\t\t\tOur File No:' + '\t ' +self.file_opening.file_no,
                                break:1
                            }),
                        ],
                        spacing: {
                            before: 200,
                            after: 200,
                        },
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: 'NUMBER OF PAGES:',
                                bold: true,
                                underline: true,
                                break:3,
                            }),
                            new TextRun({
                                text: 'MATERIAL SENT:',
                                bold: true,
                                underline: true,
                                break:4,
                            }),
                        ],
                        spacing: {
                            before: 200,
                            after: 200,
                        },
                    }),


                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "IN CASE OF INCOMPLETE TRANSMISSION, PLEASE CONTACT OUR OFFICE",
                                break:1,
                            }),
                        ],
                        spacing: {
                            before: 200,
                            after: 200,
                        },
                    }),
                    new Table({
                        rows:[
                            new TableRow({
                                children:[
                                    new TableCell({
                                        children: [
                                            new Paragraph({
                                                children: [
                                                    new TextRun({
                                                        text: "The documentation transmitted in this telecopy may contain confidential or privileged information.  It is intended for the exclusive use of the person to whom it is addressed and may not otherwise be read, distributed, copied or disclosed.  If you have received this telecopy in error, please notify our office immediately and return the original transmission to us.  Thank you for your co-operation.",
                                                        size:'15',
                                                    }),
                                                ],
                                            }),
                                        ],
                                        shading: {
                                            fill: "b7b7b7",
                                            type: ShadingType.REVERSE_DIAGONAL_STRIPE,
                                            color: "auto",
                                        },
                                    }),
                                ]
                            })
                        ]
                    })
                ],
            });
            self.content = section;
        }
    }

}
</script>

<style>

</style>
