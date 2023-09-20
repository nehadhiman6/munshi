
<template>
         <component :is="componentInstance"
            caption="Produce Letter"
            :file-name="file_name"
            :content="content"
            :client_name="client_name"
            :client_sub_title="client_sub_title"
            :client_address="client_address"
            :client_phone="client_phone"
            :client_email="client_email"
            element_type="button">
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
    computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
    },
    props:{
        file_name:{
            default:'Produce Document',
            type:String
        },

        compliance_type:{
            default:'tax',
            type:String
        },
         client_name:{
            default:'client_name',
            type:String
        },
        client_sub_title:{
            default:'client_sub_title',
            type:String
        },
        client_address:{
            default:'client_address',
            type:String
        },
        client_phone:{
            default:'client_phone',
            type:String
        },
        client_email:{
            default:'client_email',
            type:String
        },
        departments:{
            default:function(){
                return [];

            }
        },
        file_opening:{
            default:function(){
                return {};

            }
        }
    },

    data:function(){
        return {
            content:'',
        }
    },
    mounted:function(){
            this.getContent();
    },

    computed:{
        department:function(){
            var self = this;
            var department = "";
            if(this.compliance_type == 'tax'){
                department = this.tax_department;
            }
            else if(this.compliance_type == 'water'){
                department = this.water_department;
            }
            else if(this.compliance_type == 'hydro'){
                department = this.hydro_department;
            }
            else if(this.compliance_type == 'gas'){
                department = this.gas_department;
            }
            return department;
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
    methods:{

        getContent:function(){
            var self = this;
            var section = [];
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var prop_addr = self.file_opening.property ? self.file_opening.property.addr_line1+' '+self.file_opening.property.addr_line2 : '';
            var property = self.file_opening.property;
            if (property) {
                var re = "";
                re += property.street_no ? property.street_no + ", " : "";
                re += property.street_name ? property.street_name + ", " : "";
                re += property.unit_no ? property.unit_no + ", " : " ";
                re += property.city ? property.city.city_name + ", " : "";
                re += property.province ? property.province : "";
                // re += property.postal_code ? property.postal_code : "";
            }
            var purchasers = '';
            if(self.file_opening.purchasers && self.file_opening.purchasers.length > 0){
                self.file_opening.purchasers.forEach((element, index) => {
                    purchasers += (purchasers == '') ? '':' and ';
                    purchasers += element.name;
                })
            }

            var middle_content = self.compliance_type == 'tax' ?
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Please be advised that I am the solicitor for , effective November 9, 2021, purchased the property described above.",
                                    break:1
                                }),

                                new TextRun({
                                    text: "Kindly amend your records to show my client:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "as the new owner of the property.",
                                    break:4
                                }),
                                 new TextRun({
                                    text: "I would therefore request that you forward a copy of the current tax bill and all future notices and bills to the new owner of the property at:",
                                    break:2
                                }),
                                new TextRun({
                                    text:  property  && property.street_no ?  "\t" + property.street_no + ", ": '',
                                    break:3
                                }),
                                new TextRun({
                                    text:  property  && property.street_name ?  property.street_name : '' ,
                                    break:0
                                }),
                                 new TextRun({
                                    text:  property  && property.unit_no ?  property.unit_no : '' ,
                                    break:0
                                }),
                                 new TextRun({
                                    text:  property  && property.city ?  "\t" + property.city.city_name +", ":""  ,
                                    break:1
                                }),
                                 new TextRun({
                                    text:  property  && property.province ?  property.province +", ":""  ,
                                    break:0
                                }),
                                new TextRun({
                                    text:  property  && property.postal_code ?  "\t" +property.postal_code : '' ,
                                    break:1
                                }),
                                new TextRun({
                                    text: "Thank you for your co-operation in this matter.",
                                    break:2
                                }),
                            ],
                    })
                    :  new Paragraph({
                        children: [
                                new TextRun({
                                    text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021.",
                                    break:1
                                }),

                                new TextRun({
                                    text: "Kindly arrange for the "+self.compliance_type+" meter to be read on the said closing date.",
                                    break:2
                                }),
                                new TextRun({
                                    text: "Thank you for your co-operation.",
                                    break:2
                                }),
                            ],
                    });
            section.push({

                children:
                [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: self.department.department_name,
                                    break:2
                                }),
                                new TextRun({
                                    text: "Attention: "+self.department.attention,
                                    break:1
                                }),
                                new TextRun({
                                    text: self.department.street_no +' '+self.department.street_name,
                                    break:1
                                }),
                                new TextRun({
                                    text: self.department.province +', '+self.department.postal_code,
                                    break:1
                                }),

                                new TextRun({
                                    text: "Dear Sir/Madam:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t'+purchasers,
                                }),
                                new TextRun({
                                    text: '\t'+prop_addr,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\tClosing Date: ' +closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\tMy File No.: '+self.file_opening.file_no,
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
                    middle_content,

                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "Yours very truly,",
                                break:2
                            }),

                            new TextRun({
                                text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'',
                                break:2
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
