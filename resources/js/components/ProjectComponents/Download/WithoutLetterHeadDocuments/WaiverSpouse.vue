<template>
    <document-without-letter-head
        :file-name="'Waiver_of_independent_legal_advise '+file_opening.file_no+ '('+married_seller.name+')'"
        :caption="'Waiver of independent legal advise ('+married_seller.name +')'"
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
            var spouse_name = self.married_seller.spouse_name;

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
                    sellers += element.last_name ? element.last_name : element.first_name;
                    sellers_arr.push(
                        new TextRun({
                            text: "________________________________",
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
                    purchasers += element.last_name ?element.last_name:element.name ;
             })
            }


            section.push({

                children: [
                    new Paragraph({
                        heading: HeadingLevel.HEADING_3,
                        alignment: AlignmentType.CENTER,
                        children: [
                                new TextRun({
                                    text: "WAIVER OF INDEPENDENT LEGAL ADVISE",
                                    bold:true,
                                    break:1,
                                    underline:true,
                                    color:'black'
                                })
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
                                   text: '\t\t'+ "Name of seller's lawyer",
                                }),
                                new TextRun({
                                   color:'black',
                                   text: "RE:",
                                    bold:true,
                                    break:2
                                }),

                                new TextRun({
                                   color:'black',
                                   text: "\t\t(SELLERS) "+sellers+" s/t",
                                }),
                                new TextRun({
                                   color:'black',
                                   text: "\t\t(PURCHASER) "+purchasers+" (FILE NO."+file_no+ ")",
                                    break:1
                                }),
                        ],
                        spacing: {
                            before:200
                        },
                    }),

                    new Paragraph({
                        heading: HeadingLevel.HEADING_3,
                        children: [
                            new TextRun({
                                text: '\t\t'+ propery_add,
                                    color:'black'
                                // break:1
                            }),
                                new TextRun({
                                text: '\t\tClosing Date: '+ closing_date,
                                    color:'black',
                                break:1
                            }),
                                new TextRun({
                                text: '\t\tOur File No: '+ file_no,
                                    color:'black',
                                break:1
                            }),
                        ],
                        spacing: {
                            after: 200,
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
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                            new Paragraph({
                                                heading: HeadingLevel.HEADING_3,
                                                children: [
                                                     new TextRun({
                                                        color:'black',
                                                        text: "I, "+spouse_name+" acknowledge as follows:",
                                                        bold:true,
                                                        break:1
                                                    }),
                                                ],
                                                spacing: {
                            after: 100,
                        },
                                            }),
                                        ],
                                    })
                                ]
                            })
                        ],
                    }),


                    new Paragraph({
                        size:20,
                        children: [
                                new TextRun({
                                    size:24,
                                    text: 'that I and '+this.married_seller.name+' are spouses of one another;',
                                    // break:2
                                }),

                            ],
                             numbering: {
                                reference: "my-custom-numbering",
                                level: 5
                            },
                             spacing: {
                                after: 200,
                            },
                    }),
                      new Paragraph({
                        size:20,
                        children: [
                                new TextRun({
                                    size:24,
                                    text: 'that for reasons which are valid and important to us, title of the above-noted property is in the name of my husband, '+self.married_seller.name+';',
                                    // break:2
                                }),

                            ],
                             numbering: {
                                reference: "my-custom-numbering",
                                level: 5
                            },
                             spacing: {
                                after: 200,
                            },
                    }),

                    new Paragraph({
                        children: [

                                  new TextRun({
                                    size:24,
                                    text: 'that the lawyer has explained that I will not get any funds on the Transfer of Title You',
                                    // break:2
                                }),
                                  new TextRun({
                                    size:24,
                                    bold:true,
                                    text: ' should seek the advise of another, independent lawyer to give advise ',
                                    // break:2
                                }),
                                  new TextRun({
                                    size:24,
                                    text: 'prior to signing the Transfer documents (including advice on whether the documents should be signed at all);',
                                    // break:2
                                }),
                            ],

                             numbering: {
                                reference: "my-custom-numbering",
                                level: 5
                            },
                             spacing: {
                                after: 200,
                            },
                    }),
                     new Paragraph({
                        children: [

                                new TextRun({
                                    size:24,
                                    text: 'that notwithstanding the above advise, I ',
                                    // break:2
                                }),
                                  new TextRun({
                                    size:24,
                                    text: 'do not ',
                                    bold:true
                                    // break:2
                                }),
                                  new TextRun({
                                    size:24,
                                    text: 'wish to obtain independent legal advise',
                                    // break:2
                                }),
                            ],

                             numbering: {
                                reference: "my-custom-numbering",
                                level: 5
                            },
                             spacing: {
                                after: 200,
                            },
                    }),
                    new Paragraph({
                        children: [

                                  new TextRun({
                                    size:24,
                                    text: 'that I have requested the Lawyer to act for both of is in connection with the above-noted matter; and',
                                    // break:2
                                }),
                            ],

                             numbering: {
                                reference: "my-custom-numbering",
                                level: 5
                            },
                             spacing: {
                                after: 200,
                            },
                    }),

                      new Paragraph({
                        children: [

                                  new TextRun({
                                    size:24,
                                    text: 'that because the Lawyer is acting on behalf of both of us: (a) the Lawyer cannot treat any information received from on of us as confidential, insofar as the other one is concerned and (b) in the event a dispute arises between us, the lawyer cannot continue to act for both of us and may have to withdraw completely.',
                                    // break:2
                                }),
                            ],

                             numbering: {
                                reference: "my-custom-numbering",
                                level: 5
                            },
                             spacing: {
                                after: 200,
                            },
                    }),
                     new Paragraph({
                        children: [
                                  new TextRun({
                                    size:24,
                                    text: 'I hereby consent to the Lawyer acting for us subject to the terms described above.',
                                    // break:2
                                }),
                            ],
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
                                            top: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                            new Paragraph({
                                                children: [

                                                    new TextRun({
                                                        text: "DATED ",
                                                        bold:true,
                                                        break:2,
                                                        size:20
                                                    }),

                                                    new TextRun({
                                                         bold:true,
                                                         size:25,
                                                        text: "at Brampton, this __________________ day of  "+moment().format('MMMM, YYYY')+".",
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
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                            new Paragraph({
                                                children: [
                                                    new TextRun({
                                                        text: "SIGNED SEALED AND DELIVERED\t\t",
                                                        size:20,
                                                        break:1
                                                    }),
                                                ],
                                            }),
                                        ],
                                         spacing: {
                                            after: 200,
                                            before:200
                                        },

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
                                                        text: ") ____________________________",
                                                        size:20,
                                                        break:1
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
                                            bottom: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            left: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                            right: {style: BorderStyle.NONE, size: 0, color: "000000"},
                                        },
                                        children: [
                                            new Paragraph({
                                                children: [
                                                    new TextRun({
                                                        text: "In the presence of",
                                                        size:20,
                                                        break:1
                                                    }),
                                                ],
                                            }),
                                        ],
                                         spacing: {
                                            after: 200,
                                            before:200
                                        },

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
                                                        text: ") ",
                                                        size:20,
                                                        break:1
                                                    }),
                                                    new TextRun({
                                                        text: ") ____________________________",
                                                        size:20,
                                                        break:1
                                                    }),

                                                     new TextRun({
                                                        text: ")\t "+spouse_name,
                                                        size:24,
                                                        bold:true,
                                                        break:1
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
