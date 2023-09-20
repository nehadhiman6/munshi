<template>
      <component :is="componentInstance"
        :caption="'Letter to bank payout mortgage with funds '"
         :file-name="'Mortgage payout statement with funds'+ mortgage.instrument_no+'_'+file_opening.file_no"
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
        'file_opening',
        'mortgage',
        // 'doc_seller'
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
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            section.push({
                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: self.mortgage && self.mortgage.mortgagee ? self.mortgage.mortgagee.company_name:'',
                                    break:2
                                }),
                                new TextRun({
                                    text: self.mortgage && self.mortgage.address ? self.mortgage.address.addr_line1:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: self.mortgage && self.mortgage.address ? self.mortgage.address.addr_line2:'',
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
                                    text: "Attention: Mortgage Discharge",
                                }),
                            new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: "\t "+ seller1+ " and "+(self.mortgage && self.mortgage.mortgagee ? self.mortgage.mortgagee.company_name:''),
                                }),
                                new TextRun({
                                    text: "\t Discharge of first mortgage",
                                    break:1
                                }),
                                new TextRun({
                                    text:"\t "+firm_addr1,
                                    break:1
                                }),
                                new TextRun({
                                    text:"\t "+firm_addr2,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Loan No:' + '\t ' +(self.mortgage ? self.mortgage.instrument_no:''),
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t My File No:' + '\t ' +self.file_opening.file_no,
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
                                    text: "Further to previous correspondence with you in connection with the above-mentioned mortgage, Please find enclosed herewith a certified cheque in the sum of _________, being the amount required to discharge this mortgage inclusive of interest to ____________.",

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
                                    text: "Would you kindly forward the following to this office:",
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
                                    text: "A copy of the registered Discharge of Charge/Mortgage.",
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
                                    text: "Release of interest in the mortgagor's insurance policy.",
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
                                    text: "The undersigned trusts you will find the enclosed to be satisfactory",
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
