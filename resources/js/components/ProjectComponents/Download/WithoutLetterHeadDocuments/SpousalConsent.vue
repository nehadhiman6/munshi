<template>
    <document-without-letter-head
    :file-name="'spousal_consent'+file_opening.file_no+ '('+married_seller.name+')'"
        :caption="'Acknowledgement and Directions for Spousal Consent ('+married_seller.name +')'"
        :content="content">
    </document-without-letter-head>

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
  NumberFormat,
  BorderStyle,
  WidthType
} from "docx";
import DocumentWithoutLetterHead from '../DocumentWithoutLetterHead.vue'
export default {
       props:[
           'married_seller',
        'client_name',
        'client_sub_title',
        'client_address',
        'file_opening_id',
        'file_opening'
    ],
    components: {
        DocumentWithoutLetterHead,
    },
    data:function(){
        return {
            content:''
        }
    },
    mounted:function(){
        this.getContent();
    },
    methods:{
        getContent:function(){
            var self = this;
            var section = [];
             var client_address_array = [];
            var client_add = this.client_address.split('/');


            client_add.forEach(element => {
                client_address_array.push(
                    new TextRun({
                        text:element,
                        break:1,
                        color:'gray'
                    }),
                )
            });

            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var seller_solicitor = self.file_opening.solicitor && self.file_opening.solicitor.last_name ?  self.file_opening.solicitor.first_name +" "+  self.file_opening.solicitor.last_name:"";
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_name = self.file_opening.company ? self.file_opening.company.name :"Firm Name";
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
           var propery_add =  self.file_opening.property ? self.file_opening.property.addr_line2 ? self.file_opening.property.addr_line1+ ','+self.file_opening.property.addr_line2:"":"";
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            var def_solicitor = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'';
            var prop_addr = self.file_opening.property ? self.file_opening.property.addr_line1+' '+self.file_opening.property.addr_line2 : '';
            var file_no = self.file_opening.file_no ? self.file_opening.file_no:"";
            var pins = "";
            var legal_property = self.file_opening.property  ? self.file_opening.property.customer_no ? self.file_opening.property.roll_no +' '+self.file_opening.property.customer_no:self.file_opening.property.roll_no :"";


            if(self.file_opening.property ){
                self.file_opening.property.pins.forEach(function(ele,ind){
                     if(ind > 0 && ind <= self.file_opening.property.pins.length-1){
                        pins += ', ';
                    }
                    pins+= ele.pin;
                });
            }
            var sellers_arr = [];
            var sellers = '';
            var sellers_arr1 = [];
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element,index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.name;
                    sellers_arr.push(
                        new TextRun({
                            text: "________________________________ ",
                            break:3
                        }),
                        new TextRun({
                            text: "\t"+element.name,
                            break:1
                        }),
                    );
                    sellers_arr1.push(
                                new TextRun({
                                   color:'black',
                                   text: "Name",
                                }),

                                new TextRun({
                                   color:'black',
                                   text: '\t\t'+ element.name,
                                }),
                                 new TextRun({
                                   color:'black',
                                   text: "I am at least 18 years of age ( Spousal statements change as per the marital status selected by lawyer in Seller’s Tab) The property is not ordinarily occupied by me and my spouse, who is not separated from me, as our family residence. The property is not ordinarily occupied by me and my spouse, who is not separated from me, as our family residence.",
                                    break:2
                                }),
                    )
                })
            }
            var purchasers="";
            var purchasers_arr = [];
            if(self.file_opening.purchasers && self.file_opening.purchasers.length > 0){
                self.file_opening.purchasers.forEach((element, index) => {
                       purchasers += (purchasers == '') ? '':' and ';
                    purchasers += element.name;
                    purchasers_arr.push(
                          new TableRow({
                                children:[
                                     new TableCell({
                                    borders: {
                                        top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                    },
                                    children: [
                                    new Paragraph({
                                        children: [
                                            new TextRun({
                                                    text: "Name \t\t"+element.name,
                                                    italics: true,
                                            }),
                                            ],
                                                spacing: {
                                                after: 100,
                                                    before:100
                                            },
                                    })

                                    ],
                                    }),
                                    new TableCell({
                                        borders: {
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                        new Paragraph({
                                            children: [
                                                new TextRun({
                                                        text: element.title_capacity,
                                                        italics: true,
                                                }),
                                                ],
                                                    spacing: {
                                                    after: 100,
                                                        before:100
                                                },
                                        })

                                        ],
                                    }),
                                    new TableCell({
                                        borders: {
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                        new Paragraph({
                                            children: [
                                                new TextRun({
                                                        text: "",
                                                        italics: true,
                                                }),
                                                ],
                                                    spacing: {
                                                    after: 100,
                                                        before:100
                                                },
                                        })

                                        ],
                                    }),
                                ]
                            }),



                    );
                    purchasers_arr.push(
                        new TableRow({
                                children:[
                                     new TableCell({
                                    borders: {
                                        top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                    },
                                    children: [
                                    new Paragraph({
                                        children: [
                                            new TextRun({
                                                    text: "Date of Birth \t"+element.dob,
                                                    italics: true,
                                            }),
                                            ],
                                                spacing: {
                                                after: 100,
                                                    before:100
                                            },
                                    })

                                    ],
                                    }),
                                    new TableCell({
                                        borders: {
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                        new Paragraph({
                                            children: [
                                                new TextRun({
                                                        text: "",
                                                        italics: true,
                                                }),
                                                ],
                                                    spacing: {
                                                    after: 100,
                                                        before:100
                                                },
                                        })

                                        ],
                                    }),
                                     new TableCell({
                                        borders: {
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                        new Paragraph({
                                            children: [
                                                new TextRun({
                                                        text: "",
                                                        italics: true,
                                                }),
                                                ],
                                                    spacing: {
                                                    after: 100,
                                                        before:100
                                                },
                                        })

                                        ],
                                    }),

                                ]
                            })
                    );
                })
            }


            section.push({

                children: [
                    new Paragraph({
                        heading: HeadingLevel.HEADING_3,
                        alignment: AlignmentType.CENTER,
                        children: [
                                new TextRun({
                                    text: "ACKNOWLEDGEMENT AND DIRECTION",
                                    bold:true,
                                    break:4,
                                    underline:true,
                                    color:'black'
                                }),
                                  new TextRun({
                                    text: "SPOUSAL CONSENT TO ELECTRONIC",
                                    bold:true,
                                    break:3,
                                    underline:true,
                                    color:'black'
                                }),
                                  new TextRun({
                                    text: "REGISTRATION OF TRANSFER",
                                    bold:true,
                                     break:1,
                                    underline:true,
                                    color:'black'
                                }),

                            ],
                            spacing: {
                                after: 100,
                            },
                    }),


                    new Paragraph({
                        heading: HeadingLevel.HEADING_3,
                        children: [
                            new TextRun({
                                   color:'black',
                                   text: "TO:",
                                    bold:true,
                                    break:1
                                }),

                                new TextRun({
                                   color:'black',
                                   text: '\t\t'+ firm_name,
                                }),
                                 new TextRun({
                                   color:'black',
                                   text: "AND TO:",
                                    bold:true,
                                    break:2
                                }),
                                 new TextRun({
                                   color:'black',
                                   text: '\t'+ seller_solicitor,
                                }),

                                new TextRun({
                                   color:'black',
                                   text: "RE:",
                                    bold:true,
                                    break:2
                                }),

                                new TextRun({
                                   color:'black',
                                   text: "\t\t(SELLERS) "+sellers+" Sale to",
                                }),
                                new TextRun({
                                   color:'black',
                                   text: "\t\t(PURCHASER) "+purchasers+" (FILE NO."+file_no+ ")",
                                    break:1
                                }),
                                // new TextRun({
                                //      text: "\t\t"+prop_addr +" ",
                                //     break:1
                                // }),



                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),
                     new Paragraph({
                        children: [
                                new TextRun({
                                    text: 'I hereby confirm the following:',
                                    bold:true,
                                    break:1
                                }),
                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),


                    new Paragraph({
                        size:20,
                        children: [
                                new TextRun({
                                    size:22,
                                    text: 'I am the spouse of the transferor ' +self.married_seller.name,
                                    // break:2
                                }),

                            ],
                             numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            },
                             spacing: {
                                after: 200,
                            },
                    }),

                    new Paragraph({
                        children: [

                                  new TextRun({
                                    size:22,
                                    text: 'I hereby consent to the transaction described on the attached Acknowledgement and Direction (the “Acknowledgement”) and authorize you or your agent to indicate my consent on all registered documents related thereto',
                                    // break:2
                                }),
                            ],

                             numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            },
                             spacing: {
                                after: 400,
                            },
                    }),
                    new Table({
                          width: {
                            size: 9000,
                            type: WidthType.DXA,
                        },
                        rows:[
                            new TableRow({
                                children:[
                                    new TableCell({
                                         columnSpan: 2,
                                        borders: {
                                            top: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                        },
                                        children: [
                                            new Paragraph({
                                                children: [

                                                    new TextRun({
                                                        text: "\tDATED ",
                                                        bold:true,
                                                        break:2,
                                                        size:20
                                                    }),

                                                    new TextRun({
                                                         bold:true,
                                                         size:25,
                                                        text: "at Brampton, this __________________ day of  "+moment().format('MMMM, YYYY')+".",
                                                    }),
                                                    new TextRun({
                                                        text: "\tWITNESS:",
                                                        size:20,
                                                        break:2
                                                    }),
                                                ],
                                            }),



                                        ],
                                         spacing: {
                                            after: 200,
                                            before:200
                                        },

                                    }),



                                ]
                            }),
                             new TableRow({
                                children:[
                                     new TableCell({
                                        borders: {
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                          new Paragraph({
                                                alignment:AlignmentType.LEFT,
                                                children: [
                                                    new TextRun({
                                                        text: "\t\t\t\t\t ",
                                                        bold:true,
                                                    }),
                                                ],
                                                 spacing: {
                                                    after: 100,
                                                    before:100
                                                },
                                            }),


                                        ],

                                    }),
                                    new TableCell({
                                        borders: {
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.SINGLE, size: 0, color: "000000"},
                                        },
                                        children: [
                                          new Paragraph({
                                                alignment:AlignmentType.LEFT,
                                                children: [
                                                     new TextRun({
                                                        text: "________________________________ ",
                                                        break:3
                                                    }),
                                                    new TextRun({
                                                        text: "\t"+self.married_seller.name,
                                                        break:1
                                                    }),
                                                ],
                                                 spacing: {
                                                    after: 100,
                                                        before:100
                                                },
                                            }),


                                        ],

                                    }),
                                ]
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
