<template>
      <component :is="componentInstance"
        caption="Letter to inform about utilities and POA "
         :file-name="'letter_to_inform_about_utilities_and_poa'+file_opening.file_no"
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
              self.getContent(url.replace(/^data:image\/(png|jpg);base64,/, ""));
            })

        },
        getContent:function(image_url){
            var self = this;
            var section = [];
            var current_date = moment().format('LL');
              var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'DD-MM-YYYY').format("LL"):"";
            var seller1= '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                seller1 += self.file_opening.sellers[0].first_name ? self.file_opening.sellers[0].first_name + ' ' :'';
                seller1 += self.file_opening.sellers[0].middle_name ? self.file_opening.sellers[0].middle_name +' ' :'';
                seller1 += self.file_opening.sellers[0].last_name ? self.file_opening.sellers[0].last_name+' ' :'' ;
                if(seller1 == ''){
                    seller1 = 'Seller 1';
                }
            }

            var seller2= '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 1){
                seller2 += self.file_opening.sellers[1].first_name ? self.file_opening.sellers[1].first_name + ' ' :'';
                seller2 += self.file_opening.sellers[1].middle_name ? self.file_opening.sellers[1].middle_name +' ' :'';
                seller2 += self.file_opening.sellers[1].last_name ? self.file_opening.sellers[1].last_name+' ' :'' ;
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
                                    text: seller1+ " and "+ seller2,
                                    break:2
                                }),
                                new TextRun({
                                    text:  property.street_no ? property.street_no +", "+property.street_name :"",
                                    break:1
                                }),
                                new TextRun({
                                    text: property.city ? property.city.city_name +", "+property.province :"",
                                    break:1
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
                                    text: "\t "+seller1+"and "+seller2+" (the 'Vendor') s/t "+to,
                                }),
                                new TextRun({
                                    text: "\t "+purchaser1+" (the \"Purchaser\")",
                                    break:1
                                }),
                                new TextRun({
                                    text: "\t "+re +" (the \"Property\")",
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Closing Date:' + '\t ' + closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text:  '\t Our File No:' + '\t ' +self.file_opening.file_no,
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
                                    text: "In furtherance to our initial letter, please note as part of our practice our office would be contacting all the utilities to notify about the ownership change to new purchase’s name. However, these department require owners to contact as well. It is your responsibility to pay for these accounts before the date of closing. ",
                                }),
                                new TextRun({
                                    text: "If the closing date changes, please advise the utility companies of the new date.",
                                    bold:true
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
                                    text: "Following are the contact numbers for the utilities as well as the website link of the departments to close the accounts online:",
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
                                    text: "Alectra Utilities-\t\t ",
                                }),
                                new TextRun({
                                    text: "Ph: 	(905) 840-6300",
                                }),
                                new TextRun({
                                    text: "\t\t\t Email: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "BramptonCS@alectrautilities.com",
                                    color:'blue',
                                }),
                                new TextRun({
                                    text: "\t\t\t Online: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "\t\t\t https://alectrautilities.com/residential-customer-open-transfer-or-close-account?",
                                    color:'blue',
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
                                    text: "Water Department:\t ",
                                }),
                                new TextRun({
                                    text: "Ph: 	(905) 791-7400 / (905) 791-8711",
                                }),
                                new TextRun({
                                    text: "\t\t\t Email: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "utilityarrearscertificates@peelregion.ca",
                                    color:'blue',
                                }),
                                new TextRun({
                                    text: "\t\t\t Online: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "\t\t\t https://peelregion.ca/water/billing/changes.asp",
                                    color:'blue',
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
                                    text: "Gas Department:\t ",
                                }),
                                new TextRun({
                                    text: "Ph: 	(877) 362-7434 / (519) 352-3100",
                                }),
                                new TextRun({
                                    text: "\t\t\t Online: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "\t\t\t https://www.enbridgegas.com/Contact-Us",
                                    color:'blue',
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
                                    text: "Tax Department:\t ",
                                }),
                                new TextRun({
                                    text: "Ph: 	(905) 874-2200",
                                }),
                                new TextRun({
                                    text: "\t\t\t Email: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "311@brampton.ca",
                                    color:'blue',
                                }),
                                new TextRun({
                                    text: "\t\t\t Online: ",
                                    break:1
                                }),
                                new TextRun({
                                    text: "\t\t\t https://www.brampton.ca/EN/Residents/Taxes-Assessment/TaxOnline/Pages/Welcome.aspx",
                                    color:'blue',
                                    break:1
                                }),
                                // new PageBreak()
                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },

                    }),


                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "Please contact the departments listed above at your earliest convinience.",
                                bold:true,
                                break:1
                            }),

                            new TextRun({
                                text: "Yours very truly,",
                                break:2
                            }),

                            new TextRun({
                                text: "Lakhwinder Gill",
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
