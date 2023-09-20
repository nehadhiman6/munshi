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
        'file_opening',
        'departments'
    ],
    data:function(){
        return {
            content:''
        }
    },
      computed:{
           componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        },

        water_department:function(){
            var department='',
            department =  this.departments.find(obj => {
                return obj.department_type == 'water'
            });
            return department;
        },

        gas_department:function(){
            var department='',
            department =  this.departments.find(obj => {
                return obj.department_type == 'gas'
            });
            return department;
        },

        hydro_department:function(){
            var department='',
            department =  this.departments.find(obj => {
                return obj.department_type == 'hydro'
            });
            return department;
        },

        tax_department:function(){
            var department='',
            department =  this.departments.find(obj => {
                return obj.department_type == 'tax'
            });
            return department;
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
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var prop_addr1 = self.file_opening.property ? self.file_opening.property.addr_line1 : '';
            var prop_addr2 = self.file_opening.property ? self.file_opening.property.addr_line2 : '';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            var depts = self.file_opening.property && self.file_opening.property.city && self.file_opening.property.city.departments.length > 0 ? self.file_opening.property.city.departments:null;
            var depts_arr = [];
            depts.forEach((element,index) => {
                if(index == 0) {
                    var text_break = 0
                } else {
                    var text_break = 2
                }
                depts_arr.push(
                    new TextRun({
                        text: Utilities.setProperCase(element.department_type)+' department',
                        break:text_break
                    }),
                    new TextRun({
                        text:  "\t\tName: " + element.department_name,
                    }),
                    new TextRun({
                        text: "\t\t\tPh: "+(element.phone ? element.phone:''),
                        break:1
                    }),
                    new TextRun({
                        text: "\t\t\tEmail: "+(element.email ? element.email:''),
                        break:1
                    }),
                    new TextRun({
                        text: "\t\t\tOnline: "+(element.website_link ? element.website_link:''),
                        break:1
                    }),
                );
            })
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

            section.push({
                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                }),
                                new TextRun({
                                    text: sellers,
                                    break:2
                                }),
                                new TextRun({
                                    text:  prop_addr1,
                                    break:1
                                }),
                                new TextRun({
                                    text: prop_addr2,
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
                                    text: "\t "+sellers+" (the 'Vendor') s/t ",
                                }),
                                new TextRun({
                                    text: "\t "+purchasers+" (the \"Purchaser\")",
                                    break:1
                                }),
                                new TextRun({
                                    text: "\t "+prop_addr1+' '+prop_addr2,
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
                        children: depts_arr,
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
                                text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'',
                                break:3
                            }),

                            new TextRun({
                                text: acronym,
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
