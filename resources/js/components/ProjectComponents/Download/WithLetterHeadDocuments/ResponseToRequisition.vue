<template>
    <component :is="componentInstance"
        caption="Response to requisition"
        :file-name="'response_to_requisition_'+file_opening.file_no"
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
        'file_opening_id',
        'client_phone',
        'client_email',
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
                                    text: "Dear Sir or Madam:",
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
                                    text: "Without admitting the validity of any of the requisitions contained in your letter of January 9, 2021 by reason that the time during which you were permitted to submit the same had already elapsed, and specifically denying your right to submit further or other requisitions, but merely so as to assist you in your investigations with respect to title, I wish to respond as follows, using the same numerical order as in your aforesaid letter:",
                                }),

                                new TextRun({
                                    text: "1. The Deed has been messaged to you as requested.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "2. Will follow shortly.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "3. To be provided on closing.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "4. Please provide us with any executions against our clients.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "6, 7 . Please satisfy yourself.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "8, 9, 13. To be provided on closing.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "10. Please confirm with the respective real estate agents for the final inspection if the Agreement of Purchase and Sale allows it.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "11. We will provide you with keys on or before closing.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "12. Noted.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "14. We will be providing documents generated by our office on closing.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "15. My form of my personal undertaking has been prepared by my office and will be provide on or before closing.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "16, 17, 18, 19, 20, 21, 22 Please see Status Certificate provided by vendors and satisfy yourself.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "23, 24, 25, 26, 27, 29 Please satisfy yourself.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "28. On closing, we will provide you with:",
                                    break:2
                                }),

                                new TextRun({
                                    text: "a) a current mortgage statement for discharge purposes;",
                                    break:1
                                }),

                                new TextRun({
                                    text: "b) a direction that the appropriate portion of the balance due on closing be made payable to the mortgagee, and;",
                                    break:1
                                }),

                                new TextRun({
                                    text: "c) our personal undertaking to obtain and register a good and valid discharge of this mortgage as soon as possible after closing.",
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
                                    text: "SPECIAL INSTRUCTION RE: CERTIFICATION OF CHEQUES FOR CLOSING",
                                    bold:true,
                                    break:2
                                }),
                                new TextRun({
                                    text: "PLEASE ENSURE THAT THE CLOSING PROCEEDS ARE DRAWN FROM  YOUR LAW FIRMS’ TRUST ACCOUNT ONLY. To ensure that your transaction can be completed as scheduled.  All cheques must be certified. in light of the recent Law Society Ontario notices, Lakhwinder Singh Gill, Barrister and Solicitor can NO LONGER accept WIRE TRANSFER OR DIRECT DEPOSITS, unless authorized by us. Closing proceeds must be by Certified Cheque drawn from Your Firm’s Trust Account.  No exceptions can be permitted.",
                                    bold:true,
                                    break:2
                                }),

                                new TextRun({
                                    text: "There is a charge of $17.50 for any wire sent from a bank other than TD Canada Trust. Please add the fee to your deposit amount.",
                                    bold:true,
                                    break:1
                                }),

                                new TextRun({
                                    text: "As part of my firm’s new policy, please be advised that any closing funds delivered to my office, including wire transfer/direct deposit, must be issued from the Purchaser’s Solicitor’s trust account ",
                                    bold:true,
                                    break:2
                                }),
                                new TextRun({
                                    text: "only.",
                                    bold:true,
                                    italics:true,
                                    underline:true
                                }),
                                new TextRun({
                                    text: " I will ",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "not ",
                                    bold:true,
                                    italics:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "accept a certified cheque issued by a Purchaser or any other party.  Further, bank drafts will ",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "no ",
                                    bold:true,
                                    italics:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "longer be accepted.",
                                    bold:true,
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
