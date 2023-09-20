<template>
    <component :is="componentInstance"
        caption="Sale Coversheet"
         :file-name="'sale_coversheet'+file_opening.file_no"
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
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    bold:true,
                                    break:2
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor.name:'',
                                    break:2
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor && self.file_opening.purchaser_solicitor.solicitor.address ? self.file_opening.purchaser_solicitor.solicitor.address.addr_line1:'',
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor && self.file_opening.purchaser_solicitor.solicitor.address ? self.file_opening.purchaser_solicitor.solicitor.address.addr_line2:'',
                                    break:1
                                }),


                                new TextRun({
                                    text: "Attention: "+(self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor  ? self.file_opening.purchaser_solicitor.solicitor.name:''),
                                    underline:true,
                                    break:2
                                }),

                                new TextRun({
                                    text: "RE: SALE OF: "+(self.file_opening.property ? self.file_opening.property.addr_line1+' '+self.file_opening.property.addr_line2 : ''),
                                    bold:true,
                                    break:2
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
                                    text: "PLEASE FIND ENCLOSED CLOSING DOCUMENTS FOR THE SALE OF SUBJECT PROPERTY. THESE ARE SENT TO YOU TO BE HELD IN ESCROW BY YOU.",
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
                                    text: "THESE DOCUMENTS AND LOCK BOX CODE SHALL NOT BE USED OR REALSED IN ANY WAYS UNTILL: ",
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
                                    text: "YOU HAVE PAID IN FULL ALL FUNDS PURSUANT TO MY DIRECTION FOR FUNDS, UNDERTAKING TO RE-ADJUST, DRA AND DIRECTION FOR TITLE. ",
                                }),
                                new TextRun({
                                    text: "Upon receipt, I will release the deed for registration in teraview, and advise your office of the same. ",
                                    break:1
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
                                    text: "YOU ",
                                }),
                                new TextRun({
                                    text: "SHALL NOT RELEASE THE KEYS ",
                                    bold:true
                                }),
                                new TextRun({
                                    text: "UNTIL YOU HAVE COMPLETED THE PROCESS OF REGISTERING THE TRANSFER OF TITLE AND RELEASIONG THE FUNDS. ",
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
                                    text: "Please note that the keys will be placed in a lock box at the property and we will provide you with the lock box code on closing. ",
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
                                text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'',
                                break:2
                            }),

                            new TextRun({
                                text: "BARRISTER & SOLICITOR",
                                break:1
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
