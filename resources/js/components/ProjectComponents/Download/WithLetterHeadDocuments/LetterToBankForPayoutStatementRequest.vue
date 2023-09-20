<template>
      <component :is="componentInstance"
        :caption="'Letter to bank for payout statement Request' "
        :file-name="'Request for mortgage discharge statement'+ mortgage.instrument_no+'_'+file_opening.file_no"
        :content="content"
        :client_name="client_name"
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
        // 'doc_seller',
        'mortgage'
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
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'DD-MM-YYYY').format("LL"):"";
            var seller1= '';
            var sellers = '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                seller1 += self.file_opening.sellers.name;
                if(seller1 == ''){
                    seller1 = 'Seller 1';
                }
            }

            var seller2= '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 1){
                seller2 += self.file_opening.sellers.name;
                if(seller2 == ''){
                    seller2 = 'Seller 2';
                }
            }
              var purchaser1 = "";
            var to = "";
              var purchasers = self.file_opening.purchasers ? self.file_opening.purchasers:[];
            purchasers.forEach((element, index) => {
                if (element.salutation == "Corporation") {
                    to += element.company_name + " ";
                } else {
                    to += element.first_name ? element.first_name + " " : " ";
                    to += element.middle_name ? element.middle_name + " " : "";
                    to += element.last_name ? element.last_name + " " : "";
                }
                if (index == 0) {
                    purchaser1 = to;
                }
                if (
                    index < purchasers.length - 1 &&
                    index != purchasers.length - 2
                ) {
                    to += ",";
                } else if (index == purchasers.length - 2) {
                    to += " and ";
                }

                to += " ";
            });

            var property = self.file_opening.property;
            console.log(property);
            if (property) {
                var re = "";

                re += property.street_no ? property.street_no + ", " : "";
                re += property.street_name ? property.street_name + ", " : "";
                re += property.unit_no ? property.unit_no + ", " : " ";
                re += property.city ? property.city.city_name + ", " : "";
                re += property.province ? property.province + ", " : "";
                re += property.postal_code ? property.postal_code : "";
            }
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element,index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.name;
                })
            }


            var str = self.client_name;
            var matches = str.match(/\b(\w)/g); // ['L','G']
            var acronym = matches.join(' '); //


            section.push({

                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: this.client_name,
                                    break:2
                                }),
                                new TextRun({
                                    text: "204-1090 Peter Robertson Blvd",
                                    break:1
                                }),
                                new TextRun({
                                    text: "Brampton, Ontario",
                                    break:1
                                }),
                                new TextRun({
                                    text: "L6R 3B3",
                                    break:1
                                }),
                                new TextRun({
                                    text: "Attention: Lakhwinder Singh Gill",
                                    break:2,
                                    underline:true
                                }),
                                new TextRun({
                                    text: "Dear Lakhwinder Singh Gill:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t XYZ and 12345 Financial Corporation Inc.',
                                }),
                                new TextRun({
                                    text: '\t Existing first mortgage',
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t 1090 Peter Robertson Boulevard, Brampton',
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Loan Number: '+self.mortgage.instrument_no,
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
                                    text: "I, Lakhwinder Singh Gill, am the solicitor acting on behalf of "+sellers+", being the vendors referred to above.  My clients are selling the above-noted property with a closing date scheduled for February 10, 2021.",
                                }),

                                new TextRun({
                                    text: 'It is understood that you hold a mortgage (the "Mortgage") against the Property.',
                                    break:2
                                }),

                                new TextRun({
                                    text: "Please provide a mortgage statement for discharge purposes, addressed to the Vendor, "+sellers+", in care of this office.",
                                    break:2
                                }),

                                new TextRun({
                                    text: "Please include the following in the discharge statement:",
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
                                text: "The outstanding principal and accrued interest due as of the closing date, which is February 10, 2021",
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
                                text: "The per diem interest charge accruing on the mortgage thereafter;",
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
                                text: "I require that the statement does not contain any qualifications as to its inaccuracies such as “E.&O.E” inasmuch as I shall be relying on your statement and issuing our cheque payable to you directly on the basis of the amount shown to be owed in that statement;",
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
                                text: "I require that the mortgage statement be signed by an authorized representative of Bank/Trust Company;",
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
                                text: "I would appreciate receiving notice of any qualifications to the represented balance owed on the mortgage such as clearance of cheque on deposit or remitted by the vendors, etc.; and",
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
                                text: "Inasmuch as the discharge will be registered electronically, I would require that you advise as to whether you will be registering the discharge, and if so, that it be confirmed in the mortgage statement that you shall attempt, in the normal course, to register the discharge within a sixty day period and that you will provide notice of the registration particulars of the discharge, together with a copy of the confirmation of the registration of the discharge to the undersigned.",
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
                                text: "Please fax the discharge statement to my office at (905) 790-0466 when ready, with the original to follow by ordinary mail.  Your assistance is greatly appreciated.",
                                break:2
                            }),

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
