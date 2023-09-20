<template>
    <component :is="componentInstance"
        caption="First letter to purchaser solicitor"
         :file-name="'first_letter_to_purchase_solicitor_'+file_opening.file_no"
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
    mounted:function(){
        this.getImageContent();
    },
    computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
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
            var purchaser_solicitor = self.file_opening.purchaser_solicitor;
            var law_firm = purchaser_solicitor ? purchaser_solicitor.law_firm:null;
            var law_firm_add = law_firm ? law_firm.address:null;
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';

            var str = self.client_name;
            var matches = str.match(/\b(\w)/g); // ['L','G']
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';

            var section = [];

            section.push({

                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: law_firm ? law_firm.firm_name:'',
                                    break:2
                                }),
                                // new TextRun({
                                //     text: "Barrister & Solicitor",
                                //     break:1
                                // }),
                                new TextRun({
                                    text: law_firm_add ? law_firm_add.addr_line1:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: law_firm_add ? law_firm_add.addr_line2:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: "Attention:  "+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:''),
                                    break:2,
                                    underline:true
                                }),
                                new TextRun({
                                    text: "Dear Mr. and Mrs.:",
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
                                    text: '\t Closing Date: '+closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t My File No.: ' + self.file_opening.file_no,
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
                                    text: "Please be advised that I am retained by the vendors to represent them in the above transaction, and I understand that you are representing the purchasers.",
                                }),
                                new TextRun({
                                    text: "Kindly advise my office as soon as possible as to the manner in which your clients will be taking title to the property and your Teraview Account Name to be used for sending messages through Teraview.",
                                    break:2
                                }),
                                new TextRun({
                                    text: "For this transaction, as it is to be completed under the electronic land registration system, I intend to use a Document Registration Agreement to facilitate closing and would also ask your confirmation to abide by the same.",
                                    break:2
                                }),
                                new TextRun({
                                    text: "Please note that I will be using the Working Group on Lawyers and Real Estate Ontario Standard Closing Documents available at www.lawyersworkinggroup.com.",
                                    break:2,
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
