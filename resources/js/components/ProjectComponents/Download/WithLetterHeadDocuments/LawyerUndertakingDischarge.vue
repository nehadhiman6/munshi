<template>
     <component :is="componentInstance"
        caption="Lawyer undertaking discharge"
         :file-name="'lawyer_undertaking_discharge'+file_opening.file_no"
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
  Alignment
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
        this.getImageContent();
    },
    methods:{
        getImageContent:function(){
            var self = this;
            const getBase64FromUrl = async (url) => {
            const data = await fetch(url);
            const blob = await data.blob();
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = () => {

                const base64data = reader.result;
                 resolve(base64data);
                }
            });
            }


            var image_url ='';
            getBase64FromUrl('https://lh3.googleusercontent.com/i7cTyGnCwLIJhT1t2YpLW-zHt8ZKalgQiqfrYnZQl975-ygD_0mOXaYZMzekfKW_ydHRutDbNzeqpWoLkFR4Yx2Z2bgNj2XskKJrfw8').then(function(url){
              console.log(url);
              self.getContent(url.replace(/^data:image\/(png|jpg);base64,/, ""));
            })

        },

        getContent:function(image_url){
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

                children: [
                    // new Paragraph({
                    //     children: [
                    //         new TextRun({
                    //             text: "VENDORThis Document is in the Form approved by the WORKING GROUP ON LAWYERS AND REAL ESTATE (http://www.lawyersworkinggroup.com/) on ",
                    //         }),

                    //         new TextRun({
                    //             text: "February 28, 2019",
                    //             bold:true,
                    //         }),

                    //         new TextRun({
                    //             text: 'except for clearly shown changes.  Any changes not clearly shown are of no effect.',
                    //         }),
                    //     ],
                    //     spacing: {
                    //         after: 200,
                    //         before:200
                    //     },
                    // }),

                    new Paragraph({
                        alignment:AlignmentType.CENTER,
                        children: [
                            new TextRun({
                                text: "LAWYER'S UNDERTAKING",
                                bold:true,
                                font:'28px',
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
                                // new TextRun({
                                //     text: current_date,
                                //     bold:true,
                                //     break:2
                                // }),
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
                                    text: "I/WE UNDERTAKE to the Purchaser and the Purchaser's Lawyer to take all steps necessary to cause to be deleted from title each of the following encumbrances or instruments, and to advise the Purchaser's Lawyer of the registration particulars thereof within a reasonable time after the closing of this transaction:",
                                    break:1,
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
                                    text: "REGISTRATION NUMBER ",
                                }),
                                new TextRun({
                                    text: "\tNAME OF ENCUMBRANCER OR INSTRUMENT ",
                                }),

                            ],
                            spacing: {
                                after: 500,
                                before:500
                            },
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "IF I/we have agreed in writing to pay property taxes, development charges or other amounts, then I/WE UNDERTAKE to the Purchaser and the Purchaser's Lawyer to deliver satisfactory proof of payment thereof to the Purchaser's Lawyer within a reasonable time after the closing of this transaction. ",
                                    break:4
                                }),
                                new TextRun({
                                    text: "DATED at " + '\t\t,Ontario, on ' + '\t\t,20_____. ',
                                    break:3
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        alignment:AlignmentType.RIGHT,
                        children: [
                                new TextRun({
                                    text: "LAW FIRM:"+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.law_firm ? self.file_opening.purchaser_solicitor.law_firm.firm_name:''),
                                    break:2
                                }),
                                new TextRun({
                                    text: "PER: \t\t\t\t\t",
                                    break:1
                                }),
                                new TextRun({
                                    text: "____________________________________",
                                    break:4
                                }),
                                new TextRun({
                                    text: "VENDOR'S LAWYER:"+(self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:''),
                                    break:2
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),




                    // new Paragraph({
                    //     children: [

                    //          new TextRun({
                    //             text: self.client_name,
                    //             break:2
                    //         }),

                    //         new TextRun({
                    //             text: acronym,
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
