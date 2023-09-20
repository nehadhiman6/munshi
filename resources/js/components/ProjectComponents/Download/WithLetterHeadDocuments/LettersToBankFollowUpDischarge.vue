<template>
     <component :is="componentInstance"
        :caption="'Letters to bank follow up discharge'"
        :file-name="'Letters to bank follow up discharge_'+ mortgage.instrument_no+'_'+file_opening.file_no"
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
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'DD-MM-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var sellers= '';
            var seller_addr = '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element, index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.name + ' ';
                })
            }

            var mortgage = self.file_opening.mortgages && self.file_opening.mortgages.length > 0 ? self.file_opening.mortgages[0]:null;
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';

            section.push({

                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text:current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: mortgage && mortgage.mortgagee ? mortgage.mortgagee.company_name:'',
                                    break:2
                                }),
                                new TextRun({
                                    text: mortgage && mortgage.address ? mortgage.address.addr_line1:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: mortgage && mortgage.address ? mortgage.address.addr_line2:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: "Attention: Mortgage Discharge Documentation",
                                    break:2,
                                    underline:true
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
                                    text: "\t "+ seller1+ " and "+(mortgage && mortgage.mortgagee ? mortgage.mortgagee.company_name:''),
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
                                    text: "I am the solicitor who represented the vendors, "+sellers+", in the above transaction.  Upon completion of the sale of the subject property on ___________, I forwarded funds to you so as to discharge the above first mortgage.",
                                }),

                                new TextRun({
                                    text: "Please note that I have still not received the executed discharge till date.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "I would request that you give this matter your immediate attention and forward to my office the discharge of mortgage and related documentation.",
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
