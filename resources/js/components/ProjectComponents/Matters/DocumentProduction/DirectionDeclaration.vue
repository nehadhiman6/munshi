<template>
    <tr>
        <td>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1"></label>
        </div>
        </td>
        <td>Directions and Declarations</td>
        <td></td>
        <td>
            <document-generator
                :key="1"
                caption="direction_and_declaration.docx"
                :fileName="'direction_and_declaration_'+file_opening.file_no"
                :creator="author"
                :content="undertaking_content">
            </document-generator>
        </td>
    </tr>
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
    props: ['file_opening', 'author'],
    data() {
        return {
            undertaking_content:null,
        }
    },
    mounted() {
        this.setContentData();
    },
    methods: {
        currentMonth:function(){
            const date = new Date();  // 2009-11-10
            const month = date.toLocaleString('default', { month: 'long' });
            return month;
        },

        currentYear:function(){
            const date = new Date();  // 2009-11-10
            const year = date.getFullYear();
            return year;
        },

        setContentData:function(){
            var self = this;
            var content = [];
            var section1 = [];

            var purchasers = self.file_opening.purchasers;
            var  to ='';
            var purchaser1 ='';
            purchasers.forEach((element,index) => {
                if(element.salutation == 'Corporation'){

                    to += element.company_name + ' ';
                }
                else{
                    to += element.first_name ? element.first_name + ' ' :' ';
                    to += element.middle_name ? element.middle_name +' ' :'';
                    to += element.last_name ? element.last_name+' ' :'' ;
                }
                if(index == 0){
                    purchaser1 = to;
                }
                if(index < purchasers.length-1 && index != purchasers.length-2){
                    to += ',' ;
                }
                else if(index == purchasers.length-2){
                    to += ' and ' ;
                }

                to += ' ' ;
            });

            var and_to ='';

            var purchaser_solicitor = self.file_opening.purchaser_solicitor && self.file_opening.purchaser_solicitor.solicitor ? self.file_opening.purchaser_solicitor.solicitor : null;
            // if(purchaser_solicitor && purchaser_solicitor.law_firm && purchaser_solicitor.law_firm.firm_name)
            if(purchaser_solicitor)
            {
                and_to = purchaser_solicitor.first_name;
                and_to += purchaser_solicitor.middle_name ? ' '+purchaser_solicitor.middle_name : '';
                and_to += purchaser_solicitor.last_name ? ' '+purchaser_solicitor.last_name : '';
            }
            var sellers_names = '';

            var sellers = self.file_opening.sellers;
            sellers.forEach((element,index) => {
                var seller_name = '';
                if(element.salutation == 'Corporation'){

                    seller_name += element.company_name  ? element.company_name + ' ':'';
                }
                else{
                    seller_name += element.first_name ? element.first_name + ' ' :'';
                    seller_name += element.middle_name ? element.middle_name +' ' :'';
                    seller_name += element.last_name ? element.last_name+' ' :'' ;
                }


                sellers_names += seller_name == '' ? Seller + ' '+index+1 :seller_name;
                if(index < sellers.length-1 && index != sellers.length-2){
                    sellers_names += ',' ;
                }
                else if(index == sellers.length-2){
                    sellers_names += ' and ' ;
                }

                sellers_names += ' ' ;
            });


            var re_in = 'Purchaser - '+purchaser1 +', purchase from '+sellers_names;
            var property = self.file_opening.property;
            console.log(property);
            if(property){
                var re = '';

                re += property.street_no ? property.street_no +', ':'' ;
                re += property.street_name ? property.street_name +', ':'' ;
                re += property.unit_no ? property.unit_no +', ': ' ' ;
                re += property.city ? property.city.city_name +', ':'' ;
                re += property.province ? property.province+', ': '' ;
                re += property.postal_code ? property.postal_code:'' ;
            }

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
                            heading: HeadingLevel.HEADING_1,
                            alignment: AlignmentType.CENTER,
                            children: [
                                new TextRun(
                                {
                                    text: "Directions and Declarations",
                                    allCaps: true,
                                    underline:'SINGLE'
                                })
                            ],
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "To:",
                                        bold: true,
                                        break:1
                                    }),
                                    new TextRun("\t Purchasers "+to),
                                    new TextRun({
                                        text: "And To:\t",
                                        bold: true,
                                        break:2
                                    }),
                                    new TextRun(and_to),
                                    new TextRun({
                                        text: "\tBarrister & Solicitor",
                                        break:1,

                                    }),
                                    new TextRun({
                                        text: "RE:\t",
                                        bold: true,
                                        break:2,

                                    }),
                                    new TextRun({
                                        text: re_in,

                                    }),
                                    new TextRun({
                                        text: "\t"+re,
                                        break:1,
                                    }),

                                ],
                                tabStops: [
                                    {
                                        type: TabStopType.LEFT,
                                        // position: TabStopPosition.MAX,
                                        position: 2000,
                                    },
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
                                        text: "DIRECTION RE FUNDS: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " The Vendor directs that the “Balance Due on Closing” be paid to their solicitor "
                                        +" “Lakhwinder Singh Gill, in Trust”, or as their said solicitor may otherwise direct."
                                        ,

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
                                        text: "READJUSTMENTS: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " TO readjust if necessary and as soon as possible upon a demand being made, any item on the Statement of Adjustments if such item is found to be inaccurate or incomplete; ",

                                    }),
                                    new TextRun({
                                        text: " Note (More appropriate in undertakings) ",
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
                                        text: "TENANCIES: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " There are no leases or tenancies affecting the Property except as set out in the Agreement.",

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
                                        text: "COMMON EXPENSES: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: " Common expenses have been paid in accordance with the Statement of Adjustments.",

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
                                        text: "BILL OF SALE: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: "IN CONSIDERATION of the closing of the within transaction, the undersigned, being the vendors of the subject property, do hereby sell, transfer and convey to the purchasers the chattels and fixtures included in the purchase price as specified in the Agreement of Purchase and Sale; and we covenant that we are the lawful owners thereof and that we have the right to transfer and convey the same and that such chattels and fixtures are free of all encumbrances, liens and claims of any kind whatsoever.",

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
                                        text: "HST: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: 'The property is a "used residential complex" and the sale of the property is exempt from HST under Section 2 and, if applicable, Section 9 of Part I of Schedule V of the Act, and we make this declaration to be delivered to the purchasers with intent that it be relied upon by the purchasers in claiming such exemption as a statement in writing or certificate delivered to the purchasers pursuant to Section 194 of the Act.',

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
                                        text: "RESIDENCY: ",
                                        bold:true,
                                    }),
                                    new TextRun({
                                        text: "I am not a non-resident of Canada within the meaning of Section 116 of the Income Tax Act (Canada) and nor will I be a non-resident of Canada at the time of closing."

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
                                        text: "DATED at \t\t\t this           day of  \t, "+self.currentYear()+".",
                                        break:1
                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                                tabStops: [
                                    {
                                        type: TabStopType.LEFT,
                                        // position: TabStopPosition.MAX,
                                        position: 2000,
                                    },
                                ],

                        }),

                        new Paragraph({
                             children: [
                                new TextRun({
                                    text: "_____________________________",
                                    break:1,
                                }),
                                new TextRun({
                                    text: seller1,
                                    break:1,

                                }),
                                new TextRun({
                                    text: "_____________________________",
                                    break:3,
                                }),
                                new TextRun({
                                    text: seller2,
                                    break:1,
                                }),
                                new PageBreak()
                            ],
                            alignment: AlignmentType.RIGHT,
                            spacing: {
                                before:200
                            },
                        }),
                        new Paragraph({
                             children: [
                                new TextRun({
                                    text: "IN THE MATTER OF",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: ' title to:',

                                }),
                                new TextRun({
                                    text: "123 Queen Street, Bradford",
                                    break:1,
                                }),
                                new TextRun({
                                    text: 'AND IN THE MATTER OF',
                                    bold:true,
                                    break:2
                                }),
                                new TextRun({
                                    text: ' the sale thereof from',
                                }),
                                new TextRun({
                                    text: seller1+' and Two Seller to One Purchaser and ' +seller2,
                                    break:1
                                }),
                                new TextRun({
                                    text: ' Two purchaser.',
                                    break:1
                                }),
                            ],
                            alignment: AlignmentType.RIGHT,
                            spacing: {
                                before:200,
                                after:200
                            },
                        }),

                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "We, "+seller1+" and "+seller2+" , SOLEMNLY DECLARE that:",
                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:500
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "We are the absolute owner of the above mentioned lands and either personally or by my tenants have been in actual, peaceable, continuous, exclusive, open, undisturbed and undisputed possession and occupation thereof, and of the houses and other buildings used in connection therewith throughout my time of ownership of the property."

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
                                        text: "We are not aware of any person or corporation having any claim or interest in the prpoperty or any part thereof adverse to or inconsistent with registered title and are positive that none exists. "

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
                                        text: "To the best of our knowledge and belief there are no un registered lease(s), agreement(s) to lease or options to purchase the lands."

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
                                        text: "There are no proceedings under the Bankruptcy and Insolvency Act of Canada by or against us."

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
                                        text: "Our occupation and possession of the Property has been undisturbed throughout by any action, suit or other proceedings or adverse possession or otherwise on the part of any person whomsoever, and during such occupation and possession, no payment has ever been made or acknowledgement of title given by us, or, so far as I know, by anyone else, to any person in respect of any right, title, interest or claim upon the Premises."

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
                                        text: "To the best of our knowledge and belief, the buildings used in connection with the premises are situate wholly within the limits of the lands above described, and there is no dispute as to the boundaries of the property.  Except as may be registered on title, we have never heard of any claim of easement affecting the lands, either for light, drainage, or right of way or otherwise. "

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
                                        text: "To the best of our knowledge and belief, there have been no structural alterations made to the unit except in compliance with the Declaration or an agreement registered on title"

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
                                        text: "We have carefully examined the survey prepared by and dated, a copy of which is attached hereto, and have compared my knowledge of the buildings situate on the subject property with those shown on the said survey.  The survey accurately describes the property and buildings on the subject property as they exist today and there are no other buildings, additions, decks, swimming pools, outbuildings or any other structures not shown on such survey."

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
                                        text: "That we are each of the full age of eighteen years."

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
                                        text: "Our spousal status  and address for service is correctly stated in the Transfer."

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
                                        text: "AND we make this solemn Declaration conscientiously believing it to be true, and knowing that it is of the same force and effect as if made under oath."

                                    }),

                                    new PageBreak()
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                        }),
                        new Paragraph({
                            children: [
                                    new TextRun({
                                        text: "DECLARED before me" + "\t\t }",


                                    }),
                                    new TextRun({
                                        text: "at the "+ "\t\t\t\t }",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "in the "+ "\t\t\t\t }",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "of"+ "\t\t\t\t }",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "this day of February" + "\t\t }" + "\t" + "_______________________________",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "2021"+ "\t\t\t\t }" + "\t" + seller1,
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "\t\t\t\t }",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "\t\t\t\t }",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "\t\t\t\t }" + "\t" + "_______________________________",
                                        break:1

                                    }),
                                    new TextRun({
                                        text: "\t\t\t\t }" + "\t" + seller2,
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
                                        text: "A COMMISSIONER, ETC."

                                    }),
                                ],
                                spacing: {
                                    after: 200,
                                    before:200
                                },
                        }),

                    ],
            });
            self.undertaking_content = section1;
        },
    }
};
</script>
