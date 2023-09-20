<template>
    <document-generator
        :key="1"
        caption="solicitor_affidavit.docx"
        :fileName="'solicitor_affidavit'+file_opening.file_no"
        :creator="author"
        :content="solicitor_affidavit_content">
    </document-generator>
</template>

<script>


import {
  AlignmentType,
  Document,
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
import DocumentGenerator from '../../GlobalComponents/DocumentGenerator.vue';
export default {
    components: { DocumentGenerator },
    props: ['file_opening', 'author','solicitor'],
    data() {
        return {
            solicitor_affidavit_content:null,
            solicitor_fields:null,
        }
    },
    mounted() {
        this.setsolicitorFields();
    },

    methods: {
        setsolicitorFields:function(){
            var obj = new Object();
            try {
                this.solicitor.fields.forEach(element => {
                obj[element.field_name] = element.value;
            });

            } catch (error) {
                console.log(error);
            }

            this.solicitor_fields = obj;
            this.setContentData();
        },

        setContentData:function(){
            var self = this;
            console.log("self.solicitor_fields.solicitor_name");
            console.log(self.solicitor_fields.solicitor_name);
            var content = [];
            var section1 = [];

              var seller1= '';
            if(self.file_opening.sellers.length > 0){
                seller1 += self.file_opening.sellers[0].first_name ? self.file_opening.sellers[0].first_name + ' ' :'';
                seller1 += self.file_opening.sellers[0].middle_name ? self.file_opening.sellers[0].middle_name +' ' :'';
                seller1 += self.file_opening.sellers[0].last_name ? self.file_opening.sellers[0].last_name+' ' :'' ;
                if(seller1 == ''){
                    seller1 = 'Seller 1';
                }
            }
            var seller2= '';
            if(self.file_opening.sellers.length > 1){
                seller2 += self.file_opening.sellers[1].first_name ? self.file_opening.sellers[1].first_name + ' ' :'';
                seller2 += self.file_opening.sellers[1].middle_name ? self.file_opening.sellers[1].middle_name +' ' :'';
                seller2 += self.file_opening.sellers[1].last_name ? self.file_opening.sellers[1].last_name+' ' :'' ;
                if(seller2 == ''){
                    seller2 = 'Seller 2';
                }
            }


            section1.push({

                    children: [
                        new Paragraph({
                            heading: HeadingLevel.HEADING_4,
                            alignment: AlignmentType.CENTER,
                            allCaps: true,
                            children: [
                                new TextRun(
                                {
                                    text: "THE LAND TITLES ACT, ",
                                    color:'000000',
                                    bold:true,
                                    italics: true,
                                    allCaps: true,
                                    underline:true
                                }),
                                new TextRun(
                                {
                                    text: "Section 137 ",
                                    allCaps: false,
                                    bold:true,
                                    color:'000000',
                                    italics: false,
                                    underline:true

                                }),
                                 new TextRun(
                                {
                                    text: "STATUTORY DECLARATION AS TO WRITS OF EXECUTION",
                                    allCaps: false,
                                    bold:true,
                                    break:2,
                                    color:'000000',
                                    italics: false,
                                    underline:true

                                }),
                            ],
                        }),


                        new Paragraph({
                            heading: HeadingLevel.HEADING_5,
                            alignment: AlignmentType.LEFT,
                            children: [
                                    new TextRun({
                                        text: "IN THE MATTER OF:",
                                        bold:true,
                                        color:'000000',
                                    }),
                                    new TextRun({
                                        text: "IN THE REGISTER FOR:",
                                        bold:true,
                                        break:2,
                                        color:'000000',
                                    }),

                                ],
                                spacing: {
                                    after: 200,
                                    before:100
                                },
                        }),
                        new Paragraph({

                            children: [
                                    new TextRun({
                                        text: "AND IN THE MATTER OF:",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " certain Writs of Execution in the hands of the Sheriff of the Regional Municipality of "+self.solicitor_fields.municipality
                                        +"copies of which have been filed in "+self.solicitor_fields.land_registery+" as Number(s): "+self.solicitor_fields.execution_no,
                                    }),
                                    new TextRun({
                                        break:2,
                                        text: "I, "+self.solicitor_fields.solicitor_name+"/, make oath and say as follows:",
                                    }),
                                ],
                                spacing: {
                                    line: 350,
                                    before:100
                                },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "I am the solicitor for "+self.solicitor_fields.client_name+", a registered owner of the lands entered as,"+self.solicitor_fields.address+"."
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    line:350
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "The said "+self.solicitor_fields.client_name+", is not the same person as "+self.solicitor_fields.client_name+", the judgment debtor named in Writ of Execution Number "+self.solicitor_fields.execution_no+" wherein "+self.solicitor_fields.corporation+", as Plaintiff, was awarded the sum of $"+self.solicitor_fields.amount+" @"+self.solicitor_fields.amount_percentage+"% plus costs of $"+self.solicitor_fields.plus_cost+"@"+self.solicitor_fields.plus_cost_percentage+"%.",
                                    }),
                                ],
                                spacing: {
                                    before:200,
                                    line:350
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "The "+self.solicitor_fields.client_name +" shall indemnify and save harmless "+self.solicitor_fields.solicitor_name+", Barrister"
                                       + " and Solicitor from and against any, all actions, proceedings claims, demands, obligations or liabilities against the "
                                         + self.solicitor_fields.client_name +" if he/she is found one and the same person, and this covenant shall survive the closing of "
                                        + "this transaction",
                                    }),
                                ],
                                  spacing: {
                                    before:200,
                                    line:350
                                },
                                numbering: {
                                    reference: "my-custom-numbering",
                                    level: 1
                                }
                        }),

                          new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "AND I make this solemn Declaration conscientiously believing it to be true, and knowing that it is of the same force and effect as if made under oath.",
                                    }),
                                ],
                                  spacing: {
                                    before:200,
                                    line:350
                                },
                        }),




                        new Paragraph({
                            alignment: AlignmentType.LEFT,
                            children: [
                                    new TextRun({
                                        text: "Declared before me at the \t\t\t}",
                                    }),
                                    new TextRun({
                                         break:1,
                                        text: "City of "+self.solicitor_fields.city+"\t\t\t\t}",
                                    }),
                                    new TextRun({
                                        break:1,
                                        text: "in the Regional Municipality	\t}",
                                    }),
                                    new TextRun({
                                        break:1,
                                        text: "of "+self.solicitor_fields.municipality+" \t\t\t\t} ____________________________________",
                                    }),
                                    new TextRun({
                                        break:1,
                                        text: "this          day of \t\t\t\t}	" +self.solicitor_fields.solicitor_name,
                                    }),
                                    new TextRun({
                                        break:1,
                                        text: "\t\t\t\t\t}",
                                    }),
                            ],
                              spacing: {
                                    before:200,
                                },
                        }),

                    ],
            });
            self.solicitor_affidavit_content = section1;
        },
    }
};
</script>
